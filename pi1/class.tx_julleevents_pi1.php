<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2003 Christian Jul Jensen (julle@typo3.com)
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
* 
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
* 
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/** 
 * Plugin 'Events' for the 'julle_events' extension.
 *
 * @author	Christian Jul Jensen <julle@typo3.com>
 */


require_once(PATH_tslib."class.tslib_pibase.php");
include_once(t3lib_extMgm::extPath('julle_feedit').'class.tx_jullefeedit.php');


class tx_julleevents_pi1 extends tslib_pibase {
	var $prefixId = "tx_julleevents_pi1";		// Same as class name
	var $scriptRelPath = "pi1/class.tx_julleevents_pi1.php";	// Path to this script relative to the extension dir.
	var $extKey = "julle_events";	// The extension key.

	
	/**
	 * Main function
	 * 
	 * @param	string		$content: passed by TYPO3
	 * @param	array		$conf: TS configuration array passed by TYPO3
	 * @return	string		The output content
	 */
	function main($content,$conf)	{
	  switch((string)$conf["CMD"])	{
			case "singleView":
				list($t) = explode(":",$this->cObj->currentRecord);
				$this->internal["currentTable"]=$t;
				$this->internal["currentRow"]=$this->cObj->data;
				return $this->pi_wrapInBaseClass($this->singleView($content,$conf));
			break;
			default:
				if (strstr($this->cObj->currentRecord,"tt_content"))	{
					$conf["pidList"] = $this->cObj->data["pages"];
					$conf["recursive"] = $this->cObj->data["recursive"];
				}
				return $this->pi_wrapInBaseClass($this->listView($content,$conf));
			break;
		}
	}
	
	/**
	 * Generates the listview.
	 * 
	 * @param	string		$content: passed by the main function
	 * @param	array		$conf: TS configuration
	 * @return	string		The output content
	 */
	function listView($content,$conf)	{
		$this->conf=$conf;		// Setting the TypoScript passed to this function in $this->conf
		$this->dateformat = $this->conf["dateformat"] ? $this->conf["dateformat"] : "%d-%m-%y";
		$FP = $this->conf["CMD"]=="FP" ? 1 : $this->cObj->data["tx_julleevents_type"];
		$lConf = $this->conf[$FP?"frontPage.":"listView."];	// Local settings for the listView function
		$this->pi_loadLL();		// Loading the LOCAL_LANG values
		$this->category = t3lib_div::_POST($this->extKey.'_category')!=NULL?t3lib_div::_POST($this->extKey.'_category'):$this->cObj->data['tx_julleevents_category'];
		$this->city = t3lib_div::_POST($this->extKey.'_city')!=NULL?t3lib_div::_POST($this->extKey.'_city'):$this->cObj->data['tx_julleevents_city'];
		$siterootPids = $GLOBALS['TSFE']->getStorageSiterootPids();
		$this->storagePid = $siterootPids['_STORAGE_PID'];

		if ($this->piVars["showUid"])	{	// If a single element should be displayed:
			$this->internal["currentTable"] = "tx_julleevents_events";
			$this->internal["currentRow"] = $this->pi_getRecord("tx_julleevents_events",$this->piVars["showUid"]);
			
			$content = $this->singleView($content,$conf);
			return $content;
		} else {
			if (!isset($this->piVars["pointer"]))	$this->piVars["pointer"]=0;
			if (!isset($this->piVars["mode"]))	$this->piVars["mode"]=1;
	
				// Initializing the query parameters:
			list($this->internal["orderBy"],$this->internal["descFlag"]) = explode(":",$this->piVars["sort"]);
			$this->internal["results_at_a_time"]=t3lib_div::intInRange($lConf["results_at_a_time"],0,1000,3);		// Number of results to show in a listing.
			$this->internal["maxPages"]=t3lib_div::intInRange($lConf["maxPages"],0,1000,2);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal["searchFieldList"]="title,teaser";
			if($this->conf['sortByBEorder'])
			  $this->internal["orderBy"]="sorting";
			else
			  $this->internal["orderBy"]="priority DESC,date";
			
			if($this->conf['pastOrFuture']>0)
			  $aW = ' AND date > '.strtotime('-1 day');
			elseif($this->conf['pastOrFuture']<0)
			  $aW = ' AND date < '.strtotime('-1 day');

			if($this->city && 'ALL'!=$this->city) {
				$aW .= ' AND city_rel='.$this->city;
			}

			if($this->category && 'ALL'!=$this->category) {
				$mm = array('table' => 'tx_julleevents_categories',
										'mmtable' => 'tx_julleevents_events_category_mm',
										'catUidList' => $this->category
										);
			}

				// Get number of records:
			$query = $this->pi_list_query("tx_julleevents_events",1,$aW,$mm);
			$res = mysql(TYPO3_db,$query);
			if (mysql_error())	debug(array(mysql_error(),$query));
			list($this->internal["res_count"]) = mysql_fetch_row($res);
	
				// Make listing query, pass query to MySQL:
			$query = $this->pi_list_query("tx_julleevents_events",0,$aW,$mm,""," ORDER BY ".$this->internal["orderBy"]);
			$res = mysql(TYPO3_db,$query);
			if (mysql_error())	debug(array(mysql_error(),$query));
			$this->internal["currentTable"] = "tx_julleevents_events";
	
				// Put the whole list together:
			$fullTable="";	// Clear var;

			// If any categories display selectorbox
			if(!$this->cObj->data['tx_julleevents_dontshow']) {
				$fullTable .= $this->categorySelectorBox();
				$fullTable .= $this->citySelectorBox();
			}

			if ($FP)	{
			  $this->pi_tmpPageId = intval($this->cObj->data["pages"]);
			  // Adds the whole list table
			  $fullTable.=$this->makefrontpagelist($res);
			} else {

			  // Adds the whole list table
			  $fullTable.=$this->makelist($res);
			  
			  // Adds the search box:
			  $fullTable.=$this->pi_list_searchBox();
			  
			  // Adds the result browser:
			  $fullTable.=$this->pi_list_browseresults();
			}
				// Returns the content from the plugin.
			return $fullTable;
		}
	}


