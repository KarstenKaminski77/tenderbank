<?php 
session_start();

require_once('Connections/tender.php'); 

require_once('functions/functions.php');

require_once "Mail.php"; 

login($con);

select_db();

// Minimum Of 5 Gaurdians Required

$num_rows = 5;

// Add Additional Guardians

if(isset($_POST['add'])){
				
	$num_rows = count($_POST['name']) + 1;
}

$name_list = array();
$surname_list = array();
$email_list = array();
$mobile_list = array();

$name_1 = $_POST['name'];
$surname_1 = $_POST['surname'];
$email_1 = $_POST['g-email'];
$mobile_1 = $_POST['mobile'];

for($c=0;$c<$num_rows;$c++){ 

   $name = $name_1[$c];
   array_push($name_list, $name);
   
   $surname = $surname_1[$c];
   array_push($surname_list, $surname);
   
   // Check for duplicate email addresses
   
   $g_mail = $email_1[$c];
   
   if(!in_array($g_mail, $email_list)){
	   
	   array_push($email_list, $g_mail);
	   
   } else {
	   
	   array_push($email_list, '');
	   $_SESSION['error'] = 'Error';
	   
   }
   
   $mobile = $mobile_1[$c];
   array_push($mobile_list, $mobile);
   
}

// Remove Guardian From Array

if(isset($_POST['delete'])){
	
	$delete_1 = $_POST['delete'];
	
	for($i=0;$i<count($_POST['delete']);$i++){
		
		$delete = $delete_1[$i];
		
		unset($name_list[$delete]);
		unset($surname_list[$delete]);
		unset($email_list[$delete]);
		unset($mobile_list[$delete]);
	
	}
	
	$num_rows = count($_POST['name']) - count($_POST['delete']);

}

// Reset Array Keys After Removing Specific Gaurdian From Array

$name_list = array_merge($name_list);
$surname_list = array_merge($surname_list);
$email_list = array_merge($email_list);
$mobile_list = array_merge($mobile_list);

// Generic Form Field Validation

function required_field($field){
	
	if(isset($_POST['register'])){
		
		if(empty($field)){
			
			echo '<span class="error">Required Field</span>';
			
			// Set Error To Check If Form Can Be Submitted
			
			$_SESSION['error'] = 'Error';
		}
	}
}

