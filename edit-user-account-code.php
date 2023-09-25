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

/**************************************************
**************** AUTHORISE NEW ACCOUNT ***************
**************************************************/

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
					
					$query4 = mysql_query("SELECT * FROM tbl_users_temp WHERE AlertId = '$alertid'")or die(mysql_error());
					$row4 = mysql_fetch_array($query4);
						
					$name = $row4['Name'];
					$surname = $row4['Surname'];
					$email = $row4['Username'];
					$password = $row4['Password'];
					$level = $row4['UserLevel'];
					$companyid = $row4['CompanyId'];
					$guardian = $row4['Guardian'];
					$oldid = $row4['OldId'];
					
				    // If new account
				
				    if($oldid == 0){
						
					// Insert new user account details
						
					mysql_query("INSERT INTO tbl_users (Name,Surname,Username,Password,CompanyId,UserLevel,Guardian) 
					VALUES ('$name','$surname','$email','$password','$companyid','$level','$guardian')")or die(mysql_error());
					
					// Insert menu items	
						
					$query5 = mysql_query("SELECT * FROM tbl_menu_relation_temp WHERE AlertId = '$alertid'")or die(mysql_error());
					$row5 = mysql_fetch_array($query5);
						
						$userid = $row5['UserId'];
						$menuid = $row5['MenuId'];
						
						mysql_query("INSERT INTO tbl_menu_relation (UserId, MenuId) VALUES ('$userid','$menuid')")or die(mysql_error());
						
						$query6 = mysql_query("SELECT * FROM tbl_users WHERE CompanyId = '$companyid' ORDER BY Id DESC LIMIT 1")or die(mysql_error());
						$row6 = mysql_fetch_array($query6);
						
						$id = $row6['Id'];
					
					// Update old account
					
					} else {
						
						mysql_query("UPDATE tbl_users SET Name = '$name', Surname = '$surname', Username = '$email', Password = '$password', Guardian = '$guardian' WHERE Id = '$oldid'")or die(mysql_error());
												
						$id = $oldid;
						
					}
					
					// Clear the database
					
					mysql_query("DELETE FROM tbl_alerts WHERE Id = '$alertid'")or die(mysql_error());
					
					mysql_query("DELETE FROM tbl_alert_responses WHERE AlertId = '$alertid'")or die(mysql_error());
					
					mysql_query("DELETE FROM tbl_users_temp WHERE AlertId = '$alertid'")or die(mysql_error());
					
					// Send email with login details
					
					$query = mysql_query("SELECT * FROM tbl_users WHERE Id = '$oldid' ORDER BY Id DESC LIMIT 1")or die(mysql_error());
					$row = mysql_fetch_array($query);
					
					$name = $row['Name'];
					$email = $row['Username'];
					$password = $row['Password'];
					
					$subject = 'Tender Bank Login Details';
					
					$message = '
<body style="font-family:Arial; font-size:12px; color:002a76">
<table border="0" cellspacing="3" cellpadding="2" style="font-family:Arial; font-size:12px; color:002a76">
  <tr>
    <td width="329"><img src="http://www.tenderbank.co.za/images/logo.jpg" width="305" height="60" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>Hi '.$name.'<br />
      <br />
      <br />
    Your account with Tender Bank has been successfully created.<br />
    <br />
    Please use the following username and associated password to   securely access the &quot;My Account&quot; Tab at <a href="http://www.tenderbank.co.za">http://www.tenderbank.co.za</a>.<br />
    <br />
    </p>
      <table border="0" cellspacing="3" cellpadding="2" style="font-family:Arial; font-size:12px; color:002a76">
        <tr>
          <td><strong>Username</strong></td>
          <td>'.$email.'</td>
        </tr>
        <tr>
          <td><strong>Password</strong></td>
          <td>'.$password.'</td>
        </tr>
      </table>
      <p>        Kind Regards</p>
      <p>Tender Bank<br />
    </p></td>
  </tr>
</table>
</body>
';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'FROM: test@kwd.co.za' . "\r\n";

mail($email, $subject, $message, $headers);
	
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



/**************************************************
**************** DECLINE NEW ACCOUNT ***************
**************************************************/

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
				
				// If all guardians vote to decline change
				
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
