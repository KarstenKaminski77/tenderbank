<?php
session_start();

require_once('Connections/tender.php'); 

require_once('functions/functions.php');

select_db();

login($con);

$level = 1;

restrict_access($level,$con);

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
if (isset($_GET['Id'])) {
  $colname_Recordset1 = $_GET['Id'];
}

mysql_select_db($database_tender, $tender);
$query_Recordset1 = sprintf("SELECT * FROM tbl_registered_users_temp WHERE AlertId = %s", GetSQLValueString($colname_Recordset1, "int"));
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

$colname_Recordset5 = "-1";
if (isset($_SESSION['companyid'])) {
  $colname_Recordset5 = $_SESSION['companyid'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset5 = sprintf("SELECT * FROM tbl_registered_users WHERE Id = %s", GetSQLValueString($colname_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $tender) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset2 = "-1";
if (isset($_SESSION['companyid'])) {
  $colname_Recordset2 = $_SESSION['companyid'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset2 = sprintf("SELECT * FROM tbl_registered_users WHERE Id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$KTColParam1_Recordset6 = "0";
if (isset($_GET["Id"])) {
  $KTColParam1_Recordset6 = $_GET["Id"];
}
$KTColParam2_Recordset6 = "0";
if (isset($_SESSION["companyid"])) {
  $KTColParam2_Recordset6 = $_SESSION["companyid"];
}
mysql_select_db($database_tender, $tender);
$query_Recordset6 = sprintf("SELECT tbl_alerts.Id AS Id_1, tbl_users.Id, tbl_users.Name, tbl_users.Surname, tbl_users.Guardian, tbl_alert_responses.Response, tbl_alerts.CompanyId FROM ((tbl_alerts LEFT JOIN tbl_users ON tbl_users.CompanyId=tbl_alerts.CompanyId) LEFT JOIN tbl_alert_responses ON tbl_alert_responses.UserId=tbl_users.Id) WHERE tbl_alerts.Id=%s  AND tbl_alerts.CompanyId=%s ", GetSQLValueString($KTColParam1_Recordset6, "int"),GetSQLValueString($KTColParam2_Recordset6, "int"));
$Recordset6 = mysql_query($query_Recordset6, $tender) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

if($row_Recordset1['CompanyName'] != $row_Recordset2['CompanyName']){
	
	$style1 = ' style="color:#FF0000"';
	
} else {
	
	$style1 = '';
	
}

if($row_Recordset1['CompanyPerson'] != $row_Recordset2['CompanyPerson']){
	
	$style2 = ' style="color:#FF0000"';
	
} else {
	
	$style2 = '';
	
}

if($row_Recordset1['Telephone'] != $row_Recordset2['Telephone']){
	
	$style3 = ' style="color:#FF0000"';
	
} else {
	
	$style3 = '';
	
}

if($row_Recordset1['Email'] != $row_Recordset2['Email']){
	
	$style4 = ' style="color:#FF0000"';
	
} else {
	
	$style4 = '';
	
}

if($row_Recordset1['Address'] != $row_Recordset2['Address']){
	
	$style5 = ' style="color:#FF0000"';
	
} else {
	
	$style5 = '';
	
}

if($row_Recordset1['Suburb'] != $row_Recordset2['Suburb']){
	
	$style6 = ' style="color:#FF0000"';
	
} else {
	
	$style6 = '';
	
}

if($row_Recordset1['City'] != $row_Recordset2['City']){
	
	$style7 = ' style="color:#FF0000"';
	
} else {
	
	$style7 = '';
	
}

if($row_Recordset1['Country'] != $row_Recordset2['Country']){
	
	$style8 = ' style="color:#FF0000"';
	
} else {
	
	$style8 = '';
	
}

if($row_Recordset1['CompanyRegNo'] != $row_Recordset2['CompanyRegNo']){
	
	$style9 = ' style="color:#FF0000"';
	
} else {
	
	$style9 = '';
	
}

if($row_Recordset1['NatureOfBusiness'] != $row_Recordset2['NatureOfBusiness']){
	
	$style10 = ' style="color:#FF0000"';
	
} else {
	
	$style10 = '';
	
}

if($row_Recordset1['CompanyType'] != $row_Recordset2['CompanyType']){
	
	$style11 = ' style="color:#FF0000"';
	
} else {
	
	$style11 = '';
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tender Bank</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
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
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?></a> 
  <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?></a>
  <?php invitation_alerts($con); ?>
</div>
<div id="menu-container-2">
  <div id="menu-logout"><img src="images/top-menu.png" width="502" height="31" border="0" usemap="#Map" id="Image1" />
    <map name="Map" id="Map">
      <area shape="rect" coords="0,-7,174,31" href="active-tenders.php" onmouseover="MM_swapImage('Image1','','images/menu-1.png',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="174,0,336,31" href="rft.php" onmouseover="MM_swapImage('Image1','','images/menu-2.png',1)" onmouseout="MM_swapImgRestore()" />
      <area shape="rect" coords="336,1,498,31" href="control.php" onmouseover="MM_swapImage('Image1','','images/menu-3.png',1)" onmouseout="MM_swapImgRestore()" />
    </map>
  </div>
</div>
<form action="edit-details-code.php?Id=<?php echo $_GET['Id']; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <div id="container-generic">
    <table width="100%" border="0" cellpadding="2" cellspacing="3">
      <tr>
        <td width="50%" valign="bottom" class="error">
		<?php echo $response; ?>
                      <table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
<div id="list-border">
                        <table border="0" cellspacing="3" cellpadding="2">
                          <?php 
						
						if($totalRows_Recordset6 >= 1){
							
							do {
								
								if($row_Recordset6['Response'] == '1'){
						
						?>
                          
                          <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
                            <td width="300" class="active"><?php echo $row_Recordset6['Name']; ?> <?php echo $row_Recordset6['Surname']; ?></td>
                            <td width="46" class="active">Voted</td>
                          </tr>
                          <?php } else { ?>
                          <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
                            <td width="300" class="error"><?php echo $row_Recordset6['Name']; ?> <?php echo $row_Recordset6['Surname']; ?></td>
                            <td width="46" class="error">Pending</td>
                          </tr>
                          <?php
						}
						} while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); 
						}
						?>
                          </table>
                      </div>    </td>
  </tr>
</table>

        </td>
        <td width="50%" align="right"><span class="header"><?php echo $row_Recordset5['CompanyName']; ?><br />
          </span><br />
          <?php echo $row_Recordset5['Address']; ?><br />
          <?php echo $row_Recordset5['Suburb']; ?><br />
          <?php echo $row_Recordset5['City']; ?><br />
          <?php echo $row_Recordset5['Country']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
    <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="list-border">
          <table border="0" cellpadding="2" cellspacing="3">
            <tr>
              <td colspan="4" class="td-header">&nbsp;</td>
            </tr>
            <tr class="even">
              <td width="101"><strong>Company:</strong></td>
              <td width="372"<?php echo $style1; ?>><?php echo $row_Recordset1['CompanyName']; ?>&nbsp;</td>
              <td width="111"><strong>Contact Person:</strong></td>
              <td width="367"<?php echo $style2; ?>><?php echo $row_Recordset1['ContactPerson']; ?></td>
            </tr>
            <tr class="odd">
              <td><strong>Telephone:</strong></td>
              <td<?php echo $style3; ?>><?php echo $row_Recordset1['Telephone']; ?></td>
              <td><strong>Email:</strong></td>
              <td<?php echo $style4; ?>><?php echo $row_Recordset1['Email']; ?></td>
            </tr>
            <tr class="even">
              <td><strong>Address:</strong></td>
              <td<?php echo $style5; ?>><?php echo $row_Recordset1['Address']; ?></td>
              <td><strong>Suburb:</strong></td>
              <td<?php echo $style6; ?>><?php echo $row_Recordset1['Suburb']; ?></td>
            </tr>
            <tr class="odd">
              <td><strong>City:</strong></td>
              <td<?php echo $style7; ?>><?php echo $row_Recordset1['City']; ?></td>
              <td><strong>Country:</strong></td>
              <td<?php echo $style8; ?>><?php echo $row_Recordset1['Country']; ?></td>
            </tr>
            <tr class="even">
              <td><strong>Company Reg No:</strong></td>
              <td<?php echo $style9; ?>><?php echo $row_Recordset1['CompanyRegNo']; ?></td>
              <td><strong>Nature of Business:</strong></td>
              <td<?php echo $style10; ?>><?php echo $row_Recordset1['NatureOfBusiness']; ?></td>
            </tr>
            <tr class="odd">
              <td><strong> Company Type:</strong></td>
              <td colspan="3"<?php echo $style11; ?>><?php echo $row_Recordset1['CompanyType']; ?></td>
            </tr>
            <tr>
              <td colspan="4" align="right" class="td-header">
                <table border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><input name="approve" type="submit" class="btn-generic" id="approve" value="Authorise" /></td>
                    <td><input name="reject" type="submit" class="btn-generic-red" id="reject" value="Decline" /></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset2);

mysql_free_result($Recordset6);
?>
