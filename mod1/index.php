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
 * Module 'Event management' for the 'julle_events' extension.
 *
 * @author	Christian Jul Jensen <julle@typo3.com>
 */



	// DEFAULT initialization of a module [BEGIN]
unset($MCONF);	
require ("conf.php");
require ($BACK_PATH."init.php");
require ($BACK_PATH."template.php");
include ("locallang.php");
require_once (PATH_t3lib."class.t3lib_scbase.php");
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]

class tx_julleevents_module1 extends t3lib_SCbase {
	var $pageinfo;

	/**
	 * @return	[type]		...
	 */
	function init()	{
		global $AB,$BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$HTTP_GET_VARS,$HTTP_POST_VARS,$CLIENT,$TYPO3_CONF_VARS;
		
		parent::init();

		/*
		if (t3lib_div::GPvar("clear_all_cache"))	{
			$this->include_once[]=PATH_t3lib."class.t3lib_tcemain.php";
		}
		*/
	}

	/**
	 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
	 * 
	 * @return	[type]		...
	 */
	function menuConfig()	{
		global $LANG;
		$this->MOD_MENU = Array (
			"function" => Array (
				"1" => $LANG->getLL("function1"),
				"2" => $LANG->getLL("function2"),
				//				"3" => $LANG->getLL("function3"),
			)
		);
		parent::menuConfig();
	}

		// If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
	/**
	 * Main function of the module. Write the content to $this->content
	 * 
	 * @return	[type]		...
	 */
	function main()	{
		global $AB,$BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$HTTP_GET_VARS,$HTTP_POST_VARS,$CLIENT,$TYPO3_CONF_VARS;
		
		// Access check!
		// The page will show only if there is a valid page and if this page may be viewed by the user
		$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
		$access = is_array($this->pageinfo) ? 1 : 0;
		
		if (($this->id && $access) || ($BE_USER->user["admin"] && !$this->id))	{
	
				// Draw the header.
			$this->doc = t3lib_div::makeInstance("mediumDoc");
			$this->doc->backPath = $BACK_PATH;
			$this->doc->form='<form action="" method="POST">';

				// JavaScript
			$this->doc->JScode = '
				<script language="javascript">
					script_ended = 0;
					function jumpToUrl(URL)	{
						document.location = URL;
					}
				</script>
			';
			$this->doc->postCode='
				<script language="javascript">
					script_ended = 1;
					if (top.theMenu) top.theMenu.recentuid = '.intval($this->id).';
				</script>
			';

			$headerSection = $this->doc->getHeader("pages",$this->pageinfo,$this->pageinfo["_thePath"])."<br>".$LANG->php3Lang["labels"]["path"].": ".t3lib_div::fixed_lgd_pre($this->pageinfo["_thePath"],50);

			$this->content.=$this->doc->startPage($LANG->getLL("title"));
			$this->content.=$this->doc->header($LANG->getLL("title"));
			$this->content.=$this->doc->spacer(5);
			$this->content.=$this->doc->section("",$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,"SET[function]",$this->MOD_SETTINGS["function"],$this->MOD_MENU["function"])));
			$this->content.=$this->doc->divider(5);

			
			// Render content:
			$this->moduleContent();

			
			// ShortCut
			if ($BE_USER->mayMakeShortcut())	{
				$this->content.=$this->doc->spacer(20).$this->doc->section("",$this->doc->makeShortcutIcon("id",implode(",",array_keys($this->MOD_MENU)),$this->MCONF["name"]));
			}
		