	function categorySelectorBox() {
		$query = 'SELECT count(*) FROM tx_julleevents_categories WHERE pid='.$this->storagePid.$GLOBALS['TSFE']->sys_page->enableFields('tx_julleevents_categories');
		$res = mysql(TYPO3_db,$query);
		if (mysql_error())	debug(array(mysql_error(),$query));
		list($numCategories) = mysql_fetch_row($res);
		if($numCategories) {
			$retCode = '<div'.$this->pi_classParam('categorySelector').'><form action="'.$this->pi_linkTP_keepPIvars_url().'" method="POST"><select name="'.$this->extKey.'_category" onChange="submit();"><option value="ALL">'.$this->pi_getLL("all_categories").'</option>';
			$query = 'SELECT uid,category FROM tx_julleevents_categories WHERE pid='.$this->storagePid.$GLOBALS['TSFE']->sys_page->enableFields('tx_julleevents_categories');
			$res = mysql(TYPO3_db,$query);
			if (mysql_error())	debug(array(mysql_error(),$query));
			while($row = mysql_fetch_assoc($res)) {
				$sel = $this->category == $row['uid']?'SELECTED':'';
				$retCode .= '<option value="'.$row['uid'].'" '.$sel.' >'.$row['category'].'</option>';
			}
			$retCode .= '</select>';
			if($this->city) {
				$retCode .= '<input type="hidden" name="'.$this->extKey.'_city" value="'.$this->city.'"';
			}
			$retCode .= '</form></div>';
			return $retCode;
		}
	}

	function citySelectorBox() {
		$query = 'SELECT count(*) FROM tx_julleevents_cities WHERE pid='.$this->storagePid.$GLOBALS['TSFE']->sys_page->enableFields('tx_julleevents_cities');
		$res = mysql(TYPO3_db,$query);
		if (mysql_error())	debug(array(mysql_error(),$query));
		list($numCities) = mysql_fetch_row($res);
		if($numCities) {
			$retCode = '<div'.$this->pi_classParam('citySelector').'><form action="'.$this->pi_linkTP_keepPIvars_url().'" method="POST"><select name="'.$this->extKey.'_city" onChange="submit();"><option value="ALL">'.$this->pi_getLL("all_cities").'</option>';
			$query = 'SELECT uid,city FROM tx_julleevents_cities WHERE pid='.$this->storagePid.$GLOBALS['TSFE']->sys_page->enableFields('tx_julleevents_cities');
			$res = mysql(TYPO3_db,$query);
			if (mysql_error())	debug(array(mysql_error(),$query));
			while($row = mysql_fetch_assoc($res)) {
				$sel = $this->city == $row['uid']?'SELECTED':'';
				$retCode .= '<option value="'.$row['uid'].'" '.$sel.' >'.$row['city'].'</option>';
			}
			$retCode .= '</select>';
			if($this->category) {
				$retCode .= '<input type="hidden" name="'.$this->extKey.'_category" value="'.$this->category.'"';
			}
			$retCode .= '</form></div>';
			return $retCode;
		}
	}


