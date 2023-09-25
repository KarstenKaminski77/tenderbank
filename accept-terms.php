<?php require_once('Connections/tender.php'); ?>
<?php
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
 
session_start();

require_once('Connections/tender.php');

require_once('functions/functions.php');

if(isset($_GET['Accept']) && !isset($_GET['Id'])){
	
	setcookie('terms', $_SESSION['userid'], 60 * 60 * 24 * 365 + time());
	
	header('Location: control.php');
}

if(isset($_GET['Accept']) && isset($_GET['Id'])){
	
	setcookie('terms', $_SESSION['userid'], 60 * 60 * 24 * 365 + time());
	
	header('Location: tender-submit.php?Id='. $_GET['Id']);
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
$query_Recordset1 = "SELECT * FROM tbl_terms";
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_SESSION['companyid'])) {
  $colname_Recordset2 = $_SESSION['companyid'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset2 = sprintf("SELECT * FROM tbl_registered_users WHERE Id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

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
  </div>
<div id="menu-ontainer-tenderer">
  <table width="982" border="0" align="center" cellpadding="2" cellspacing="3">
    <tr>
      <td width="494" valign="bottom" nowrap="nowrap" class="header">Terms &amp; Conditions</td>
      <td width="471" align="right" valign="bottom" nowrap="nowrap" class="header"><span class="header"><?php echo $row_Recordset2['CompanyName']; ?><br />
      </span></td>
    </tr>
    <tr>
      <td align="right" valign="bottom" nowrap="nowrap">&nbsp;</td>
      <td align="right" valign="bottom" nowrap="nowrap"><?php echo $row_Recordset2['Address']; ?><br />
        <?php echo $row_Recordset2['Suburb']; ?><br />
        <?php echo $row_Recordset2['City']; ?><br />
      <?php echo $row_Recordset2['Country']; ?></td>
    </tr>
  </table>
</div>
<div id="container"><?php echo nl2br($row_Recordset1['Content']); ?><br />
  <br />
  <form id="form1" name="form1" method="post" action="">
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td nowrap="nowrap"><strong>I have read and accept Tender Banks terms of use</strong></td>
        <td width="46" align="center"><input type="checkbox" name="terms" id="terms" onclick="location.href='accept-terms.php?Accept<?php if(isset($_GET['Id'])){ echo '&Id='. $_GET['Id']; } ?>';" /></td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
