<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

$TCA["tx_julleevents_participants"] = Array (
	"ctrl" => $TCA["tx_julleevents_participants"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,firstname,lastname,position,company,address,zip,city,country,billing_address,email,phone,partner_code"
	),
	"feInterface" => $TCA["tx_julleevents_participants"]["feInterface"],
	"columns" => Array (
		"hidden" => Array (		
			"exclude" => 1,	
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"firstname" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.firstname",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
			)
		),
		"lastname" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.lastname",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
			)
		),
		"position" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.position",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"company" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.company",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"address" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.address",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
			)
		),
		"zip" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.zip",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
			)
		),
		"city" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.city",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
			)
		),
		"country" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.country",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
			)
		),
		"billing_address" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.billing_address",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",	
				"rows" => "5",
			)
		),
		"email" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.email",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
			)
		),
		"phone" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.phone",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"partner_code" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_participants.partner_code",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "hidden;;1;;1-1-1, firstname, lastname, position, company, address, zip, city, country, billing_address, email, phone, partner_code")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);



$TCA["tx_julleevents_events"] = Array (
	"ctrl" => $TCA["tx_julleevents_events"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,starttime,endtime,title,date,enddate,city,teaser,regtext,regstart,regend,show_participants,priority,notify_email,pages,participants"
	),
	"feInterface" => $TCA["tx_julleevents_events"]["feInterface"],
	"columns" => Array (
		"hidden" => Array (		
			"exclude" => 1,	
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,	
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,	
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"title" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
				"eval" => "required",
			)
		),
		"date" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.date",		
			"config" => Array (
				"type" => "input",
				"size" => "12",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
			)
		),
		"enddate" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.enddate",		
			"config" => Array (
				"type" => "input",
				"size" => "12",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
			)
		),
		"city" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.city",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
				)
			),
		"city_rel" => Array (        
        "exclude" => 0,        
        "label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.city_rel",        
        "config" => Array (
            "type" => "group",    
            "internal_type" => "db",    
            "allowed" => "tx_julleevents_cities",    
            "size" => 1,    
            "minitems" => 0,
            "maxitems" => 1,    
						)
				),
		
		"category" => Array (        
        "exclude" => 0,        
        "label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.category",        
        "config" => Array (
            "type" => "group",    
            "internal_type" => "db",    
            "allowed" => "tx_julleevents_categories",    
            "size" => 5,    
            "minitems" => 0,
            "maxitems" => 100,    
            "MM" => "tx_julleevents_events_category_mm",
						)
				),
		"teaser" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.teaser",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => Array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"regtext" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.regtext",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => Array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"regstart" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.regstart",		
			"config" => Array (
				"type" => "input",
				"size" => "12",
				"max" => "20",
				"eval" => "datetime",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"regend" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.regend",		
			"config" => Array (
				"type" => "input",
				"size" => "12",
				"max" => "20",
				"eval" => "datetime",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"show_participants" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.show_participants",		
			"config" => Array (
				"type" => "input",	
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"range" => Array (
					"upper" => "1000",
					"lower" => "0"
				),
				"default" => 3
			)
		),
		"max_participants" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.max_participants",		
			"config" => Array (
				"type" => "input",	
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"range" => Array (
					"upper" => "1000",
					"lower" => "0"
				),
				"default" => 3
			)
		),
		"max_page" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.max_page",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "pages",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"notify_email" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.notify_email",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
			)
		),
		"pages" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.pages",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "pages",	
				"size" => 5,	
				"minitems" => 0,
				"maxitems" => 30,
			)
		),
		"participants" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.participants",		
			"config" => Array (
				"exclude" => 1,
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_julleevents_participants",	
				"size" => 15,	
				"minitems" => 0,
				"maxitems" => 100,	
				"MM" => "tx_julleevents_events_participants_mm",
			)
		),
		"priority" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_events.priority",		
			"config" => Array (
				"type" => "input",	
				"size" => "3",
				"max" => "3",
				"eval" => "int",
				"checkbox" => "0",
				"range" => Array (
					"upper" => "10",
					"lower" => "-10"
				),
				"default" => 0
				),
			),
		),
	"types" => Array (
		"0" => Array("showitem" => "hidden;;1;;1-1-1, title;;;;2-2-2, date, enddate, city, city_rel, category, teaser;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts], regtext;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts], regstart;;;;3-3-3, regend, show_participants, max_participants, max_page, priority, notify_email, pages;;;;4-4-4, participants")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime")
	)
);

$TCA["tx_julleevents_partners"] = Array (
	"ctrl" => $TCA["tx_julleevents_partners"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,starttime,endtime,name,link,logo,sponsors"
	),
	"feInterface" => $TCA["tx_julleevents_partners"]["feInterface"],
	"columns" => Array (
		"hidden" => Array (		
			"exclude" => 1,	
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,	
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,	
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"name" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_partners.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"link" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_partners.link",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"logo" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_partners.logo",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => $GLOBALS["TYPO3_CONF_VARS"]["GFX"]["imagefile_ext"],	
				"max_size" => 500,	
				"uploadfolder" => "uploads/tx_julleevents",
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"sponsors" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_partners.sponsors",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_julleevents_events",	
				"size" => 3,	
				"minitems" => 0,
				"maxitems" => 99,
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "hidden;;1;;1-1-1, name, link, logo, sponsors")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime")
	)
);

$TCA["tx_julleevents_categories"] = Array (
    "ctrl" => $TCA["tx_julleevents_categories"]["ctrl"],
    "interface" => Array (
        "showRecordFieldList" => "hidden,category"
    ),
    "feInterface" => $TCA["tx_julleevents_categories"]["feInterface"],
    "columns" => Array (
        "hidden" => Array (        
            "exclude" => 1,    
            "label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
            "config" => Array (
                "type" => "check",
                "default" => "0"
            )
        ),
        "category" => Array (        
            "exclude" => 1,        
            "label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_categories.category",        
            "config" => Array (
                "type" => "input",    
                "size" => "30",    
                "eval" => "required",
            )
        ),
    ),
    "types" => Array (
        "0" => Array("showitem" => "hidden;;1;;1-1-1, category")
    ),
    "palettes" => Array (
        "1" => Array("showitem" => "")
    )
);

$TCA["tx_julleevents_cities"] = Array (
    "ctrl" => $TCA["tx_julleevents_cities"]["ctrl"],
    "interface" => Array (
        "showRecordFieldList" => "hidden,city"
    ),
    "feInterface" => $TCA["tx_julleevents_cities"]["feInterface"],
    "columns" => Array (
        "hidden" => Array (        
            "exclude" => 1,    
            "label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
            "config" => Array (
                "type" => "check",
                "default" => "0"
            )
        ),
        "city" => Array (        
            "exclude" => 1,        
            "label" => "LLL:EXT:julle_events/locallang_db.php:tx_julleevents_cities.city",        
            "config" => Array (
                "type" => "input",    
                "size" => "30",    
                "eval" => "required",
            )
        ),
    ),
    "types" => Array (
        "0" => Array("showitem" => "hidden;;1;;1-1-1, city")
    ),
    "palettes" => Array (
        "1" => Array("showitem" => "")
    )
);


?>