	/**
	 * Generates the list from a MySQL result.
	 * 
	 * @param	resource	$res: MySQL result ponter
	 * @return	string			
	 */
	function makelist($res)	{
		$items=Array();
			// Make list table rows
		while($this->internal["currentRow"] = mysql_fetch_assoc($res))	{
			$items[]=$this->makeListItem();
		}
	
		$out = '<DIV'.$this->pi_classParam("listrow").'>
			'.implode(chr(10),$items).'
			</DIV>';
		return $out;
	}

	/**
	 * Generates each single item for the list
	 * 
	 * @return	string		
	 */
	function makeListItem()	{
		$out='
				<P'.$this->pi_classParam("listrowField-title").'>'.$this->getFieldContent("title").'</P>
				<P'.$this->pi_classParam("listrowField-datetime").'><b>'.$this->pi_getLL("date").':</b> '.$this->getFieldContent("date").'</P>
				<P'.$this->pi_classParam("listrowField-datetime").'><b>'.$this->pi_getLL("city").':</b> '.$this->getFieldContent("city").'</P>
				<P'.$this->pi_classParam("listrowField-teaser").'><b>'.$this->pi_getLL("description").':</b> '.$this->getFieldContent("teaser").'</P>
			';
		return $out;
	}

	/**
	 * Makes list for the frontpage 
	 * 
	 * @param	resource		$res: MySQL result pointer
	 * @return	string		...
	 */
	function makefrontpagelist($res)	{
		$items=Array();
			// Make list table rows
		while($this->internal["currentRow"] = mysql_fetch_assoc($res))	{
			$items[]=$this->makeFrontPageListItem();
		}
	
		$out = '<DIV'.$this->pi_classParam("listrowFrontPage").'>
			'.implode(chr(10),$items).'
			</DIV>';
		return $out;
	}

	/**
	 * Generates eacj single item for the front page list
	 * 
	 * @return	string
	 */
	function makeFrontPageListItem()	{
		$out='
				<P'.$this->pi_classParam("listrowFrontPageField-title").'>'.$this->getFieldContent("title").'</P>
				<P'.$this->pi_classParam("listrowFrontPageField-datetime").'><b>'.$this->pi_getLL("date").':</b> '.$this->getFieldContent("date").'</P>
				<P'.$this->pi_classParam("listrowFrontPageField-datetime").'><b>'.$this->pi_getLL("city").':</b> '.$this->getFieldContent("city").'</P>
				<P'.$this->pi_classParam("listrowFrontPageField-teaser").'><b>'.$this->pi_getLL("description").':</b> '.$this->getFieldContent("teaser").'</P>
			';
		return $out;
	}


