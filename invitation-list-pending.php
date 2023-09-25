<?php require_once('Connections/tender.php'); ?>
<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once('functions/functions.php');

$level = 1;

restrict_access($level,$con);

login($con);

select_db();
																
$companyid = $_SESSION['companyid'];

$query_Recordset1 = "SELECT * FROM tbl_registered_users WHERE Id = '$companyid'";
$Recordset1 = mysqli_query($con, $query_Recordset1) or die(mysqli_error($con));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$companyid = $_SESSION['companyid'];

$query_Recordset2 = "SELECT tbl_alerts.Requestor, tbl_alerts.DateRequested, tbl_industries.Industry, tbl_invitation_list_temp.CompanyName, tbl_invitation_list_temp.ContactPerson, tbl_invitation_list_temp.Email, tbl_alerts.CompanyId, tbl_invitation_list_temp.AlertId FROM ((tbl_alerts LEFT JOIN tbl_invitation_list_temp ON tbl_invitation_list_temp.AlertId=tbl_alerts.Id) LEFT JOIN tbl_industries ON tbl_industries.Id=tbl_invitation_list_temp.IndustryType) WHERE tbl_alerts.CompanyId = '$companyid' AND tbl_alerts.URL = 'invitation-list-pending.php' GROUP BY tbl_invitation_list_temp.AlertId";
$Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error($con));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$alertid = $_GET['Id'];

$query_Recordset3 = "SELECT tbl_alerts.Requestor, tbl_industries.Industry, tbl_invitation_list_temp.CompanyName, tbl_invitation_list_temp.ContactPerson, tbl_invitation_list_temp.OldId, tbl_invitation_list_temp.Email, tbl_alerts.CompanyId, tbl_invitation_list_temp.AlertId FROM ((tbl_alerts LEFT JOIN tbl_invitation_list_temp ON tbl_invitation_list_temp.AlertId=tbl_alerts.Id) LEFT JOIN tbl_industries ON tbl_industries.Id=tbl_invitation_list_temp.IndustryType) WHERE tbl_invitation_list_temp.AlertId = '$alertid' ORDER BY tbl_invitation_list_temp.Id ASC";
$Recordset3 = mysqli_query($con, $query_Recordset3) or die(mysqli_error($con));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_SESSION['userid'])) {
  $colname_Recordset4 = $_SESSION['userid'];
}
$query_Recordset4 = "SELECT * FROM tbl_users WHERE Id = '$colname_Recordset4'";
$Recordset4 = mysqli_query($con, $query_Recordset4) or die(mysqli_error($con));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$KTColParam1_Recordset6 = "0";
if (isset($_GET["Id"])) {
  $KTColParam1_Recordset6 = $_GET["Id"];
}
$KTColParam2_Recordset6 = "0";
if (isset($_SESSION["companyid"])) {
  $KTColParam2_Recordset6 = $_SESSION["companyid"];
}
$query_Recordset6 = "SELECT tbl_alerts.Id AS Id_1, tbl_users.Id, tbl_users.Name, tbl_users.Surname, tbl_users.Guardian, tbl_alert_responses.Response, tbl_alerts.CompanyId FROM ((tbl_alerts LEFT JOIN tbl_users ON tbl_users.CompanyId=tbl_alerts.CompanyId) LEFT JOIN tbl_alert_responses ON tbl_alert_responses.UserId=tbl_users.Id) WHERE tbl_alerts.Id = '$KTColParam1_Recordset6'  AND tbl_alerts.CompanyId = '$KTColParam2_Recordset6' ";
$Recordset6 = mysqli_query($con, $query_Recordset6) or die(mysqli_error($con));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);

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
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?></a> 
  <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?></a>
  <?php invitation_alerts($con); ?>
  </div>
<div id="menu-container-2">
  <div id="menu-logout"> <img src="images/top-menu.png" width="502" height="31" border="0" usemap="#Map" id="Image1" />
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
        <td><table width="992" border="0" cellpadding="2" cellspacing="3">
          <tr>
            <td width="50%" valign="bottom" class="KT_field_error">
