<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

if (TYPO3_MODE=="BE")	{
		
	t3lib_extMgm::addModule("web","txjulleeventsM1","",t3lib_extMgm::extPath($_EXTKEY)."mod1/");
}

$tempColumns = Array (
	"tx_julleevents_type" => Array (		
		"exclude" => 0,		
		"label" => "LLL:EXT:julle_events/locallang_db.php:tt_content.tx_julleevents_type",		
		"config" => Array (
			 "type" => "select",
			 "items" => Array (
					Array("LLL:EXT:julle_events/locallang_db.php:tt_content.tx_julleevents_type.I.0", "0"),
					Array("LLL:EXT:julle_events/locallang_db.php:tt_content.tx_julleevents_type.I.1", "1"),
					),
			 ),
		),
	"tx_julleevents_category" => Array (        
		"exclude" => 1,        
		"label" => "LLL:EXT:julle_events/locallang_db.php:tt_content.tx_julleevents_category",        
		"config" => Array (
			 "type" => "select",    
			 "items" => Array (
					Array("",0),
					),
			 "foreign_table" => "tx_julleevents_categories",    
			 "foreign_table_where" => "AND tx_julleevents_categories.pid=###STORAGE_PID### ORDER BY tx_julleevents_categories.category",    
			 "size" => 1,    
			 "minitems" => 0,
			 "maxitems" => 1,
			 )
		),
	"tx_julleevents_city" => Array (        
		"exclude" => 1,        
		"label" => "LLL:EXT:julle_events/locallang_db.php:tt_content.tx_julleevents_city",        
		"config" => Array (
			 "type" => "select",    
			 "items" => Array (
					Array("",0),
					),
			 "foreign_table" => "tx_julleevents_cities",    
			 "foreign_table_where" => "AND tx_julleevents_cities.pid=###STORAGE_PID### ORDER BY tx_julleevents_cities.city",    
			 "size" => 1,    
			 "minitems" => 0,
			 "maxitems" => 1,
			 )
		),
	"tx_julleevents_dontshow" => Array (        
		"exclude" => 1,        
		"label" => "LLL:EXT:julle_events/locallang_db.php:tt_content.tx_julleevents_dontshow",        
		"config" => Array (
			"type" => "check",
			)
		),
	);


t3lib_div::loadTCA("tt_content");
t3lib_extMgm::addTCAcolumns("tt_content",$tempColumns,1);
#t3lib_extMgm::addToAllTCAtypes("tt_content","tx_julleevents_type;;;;1-1-1");


t3lib_extMgm::allowTableOnStandardPages("tx_julleevents_participants");

$TCA["tx_julleevents_participants"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants",		
		"label" => "email",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"default_sortby" => "ORDER BY crdate",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_julleevents_participants.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "firstname, lastname, position, company, address, zip, city, country, billing_address, email, phone, partner_code",
	)
);


t3lib_extMgm::allowTableOnStandardPages("tx_julleevents_events");

$TCA["tx_julleevents_events"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"sortby" => "sorting",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_julleevents_events.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "hidden, starttime, endtime, title, date, teaser, regstart, regend, show_participants, pages, participants",
	)
);

$TCA["tx_julleevents_partners"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_partners",		
		"label" => "name",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"default_sortby" => "ORDER BY crdate",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_julleevents_partners.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "hidden, starttime, endtime, name, link, logo, sponsors",
	)
);

$TCA["tx_julleevents_categories"] = Array (
    "ctrl" => Array (
        "title" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_categories",        
        "label" => "category",    
        "tstamp" => "tstamp",
        "crdate" => "crdate",
        "cruser_id" => "cruser_id",
        "default_sortby" => "ORDER BY category",    
        "delete" => "deleted",    
        "enablecolumns" => Array (        
            "disabled" => "hidden",
        ),
        "dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
        "iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_julleevents_categories.gif",
    ),
    "feInterface" => Array (
        "fe_admin_fieldList" => "hidden, category",
    )
);

$TCA["tx_julleevents_cities"] = Array (
    "ctrl" => Array (
        "title" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_cities",        
        "label" => "city",    
        "tstamp" => "tstamp",
        "crdate" => "crdate",
        "cruser_id" => "cruser_id",
        "default_sortby" => "ORDER BY city",    
        "delete" => "deleted",    
        "enablecolumns" => Array (        
            "disabled" => "hidden",
        ),
        "dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
        "iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_julleevents_cities.gif",
    ),
    "feInterface" => Array (
        "fe_admin_fieldList" => "hidden, city",
    )
);



t3lib_div::loadTCA("tt_content");
$TCA["tt_content"]["types"]["list"]["subtypes_excludelist"][$_EXTKEY."_pi1"]="layout,select_key";
$TCA["tt_content"]["types"]["list"]["subtypes_addlist"][$_EXTKEY."_pi1"]="tx_julleevents_type;;;;1-1-1, tx_julleevents_category, tx_julleevents_city, tx_julleevents_dontshow";


t3lib_extMgm::addPlugin(Array("LLL:EXT:julle_events/locallang_db.php:tt_content.list_type_pi1", $_EXTKEY."_pi1"),"list_type");
t3lib_extMgm::addPlugin(Array("LLL:EXT:julle_events/locallang_db.php:tt_content.list_type_pi2", $_EXTKEY."_pi2"),"list_type");
?>