$duplicate_email = array();
						
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
$query_Recordset1 = "SELECT * FROM tbl_nature_business ORDER BY Type ASC";
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_tender, $tender);
$query_Recordset2 = "SELECT * FROM tbl_countries ORDER BY Country ASC";
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
  <?php echo $_SESSION['mail-error']; ?>
    <table border="0" align="right" cellpadding="2" cellspacing="3">
      <tr>
        <td><input name="username" type="text" class="tarea-login" /></td>
        <td><input name="password" type="text" class="tarea-login" /></td>
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
<div id="container-register">
  <form id="form2" name="form2" method="post" action="register.php">
    <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="list-border">
          <table border="0" align="center" cellpadding="2" cellspacing="3">
            <tr>
              <td colspan="4" class="td-header">&nbsp;General Information</td>
            </tr>
            <tr class="even">
              <td width="106">Company:</td>
              <td width="367" class="error">
              <input name="company" type="text" class="tarea2" id="company" value="<?php echo $_POST['company']; ?>" />                
			  <?php
              $field = $_POST['company'];
			  required_field($field);
			  ?></td>
              <td width="111">Contact Person:</td>
              <td width="367" class="error">
              <input name="contact-person" type="text" class="tarea2" id="contact-person" value="<?php echo $_POST['contact-person']; ?>" />
              <?php 
			  $field = $_POST['contact-person'];
			  required_field($field);
			  ?></td>
            </tr>
            <tr class="odd">
              <td>Telephone:</td>
              <td class="error">
              <input name="telephone" type="text" class="tarea2" id="telephone" value="<?php echo $_POST['telephone']; ?>" />
              <?php
			  $field = $_POST['telephone'];
			  required_field($field);
			  ?>
              </td>
              <td>Email:</td>
              <td class="error">
              <input name="email" type="text" class="tarea2" id="email" value="<?php echo $_POST['email']; ?>" />
              <?php
			  $field = $_POST['email'];
			  required_field($field);
			  ?>
              </td>
            </tr>
            <tr class="even">
              <td>Address:</td>
              <td class="error">
              <input name="address" type="text" class="tarea2" id="address" value="<?php echo $_POST['address']; ?>" />
              <?php
			  $field = $_POST['address'];
			  required_field($field);
			  ?>
              </td>
              <td>Suburb:</td>
              <td class="error">
              <input name="suburb" type="text" class="tarea2" id="suburb" value="<?php echo $_POST['suburb']; ?>" />
              <?php
			  $field = $_POST['suburb'];
			  required_field($field);
			  ?>
              </td>
             </tr>
            <tr class="odd">
              <td>City:</td>
              <td class="error">
              <input name="city" type="text" class="tarea2" id="city" value="<?php if(isset($_POST['city'])){ echo $_POST['city']; } ?>" />
              <?php
			  $field = $_POST['city'];
			  required_field($field);
			  ?>
              </td>
              <td>Country:</td>
              <td class="error">
              <select name="country" class="tarea2" id="country">
                <option value="">Select one...</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['Country']?>"<?php if ($row_Recordset2['Country'] == $_POST['country']) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['Country']?></option>
                <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
              </select>
              <?php
			  $field = $_POST['country'];
			  required_field($field);
			  ?>
                            </td>
            </tr>
            <tr class="even">
              <td>Company Reg No:</td>
              <td class="error">
              <input name="reg-no" type="text" class="tarea2" id="reg-no" value="<?php echo $_POST['reg-no']; ?>" />
              <?php
			  $field = $_POST['reg-no'];
			  required_field($field);
			  ?>
              </td>
              <td>Nature of Business:</td>
              <td class="error"><select name="nature-business" class="tarea2" id="nature-business">
                <option value="">Select one...</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['Type']?>"<?php if ($_POST['nature-business'] == $row_Recordset1['Type']) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['Type']?></option>
                <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
              </select>
              <?php
			  $field = $_POST['nature-business'];
			  required_field($field);
			  ?>
               </td>
            </tr>
            <tr class="odd">
              <td>Company Type:</td>
              <td colspan="3"><label>
                <input <?php if ($_POST['company-type'] == "Private") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="Private" id="company-type_0" />
                Private</label>
                <label> &nbsp; 
                  &nbsp;
                  <input <?php if ($_POST['company-type'] == "Public") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="Public" id="company-type_1" />
                  Public</label>
                <label> &nbsp; 
                  &nbsp;
                  <input <?php if ($_POST['company-type'] == "State / Government") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="State / Government" id="company-type_2" />
                  State / Government</label>
              <?php
			  $field = $_POST['company-type'];
			  required_field($field);
			  ?>
                                </td>
            </tr>
            <tr class="odd">
              <td colspan="4" class="td-header">&nbsp;Billing Information</td>
              </tr>
            <tr class="even">
              <td>&nbsp;Contact Person:</td>
              <td>
              <input name="billing-contact" type="text" class="tarea2" id="billing-contact" value="<?php echo $_POST['billing-contact']; ?>" />
              <?php
			  $field = $_POST['billing-contact'];
			  required_field($field);
			  ?>
              </td>
              <td>&nbsp;Email:</td>
              <td>
              <input name="billing-mail" type="text" class="tarea2" id="billing-mail" value="<?php echo $_POST['billing-mail']; ?>" />
              <?php
			  $field = $_POST['billing-mail'];
			  required_field($field);
			  ?>
              </td>
              </tr>
            <tr class="odd">
              <td>&nbsp;Address:</td>
              <td>
              <input name="billing-address" type="text" class="tarea2" id="billing-address" value="<?php echo $_POST['billing-address']; ?>" />
              <?php
			  $field = $_POST['billing-address'];
			  required_field($field);
			  ?>
              </td>
              <td>&nbsp;Vat No:</td>
              <td>
              <input name="vatno" type="text" class="tarea2" id="vatno" value="<?php echo $_POST['vatno']; ?>" />
              <?php
			  $field = $_POST['vatno'];
			  required_field($field);
			  ?>
              </td>
            </tr>
            <tr class="odd">
              <td colspan="4" class="td-header"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="98%">&nbsp;Nominate Guardians (Minimum 5)</td>
                  <td width="2%" align="right"><div id="new-nature-business"><input name="add" type="submit" class="new-nature-business" id="add" value="" /></div></td>
                  </tr>
                </table></td>
            </tr>
            <?php for($c=0;$c<$num_rows;$c++){ ?>
            <tr class="odd">
              <td colspan="4" class="odd-dark"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="98%"><strong>&nbsp;Guardian <?php echo $c + 1; ?></strong></td>
                  <td width="2%"><input type="checkbox" name="delete[]" id="delete[]" value="<?php echo $c; ?>" /></td>
                  </tr>
              </table></td>
              </tr>
            <tr class="even">
              <td>First Name:</td>
              <td class="error"><input name="name[]" type="text" class="tarea2" id="name[]" value="<?php echo $name_list[$c]; ?>" />
              <?php 
			  $field = $name_list[$c];
			  required_field($field); 
			  ?>
              </td>
              <td>Last Name:</td>
              <td class="error"> <input name="surname[]" type="text" class="tarea2" id="surname[]" value="<?php echo $surname_list[$c]; ?>" />
              <?php 
			  $field = $surname_list[$c];
			  required_field($field); 
			  ?>
			  </td>
            </tr>
            <tr class="odd">
              <td>Email:</td>
              <td class="error"><input name="g-email[]" type="text" class="tarea2" id="g-email[]" value="<?php echo $email_list[$c]; ?>" />
              <?php 
			  $mail = $email_1[$c];
			  if(!empty($mail) && in_array($mail, $duplicate_email)){
				  
				  echo 'Duplicate Eamil Address';
				  
			  } else {
				  
				  $field = $email_list[$c];
				  required_field($field);
				  
			  }
			  
			  array_push($duplicate_email, $mail);
			  ?>
              </td>
              <td>Mobile:</td>
              <td class="error"><input name="mobile[]" type="text" class="tarea2" id="mobile[]" value="<?php echo $mobile_list[$c]; ?>" />
              <?php 
			  $field = $mobile_list[$c];
			  required_field($field); 
			  ?>
              </td>
            </tr>
            <tr class="even">
              <td>&nbsp;Accessability:</td>
              <td colspan="3"><table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <?php
  $i = 0;
  
  $query = mysql_query("SELECT * FROM tbl_menu_items ORDER BY Name ASC")or die(mysql_error());
  while($row = mysql_fetch_array($query)){
  
  $level_id = $row_Recordset1['Id'];
  $userid = $_GET['Id'];
  
  $query2 = mysql_query("SELECT * FROM tbl_menu_relation WHERE MenuId = '$level_id' AND UserId = '$userid'")or die(mysql_error());
  $numrows = mysql_num_rows($query2);
  
  $i++;
  
?>
                  <td><table border="0" cellspacing="3" cellpadding="2">
                    <tr>
                      <td><input name="access[]" type="checkbox" id="access[<?php echo $i; ?>]" value="<?php echo $row['Id']; ?>" checked="checked" <?php if($numrows >= 1){ echo 'checked="checked"'; } ?> />
                        &nbsp;
                        <label for="access[<?php echo $i; ?>]"><?php echo $row['Name']; ?></label></td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                  <?php  } ?>
                </tr>
              </table></td>
            </tr>
			<?php } ?>
            <tr>
              <td colspan="4" align="right" class="td-header">
              <div id="btn-padding">
                  <input name="register" type="submit" class="btn-generic" id="register" value="Register" />
                </div></td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>
