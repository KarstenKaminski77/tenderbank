<?php require_once('Connections/tender.php'); ?>
<?php
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
 
session_start();

$con = mysqli_connect('dedi18b.your-server.co.za','tender','tender001','tender');

require_once('Connections/tender.php');

require_once('functions/functions.php');

$level = 1;

//restrict_access($level,$con);

login($con);

select_db();

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
$query_Recordset1 = "SELECT * FROM tbl_about";
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

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
<title>Tender Bank</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('images/menu-1.png','images/menu-2.png','images/menu-3.png')">
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

<?php if(isset($_SESSION['userid'])){ ?>
  <a href="logout.php" class="menu-2">
    <img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?>
  </a> 
  <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?></a>
  
  <?php invitation_alerts($con); ?>
  
<?php } else { ?>

  <a href="register.php" class="register">Register Account</a> | <a href="admin" class="register">Forgot Password</a>

<?php } ?>
</div>

<?php if(isset($_SESSION['userid'])){ ?>

<div id="menu-container-2">
  <a href="active-tenders.php" class="tab">Active Tenders</a>
  <a href="rft.php" class="tab">Request For Tender</a>
  <a href="control.php" class="tab">Dashboard</a>
  <a href="#" class="tab-logout">Logout</a>
</div>

<?php } else { ?>
<div id="menu-container-login">
  <form id="form1" name="form1" method="post" action="">
    <table border="0" align="right" cellpadding="2" cellspacing="3">
      <tr>
        <td><input name="username" type="text" class="tarea-login" value="<?php echo $_GET['Username']; ?>" placeholder="Username" /></td>
        <td><input name="password" type="text" class="tarea-login" value="<?php echo $_GET['Password']; ?>" placeholder="Password" /></td>
        <td><input name="button" type="submit" class="btn-generic" id="button" value="Login" /></td>
      </tr>
    </table>
  </form>
</div>
<?php } ?>
<div id="container"><?php echo $row_Recordset1['Content']; ?></div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset4);
?>
