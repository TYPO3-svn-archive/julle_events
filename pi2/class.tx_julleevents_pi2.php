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
 * Plugin 'Events' for the 'tx_julleevents' extension.
 *
 * @author	Christian Jul Jensen <julle@typo3.com>
 */


require_once(PATH_tslib."class.tslib_pibase.php");

class tx_julleevents_pi2 extends tslib_pibase {
	var $prefixId = "tx_julleevents_pi2";		// Same as class name
	var $scriptRelPath = "pi2/class.tx_julleevents_pi2.php";	// Path to this script relative to the extension dir.
	var $extKey = "tx_julleevents";	// The extension key.
	
	/**
	 * [Put your description here]
	 * 
	 * @param	[type]		$content: ...
	 * @param	[type]		$conf: ...
	 * @return	[type]		...
	 */
	function main($content,$conf)	{
	  $pi1GPvars = t3lib_div::GPvar("tx_julleevents_pi1");
	  $query = 'SELECT * FROM tx_julleevents_partners WHERE sponsors LIKE"'.$pi1GPvars["showUid"].'"';
	  $res = mysql(TYPO3_db,$query);
	  if (mysql_error())	debug(array(mysql_error(),$query));
	  while($row = mysql_fetch_assoc($res)) {
	    $logo = $this->getImage($row["logo"],$conf["image."]);
	    $uP = parse_url($row["link"]);
	    $value = $uP["host"].($uP["path"]&&$uP["path"]!="/"?$uP["path"]:"");
	    $out = '<a href="http://'.$value.'" target="_blank">'.$logo.'</a>';
	  }

	  return $out;

	}

	/**
	 * [Describe function...]
	 * 
	 * @param	[type]		$filename: ...
	 * @param	[type]		$TSconf: ...
	 * @return	[type]		...
	 */
	function getImage($filename,$TSconf)    {
	  list($theImage)=explode(",",$filename);
	  $TSconf["file"] = "uploads/tx_julleevents/".$theImage;
	  
	  $img = $this->cObj->IMAGE($TSconf);
	  return $img;
	}

}



if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/julle_events/pi2/class.tx_julleevents_pi2.php"])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/julle_events/pi2/class.tx_julleevents_pi2.php"]);
}

?>