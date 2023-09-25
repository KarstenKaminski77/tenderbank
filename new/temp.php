<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
 
session_start();

require_once('../Connections/tender.php');

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

$colname_Recordset2 = "-1";
if (isset($_SESSION['userid'])) {
  $colname_Recordset2 = $_SESSION['userid'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset2 = sprintf("SELECT * FROM tbl_registered_users WHERE UserId = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$level = 1;

//restrict_access($level);

login();

select_db();

if(!isset($_POST['row-count'])){
	
	$list_rows = 1;
	
} else {
	
	$list_rows = $_POST['row-count'];
	
}

if(isset($_POST['invite-new'])){
	
	$list_rows = $_POST['row-count'] + 1;
	
	}
	

	
if(isset($_POST['insert']) && $_POST['description'] == NULL){
	
	$error_1 = 'Required field';
	
	}
	
if(isset($_POST['insert']) && !isset($_FILES['filepc']) && ($_POST['Name'] == NULL || $_POST['company'] == NULL || $_POST['email'] == NULL)){
	
	$error_2 = 'Please select an ivitation method';
	
	}
	
if(isset($_POST['insert']) && $_POST['date'] == NULL){
	
	$error_3 = 'Required field';
	
	}
	
if(isset($_POST['insert']) && !isset($error_1) && !isset($error_1) && !isset($error_1)){
	
	
	$invitation_type = 2;
	
	if(isset($_FILES['csv'])){
		
		$target_path = "csv/";
		
		$target_path = $target_path . basename($_FILES['csv']['name']);
		
		if(move_uploaded_file($_FILES['csv']['tmp_name'], $target_path));
		
		$invitation_type = 1;
		
		$csv = $_FILES['csv']['name'];
		
	}
	
	$query = mysql_query("SELECT * FROM tbl_ref_no ORDER BY Id DESC LIMIT 1")or die(mysql_error());
	$row = mysql_fetch_array($query);
	
	$tenderno = $row['Id'] + 1;
	
	mysql_query("INSERT INTO tbl_ref_no (Ref) VALUES ('$refno')")or die(mysql_error());
	
	$userid = $_SESSION['userid'];
	$subject = $_POST['subject'];
	$description = addslashes($_POST['description']);
	$start = date('Y-m-d');
	$end = $_POST['date'];
	
	mysql_query("INSERT INTO tbl_tenders (UserId,TenderNo,TenderName,Description,InvitationDate,ClosingDate,InvitationType,CSV) VALUES ('$userid','$tenderno','$subject','$description','$start','$end','$invitation_type','$csv')")or die(mysql_error());		
	
}
		
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
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset1['Name']; ?> <?php echo $row_Recordset1['Surname']; ?></a> <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset1['LastLogin'])); ?></a></div>
<div id="menu-ontainer">
  <div id="menu-logout"></div>
</div>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div id="container">
    <table width="964" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>
          <table width="982" border="0" align="center" cellpadding="2" cellspacing="3">
            <tr>
              <td colspan="2" valign="bottom" nowrap="nowrap" class="header">Request for Tender</td>
              <td align="right"><span class="header"><?php echo $row_Recordset2['CompanyName']; ?><br />
              </span></td>
            </tr>
            <tr>
              <td valign="bottom" nowrap="nowrap"><strong>Closing Date</strong></td>
              <td valign="bottom" nowrap="nowrap"><input name="date" class="tarea-generic" id="date" value="<?php echo $_POST['date']; ?>" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format.' '.$KT_screen_time_format; ?>" wdg:type="widget" wdg:mondayfirst="false" wdg:singleclick="false" wdg:restricttomask="no" wdg:readonly="true" /></td>
              <td width="891" align="right">
              <?php echo $row_Recordset2['Address']; ?><br />
              <?php echo $row_Recordset2['Suburb']; ?><br />
              <?php echo $row_Recordset2['City']; ?><br />
              <?php echo $row_Recordset2['Country']; ?></td>
            </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            </table>
          <table border="0" cellpadding="0" cellspacing="0">
           <tr><td>
          <div id="list-border">
          <table cellpadding="0" cellspacing="1">
          <tr><td class="td-header"><strong>&nbsp;Subject</strong></td>
          </tr><tr>
          <td><input name="subject" type="text" class="tfield-subject" id="subject" value="<?php echo $_POST['subject']; ?>" /></td>
          </tr>
          </table>
          </div>
          </td></tr>
          </table>
          <table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">
              <table border="0" cellpadding="0" cellspacing="0">
              <tr><td>
              <div id="list-border">
                <table border="0" cellpadding="0" cellspacing="1">
                  <tr>
                    <td colspan="2" class="td-header">&nbsp;<strong>Description</strong></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" class="even"><textarea name="description" class="tender-tarea" id="description"><?php echo $_POST['description']; ?></textarea></td>
                  </tr>
                  </table>
                  </div>
               </td></tr>
               </table>
                  <table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>
<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="list-border"><table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>                    <div class="dhtmlgoodies_question" id="show-hide">
                      <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><span class="dhtmlgoodies_question">&nbsp;Upload Invitations CSV Format </span></td>
                          <td align="right"><span class="dhtmlgoodies_question" style="margin-top:3px"> <a href="images/csv.png" class="look_inside" onclick="return hs.expand(this)"> <img src="images/help.png" width="18" height="18" border="0" /></a></span></td>
                        </tr>
                      </table>
                    </div>
                      <div id="file-upload">
                        <div class="dhtmlgoodies_answer">
                          <div style="background-color:#FFF; margin:1px">
                            <input name="csv" type="file" class="btn-generic" id="csv" />
                          </div>
                        </div>
                      </div>
</td>
  </tr>
</table>
</div></td>
  </tr>
</table>
<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
<tr><td>
<div id="list-border">
<table border="0" cellpadding="0" cellspacing="0">
<tr><td>
<div class="dhtmlgoodies_question" id="show-hide">&nbsp;Add Invitations Manually</div>
                      <div class="dhtmlgoodies_answer">
                        <div>
                          <table border="0" cellspacing="3" cellpadding="2">
                            <tr class="rft-bold">
                              <td>Company </td>
                              <td>Contact Person</td>
                              <td colspan="2">Email Address</td>
                            </tr>
                            <?php 
		
		$company = $_POST['company'];
		$mail = $_POST['email'];
		$name = $_POST['name'];
		
		for($c=0;$c<$list_rows;$c++){ 
		
		$company1 = $company[$c];
		$email = $mail[$c];
		$name1 = $name[$c];
		
		?>
                            <tr>
                              <td align="center"><input name="company[]" type="text" class="tarea-rft" id="company[]" value="<?php if(isset($_POST['invite-new'])){ echo $company1; } ?>" /></td>
                              <td align="center"><input name="name[]" type="text" class="tarea-rft" id="name[]" value="<?php if(isset($_POST['invite-new'])){ echo $name1; } ?>" />
                                <input name="nature_id" type="hidden" id="nature_id" value="<?php echo $row_Recordset1['Id']; ?>" />
                                <input type="hidden" name="row-count" id="row-count" value="<?php echo $list_rows; ?>" /></td>
                              <td align="center"><input name="email[]" type="text" class="tarea-rft" id="email[]" value="<?php if(isset($_POST['invite-new'])){ echo $email; } ?>" /></td>
                              <td align="center"><?php if($c == 0){ ?>
                                <input name="invite-new" type="submit" class="new-nature-business" id="invite-new" value="" />
                                <?php } ?></td>
                            </tr>
                            <?php } ?>
                          </table>
                        </div>
                      </div>
</td></tr>
</table>
</div>
</td></tr>
</table>
                      <script type="text/javascript">
initShowHideDivs();
<?php if(isset($_POST['invite-new'])){ ?>
showHideContent(false,2);	// Automatically expand first item
<?php } ?>
                  </script></td>
                  </tr>
                </table>
              </td>
            </tr>
        </table></td>
      </tr>
    </table>
  </div>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right"><div style="padding-right:20px; padding-bottom:20px">
        <input name="submit" type="submit" class="btn-generic" id="submit" value="Request for Tender" />
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
