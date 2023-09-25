<?php require_once('Connections/tender.php'); ?>
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

$colname_Recordset2 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset2 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset2 = sprintf("SELECT * FROM tbl_tenders WHERE Id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_SESSION['userid'])) {
  $colname_Recordset3 = $_SESSION['userid'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset3 = sprintf("SELECT * FROM tbl_invitations_sent WHERE Id = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $tender) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$companyid = $row_Recordset3['CompanyId'];

mysql_select_db($database_tender, $tender);
$query_Recordset4 = "SELECT * FROM tbl_registered_users WHERE Id = '$companyid'";
$Recordset4 = mysql_query($query_Recordset4, $tender) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);


$level = 1;

//restrict_access($level,$con);

login($con);

select_db();
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tender Bank</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />
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
<div id="menu-ontainer-tenderer">
  <table width="982" border="0" align="center" cellpadding="2" cellspacing="3">
    <tr>
      <td colspan="2" valign="bottom" nowrap="nowrap" class="header"><?php echo $row_Recordset3['CompanyName']; ?></td>
      <td width="50%" align="right"><span class="header"><?php echo $row_Recordset4['CompanyName']; ?><br />
      </span></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" nowrap="nowrap"><?php echo $row_Recordset3['ContactPerson']; ?></td>
      <td width="50%" align="right"><?php echo $row_Recordset4['Address']; ?><br />
        <?php echo $row_Recordset4['Suburb']; ?><br />
        <?php echo $row_Recordset4['City']; ?><br />
      <?php echo $row_Recordset4['Country']; ?></td>
    </tr>
  </table>
</div>
<div id="container-no-bg">
    <div id="banner-success">
    Thank you for subitting your tender . You will be notified if if you are the winning bidder<br />
              <br />
              The tender closes on <?php echo $row_Recordset2['ClosingDate']; ?>, should you wish to update 
              your <br />
              tender 
              please login 
              with your username and password and make any updates needed.
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