			$this->content.=$this->doc->spacer(10);
		} else {
				// If no access or if ID == zero
		
			$this->doc = t3lib_div::makeInstance("mediumDoc");
			$this->doc->backPath = $BACK_PATH;
		
			$this->content.=$this->doc->startPage($LANG->getLL("title"));
			$this->content.=$this->doc->header($LANG->getLL("title"));
			$this->content.=$this->doc->spacer(5);
			$this->content.=$this->doc->spacer(10);
		}
	}

	/**
	 * Prints out the module HTML
	 * 
	 * @return	[type]		...
	 */
	function printContent()	{
		global $SOBE;

		$this->content.=$this->doc->middle();
		$this->content.=$this->doc->endPage();
		echo $this->content;
	}
	
	/**
	 * Generates the module content
	 * 
	 * @return	[type]		...
	 */
	function moduleContent()	{
	  global $LANG;
	  $evUid = t3lib_div::GPvar("ev");
//   	  debug($GLOBALS["HTTP_GET_VARS"]);
//   	  debug($GLOBALS["HTTP_POST_VARS"]);
//   	  debug($evUid);
	  if(!$evUid) {
	    $query = 'SELECT count(*),pid FROM tx_julleevents_events WHERE 1=1 '.t3lib_BEfunc::deleteClause("tx_julleevents_events")." GROUP BY pid";
	    $res = mysql(TYPO3_db,$query);
	    if (mysql_error())	debug(array(mysql_error(),$query));
	    $links=array();
	    // !
	    //	  $links[] = "GET:".t3lib_div::view_array($GLOBALS["HTTP_GET_VARS"])."<BR>";
	    // !
	    while($row = mysql_fetch_assoc($res)) {
	      if ($GLOBALS["BE_USER"]->isInWebMount($row["pid"]))	{
		$pRec = t3lib_BEfunc::getRecord("pages",$row["pid"]);
		$links[]='<a href="index.php?id='.$pRec["uid"].'"><img src="'.$GLOBALS["BACK_PATH"].'t3lib/gfx/i/sysf.gif" width="18" height="16" border="0" alt="" align="absmiddle">'.htmlspecialchars($pRec["title"]).'</a><BR>'; 
		if($pRec["uid"]==$this->id) {
		  $query = 'SELECT uid,title FROM tx_julleevents_events WHERE pid='.$this->id.' '.t3lib_BEfunc::deleteClause("tx_julleevents_events");
		  $evRes = mysql(TYPO3_db,$query);
		  if (mysql_error())	debug(array(mysql_error(),$query));
		  $count = mysql_num_rows($evRes);
		  $i = 0;
		  while($evRow = mysql_fetch_assoc($evRes)) {
		    
		    if(++$i==$count)
		      $line="joinbottom.gif";
		    else
		      $line="join.gif";
		    $links[]='<a href="index.php?id='.$pRec["uid"].'&ev='.$evRow["uid"].'"><img src="'.$GLOBALS["BACK_PATH"].'t3lib/gfx/ol/'.$line.'" width="18" height="16" border="0" alt="" align="absmiddle"><img src="'.$GLOBALS["BACK_PATH"].'t3lib/gfx/i/default_red.gif" width="18" height="16" border="0" alt="" align="absmiddle">'.htmlspecialchars($evRow["title"]).'</a><BR>'; 
		  }
		}
		
	      }
	    }
	    if (count($links))	{
	      $this->content.=$this->doc->section($LANG->getLL("choose_event").":",implode("",$links),0,1);
	    } else {
	      $content='There were no pages with newsletter categories found!';
	    $this->content.=$this->doc->section("Pages with newletter categories:",$content,0,1);
	    }
	  } else {
	    $content = '<input type="hidden" name="ev" value="'.$evUid.'">';

	    $query = 'SELECT * FROM tx_julleevents_participants AS p LEFT JOIN tx_julleevents_events_participants_mm AS mm ON p.uid=mm.uid_foreign LEFT JOIN tx_julleevents_events AS e ON e.uid=mm.uid_local WHERE e.uid='.$evUid.' '.t3lib_BEfunc::deleteClause("p");
	    $res = mysql(TYPO3_db,$query);
	    if (mysql_error())	debug(array(mysql_error(),$query));
	    switch((string)$this->MOD_SETTINGS["function"])	{
	    case 1:
	      $fields = "firstname,lastname,position,company,address,zip,country,billing_address,email,phone,partner_code";
	      $fields = explode(",",$fields);

	      $chkAll = t3lib_div::GPvar("chkall");
	      $GPfields = t3lib_div::GPvar("field");
	      $chkLL = "chkall";
	      if($chkAll) {
		$chk = "checked";
		$chkLL = "unchkall";
	      }	      
	      if(sizeof($GPfields)==sizeof($fields)) {
		$chkLL = "unchkall";
		if($chkAll) {
		  $chkLL = "chkall";
		  $chk = "";
		  $chkAll = true;
		}
	      }
	      $csv_list = Array();
	      if(is_array($GPfields)) {
		foreach($GPfields as $GPfield => $on) {
		  $acc[] = $LANG->getLL($GPfield);
		}
		$csv_list[] = implode(",",$acc);
		unset($acc);
		
		while($row = mysql_fetch_assoc($res)) {
		  $title = $row["title"];
		  foreach($GPfields as $GPfield => $on) {
		    $acc[] = '"'.$row[$GPfield].'"';
		  }
		  $csv_list[] = implode(",",$acc);
		  unset($acc);
		}
	      }
	      $content .='<div align=center style="text-decoration:underline"><strong>'.$title."</strong></div>";


	      $content .= $LANG->getLL("select_fields");
	      $content .= '<div style="margin-left:20px"><table>';
	      $content .= '<tr><td bgcolor="'.$this->doc->bgColor4.'">'.$LANG->getLL("field").':</td><td bgcolor="'.$this->doc->bgColor4.'">'.$LANG->getLL("show").'</td><td style="width:150px;text-align: center" bgcolor="'.$this->doc->bgColor4.'">'.$LANG->getLL($chkLL).'</td><tr>';
	      $first = true;
	      foreach($fields as $field) {
		if(!$chkAll)
		  $chk = isset($GPfields[$field])?"Checked":"";
		$content .= '<tr><td bgcolor="'.$this->doc->bgColor5.'">'.$LANG->getLL($field).':</td><td bgcolor="'.$this->doc->bgColor5.'"><input type="checkbox" name="field['.$field.']" '.$chk.'></td>'.($first?'<td bgcolor="'.$this->doc->bgColor6.'" align="right"><input type="checkbox" onChange="this.value=\'click\';submit();" name="chkall" ></td>':"").'<tr>';
		$first = false;
	      }
	      $content .= '</table></div>';
	      $content .= '<div align="right"><input type="submit" name="_update" value="'.$LANG->getLL("update").'"></div>';
	      $content .= '<textarea rows="20" '.$this->doc->formWidthText(48,"","off").' rows="10" wrap="off">'.t3lib_div::formatForTextarea(implode("\r\n",$csv_list)).'</textarea>';
	      $content .= '<input type="submit" name="_dl" value="'.$LANG->getLL("download").'">';
	      $content .= '<p><b><a href="index.php?id='.$this->id.'">'.$LANG->getLL("select_new_event").'</a></b></p>';
	      $this->content.=$this->doc->section($LANG->getLL("function1"),$content,0,1);
	      if(t3lib_div::GPvar("_dl")) {
		$filename=$title."_csv_list_".date("dmy-Hi").".txt";
		$mimeType = "application/octet-stream";
		Header("Content-Type: ".$mimeType);
		Header("Content-Disposition: attachment; filename=".$filename);
		echo implode("\r\n",$csv_list);
		exit;
	      }
	      break;
	    case 2:
	      $email_list = Array();
	      while($row = mysql_fetch_assoc($res)) {
		$title = $row["title"];
		$rich_adr = (trim($row["firstname"])?trim($row["firstname"])." ":"").(trim($row["lastname"])?trim($row["lastname"])." ":"")."<".trim($row["email"]).">";
		if(trim($row["email"])!="")
		  $email_list[] = $rich_adr;
	      }
	      $content .='<div align=center style="text-decoration:underline"><strong>'.$title."</strong></div>";
	      $content .= '<textarea rows="20" '.$this->doc->formWidthText(48,"","off").' rows="10" wrap="off">'.t3lib_div::formatForTextarea(implode(", ",$email_list)).'</textarea>';
	      $content .= '<input type="submit" name="_dl" value="'.$LANG->getLL("download").'">';
	      $content .= '<p><b><a href="index.php?id='.$this->id.'">'.$LANG->getLL("select_new_event").'</a></b></p>';
	      $this->content.=$this->doc->section($LANG->getLL("function2"),$content,0,1);
	      if(t3lib_div::GPvar("_dl")) {
		$filename=$title."_email_list_".date("dmy-Hi").".txt";
		$mimeType = "application/octet-stream";
		Header("Content-Type: ".$mimeType);
		Header("Content-Disposition: attachment; filename=".$filename);
		echo implode(", ",$email_list);
		exit;
	      }
	      break;
	    case 3:
	      $content="<div align=center><strong>Hello World!</strong></div><BR>
					The 'Kickstarter' has made this module automatically, it contains a default framework for a backend module but apart from it does nothing useful until you open the script '".substr(t3lib_extMgm::extPath("julle_events"),strlen(PATH_site))."mod1/index.php' and edit it!
					<HR>
					<BR>This is the GET/POST vars sent to the script:<BR>".
		"GET:".t3lib_div::view_array($GLOBALS["HTTP_GET_VARS"])."<BR>".
		"POST:".t3lib_div::view_array($GLOBALS["HTTP_POST_VARS"])."<BR>".
		"";
	      $this->content.=$this->doc->section("Message #1:",$content,0,1);
	      break;
	    } 
	  }
	}

}



if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/julle_events/mod1/index.php"])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/julle_events/mod1/index.php"]);
}




// Make instance:
$SOBE = t3lib_div::makeInstance("tx_julleevents_module1");
$SOBE->init();

// Include files?
reset($SOBE->include_once);	
while(list(,$INC_FILE)=each($SOBE->include_once))	{include_once($INC_FILE);}

$SOBE->main();
$SOBE->printContent();

?>