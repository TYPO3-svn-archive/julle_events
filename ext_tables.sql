#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_julleevents_type int(11) unsigned DEFAULT '0' NOT NULL
  tx_julleevents_category int(11) unsigned DEFAULT '0' NOT NULL
  tx_julleevents_city int(11) unsigned DEFAULT '0' NOT NULL
  tx_julleevents_dontshow tinyint(3) unsigned DEFAULT '0' NOT NULL
);



#
# Table structure for table 'tx_julleevents_participants'
#
CREATE TABLE tx_julleevents_participants (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	firstname tinytext NOT NULL,
	lastname tinytext NOT NULL,
	position tinytext NOT NULL,
	company tinytext NOT NULL,
	address tinytext NOT NULL,
	zip tinytext NOT NULL,
	city tinytext NOT NULL,
	country tinytext NOT NULL,
	billing_address text NOT NULL,
	email tinytext NOT NULL,
	phone tinytext NOT NULL,
	partner_code tinytext NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);




#
# Table structure for table 'tx_julleevents_events_participants_mm'
# 
#
CREATE TABLE tx_julleevents_events_participants_mm (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_julleevents_events'
#
CREATE TABLE tx_julleevents_events (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(10) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	date int(11) DEFAULT '0' NOT NULL,
	enddate int(11) DEFAULT '0' NOT NULL,
	city tinytext NOT NULL,
	teaser text NOT NULL,
	regstart int(11) DEFAULT '0' NOT NULL,
	regend int(11) DEFAULT '0' NOT NULL,
	regtext text NOT NULL,
	show_participants int(11) DEFAULT '0' NOT NULL,
	max_participants int(11) DEFAULT '0' NOT NULL,
	max_page blob NOT NULL,
	priority int(11) DEFAULT '0' NOT NULL, 
	pages blob NOT NULL,
	participants int(11) unsigned DEFAULT '0' NOT NULL,
	notify_email tinytext NOT NULL,
	category int(11) unsigned DEFAULT '0' NOT NULL
	city_rel int(11) unsigned DEFAULT '0' NOT NULL
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_julleevents_events_category_mm'
# 
#
CREATE TABLE tx_julleevents_events_category_mm (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tx_julleevents_categories'
#
CREATE TABLE tx_julleevents_categories (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) unsigned DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    category tinytext NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);

#
# Table structure for table 'tx_julleevents_cities'
#
CREATE TABLE tx_julleevents_cities (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) unsigned DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    city tinytext NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);


#
# Table structure for table 'tx_julleevents_partners'
#
CREATE TABLE tx_julleevents_partners (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	name tinytext NOT NULL,
	link tinytext NOT NULL,
	logo blob NOT NULL,
	sponsors blob NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);