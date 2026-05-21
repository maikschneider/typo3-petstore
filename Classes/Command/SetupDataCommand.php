<?php

declare(strict_types=1);

namespace MaikSchneider\Typo3Petstore\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[AsCommand(
    name: 'petstore:setup:data',
    description: 'Import petstore demo data (categories, tags, pets, customers, orders) into a sys_folder',
)]
class SetupDataCommand extends Command
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'pid',
            'p',
            InputOption::VALUE_OPTIONAL,
            'PID of an existing sys_folder. A new "Petstore Demo Data" folder is created at root when omitted.',
            null
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Petstore — Demo Data Import');

        $pidOption = $input->getOption('pid');
        if ($pidOption === null) {
            $pid = $this->createSysFolder('Petstore Demo Data', 0);
            $io->success(sprintf('Created sys_folder "Petstore Demo Data" (uid=%d)', $pid));
        } else {
            $pid = (int)$pidOption;
            $io->text(sprintf('Importing into existing folder pid=%d', $pid));
        }

        $io->section('Categories');
        $categoryMap = $this->importCategories($pid, $io);

        $io->section('Tags');
        $tagMap = $this->importTags($pid, $io);

        $io->section('Pets');
        $petMap = $this->importPets($pid, $categoryMap, $tagMap, $io);

        $io->section('Customers');
        $this->importCustomers($pid, $io);

        $io->section('Orders');
        $this->importOrders($pid, $petMap, $io);

        $io->success(sprintf(
            'Import complete. All records created in pid=%d.',
            $pid
        ));

        return Command::SUCCESS;
    }

    /** @return array<string, int> uid_ref => uid */
    private function importCategories(int $pid, SymfonyStyle $io): array
    {
        $map = [];
        foreach ($this->readCsv('EXT:typo3_petstore/Resources/Private/Fixtures/Categories.csv') as $row) {
            $uid = $this->insert('tx_typo3petstore_domain_model_category', [
                'pid' => $pid,
                'name' => $row['name'],
                'description' => $row['description'],
                'badge_color' => $row['badge_color'],
                'sort_order' => (int)$row['sort_order'],
            ]);
            $map[$row['uid_ref']] = $uid;
            $io->text(sprintf('  <info>+</info> %s (uid=%d)', $row['name'], $uid));
        }
        return $map;
    }

    /** @return array<string, int> uid_ref => uid */
    private function importTags(int $pid, SymfonyStyle $io): array
    {
        $map = [];
        foreach ($this->readCsv('EXT:typo3_petstore/Resources/Private/Fixtures/Tags.csv') as $row) {
            $uid = $this->insert('tx_typo3petstore_domain_model_tag', [
                'pid' => $pid,
                'name' => $row['name'],
                'color' => $row['color'],
                'description' => $row['description'],
            ]);
            $map[$row['uid_ref']] = $uid;
            $io->text(sprintf('  <info>+</info> %s (uid=%d)', $row['name'], $uid));
        }
        return $map;
    }

    /**
     * @param array<string, int> $categoryMap
     * @param array<string, int> $tagMap
     * @return array<string, int> uid_ref => uid
     */
    private function importPets(int $pid, array $categoryMap, array $tagMap, SymfonyStyle $io): array
    {
        $map = [];
        foreach ($this->readCsv('EXT:typo3_petstore/Resources/Private/Fixtures/Pets.csv') as $row) {
            $tagUids = $this->resolveRefs($row['tags_uid_refs'], $tagMap);

            $uid = $this->insert('tx_typo3petstore_domain_model_pet', [
                'pid' => $pid,
                'name' => $row['name'],
                'latin_name' => $row['latin_name'],
                'status' => $row['status'],
                'gender' => $row['gender'],
                'price' => (float)$row['price'],
                'weight_kg' => (float)$row['weight_kg'],
                'stock_quantity' => (int)$row['stock_quantity'],
                'description' => $row['description'],
                'care_notes' => $row['care_notes'],
                'category_id' => $categoryMap[$row['category_uid_ref']] ?? 0,
                'tags' => count($tagUids),
            ]);

            foreach (array_values($tagUids) as $sorting => $tagUid) {
                $this->connectionPool->getConnectionForTable('tx_typo3petstore_pet_tag_mm')->insert(
                    'tx_typo3petstore_pet_tag_mm',
                    [
                        'uid_local' => $uid,
                        'uid_foreign' => $tagUid,
                        'sorting' => $sorting + 1,
                        'sorting_foreign' => 0,
                    ]
                );
            }

            $map[$row['uid_ref']] = $uid;
            $io->text(sprintf(
                '  <info>+</info> %-20s [%s] uid=%-4d tags=%d',
                $row['name'],
                $row['status'],
                $uid,
                count($tagUids)
            ));
        }
        return $map;
    }

    private function importCustomers(int $pid, SymfonyStyle $io): void
    {
        foreach ($this->readCsv('EXT:typo3_petstore/Resources/Private/Fixtures/Customers.csv') as $row) {
            $uid = $this->insert('tx_typo3petstore_domain_model_customer', [
                'pid' => $pid,
                'username' => $row['username'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'address' => $row['address'],
                'user_status' => (int)$row['user_status'],
            ]);
            $io->text(sprintf('  <info>+</info> %s %s (uid=%d)', $row['first_name'], $row['last_name'], $uid));
        }
    }

    /** @param array<string, int> $petMap */
    private function importOrders(int $pid, array $petMap, SymfonyStyle $io): void
    {
        foreach ($this->readCsv('EXT:typo3_petstore/Resources/Private/Fixtures/Orders.csv') as $row) {
            $petUid = $petMap[$row['pet_uid_ref']] ?? 0;
            $uid = $this->insert('tx_typo3petstore_domain_model_order', [
                'pid' => $pid,
                'pet_id' => $petUid,
                'customer_name' => $row['customer_name'],
                'customer_email' => $row['customer_email'],
                'customer_phone' => $row['customer_phone'],
                'status' => $row['status'],
                'quantity' => (int)$row['quantity'],
                'total_price' => (float)$row['total_price'],
                'shipping_address' => $row['shipping_address'],
            ]);
            $io->text(sprintf(
                '  <info>+</info> Order #%-3d %-20s [%s] pet uid=%d',
                $uid,
                $row['customer_name'],
                $row['status'],
                $petUid
            ));
        }
    }

    private function createSysFolder(string $title, int $parentPid): int
    {
        $slug = '/' . strtolower((string)preg_replace('/[^a-z0-9]+/i', '-', $title));
        return $this->insert('pages', [
            'pid' => $parentPid,
            'title' => $title,
            'doktype' => 254,
            'slug' => $slug,
            'hidden' => 0,
        ]);
    }

    private function insert(string $table, array $data): int
    {
        $now = time();
        $connection = $this->connectionPool->getConnectionForTable($table);
        $connection->insert($table, array_merge(['tstamp' => $now, 'crdate' => $now], $data));
        return (int)$connection->lastInsertId();
    }

    /**
     * @param array<string, int> $map
     * @return array<int, int>
     */
    private function resolveRefs(string $csv, array $map): array
    {
        $uids = [];
        foreach (array_filter(array_map('trim', explode(',', $csv))) as $ref) {
            if (isset($map[$ref])) {
                $uids[] = $map[$ref];
            }
        }
        return $uids;
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function readCsv(string $extensionPath): array
    {
        $file = GeneralUtility::getFileAbsFileName($extensionPath);
        if (!is_file($file)) {
            throw new \RuntimeException('Fixture file not found: ' . $file, 1716278401);
        }
        $handle = fopen($file, 'r');
        $headers = fgetcsv($handle);
        $rows = [];
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) === count($headers)) {
                $rows[] = array_combine($headers, $row);
            }
        }
        fclose($handle);
        return $rows;
    }
}
