<?php require_once('Connections/tender.php'); ?>
<?php 
session_start();

require_once('Connections/tender.php'); 

require_once('functions/functions.php');

$level = 1;

restrict_access($level,$con);

login($con);

select_db();

if(isset($_POST['update']) && $_POST['industry'] != NULL){
	
	$industryid = $_GET['Id'];
	$industry = $_POST['industry'];
	$userid = $_SESSION['userid'];
	$date = date('Y-m-d');
	
	mysql_query("UPDATE tbl_industries SET Industry = '$industry', DateCreated = '$date', UserId = '$userid' WHERE Id = '$industryid'")or die(mysql_error());
	
}

if(isset($_POST['insert']) && $_POST['industry'] != NULL){
	
	$industry = $_POST['industry'];
	$companyid = $_SESSION['companyid'];
	$userid = $_SESSION['userid'];
	$date = date('Y-m-d');
	
	mysql_query("INSERT INTO tbl_industries (CompanyId,Industry,DateCreated,UserId) VALUES ('$companyid','$industry','$date','$userid')")or die(mysql_error());
	
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
$query_Recordset1 = sprintf("SELECT * FROM tbl_registered_users WHERE UserId = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$KTColParam1_Recordset2 = "0";
if (isset($_SESSION["companyid"])) {
  $KTColParam1_Recordset2 = $_SESSION["companyid"];
}
mysql_select_db($database_tender, $tender);
$query_Recordset2 = sprintf("SELECT tbl_industries.Industry, tbl_industries.DateCreated, tbl_users.Name, tbl_users.Surname, tbl_users.CompanyId, tbl_industries.Id, tbl_industries.UserId FROM (tbl_industries LEFT JOIN tbl_users ON tbl_users.Id=tbl_industries.UserId) WHERE tbl_users.CompanyId=%s ", GetSQLValueString($KTColParam1_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset3 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset3 = sprintf("SELECT * FROM tbl_industries WHERE Id = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $tender) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tender Bank</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
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
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?></a> <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?></a></div>
<div id="menu-container-2">
  <div id="menu-logout"> <img src="images/menu-1.png" width="502" height="31" border="0" usemap="#Map" id="Image1" />
    <map name="Map" id="Map">
      <area shape="rect" coords="0,-7,174,31" href="active-tenders.php" onmouseover="MM_swapImage('Image1','','images/menu-1.png',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="174,0,336,31" href="rft.php" onmouseover="MM_swapImage('Image1','','images/menu-2.png',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="336,1,498,31" href="control.php" onmouseover="MM_swapImage('Image1','','images/menu-3.png',1)" onmouseout="MM_swapImgRestore()" />
    </map>
  </div>
</div>
  <div id="container">
    <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="2" cellspacing="3">
          <tr>
            <td width="50%">&nbsp;</td>
            <td width="50%" align="right"><span class="header"><?php echo $row_Recordset1['CompanyName']; ?><br />
              </span><br />
              <?php echo $row_Recordset1['Address']; ?><br />
              <?php echo $row_Recordset1['Suburb']; ?><br />
              <?php echo $row_Recordset1['City']; ?><br />
              <?php echo $row_Recordset1['Country']; ?></td>
          </tr>
        </table>
          <br />
          <div id="list-border">
            <form id="form1" name="form1" method="post" action="">
              <table border="0" cellpadding="2" cellspacing="3">
                <tr>
                  <td class="td-header">&nbsp;Industry</td>
                </tr>
                <tr>
                  <td align="center" class="even"><span class="td-header">
                    <input name="industry" type="text" class="tfield-subject" id="industry" value="<?php echo $row_Recordset3['Industry']; ?>" />
                  </span></td>
                </tr>
                <tr>
                  <td align="right" class="td-header"><table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><?php if(isset($_GET['Id'])){ ?>
                        <input name="update" type="submit" class="btn-generic" id="update" value="Update" />
                        <input name="cancel" type="reset" class="btn-generic-red" id="cancel" value="Cancel" />
                        <?php } else { ?>
                        <input name="insert" type="submit" class="btn-generic" id="insert" value="Insert" />
                        <?php } ?></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
            </form>
          </div></td>
      </tr>
    </table>
    <?php if($totalRows_Recordset2 >= 1){ ?>
    <br />
    <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="list-border">
          <table width="992" border="0" align="center" cellpadding="2" cellspacing="3">
            <tr>
              <td class="td-header">&nbsp;Industry</td>
              <td width="240" class="td-header">Last Modified By</td>
              <td width="120" class="td-header">Last Modified</td>
              <td width="37" class="td-header">&nbsp;</td>
              <td width="37" class="td-header">&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
              <td>&nbsp;<?php echo $row_Recordset2['Industry']; ?></td>
              <td width="240"><?php echo $row_Recordset2['Name']; ?> <?php echo $row_Recordset2['Surname']; ?></td>
              <td width="120"><?php echo $row_Recordset2['DateCreated']; ?></td>
              <td><form id="form2" name="form2" method="post" action="industries.php?Id=<?php echo $row_Recordset2['Id']; ?>">
                <input name="edit" type="submit" class="btn-generic" id="edit" value="Edit" />
              </form></td>
              <td><form id="form3" name="form3" method="post" action="industries.php?Delete=<?php echo $row_Recordset2['Id']; ?>">
                <input name="delete" type="submit" class="btn-generic-red" id="delete" value="Delete" />
              </form></td>
            </tr>
            <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
            <tr>
              <td colspan="5" align="right" class="td-header">&nbsp;</td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table>
  <?php } ?>
  </div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
