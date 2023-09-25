<?php 
session_start();

require_once('../Connections/tender.php'); 

require_once('functions/functions.php');

select_db();

login();

$level = 1;

restrict_access($level);

if(isset($_POST['insert'])){
				
				if(empty($_POST['name'])){
					
					$error_1 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['surname'])){
					
					$error_2 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['email'])){
					
					$error_3 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['password'])){
					
					$error_4 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['access'])){
					
					$error_5 = '<span class="error">Required Field</span>';
					
				}
				
				if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['access'])){
					
					$name = $_POST['name'];
					$surname = $_POST['surname'];
					$email = $_POST['email'];
					$password = $_POST['password'];
					$companyid = $_SESSION['companyid'];
					
					mysql_query("INSERT INTO tbl_users (Name,Surname,Username,Password,CompanyId,UserLevel) VALUES ('$name','$surname','$email','$password','$companyid','2')")or die(mysql_error());
					
					$query = mysql_query("SELECT * FROM tbl_users ORDER BY Id DESC LIMIT 1")or die(mysql_error());
					$row = mysql_fetch_array($query);
					
					$userid = $row['Id'];
					
					mysql_query("DELETE FROM tbl_menu_relation WHERE UserId = '$userid'")or die(mysql_error());
					
					$count = count($_POST['access']);
					
					$access = $_POST['access'];
					
					for($i=0;$i<$count;$i++){
						
						$menuid = $access[$i];
						
						mysql_query("INSERT INTO tbl_menu_relation (UserId,MenuId) VALUES ('$userid','$menuid')")or die(mysql_error());
						
					}
					
$subject = 'Tender Bank Login Details';

$message = '
<body style="font-family:Arial; font-size:12px; color:002a76">
<table border="0" cellspacing="3" cellpadding="2" style="font-family:Arial; font-size:12px; color:002a76">
  <tr>
    <td width="329"><img src="http://www.tenderbank.co.za/images/logo.jpg" width="305" height="60" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>Hi '.$name.'<br />
      <br />
      <br />
    Your account with Tender Bank has been successfully created.<br />
    <br />
    Please use the following username and associated password to   securely access the &quot;My Account&quot; Tab at <a href="http://www.tenderbank.co.za">http://www.tenderbank.co.za</a>.<br />
    <br />
    </p>
      <table border="0" cellspacing="3" cellpadding="2" style="font-family:Arial; font-size:12px; color:002a76">
        <tr>
          <td><strong>Username</strong></td>
          <td>'.$email.'</td>
        </tr>
        <tr>
          <td><strong>Password</strong></td>
          <td>'.$password.'</td>
        </tr>
      </table>
      <p>        Kind Regards</p>
      <p>Tender Bank<br />
    </p></td>
  </tr>
</table>
</body>
';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'FROM: test@kwd.co.za' . "\r\n";
$headers .= 'Cc: nicky@seavest.co.za' . "\r\n";

mail($email, $subject, $message, $headers);
					
				}
}

if(isset($_POST['update'])){
				
				if(empty($_POST['name'])){
					
					$error_1 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['surname'])){
					
					$error_2 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['email'])){
					
					$error_3 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['password'])){
					
					$error_4 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['access'])){
					
					$error_5 = '<span class="error">Required Field</span>';
					
				}
				
				if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['access'])){
					
					$userid = $_GET['Id'];
					
					$name = $_POST['name'];
					$surname = $_POST['surname'];
					$email = $_POST['email'];
					$password = $_POST['password'];
					
					mysql_query("UPDATE tbl_users SET Name = '$name', Surname = '$surname', Username = '$email', Password = '$password' WHERE Id = '$userid'")or die(mysql_error());
					
					mysql_query("DELETE FROM tbl_menu_relation WHERE UserId = '$userid'")or die(mysql_error());
					
					$count = count($_POST['access']);
					
					$access = $_POST['access'];
					
					for($i=0;$i<$count;$i++){
						
						$menuid = $access[$i];
						
						mysql_query("INSERT INTO tbl_menu_relation (UserId,MenuId) VALUES ('$userid','$menuid')")or die(mysql_error());
						
					}
				}
}

if(isset($_GET['delete'])){
	
	$id = $_GET['delete'];
	
	mysql_query("DELETE FROM tbl_users WHERE Id = '$id'")or die(mysql_error());
	mysql_query("DELETE FROM tbl_menu_relation WHERE UserId = '$id'")or die(mysql_error());
	
}
	
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

