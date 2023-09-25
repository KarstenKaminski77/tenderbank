<?php 
session_start();

require_once('../Connections/tender.php'); 

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

$userid = $_SESSION['userid'];

mysql_select_db($database_tender, $tender);
$query_Recordset1 = "SELECT tbl_menu_relation.MenuId, tbl_menu_relation.UserId, tbl_menu_items.Id, tbl_menu_items.Name, tbl_menu_items.Btn, tbl_menu_items.URL FROM (tbl_menu_relation LEFT JOIN tbl_menu_items ON tbl_menu_items.Id=tbl_menu_relation.MenuId) WHERE tbl_menu_relation.UserId='$userid'";
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
require_once('functions/functions.php');

login();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/fonts.css" rel="stylesheet" type="text/css" />
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
<div id="tab-top"></div>
<div id="container-centred">
  <?php do { ?>
    <a href="<?php echo $row_Recordset1['URL']; ?>"><img src="images/<?php echo $row_Recordset1['Btn']; ?>" width="185" height="28" border="0" /></a>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <br />
  <br />
  <br />
<span class="header-welcome">Welcome.....</span>
<b><br />
<br /> 
</b>Your last logged off:<br /><br />  
<?php last_logout(); ?>
</div>
<div id="tab-btm"></div>
<div id="gooter"></div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
