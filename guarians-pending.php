<?php 
session_start();

$con = mysqli_connect('dedi18b.your-server.co.za','tender','tender001','tender');

require_once('Connections/tender.php');

require_once('functions/functions.php');

$userid = intval($_GET['Id']);

$query_Recordset1 = "SELECT * FROM tbl_users WHERE Id = '$colname_Recordset1'";
$Recordset1 = mysqli_query($con, $query_Recordset1) or die(mysqli_error($con));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset2 = "SELECT * FROM tbl_registered_users WHERE Id = '$userid'";
$Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error($con));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$query_Recordset3 = "SELECT * FROM tbl_users WHERE CompanyId = '$userid'";
$Recordset3 = mysqli_query($con, $query_Recordset3) or die(mysqli_error($con));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$query_Recordset4 = "SELECT * FROM tbl_users_temp WHERE CompanyId = '$userid'";
$Recordset4 = mysqli_query($con, $query_Recordset4) or die(mysqli_error($con));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$level = 1;

//restrict_access($level,$con);

login($con);

select_db();
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?></a> 
  <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?></a>
  <?php invitation_alerts($con); ?>
<?php } ?>
  </div>
<?php if(isset($_SESSION['userid'])){ ?>
<div id="menu-container-2">
  <div id="menu-logout">
  <img src="images/top-menu.png" width="502" height="31" border="0" usemap="#Map" id="Image1" />
    <map name="Map" id="Map">
      <area shape="rect" coords="0,-7,174,31" href="active-tenders.php" onmouseover="MM_swapImage('Image1','','images/menu-1.png',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="-24,4106,138,4137" href="rft.php" onmouseover="MM_swapImage('Image1','','images/menu-2.png',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="335,1,497,31" href="control.php" onmouseover="MM_swapImage('Image1','','images/menu-3.png',1)" onmouseout="MM_swapImgRestore()" />
    </map>
  </div>
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
            <td colspan="2" rowspan="2" valign="bottom" nowrap="nowrap" class="header">&nbsp;</td>
            <td align="right"><span class="header"><?php echo $row_Recordset2['CompanyName']; ?><br />
            </span></td>
          </tr>
          <tr>
            <td width="891" align="right"><?php echo $row_Recordset2['Address']; ?><br />
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
<?php
mysqli_free_result($Recordset1);

mysqli_free_result($Recordset2);

mysqli_free_result($Recordset3);

mysqli_free_result($Recordset4);
?>
