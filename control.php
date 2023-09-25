<?php 
session_start();

require_once('Connections/tender.php'); 

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

$userid = $_SESSION['userid'];

mysql_select_db($database_tender, $tender);
$query_Recordset2 = "SELECT tbl_menu_relation.MenuId, tbl_menu_relation.UserId, tbl_menu_items.Id, tbl_menu_items.Name, tbl_menu_items.Btn, tbl_menu_items.URL FROM (tbl_menu_relation LEFT JOIN tbl_menu_items ON tbl_menu_items.Id=tbl_menu_relation.MenuId) WHERE tbl_menu_relation.UserId='$userid'";
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<?php
require_once('functions/functions.php');

login($con);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tender Bank</title>
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
<div id="banner-lower">
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset1['Name']; ?> <?php echo $row_Recordset1['Surname']; ?></a> 
  <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset1['LastLogin'])); ?></a>
  <?php invitation_alerts($con); ?>
</div>

<div id="menu-container-2">
  <a href="active-tenders.php" class="tab">Active Tenders</a>
  <a href="rft.php" class="tab">Request For Tender</a>
  <a href="control.php" class="tab-active">Dashboard</a>
  <a href="#" class="tab-logout">Logout</a>
</div>

<div id="container">
  <br />
  <br />
  <table width="400" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr>
      <?php
  do { // horizontal looper version 3
?>
        <td><input name="button" type="submit" class="btn-generic" id="button" value="<?php echo $row_Recordset2['Name']; ?>" onclick="location.href='<?php echo $row_Recordset2['URL']; ?>'" /></td>
        <?php
    $row_Recordset2 = mysql_fetch_assoc($Recordset2);
    if (!isset($nested_Recordset2)) {
      $nested_Recordset2= 1;
    }
    if (isset($row_Recordset2) && is_array($row_Recordset2) && $nested_Recordset2++ % 2==0) {
      echo "</tr><tr>";
    }
  } while ($row_Recordset2); //end horizontal looper version 3
?>
    </tr>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
