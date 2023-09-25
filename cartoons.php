<?php require_once('Connections/tender.php'); ?>
<?php
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
 
session_start();

require_once('Connections/tender.php');

require_once('functions/functions.php');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['userid'])) {
  $colname_Recordset1 = $_SESSION['userid'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset1 = sprintf("SELECT * FROM tbl_users WHERE Id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_tender, $tender);
$query_Recordset2 = "SELECT tbl_invitation_list.ContactPerson AS ContactPerson_1, tbl_invitation_list.Email AS Email_1, tbl_invitation_list.CompanyName AS CompanyName_1, tbl_tenders.TenderName, tbl_registered_users.CompanyName, tbl_registered_users.ContactPerson, tbl_registered_users.Email, tbl_registered_users.Telephone, tbl_registered_users.Address, tbl_registered_users.Suburb, tbl_registered_users.City, tbl_registered_users.Country, tbl_tender_fields.OverallTotal, tbl_invitation_list.CompanyId, tbl_tender_fields.BidderId, tbl_tender_fields.Qty, tbl_tender_fields.Description, tbl_tender_fields.Price, tbl_tender_fields.Total FROM (((tbl_tenders LEFT JOIN tbl_tender_fields ON tbl_tender_fields.TenderId=tbl_tenders.Id) LEFT JOIN tbl_registered_users ON tbl_registered_users.Id=tbl_tenders.UserId) LEFT JOIN tbl_invitation_list ON tbl_invitation_list.Id=tbl_tender_fields.BidderId) WHERE tbl_tender_fields.BidderId=3 ";
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$companyid = $_SESSION['companyid'];

mysql_select_db($database_tender, $tender);
$query_Recordset3 = "SELECT tbl_invitation_list.CompanyName, tbl_invitation_list.ContactPerson, tbl_invitation_list.Email, tbl_industries.Industry, tbl_users.Name, tbl_users.Surname, tbl_invitation_list.DateModified, tbl_invitation_list.IndustryType, tbl_invitation_list.CompanyId FROM ((tbl_invitation_list LEFT JOIN tbl_industries ON tbl_industries.Id=tbl_invitation_list.IndustryType) LEFT JOIN tbl_users ON tbl_users.Id=tbl_invitation_list.ModifiedBy) WHERE tbl_invitation_list.CompanyId = '$companyid' GROUP BY tbl_invitation_list.IndustryType";
$Recordset3 = mysql_query($query_Recordset3, $tender) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$level = 1;

//restrict_access($level,$con);

login($con);

select_db();	
	
function required_field($field){
	
	if(isset($_POST['submit'])){
		
		if(empty($field)){
			
			echo '<span class="error">Required Field</span>';
			
		}
	}
}
	
	if(!empty($_POST['subject']) && !empty($_POST['date']) && !empty($_POST['invitation-list']) && !empty($_POST['description'])){
		
		$query = mysql_query("SELECT * FROM tbl_ref_no ORDER BY Id DESC LIMIT 1")or die(mysql_error());
		$row = mysql_fetch_array($query);
		
		$tenderno = $row['Id'] + 1;
		
		mysql_query("INSERT INTO tbl_ref_no (Ref) VALUES ('$refno')")or die(mysql_error());
		
		$userid = $_SESSION['companyid'];
		$subject = $_POST['subject'];
		$description = addslashes($_POST['description']);
		$start = date('Y-m-d');
		$end = $_POST['date'];
		$invitation_type = $_POST['invitation-list'];
		
		$query3 = mysql_query("SELECT * FROM tbl_invitation_list WHERE CompanyId = '$userid' AND IndustryType = '$invitation_type'")or die(mysql_error());
		$numrows = mysql_num_rows($query3);
		
		mysql_query("INSERT INTO tbl_tenders (UserId,TenderNo,TenderName,Description,InvitationDate,ClosingDate,InvitationType,Invitations) VALUES ('$userid','$tenderno','$subject','$description','$start','$end','$invitation_type','$numrows')")or die(mysql_error());	
		
		$query2 = mysql_query("SELECT * FROM tbl_tenders ORDER BY Id DESC LIMIT 1")or die(mysql_error());
		$row2 = mysql_fetch_array($query2);
				
		$tender_id = $row2['Id'];
			
		header('Location: tender-send.php?Id='. $tender_id.'&Type='.$invitation_type);
	
	}
	
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tender Bank</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="new/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		skin_variant : "silver",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo",
		theme_advanced_buttons2 : "link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>

<script type="text/javascript">
/************************************************************************************************************
(C) www.dhtmlgoodies.com, November 2005

This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.

Terms of use:
You are free to use this script as long as the copyright message is kept intact. However, you may not
redistribute, sell or repost it without our permission.

Thank you!

www.dhtmlgoodies.com
Alf Magne Kalleland

************************************************************************************************************/

var dhtmlgoodies_slideSpeed = 10;	// Higher value = faster
var dhtmlgoodies_timer = 10;	// Lower value = faster

var objectIdToSlideDown = false;
var dhtmlgoodies_activeId = false;
var dhtmlgoodies_slideInProgress = false;
var dhtmlgoodies_expandMultiple = false;

function showHideContent(e,inputId)
{
	if(dhtmlgoodies_slideInProgress)return;
	dhtmlgoodies_slideInProgress = true;
	if(!inputId)inputId = this.id;
	inputId = inputId + '';
	var numericId = inputId.replace(/[^0-9]/g,'');
	var answerDiv = document.getElementById('dhtmlgoodies_a' + numericId);

	objectIdToSlideDown = false;

	if(!answerDiv.style.display || answerDiv.style.display=='none'){
		if(dhtmlgoodies_activeId &&  dhtmlgoodies_activeId!=numericId && !dhtmlgoodies_expandMultiple){
			objectIdToSlideDown = numericId;
			slideContent(dhtmlgoodies_activeId,(dhtmlgoodies_slideSpeed*-1));
		}else{

			answerDiv.style.display='block';
			answerDiv.style.visibility = 'visible';

			slideContent(numericId,dhtmlgoodies_slideSpeed);
		}
	}else{
		slideContent(numericId,(dhtmlgoodies_slideSpeed*-1));
		dhtmlgoodies_activeId = false;
	}
}

function slideContent(inputId,direction)
{

	var obj =document.getElementById('dhtmlgoodies_a' + inputId);
	var contentObj = document.getElementById('dhtmlgoodies_ac' + inputId);
	height = obj.clientHeight;
	if(height==0)height = obj.offsetHeight;
	height = height + direction;
	rerunFunction = true;
	if(height>contentObj.offsetHeight){
		height = contentObj.offsetHeight;
		rerunFunction = false;
	}
	if(height<=1){
		height = 1;
		rerunFunction = false;
	}

	obj.style.height = height + 'px';
	var topPos = height - contentObj.offsetHeight;
	if(topPos>0)topPos=0;
	contentObj.style.top = topPos + 'px';
	if(rerunFunction){
		setTimeout('slideContent(' + inputId + ',' + direction + ')',dhtmlgoodies_timer);
	}else{
		if(height<=1){
			obj.style.display='none';
			if(objectIdToSlideDown && objectIdToSlideDown!=inputId){
				document.getElementById('dhtmlgoodies_a' + objectIdToSlideDown).style.display='block';
				document.getElementById('dhtmlgoodies_a' + objectIdToSlideDown).style.visibility='visible';
				slideContent(objectIdToSlideDown,dhtmlgoodies_slideSpeed);
			}else{
				dhtmlgoodies_slideInProgress = false;
			}
		}else{
			dhtmlgoodies_activeId = inputId;
			dhtmlgoodies_slideInProgress = false;
		}
	}
}



function initShowHideDivs()
{
	var divs = document.getElementsByTagName('DIV');
	var divCounter = 1;
	for(var no=0;no<divs.length;no++){
		if(divs[no].className=='dhtmlgoodies_question'){
			divs[no].onclick = showHideContent;
			divs[no].id = 'dhtmlgoodies_q'+divCounter;
			var answer = divs[no].nextSibling;
			while(answer && answer.tagName!='DIV'){
				answer = answer.nextSibling;
			}
			answer.id = 'dhtmlgoodies_a'+divCounter;
			contentDiv = answer.getElementsByTagName('DIV')[0];
			contentDiv.style.top = 0 - contentDiv.offsetHeight + 'px';
			contentDiv.className='dhtmlgoodies_answer_content';
			contentDiv.id = 'dhtmlgoodies_ac' + divCounter;
			answer.style.display='none';
			answer.style.height='1px';
			divCounter++;
		}
	}
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
</script>
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="Calendar.js"></script>
<script type="text/javascript" src="includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="includes/resources/calendar.js"></script>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table width="982" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" valign="bottom" nowrap="nowrap" class="header"><?php echo $row_Recordset2['TenderName']; ?></td>
    <td align="right" style="text-align:right"><div><span class="header"><?php echo $row_Recordset2['CompanyName_1']; ?><br />
    </span></div></td>
  </tr>
  <tr>
    <td colspan="3" valign="bottom" nowrap="nowrap">&nbsp;</td>
    <td width="483" align="right"><?php echo $row_Recordset2['ContactPerson_1']; ?><br />
      <?php echo $row_Recordset2['Email_1']; ?><br />
      <br />
      <?php echo date('d-M-Y'); ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><?php echo $row_Recordset2['Description']; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  </table>
  <table width="982" align="center" cellpadding="0" cellspacing="0" border="1">
  <tr>
    <td bgcolor="#D7D7D7">&nbsp;</td>
    <td bgcolor="#D7D7D7">&nbsp;</td>
    <td bgcolor="#D7D7D7">&nbsp;</td>
    <td bgcolor="#D7D7D7">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td width="100">&nbsp;</td>
    <td width="100">&nbsp;</td>
    <td width="100">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

?>
