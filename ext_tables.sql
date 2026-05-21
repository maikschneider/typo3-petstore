CREATE TABLE tx_typo3petstore_domain_model_pet (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(1) DEFAULT '0' NOT NULL,
	hidden tinyint(1) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	latin_name varchar(255) DEFAULT '' NOT NULL,
	description text,
	care_notes text,

	price decimal(10,2) DEFAULT '0.00' NOT NULL,
	weight_kg decimal(10,2) DEFAULT '0.00' NOT NULL,
	stock_quantity int(11) DEFAULT '0' NOT NULL,

	status varchar(20) DEFAULT 'available' NOT NULL,
	gender varchar(20) DEFAULT 'unknown' NOT NULL,

	is_vaccinated tinyint(1) DEFAULT '0' NOT NULL,
	features int(11) DEFAULT '0' NOT NULL,

	birth_date date DEFAULT NULL,
	available_from int(11) DEFAULT '0' NOT NULL,
	feeding_time time DEFAULT NULL,

	photos int(11) DEFAULT '0' NOT NULL,
	health_certificate int(11) DEFAULT '0' NOT NULL,

	owner_website varchar(1024) DEFAULT '' NOT NULL,
	highlight_color varchar(10) DEFAULT '' NOT NULL,
	contact_email varchar(255) DEFAULT '' NOT NULL,
	url_slug varchar(2048) DEFAULT '' NOT NULL,
	external_id varchar(36) DEFAULT '' NOT NULL,

	metadata json DEFAULT NULL,
	extra_settings text,

	categories int(11) DEFAULT '0' NOT NULL,
	category_id int(11) DEFAULT '0' NOT NULL,
	orders int(11) DEFAULT '0' NOT NULL,
	tags int(11) DEFAULT '0' NOT NULL,
	related_pets int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent, sys_language_uid)
);

CREATE TABLE tx_typo3petstore_domain_model_category (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(1) DEFAULT '0' NOT NULL,
	hidden tinyint(1) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description text,
	parent_category int(11) DEFAULT '0' NOT NULL,
	icon int(11) DEFAULT '0' NOT NULL,
	sort_order int(11) DEFAULT '0' NOT NULL,
	badge_color varchar(10) DEFAULT '' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_typo3petstore_domain_model_tag (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(1) DEFAULT '0' NOT NULL,
	hidden tinyint(1) DEFAULT '0' NOT NULL,

	name varchar(100) DEFAULT '' NOT NULL,
	color varchar(10) DEFAULT '' NOT NULL,
	description text,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_typo3petstore_domain_model_order (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(1) DEFAULT '0' NOT NULL,
	hidden tinyint(1) DEFAULT '0' NOT NULL,

	pet_id int(11) DEFAULT '0' NOT NULL,
	quantity int(11) DEFAULT '1' NOT NULL,
	total_price decimal(10,2) DEFAULT '0.00' NOT NULL,
	status varchar(20) DEFAULT 'placed' NOT NULL,
	complete tinyint(1) DEFAULT '0' NOT NULL,

	customer_name varchar(255) DEFAULT '' NOT NULL,
	customer_email varchar(255) DEFAULT '' NOT NULL,
	customer_phone varchar(50) DEFAULT '' NOT NULL,
	shipping_address text,

	ship_date datetime DEFAULT NULL,
	delivery_date date DEFAULT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY pet (pet_id)
);

CREATE TABLE tx_typo3petstore_domain_model_customer (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(1) DEFAULT '0' NOT NULL,
	hidden tinyint(1) DEFAULT '0' NOT NULL,

	username varchar(100) DEFAULT '' NOT NULL,
	first_name varchar(100) DEFAULT '' NOT NULL,
	last_name varchar(100) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	password_hash varchar(255) DEFAULT '' NOT NULL,
	phone varchar(30) DEFAULT '' NOT NULL,
	address text,
	user_status int(11) DEFAULT '0' NOT NULL,
	loyalty_points int(11) DEFAULT '0' NOT NULL,
	profile_image int(11) DEFAULT '0' NOT NULL,
	date_of_birth date DEFAULT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_typo3petstore_pet_tag_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

CREATE TABLE tx_typo3petstore_pet_related_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