	/**
	 * Makes the single view of an event.
	 * 
	 * @param	string		$content: Content passed by TYPO3
	 * @param	array		$conf: TS configuration
	 * @return	string
	 */
	function singleView($content,$conf)	{
		$this->conf=$conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->dateformat = $this->conf["dateformat"] ? $this->conf["dateformat"] : "%d-%m-%y";

			// This sets the title of the page for use in indexed search results:
		if ($this->internal["currentRow"]["title"])	$GLOBALS["TSFE"]->indexedDocTitle=$this->internal["currentRow"]["title"];


		//Check if there are enough registered participants to show the list
		$query = 'SELECT COUNT(*) FROM tx_julleevents_participants LEFT JOIN tx_julleevents_events_participants_mm ON uid=uid_foreign WHERE NOT tx_julleevents_participants.deleted AND uid_local="'.$this->internal["currentRow"]["uid"].'"';
		$res = mysql(TYPO3_db,$query);
		if (mysql_error())	debug(array(mysql_error(),$query));
		list($numParticipants) = mysql_fetch_row($res);
		if($this->internal["currentRow"]["show_participants"]<=$numParticipants && $this->internal["currentRow"]["show_participants"]!=0) {
		  $showPart = true;
		}
		//check if registration is allowed
		if($this->internal["currentRow"]["regstart"] && $this->internal["currentRow"]["regstart"]  < time()
			 && (time() < $this->internal["currentRow"]["regend"] || !$this->internal["currentRow"]["regend"])
			 && ($this->internal["currentRow"]["max_participants"]>$numParticipants || !$this->internal["currentRow"]["max_participants"])
			 )
		  $showReg = true;


		switch($this->piVars["sub"]) {
		case "reg":
		  if($showReg)
		    $this->sub = $this->piVars["sub"];
		  elseif($this->internal["currentRow"]["max_page"])
		    $this->sub = $this->internal["currentRow"]["max_page"];
			else
		    $this->sub = array_shift(explode(",",$this->internal["currentRow"]["pages"]));
		  break;
		case "part":
		  if($showPart)
		    $this->sub = $this->piVars["sub"];
		  else
		    $this->sub = array_shift(explode(",",$this->internal["currentRow"]["pages"]));
		  break;
		default:
		  if(!$this->piVars["sub"] || !$this->piVars["sub"]==intval($this->piVars["sub"]) || !t3lib_div::inList($this->internal["currentRow"]["pages"],$this->piVars["sub"]))
		    $this->sub = array_shift(explode(",",$this->internal["currentRow"]["pages"]));
		  else
		    $this->sub = $this->piVars["sub"];
		}

		$menuArr = Array();
		foreach(t3lib_div::trimExplode(",",$this->internal["currentRow"]["pages"],1) as $menuEntryPID) {
		  $menuEntry = $GLOBALS["TSFE"]->sys_page->getPage($menuEntryPID);
		  $urlParams["sub"] = $menuEntryPID;
		  if($menuEntryPID != $this->sub)
		    $menuArr[] = $this->pi_linkTP_keepPIvars($menuEntry["title"],$urlParams);
		  else
		    $menuArr[] = $menuEntry["title"];
		}

		if($showReg) {
		  $urlParams["sub"] = "reg";
		  if($this->sub != "reg")
		    $menuArr[] = $this->pi_linkTP_keepPIvars($this->pi_getLL("registration"),$urlParams);
		  else
		    $menuArr[] = $this->pi_getLL("registration");
		

		} elseif($this->internal["currentRow"]["max_page"]) {
		  $menuEntry = $GLOBALS["TSFE"]->sys_page->getPage($this->internal["currentRow"]["max_page"]);
		  $urlParams["sub"] = "reg";
		  if($this->internal["currentRow"]["max_page"] != $this->sub)
		    $menuArr[] = $this->pi_linkTP_keepPIvars($menuEntry["title"],$urlParams);
		  else
		    $menuArr[] = $menuEntry["title"];
		}
		if($showPart) {
		  $urlParams["sub"] = "part";
		  if($this->sub != "part")
		    $menuArr[] = $this->pi_linkTP_keepPIvars($this->pi_getLL("participants"),$urlParams);
		  else
		    $menuArr[] = $this->pi_getLL("participants");

		}

		$menu = implode(" | ",$menuArr);
		$content='<DIV'.$this->pi_classParam("singleView").'>

				       <P'.$this->pi_classParam("singleViewField-title").'>'.$this->getFieldContent("title",1).', '.$this->getFieldContent("city").' - '.$this->getFieldContent("date").'</P>
				       <P'.$this->pi_classParam("singleView-Menu").'>'.$menu.'</P>
                                       <P'.$this->pi_classParam("singleView-Subcontent").'>'.$this->getSubContent().'</P>
                         </DIV>'.
		$this->pi_getEditPanel();
	
		return $content;




	}
	/**
	 * Gets the content to display in the 'sub'-part of the event
	 * 
	 * @return	string		
	 */
	 function getSubContent() {
	  if($this->sub =="reg") {
	    $feEdit = new tx_jullefeedit($this,"tx_julleevents_participants");	
		if($this->conf['excludeList']) {
			$feEdit->exclude_field_list = $this->conf['excludeList'];
		}
		if(is_array($this->conf['defaultVals.'])) {
			$feEdit->default_values = $this->conf['defaultVals.'];
		}
	    $retVal = $feEdit->doTheMagic();
	    if(!is_array($retVal))
	      return $this->getFieldContent("regtext").$retVal;
	    else {
	      if($retVal["uid"]) {
		$query= 'INSERT INTO tx_julleevents_events_participants_mm SET uid_local="'.$this->internal["currentRow"]["uid"].'",uid_foreign="'.$retVal["uid"].'"';
		mysql(TYPO3_db,$query);
		if (mysql_error())	debug(array(mysql_error(),$query));
		if($this->internal["currentRow"]["notify_email"]) {
		  $msg[] = $this->pi_getLL("subj").$this->internal["currentRow"]["title"];
		  $msg[] = $this->pi_getLL("submvals");
		  foreach($retVal["submitted_values"] as $field => $val)
		    $msg[] = $field.": ".$val;
		  $this->cObj->sendNotifyEmail(implode("\n",$msg), $this->internal["currentRow"]["notify_email"], "",$this->conf["sender-address"],$this->conf["sender-name"]);
		}
		return $this->pi_getLL("thank_you");
	      } else {
		return $this->pi_getLL("regError");;
	      }
	    }
	  }
	  if($this->sub =="part") {
	    $query = 'SELECT firstname,lastname,company FROM tx_julleevents_participants LEFT JOIN tx_julleevents_events_participants_mm ON uid=uid_foreign WHERE NOT deleted AND uid_local="'.$this->internal["currentRow"]["uid"].'"';
	    $res = mysql(TYPO3_db,$query);
	    if (mysql_error())	debug(array(mysql_error(),$query));
	    while($row = mysql_fetch_assoc($res)) {
	      $accu[] = htmlspecialchars($row["firstname"].' '.$row["lastname"].(trim($row["company"])?(' - '.$row["company"]):('')));
	    }
	    return '<p>'.implode('<br />',$accu).'</p>';
	  }
	  if($this->sub) {
	    $conf["table"] = "tt_content"; 
	    $conf["select."]["pidInList"] = $this->sub;
	    $conf["select."]["orderBy"] = "sorting";
   
   
	    return $this->cObj->CONTENT($conf);
	  }
	}
	