mysql_select_db($database_tender, $tender);
$query_Recordset1 = "SELECT * FROM tbl_menu_items ORDER BY Name ASC";
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_SESSION['companyid'])) {
  $colname_Recordset2 = $_SESSION['companyid'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset2 = sprintf("SELECT * FROM tbl_users WHERE CompanyId = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset3 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset3 = sprintf("SELECT * FROM tbl_users WHERE Id = %s", GetSQLValueString($colname_Recordset3, "int"));
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

if(isset($_GET['Id'])){
	
	$value_1 = $row_Recordset3['Name'];
	$value_2 = $row_Recordset3['Surname'];
	$value_3 = $row_Recordset3['Username'];
	$value_4 = $row_Recordset3['Password'];
	
} else {
	
	$value_1 = '';
	$value_2 = '';
	$value_3 = '';
	$value_4 = '';

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
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?></a> <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?></a></div>
<div id="menu-container-3">
  <div id="menu-logout">
  <a href="active-tenders.php" class="top-menu-1"></a>
  <a href="rft.php" class="top-menu-2"></a>
  <a href="create-user-account.php" class="top-menu-2"></a>
  <a href="edit-details.php" class="top-menu-2"></a>
  </div>
</div>  <div id="container-generic">
    <form id="form1" name="form1" method="post" action="">
      <div id="list-border2">
        <table width="100%" border="0" cellpadding="2" cellspacing="3">
          <tr>
            <td colspan="4" class="td-header">&nbsp;</td>
          </tr>
          <tr class="even">
            <td width="106">First Name:</td>
            <td width="367" class="error">&nbsp;
              <input name="name" type="text" class="tarea2" id="name" value="<?php echo $value_1; ?>" />
              <?php
							
							if(isset($error_1)){
									 
							echo $error_1; 
							
							}
							?></td>
            <td width="111">Last Name:</td>
            <td width="367" class="error">&nbsp;
              <input name="surname" type="text" class="tarea2" id="surname" value="<?php echo $value_2; ?>" />
              <?php 
							
							if(isset($error_2)){
									 
							echo $error_2; 
							
							}
							?></td>
          </tr>
          <tr class="odd">
            <td>Email:</td>
            <td class="error">&nbsp;
              <input name="email" type="text" class="tarea2" id="email" value="<?php echo $value_3; ?>" />
              <?php 
							
							if(isset($error_3)){
									 
							echo $error_3; 
							
							}
							?></td>
            <td>Password:</td>
            <td class="error">&nbsp;
              <input name="password" type="text" class="tarea2" id="password" value="<?php echo $value_4; ?>" />
              <?php 
							
							if(isset($error_4)){
									 
							echo $error_4; 
							
							}
							?></td>
          </tr>
          <tr class="odd">
            <td>&nbsp;Accessability:</td>
            <td colspan="3"><table border="0">
              <tr>
                <?php
  $i = 0;
  
  do { // horizontal looper version 3
  
  $level_id = $row_Recordset1['Id'];
  $userid = $_GET['Id'];
  
  $query = mysql_query("SELECT * FROM tbl_menu_relation WHERE MenuId = '$level_id' AND UserId = '$userid'")or die(mysql_error());
  $numrows = mysql_num_rows($query);
  
  $i++;
  
?>
                <td><table border="0" cellspacing="3" cellpadding="2">
                  <tr>
                    <td><input name="access[]" type="checkbox" id="access[<?php echo $i; ?>]" value="<?php echo $row_Recordset1['Id']; ?>" <?php if($numrows >= 1){ echo 'checked="checked"'; } ?> />
                      &nbsp;
                      <label for="access[<?php echo $i; ?>]"><?php echo $row_Recordset1['Name']; ?></label></td>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
                <?php
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    if (!isset($nested_Recordset1)) {
      $nested_Recordset1= 1;
    }
    if (isset($row_Recordset1) && is_array($row_Recordset1) && $nested_Recordset1++ % 4==0) {
      echo "</tr><tr>";
    }
  } while ($row_Recordset1); //end horizontal looper version 3
?>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="4" align="right" class="td-header"><div id="btn-padding">
              <?php if(isset($_GET['Id'])){ ?>
              <input name="update" type="submit" class="btn-generic" id="update" value="Update" />
              <?php } else { ?>
              <input name="insert" type="submit" class="btn-generic" id="insert" value="Insert" />
            </div>
              <?php } ?></td>
          </tr>
        </table>
      </div>
    </form>
    <br />
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="list-border">
          <table width="100%" border="0" align="center" cellpadding="2" cellspacing="3">
            <tr>
              <td width="208" class="td-header">First Name</td>
              <td class="td-header">&nbsp;Surname</td>
              <td class="td-header">Email</td>
              <td class="td-header">&nbsp;Password</td>
              <td colspan="2" class="td-header">&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
              <td>&nbsp;<?php echo $row_Recordset2['Name']; ?></td>
              <td width="205">&nbsp;<?php echo $row_Recordset2['Surname']; ?></td>
              <td width="231">&nbsp;<?php echo $row_Recordset2['Username']; ?></td>
              <td width="220">&nbsp;<?php echo $row_Recordset2['Password']; ?></td>
              <td width="52"><?php if($row_Recordset2['UserLevel'] == 2){ ?>
                <form id="form2" name="form2" method="post" action="create-user-account.php?delete=<?php echo $row_Recordset2['Id']; ?>">
                  <input name="button" type="submit" class="btn-generic-red" id="button" value="Delete" />
                </form>
                <?php } ?></td>
              <td width="37"><form id="form3" name="form3" method="post" action="create-user-account.php?Id=<?php echo $row_Recordset2['Id']; ?>">
                <input name="button2" type="submit" class="btn-generic" id="button2" value="Edit" />
              </form>
              </td>
            </tr>
            <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
            <tr>
              <td colspan="6" align="right" class="td-header">&nbsp;</td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