<table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div id="list-border">
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
						} while ($row_Recordset6 = mysqli_fetch_assoc($Recordset6)); 
						}
						?>
                </table>
              </div></td>
            </tr>
          </table>            <?php if(isset($_SESSION['alert_error'])){ echo $_SESSION['alert_error']; } ?>
            </td>
            <td width="50%" align="right"><span class="header"><?php echo $row_Recordset1['CompanyName']; ?><br />
              </span><br />
              <?php echo $row_Recordset1['Address']; ?><br />
              <?php echo $row_Recordset1['Suburb']; ?><br />
              <?php echo $row_Recordset1['City']; ?><br />
              <?php echo $row_Recordset1['Country']; ?></td>
          </tr>
        </table>
        <?php if(isset($_GET['Id'])){ ?>
          <br />
            <form action="invitation-list-code.php?Id=<?php echo $_GET['Id']; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><table width="640" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><div id="list-border">
                        <table width="992" border="0" align="center" cellpadding="2" cellspacing="3">
                          <tr class="td-header">
                            <td width="25%">Industry</td>
                            <td width="25%">Company</td>
                            <td width="25%">Contact Person</td>
                            <td width="25%">Email Address</td>
                          </tr>
                          <?php 
						  
						  do { 
						  
						  $oldid = $row_Recordset3['OldId'];
						  
						  $query = mysqli_query($con, "SELECT * FROM tbl_invitation_list WHERE Id = '$oldid' ORDER BY Id ASC")or die(mysqli_error($con));
						  $row = mysqli_fetch_array($query);
						  
						  if($row_Recordset3['CompanyName'] != $row['CompanyName']){
							  
							  $style1 = ' style="color:#FF0000"';
							  
						  } else {
							  
							  $style1 = '';
							  
						  }
						  
						  if($row_Recordset3['ContactPerson'] != $row['ContactPerson']){
							  
							  $style2 = ' style="color:#FF0000"';
							  
						  } else {
							  
							  $style2 = '';
							  
						  }
						  
						  if($row_Recordset3['Email'] != $row['Email']){
							  
							  $style3 = ' style="color:#FF0000"';
							  
						  } else {
							  
							  $style3 = '';
							  
						  }
						  
						  
						  
						  ?>
                            <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
                              <td width="25%"><?php echo $row_Recordset3['Industry']; ?></td>
                              <td width="25%"<?php echo $style1; ?>><?php echo $row_Recordset3['CompanyName']; ?></td>
                              <td width="25%"<?php echo $style2; ?>><?php echo $row_Recordset3['ContactPerson']; ?></td>
                              <td width="25%"<?php echo $style3; ?>><?php echo $row_Recordset3['Email']; ?></td>
                            </tr>
                            <?php } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3)); ?>
<tr class="td-header">
                            <td colspan="4"><table border="0" align="right" cellpadding="0" cellspacing="0">
                              <tr>
                                <td><input name="approve" type="submit" class="btn-generic" id="approve" value="Authorise" /></td>
                                <td><input name="reject" type="submit" class="btn-generic-red" id="reject" value="Decline" /></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                      </div></td>
                    </tr>
                  </table>
                    <script type="text/javascript">
initShowHideDivs();
<?php if(isset($_POST['invite-new']) || isset($_POST['update']) || isset($_GET['Id'])){ ?>
showHideContent(false,2);	// Automatically expand first item
<?php } ?>
                  </script></td>
                </tr>
              </table>
            </form>
        <?php } ?>
        </td>
      </tr>
    </table>
    <?php if($totalRows_Recordset2 >= 1){ ?>
    <br />
    <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="list-border">
          <table width="992" border="0" align="center" cellpadding="2" cellspacing="3">
            <tr>
              <td width="241" class="td-header">&nbsp;Industry</td>
              <td width="241" class="td-header">Invitations</td>
              <td width="241" class="td-header">Requestor</td>
              <td width="159" class="td-header">Date</td>
              <td colspan="2" class="td-header">&nbsp;</td>
            </tr>
            <?php do { 
			$industry_type = $row_Recordset2['IndustryType'];
			$alertid = $row_Recordset2['AlertId'];
			$userid = $_SESSION['userid'];
			?>
            <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
              <td>&nbsp;<?php echo $row_Recordset2['Industry']; ?></td>
              <td width="241">  &nbsp;<?php count_invitations_temp($alertid,$con); ?></td>
              <td width="241">  &nbsp;<?php echo $row_Recordset2['Requestor']; ?></td>
              <td width="159">  &nbsp;<?php echo $row_Recordset2['DateRequested']; ?></td>
              <td width="17"><?php invitation_icon($userid,$alertid,$con); ?></td>
              <td width="48"><form id="form2" name="form2" method="post" action="invitation-list-pending.php?Id=<?php echo $row_Recordset2['AlertId']; ?>">
                <input name="edit" type="submit" class="btn-generic" id="edit" value="View" />
              </form></td>
            </tr>
            <?php } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2)); ?>
            <tr>
              <td colspan="6" align="right" class="td-header">&nbsp;</td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table>
  <?php } else { ?>
  You have no pending alerts.
  <?php } ?>
</div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);

mysqli_free_result($Recordset2);

mysqli_free_result($Recordset3);

mysqli_free_result($Recordset4);
?>