	/**
	 * Gets the content of a field in the current result/event
	 * 
	 * @param	string		$fN: field name
	 * @param	bool		$inverseLinking: inverse the linking of the field.
	 * @return	string		...
	 */
	function getFieldContent($fN,$inverseLinking=false)	{
		switch($fN) {
			case "uid":
				return $this->pi_list_linkSingle($this->internal["currentRow"][$fN],$this->internal["currentRow"]["uid"],1);	// The "1" means that the display of single items is CACHED! Set to zero to disable caching.
			break;
			case "title":
			  if($inverseLinking)
				return $this->internal["currentRow"]["title"];
			  else
					// This will wrap the title in a link.
				return $this->pi_list_linkSingle($this->internal["currentRow"]["title"],$this->internal["currentRow"]["uid"],1);
			break;
			case "date":
			  $date = strftime($this->dateformat,$this->internal["currentRow"]["date"]);
			  if($this->internal["currentRow"]["enddate"])
			    $date.= ' '.$this->pi_getLL("to").' '.strftime($this->dateformat,$this->internal["currentRow"]["enddate"]);
			  return $date;
			break;
			case "regstart":
				return strftime($this->dateformat.' %H:%M',$this->internal["currentRow"]["regstart"]);
			break;
			case "regend":
				return strftime($this->dateformat.' %H:%M',$this->internal["currentRow"]["regend"]);
			break;
		case 'city':
			if($this->internal["currentRow"]['city_rel']) {
				$cityrow = $GLOBALS['TSFE']->sys_page->checkRecord('tx_julleevents_cities',$this->internal["currentRow"]['city_rel']);
				return $cityrow['city'];
			} else {
				return $this->internal["currentRow"]['city'];
			}
			break;
		default:
			return $this->internal["currentRow"][$fN];
			break;
		}
	}
	/**
	 * Get the header for a field
	 * 
	 * @param	string		$fN: field name
	 * @return	string
	 */
	function getFieldHeader($fN)	{
		switch($fN) {
			case "title":
				return $this->pi_getLL("listFieldHeader_title","<em>title</em>");
			break;
			default:
				return $this->pi_getLL("listFieldHeader_".$fN,"[".$fN."]");
			break;
		}
	}
	
	/**
	 * get the header, and wrap it with a sorting link
	 * 
	 * @param	string		$fN: field name
	 * @return	string
	 */
	function getFieldHeader_sortLink($fN)	{
		return $this->pi_linkTP_keepPIvars($this->getFieldHeader($fN),array("sort"=>$fN.":".($this->internal["descFlag"]?0:1)));
	}
}



if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/julle_events/pi1/class.tx_julleevents_pi1.php"])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/julle_events/pi1/class.tx_julleevents_pi1.php"]);
}

?>