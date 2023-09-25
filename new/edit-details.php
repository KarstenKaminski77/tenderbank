<?php
session_start();

require_once('../Connections/tender.php'); 

require_once('functions/functions.php');



select_db();

login();

$level = 1;

restrict_access($level);

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

if(isset($_POST['register'])){

if($_POST['company'] != NULL && $_POST['contact-person'] != NULL && $_POST['telephone'] != NULL && $_POST['address'] != NULL && $_POST['suburb'] != NULL && $_POST['city'] != NULL && $_POST['country'] != NULL && $_POST['reg-no'] != NULL && $_POST['nature-business'] != NULL && isset($_POST['company-type'])){

$company = $_POST['company'];
$name = $_POST['contact-person'];
$telephone = $_POST['telephone'];
$address = $_POST['address'];
$suburb = $_POST['suburb'];
$city = $_POST['city'];
$country = $_POST['country'];
$regno = $_POST['reg-no'];
$nature = $_POST['nature-business'];
$type = $_POST['company-type'];
$userid = $_SESSION['userid'];

mysql_query("UPDATE tbl_registered_users SET CompanyName = '$company' ,ContactPerson = '$name' ,Telephone = '$telephone' ,Address = '$address' ,Suburb = '$suburb' ,City = '$city' ,Country = '$country' ,CompanyRegNo = '$regno' ,NatureOfBusiness = '$nature' ,CompanyType = '$type' WHERE UserId = '$userid'")or die(mysql_error());

}}

