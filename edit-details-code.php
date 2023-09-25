<?php
session_start();

require_once('Connections/tender.php');

require_once('functions/functions.php');

if(isset($_POST['approve'])){
	
	$_SESSION['status'] = '1';
	
}

if(isset($_POST['reject'])){
	
	$_SESSION['status'] = '0';
	
}

// VOTE TO AUTHORISE CHANGE

if(isset($_POST['code']) && $_SESSION['status'] == '1'){
	
	$userid = $_SESSION['userid'];
	$companyid = $_SESSION['companyid'];
	$alertid = $_GET['Id'];
	
	// Get reference code
	
	$query = mysql_query("SELECT * FROM tbl_alerts WHERE Id = '$alertid'")or die(mysql_error());
	$row = mysql_fetch_array($query);
	
	if($row['Password'] == $_POST['code']){
		
		// Check if user has voted
		
		$query = mysql_query("SELECT * FROM tbl_alert_responses WHERE UserId = '$userid' AND AlertId = '$alertid'")or die(mysql_error());
		$numrows = mysql_num_rows($query);
		
		if($numrows == 0){
			
			// Insert vote
			
			mysql_query("INSERT INTO tbl_alert_responses (AlertId,UserId,Response) VALUES ('$alertid','$userid','1')")or die(mysql_error());
			
			// Count guardians
			
			$query = mysql_query("SELECT * FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysql_error());
			$numrows = mysql_num_rows($query);
			
			// Count votes
			
			$query2 = mysql_query("SELECT * FROM tbl_alert_responses WHERE AlertId = '$alertid'")or die(mysql_error());
			$numrows2 = mysql_num_rows($query2);
			
			// If all guardians have voted
			
			if($numrows == $numrows2){
				
				$query3 = mysql_query("SELECT SUM(Response) FROM tbl_alert_responses WHERE AlertId ='$alertid'")or die(mysql_error());
				$row3 = mysql_fetch_array($query3);
				
				// If all guardians authorise change get new details from temporary table
				
				if($row3['SUM(Response)'] == $numrows){
					
					$query4 = mysql_query("SELECT * FROM tbl_registered_users_temp WHERE CompanyId = '$companyid'")or die(mysql_error());
					$row4 = mysql_fetch_array($query4);
						
						$company = $row4['CompanyName'];
						$contact = $row4['ContactPerson'];
						$email = $row4['Email'];
						$telephone = $row4['Telephone'];
						$address = $row4['Address'];
						$suburb = $row4['Suburb'];
						$city = $row4['City'];
						$country = $row4['Country'];
						$regno = $row4['CompanyRegNo'];
						$nature = $row4['NatureOfBusiness'];
						$type = $row4['CompanyType'];
						
						// Update company details
													
						mysql_query("UPDATE tbl_registered_users SET CompanyName = '$company', ContactPerson = '$contact', Email = '$email', Telephone = '$telephone', Address = '$address', Suburb = '$suburb', City = '$city', Country = '$country', CompanyRegNo = '$regno', NatureOfBusiness = '$nature', CompanyType = '$type' WHERE Id = '$companyid'") or die(mysql_error());
						
					
				// Clear the database
				
				mysql_query("DELETE FROM tbl_alerts WHERE Id = '$alertid'")or die(mysql_error());
				
				mysql_query("DELETE FROM tbl_alert_responses WHERE AlertId = '$alertid'")or die(mysql_error());
				
				mysql_query("DELETE FROM tbl_registered_users_temp WHERE CompanyId = '$companyid'")or die(mysql_error());
										
				}
								
			}
			
		} else {
			
			$_SESSION['alert_error'] = 'You may only vote once.';
			
		}
		
	} else {
		
		$_SESSION['alert_error'] = 'Invalid code.';
		
	}
	
	header('Location: pending-alerts.php');
}



// VOTE TO DECLINE CHANGE

if(isset($_POST['code']) && $_SESSION['status'] == '0'){
	
	$userid = $_SESSION['userid'];
	$companyid = $_SESSION['companyid'];
	$alertid = $_GET['Id'];
	
	// Get reference code
	
	$query = mysql_query("SELECT * FROM tbl_alerts WHERE Id = '$alertid'")or die(mysql_error());
	$row = mysql_fetch_array($query);
	
	if($row['Password'] == $_POST['code']){
		
		// Check if user has voted
		
		$query = mysql_query("SELECT * FROM tbl_alert_responses WHERE UserId = '$userid' AND AlertId = '$alertid'")or die(mysql_error());
		$numrows = mysql_num_rows($query);
		
		if($numrows == 0){
			
			// Insert vote
			
			mysql_query("INSERT INTO tbl_alert_responses (AlertId,UserId,Response) VALUES ('$alertid','$userid','0')")or die(mysql_error());
			
			// Count guardians
			
			$query = mysql_query("SELECT * FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysql_error());
			$numrows = mysql_num_rows($query);
			
			// Count votes
			
			$query2 = mysql_query("SELECT * FROM tbl_alert_responses WHERE AlertId = '$alertid'")or die(mysql_error());
			$numrows2 = mysql_num_rows($query2);
			
			// If all guardians have voted
			
			if($numrows == $numrows2){
				
				$query3 = mysql_query("SELECT SUM(Response) FROM tbl_alert_responses WHERE AlertId ='$alertid'")or die(mysql_error());
				$row3 = mysql_fetch_array($query3);
				
				// If all guardians vote to not authorise change
				
				if($row3['SUM(Response)'] != $numrows){
					
				// Clear the database
				
				mysql_query("DELETE FROM tbl_alerts WHERE Id = '$alertid'")or die(mysql_error());
				
				mysql_query("DELETE FROM tbl_alert_responses WHERE AlertId = '$alertid'")or die(mysql_error());
				
				mysql_query("DELETE FROM tbl_registered_users_temp WHERE CompanyId = '$companyid'")or die(mysql_error());
								
						
				}
				
			}
			
		} else {
			
			$_SESSION['alert_error'] = 'You may only vote once.';
			
		}
		
	} else {
		
		$_SESSION['alert_error'] = 'Invalid code.';
		
	}
	
	header('Location: pending-alerts.php');
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
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset1['Name']; ?> <?php echo $row_Recordset1['Surname']; ?></a> 
  <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset1['LastLogin'])); ?></a>
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
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div id="container">
    <table width="964" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="982" border="0" align="center" cellpadding="2" cellspacing="3">
          <tr>
            <td rowspan="2" valign="bottom" nowrap="nowrap" class="header">&nbsp;</td>
            <td align="right"><span class="header"><?php echo $row_Recordset2['CompanyName']; ?><br />
            </span></td>
          </tr>
          <tr>
            <td width="891" align="right"><?php echo $row_Recordset2['Address']; ?><br />
              <?php echo $row_Recordset2['Suburb']; ?><br />
              <?php echo $row_Recordset2['City']; ?><br />
              <?php echo $row_Recordset2['Country']; ?></td>
          <tr>
            <td colspan="2" valign="bottom" nowrap="nowrap" class="header">&nbsp;</td>
            <tr>
            <td colspan="2" valign="bottom" nowrap="nowrap"><table border="0" align="center" cellpadding="2" cellspacing="3">
              <tr>
                <td>Please enter your reference code to proceed</td>
              </tr>
              <tr>
                <td><table border="0" align="center" cellpadding="5" cellspacing="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="code" type="text" class="tarea-login" id="code" /></td>
                    <td><input name="button" type="submit" class="btn-generic" id="button" value="Authorise" /></td>
                  </tr>
                </table></td></tr>
            </table></td>
        </table></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
