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
    name: 'petstore:setup:pages',
    description: 'Create petstore page and content element structure from CSV fixtures',
)]
class SetupPagesCommand extends Command
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'root-pid',
                null,
                InputOption::VALUE_OPTIONAL,
                'PID under which the petstore root page is created',
                0
            )
            ->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Create pages even when a "Petstore" page already exists under root-pid'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $rootPid = (int)$input->getOption('root-pid');
        $force = (bool)$input->getOption('force');

        $io->title('Petstore — Page & Content Setup');

        if (!$force) {
            $existing = $this->findPageByTitle('Petstore', $rootPid);
            if ($existing !== null) {
                $io->warning(sprintf(
                    'A "Petstore" page already exists under pid=%d (uid=%d). Use --force to create another.',
                    $rootPid,
                    $existing
                ));
                return Command::SUCCESS;
            }
        }

        $pages = $this->readCsv('EXT:typo3_petstore/Resources/Private/Fixtures/Pages.csv');
        $contentElements = $this->readCsv('EXT:typo3_petstore/Resources/Private/Fixtures/ContentElements.csv');

        // uid_ref => actual DB uid; ROOT resolves to the chosen parent
        $uidMap = ['ROOT' => $rootPid];

        $io->section('Creating pages');
        foreach ($pages as $page) {
            $parentUid = $uidMap[$page['parent_uid_ref']] ?? $rootPid;
            $uid = $this->insertPage(
                pid: $parentUid,
                title: $page['title'],
                doktype: (int)$page['doktype'],
                slug: $page['slug'],
                navHide: (int)$page['nav_hide'],
                description: $page['description'],
            );
            $uidMap[$page['uid_ref']] = $uid;
            $io->text(sprintf('  <info>+</info> %-30s uid=%-4d pid=%d', $page['title'], $uid, $parentUid));
        }

        $io->section('Creating content elements');
        $sorting = 256;
        foreach ($contentElements as $el) {
            $pageUid = $uidMap[$el['page_uid_ref']] ?? null;
            if ($pageUid === null) {
                $io->warning('Skipping unknown page_uid_ref: ' . $el['page_uid_ref']);
                continue;
            }
            $this->insertContentElement(
                pid: $pageUid,
                cType: $el['CType'],
                header: $el['header'],
                bodytext: $el['bodytext'],
                colPos: (int)($el['colPos'] ?? 0),
                sorting: $sorting,
            );
            $sorting += 256;
            $io->text(sprintf('  <info>+</info> %-42s page uid=%d', '"' . mb_strimwidth($el['header'], 0, 40, '…') . '"', $pageUid));
        }

        $io->success(sprintf(
            'Done: %d pages and %d content elements created under pid=%d.',
            count($pages),
            count($contentElements),
            $rootPid
        ));

        return Command::SUCCESS;
    }

    private function insertPage(
        int $pid,
        string $title,
        int $doktype,
        string $slug,
        int $navHide,
        string $description,
    ): int {
        $now = time();
        $connection = $this->connectionPool->getConnectionForTable('pages');
        $connection->insert('pages', [
            'pid' => $pid,
            'title' => $title,
            'doktype' => $doktype,
            'slug' => $slug,
            'nav_hide' => $navHide,
            'description' => $description,
            'tstamp' => $now,
            'crdate' => $now,
            'hidden' => 0,
            'deleted' => 0,
        ]);
        return (int)$connection->lastInsertId();
    }

    private function insertContentElement(
        int $pid,
        string $cType,
        string $header,
        string $bodytext,
        int $colPos,
        int $sorting,
    ): void {
        $now = time();
        $this->connectionPool->getConnectionForTable('tt_content')->insert('tt_content', [
            'pid' => $pid,
            'CType' => $cType,
            'header' => $header,
            'bodytext' => $bodytext,
            'colPos' => $colPos,
            'sorting' => $sorting,
            'tstamp' => $now,
            'crdate' => $now,
            'hidden' => 0,
            'deleted' => 0,
        ]);
    }

    private function findPageByTitle(string $title, int $pid): ?int
    {
        $qb = $this->connectionPool->getQueryBuilderForTable('pages');
        $qb->getRestrictions()->removeAll();
        $result = $qb
            ->select('uid')
            ->from('pages')
            ->where(
                $qb->expr()->eq('pid', $qb->createNamedParameter($pid)),
                $qb->expr()->eq('title', $qb->createNamedParameter($title)),
                $qb->expr()->eq('deleted', $qb->createNamedParameter(0))
            )
            ->executeQuery()
            ->fetchOne();

        return $result !== false ? (int)$result : null;
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function readCsv(string $extensionPath): array
    {
        $file = GeneralUtility::getFileAbsFileName($extensionPath);
        if (!is_file($file)) {
            throw new \RuntimeException('Fixture file not found: ' . $file, 1716278400);
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