$KTColParam1_Recordset1 = "0";
if (isset($_SESSION["userid"])) {
  $KTColParam1_Recordset1 = $_SESSION["userid"];
}
mysql_select_db($database_tender, $tender);
$query_Recordset1 = sprintf("SELECT tbl_users.Username, tbl_users.Password, tbl_registered_users.CompanyName, tbl_registered_users.ContactPerson, tbl_registered_users.Email, tbl_registered_users.Telephone, tbl_registered_users.Address, tbl_registered_users.Suburb, tbl_registered_users.Approved, tbl_registered_users.City, tbl_registered_users.Country, tbl_registered_users.CompanyRegNo, tbl_registered_users.NatureOfBusiness, tbl_registered_users.CompanyType, tbl_registered_users.SupplierType, tbl_registered_users.UserId FROM (tbl_users LEFT JOIN tbl_registered_users ON tbl_registered_users.UserId=tbl_users.Id) WHERE tbl_registered_users.UserId=%s ", GetSQLValueString($KTColParam1_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_tender, $tender);
$query_Recordset2 = "SELECT * FROM tbl_countries ORDER BY Country ASC";
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_tender, $tender);
$query_Recordset3 = "SELECT * FROM tbl_nature_business ORDER BY Type ASC";
$Recordset3 = mysql_query($query_Recordset3, $tender) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_SESSION['userid'])) {
  $colname_Recordset4 = $_SESSION['userid'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset4 = sprintf("SELECT * FROM tbl_users WHERE Id = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $tender) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
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
</script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<div id="banner"> 
  <a href="contact.php" class="menu-1">Contact</a> 
  <?php if(isset($_SESSION['userid'])){ ?>
  <a href="logout.php" class="menu">Logout</a>
  <?php } else { ?> 
  <a href="login.php" class="menu">Login</a>
  <?php } ?>
  <a href="terms.php" class="menu">Terms</a> 
  <a href="about.php" class="menu">About</a> 
  <a href="index.php" class="menu">Home</a> 
</div>
<div id="banner-lower">
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?></a> <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?></a></div>
<div id="menu-container-4">
  <div id="menu-logout">
  <a href="active-tenders.php" class="top-menu-1"></a>
  <a href="rft.php" class="top-menu-2"></a>
  <a href="create-user-account.php" class="top-menu-2"></a>
  <a href="edit-details.php" class="top-menu-2"></a>
  </div>
</div><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <div id="container-generic">
    <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="list-border">
          <table border="0" cellpadding="2" cellspacing="3">
            <tr>
              <td colspan="4" class="td-header">&nbsp;</td>
            </tr>
            <tr class="even">
              <td width="101">Company:</td>
              <td width="372" align="center" class="error"><input name="company" type="text" class="tarea2" id="company" value="<?php echo $row_Recordset1['CompanyName']; ?>" />
                <?php
							
							if(isset($error_1)){
									 
							echo $error_1; 
							
							}
							?></td>
              <td width="111">Contact Person:</td>
              <td width="367" align="center" class="error"><input name="contact-person" type="text" class="tarea2" id="contact-person" value="<?php echo $row_Recordset1['ContactPerson']; ?>" />
                <?php 
							
							if(isset($error_2)){
									 
							echo $error_2; 
							
							}
							?></td>
            </tr>
            <tr class="odd">
              <td>Telephone:</td>
              <td align="center" class="error"><input name="telephone" type="text" class="tarea2" id="telephone" value="<?php echo $row_Recordset1['Telephone']; ?>" />
                <?php 
							
							if(isset($error_3)){
									 
							echo $error_3; 
							
							}
							?></td>
              <td>Email:</td>
              <td align="center" class="error"><input name="email" type="text" class="tarea2" id="email" value="<?php echo $row_Recordset1['Email']; ?>" readonly="readonly" />
                <?php 
							
							if(isset($error_4)){
									 
							echo $error_4; 
							
							}
							?></td>
            </tr>
            <tr class="even">
              <td>Address:</td>
              <td align="center" class="error"><input name="address" type="text" class="tarea2" id="address" value="<?php echo $row_Recordset1['Address']; ?>" />
                <?php 
							
							if(isset($error_5)){
									 
							echo $error_5; 
							
							}
							?></td>
              <td>Suburb:</td>
              <td align="center" class="error"><input name="suburb" type="text" class="tarea2" id="suburb" value="<?php echo $row_Recordset1['Suburb']; ?>" />
                <?php 
							
							if(isset($error_6)){
									 
							echo $error_6; 
							
							}
							?></td>
            </tr>
            <tr class="odd">
              <td>City:</td>
              <td align="center" class="error"><input name="city" type="text" class="tarea2" id="city" value="<?php echo $row_Recordset1['City']; ?>" />
                <?php 
							
							if(isset($error_7)){
									 
							echo $error_7; 
							
							}
							?></td>
              <td>Country:</td>
              <td align="center" class="error"><select name="country" class="tarea2" id="country">
                <option value="" <?php if (!(strcmp("", $row_Recordset1['Country']))) {echo "selected=\"selected\"";} ?>>Select one...</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['Country']?>"<?php if (!(strcmp($row_Recordset2['Country'], $row_Recordset1['Country']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['Country']?></option>
                <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
              </select>
                <?php 
							
							if(isset($error_8)){
									 
							echo $error_8; 
							
							}
							?></td>
            </tr>
            <tr class="even">
              <td>Company Reg No:</td>
              <td align="center" class="error"><input name="reg-no" type="text" class="tarea2" id="reg-no" value="<?php echo $row_Recordset1['CompanyRegNo']; ?>" />
                <?php 
							
							if(isset($error_9)){
									 
							echo $error_9; 
							
							}
							?></td>
              <td>Nature of Business:</td>
              <td align="center" class="error"><select name="nature-business" class="tarea2" id="nature-business">
                <option value="" <?php if (!(strcmp("", $row_Recordset1['NatureOfBusiness']))) {echo "selected=\"selected\"";} ?>>Select one...</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset3['Type']?>"<?php if (!(strcmp($row_Recordset3['Type'], $row_Recordset1['NatureOfBusiness']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['Type']?></option>
                <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
              </select>
                <?php 
							
							if(isset($error_10)){
									 
							echo $error_10; 
							
							}
							?></td>
            </tr>
            <tr class="odd">
              <td> Company Type:</td>
              <td colspan="3"><label>
                <input <?php if (!(strcmp($row_Recordset1['CompanyType'],"Private"))) {echo "checked=\"checked\"";} ?> <?php if ($_POST['company-type'] == "Private") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="Private" id="company-type_0" />
                Private</label>
                <label> &nbsp; 
                  &nbsp;
                  <input <?php if (!(strcmp($row_Recordset1['CompanyType'],"Public"))) {echo "checked=\"checked\"";} ?> <?php if ($_POST['company-type'] == "Public") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="Public" id="company-type_1" />
                  Public</label>
                <label> &nbsp; 
                  &nbsp;
                  <input <?php if (!(strcmp($row_Recordset1['CompanyType'],"State / Government"))) {echo "checked=\"checked\"";} ?> <?php if ($_POST['company-type'] == "State / Government") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="State / Government" id="company-type_2" />
                  State / Government</label>
                <?php 
								
								if(isset($error_11)){
										 
								echo $error_11; 
								
								}
								?></td>
            </tr>
            <tr>
              <td colspan="4" align="right" class="td-header"><div id="btn-padding">
                  <input name="register" type="submit" class="btn-generic" id="register" value="Update" />
              </div></td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