<?php

if(isset($_POST['register']) && ($_SESSION['error'] != 'Error')){
	
	
	// General Information
	
	$company = $_POST['company'];
	$name = $_POST['contact-person'];
	$telephone = $_POST['telephone'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$suburb = $_POST['suburb'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	$regno = $_POST['reg-no'];
	$nature = $_POST['nature-business'];
	$type = $_POST['company-type'];
	
	mysql_query("INSERT INTO tbl_registered_users (CompanyName,ContactPerson,Email,Telephone,Address,Suburb,City,Country,CompanyRegNo,NatureOfBusiness,CompanyType,Approved) VALUES ('$company','$name','$email','$telephone','$address','$suburb','$city','$country','$regno','$nature','$type','0')")or die(mysql_error());
		
	$query = mysql_query("SELECT * FROM tbl_registered_users ORDER BY Id DESC LIMIT 1")or die(mysql_error());
	$row = mysql_fetch_array($query);
	
	$companyid = $row['Id'];
	
	// Billing Information
	
	$name_b = $_POST['billing-contact'];
	$email_b = $_POST['billing-mail'];
	$address_b = $_POST['billing-address'];
	$vatno = $_POST['vatno'];
	
	mysql_query("INSERT INTO tbl_billing_info (CompanyId,ContactPerson,Email,Address,VatNo) VALUES ('$companyid','$name_b','$email_b','$address_b','$vatno')")or die(mysql_error());
	
	// Add Guardian Accounts To Temporary Table Pending Approval
	
	$guardian_name = $_POST['name'];
	$guardian_surname = $_POST['surname'];
	$guardian_mail = $_POST['g-email'];
	$guardian_mobile = $_POST['mobile'];
	
	date_default_timezone_set('Etc/UTC');
	
	require_once('PHPMailer/PHPMailerAutoload.php');
	
	for($i=0;$i<$num_rows;$i++){
		
		$g_name = $guardian_name[$i];
		$g_surname = $guardian_surname[$i];
		$g_mail = $guardian_mail[$i];
		$g_mobile = $guardian_mobile[$i];
		$characters = 6;
		generateCode($characters);
		$password = $_SESSION['password'];
		
		mysql_query("INSERT INTO tbl_users_temp (Name,Surname,Username,Mobile,Password,CompanyId,UserLevel,Guardian) VALUES ('$g_name','$g_surname','$g_mail','$g_mobile','$password','$companyid','2','1')")or die(mysql_error());
		
		$query2 =mysql_query("SELECT * FROM tbl_users_temp ORDER BY Id DESC LIMIT 1")or die(mysql_error());
		$row2 = mysql_fetch_array($query2);
		
		$userid = $row2['Id'];
				
		$body = '
		  <body style="font-family:Arial; font-size:12px; color:002a76">
		  <table border="0" cellspacing="3" cellpadding="2" style="font-family:Arial; font-size:12px; color:002a76">
			<tr>
			  <td><img src="http://www.tenderbank.co.za/images/mail-logo.jpg" width="193" height="39" /></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>Hi '. $g_name .'<br />
			  <br />
			  You have been nominated as a Guardian for '. $company .'s account with Tender Bank.<br />
			  <br />
			  Please activate your user account using the button below.</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td><a href="http://www.tenderbank.co.za/activate-guardian.php?Id='.$userid.'"><img src="http://www.tenderbank.co.za/images/btn-activate.jpg" border="0" width="113" height="29" /></a></td>
			</tr>
		  </table>
		  </body>';
		  		
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = "www27.jnb1.host-h.net";
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = 587;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication
		$mail->Username = "test@kwd.co.za";
		//Password to use for SMTP authentication
		$mail->Password = "K4rsten001";
		//Set who the message is to be sent from
		$mail->setFrom('control@seavest.co.za', 'Seavest Africa');
		//Set an alternative reply-to address
		$mail->addReplyTo('control@seavest.co.za', 'Seavest Africa');
		//Set who the message is to be sent to
		$mail->addAddress($g_mail, $guardian_name .' '. $guardian_surname);
		//Set the subject line
		$mail->Subject = 'Tender Bank Registration';
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($body);
		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');
		
		$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		));
		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}		

	}
	
	header('Location: register-confirm.php?Id='.$companyid);
}

unset($_SESSION['error']);
?>