<?php require_once('Connections/tender.php'); ?>
<?php require_once('Connections/tender.php'); ?>
<?php require_once('Connections/tender.php'); ?>
<?php 
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
$query_Recordset2 = sprintf("SELECT * FROM tbl_registered_users WHERE Id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset3 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset3 = sprintf("SELECT * FROM tbl_users WHERE CompanyId = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $tender) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset4 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset4 = sprintf("SELECT * FROM tbl_users_temp WHERE CompanyId = %s", GetSQLValueString($colname_Recordset4, "int"));
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

<body onload="MM_preloadImages('images/menu-1.png','images/menu-2.png')">
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
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?></a> 
  <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?></a>
  <?php invitation_alerts($con); ?>
<?php } ?>
  </div>
<?php if(isset($_SESSION['userid'])){ ?>
  <div id="menu-logout-pending">
    <map name="Map" id="Map">
      <area shape="rect" coords="0,-7,174,31" href="active-tenders.php" onmouseover="MM_swapImage('Image1','','images/menu-1.png',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="-24,4106,138,4137" href="rft.php" onmouseover="MM_swapImage('Image1','','images/menu-2.png',1)" onmouseout="MM_swapImgRestore()" />
    </map>
  </div>
<?php } else { ?>
<div id="menu-container-login">
  <form id="form1" name="form1" method="post" action="">
    <table border="0" align="right" cellpadding="2" cellspacing="3">
      <tr>
        <td><input name="username" type="text" class="tarea-login" value="<?php echo $_GET['Username']; ?>" /></td>
        <td><input name="password" type="text" class="tarea-login" value="<?php echo $_GET['Password']; ?>" /></td>
        <td><input name="button" type="submit" class="btn-generic" id="button" value="Login" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><a href="register.php">Register Account</a> | <a href="admin">Forgot Password</a></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</div>
<?php } ?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div id="container">
    <table width="964" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="982" border="0" align="center" cellpadding="2" cellspacing="3">
          <tr>
            <td colspan="2" rowspan="2" valign="top">
            <?php if($_GET['Id'] == ''){ ?>
            Your account has already been activated, please login with the login credentials that were sent to your inbox.
            <?php } else { ?>
              <span class="rft-bold">
			  <?php 
			  if($totalRows_Recordset3 >= 5){
				  
				  echo 'The minimum of 5 Guardian accounts has been met and your account is now active.';
				  
			  } else {
				  
				  echo $totalRows_Recordset4; ?> Guardian accounts still require activation.
              <?php } ?></span>
                <br />
                <br />
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div id="list-border">
                      <table border="0" cellspacing="3" cellpadding="2">
                        <?php 
						
						if($totalRows_Recordset4 >= 1){
							
							do { 
						
						?>
                        <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
                          <td width="300"><?php echo $row_Recordset4['Name'] .' '. $row_Recordset4['Surname']; ?></td>
                          <td width="46" class="error">Pending</td>
                        </tr>
                        <?php 
						} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); 
						}
						?>
                        <?php do { ?>
                        <tr class="<?php echo ($ac_sw2++%2==0)?"odd":"even"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
                          <td width="300"><?php echo $row_Recordset3['Name'] .' '. $row_Recordset3['Surname']; ?></td>
                          <td class="active">Active</td>
                        </tr>
                        <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
                      </table>
                    </div></td>
                  </tr>
                </table>
                <?php } ?>
                </td>
            <td align="right"><span class="header"><?php echo $row_Recordset2['CompanyName']; ?><br />
            </span></td>
          </tr>
          <tr>
            <td width="231" align="right"><?php echo $row_Recordset2['Address']; ?><br />
              <?php echo $row_Recordset2['Suburb']; ?><br />
              <?php echo $row_Recordset2['City']; ?><br />
              <?php echo $row_Recordset2['Country']; ?></td>
        </table></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>