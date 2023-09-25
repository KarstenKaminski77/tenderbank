<?php 
session_start();

require_once('../Connections/tender.php'); 

require_once('functions/functions.php');

login();

select_db();

if(isset($_POST['register'])){

if($_POST['company'] != NULL && $_POST['contact-person'] != NULL && $_POST['telephone'] != NULL && $_POST['email'] != NULL && $_POST['address'] != NULL && $_POST['suburb'] != NULL && $_POST['city'] != NULL && $_POST['country'] != NULL && $_POST['reg-no'] != NULL && $_POST['nature-business'] != NULL && isset($_POST['company-type'])){

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

$userid = $row['Id'];

$to  = $email; 
$subject = 'Tender Bank Registration';

$message = '
<body style="font-family:Arial; font-size:12px; color:002a76">
<table border="0" cellspacing="3" cellpadding="2" style="font-family:Arial; font-size:12px; color:002a76">
  <tr>
    <td colspan="2"><img src="http://www.tenderbank.co.za/images/logo.jpg" width="305" height="60" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Company</strong></td>
    <td>'. $_POST['company'] .'</td>
  </tr>
  <tr>
    <td><strong>Contact Person</strong></td>
    <td>'. $_POST['contact-person'] .'</td>
  </tr>
  <tr>
    <td><strong>Telephone No</strong></td>
    <td>'. $_POST['telephone'] .'</td>
  </tr>
  <tr>
    <td><strong>Email</strong></td>
    <td>'. $_POST['email'] .'</td>
  </tr>
  <tr>
    <td><strong>Address</strong></td>
    <td>'. $_POST['address'] .'</td>
  </tr>
  <tr>
    <td><strong>Suburb</strong></td>
    <td>'. $_POST['suburb'] .'</td>
  </tr>
  <tr>
    <td><strong>City</strong></td>
    <td>'. $_POST['city'] .'</td>
  </tr>
  <tr>
    <td><strong>Country</strong></td>
    <td>'. $_POST['country'] .'</td>
  </tr>
  <tr>
    <td><strong>Company Reg No</strong></td>
    <td>'. $_POST['reg-no'] .'</td>
  </tr>
  <tr>
    <td><strong>Nature of Business</strong></td>
    <td>'. $_POST['nature-business'] .'</td>
  </tr>
  <tr>
    <td><strong>Type of Company</strong></td>
    <td>'. $_POST['company-type'] .'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="http://www.tenderbank.co.za/new/activate-registration.php?Id='.$userid.'"><img src="http://www.tenderbank.co.za/images/btn-activate.jpg" border="0" width="113" height="29" /></a></td>
    <td><a href="http://www.tenderbank.co.za/new/deny-registration.php?Id='.$userid.'"><img src="http://www.tenderbank.co.za/images/btn-decline.jpg" border="0" width="113" height="29" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<div id="footer"></div>
</body>

';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'FROM: test@kwd.co.za' . "\r\n";
$headers .= 'Cc: nicky@seavest.co.za' . "\r\n";

mail($to, $subject, $message, $headers);

}}

if(isset($_POST['register'])){
				
				if($_POST['company'] == NULL){
					
					$error_1 = 'Required Field';
					
				}

				
				if($_POST['contact-person'] == NULL){
					
					$error_2 = 'Required Field';
					
				}

				
				if($_POST['telephone'] == NULL){
					
					$error_3 = 'Required Field';
					
				}

				
				if($_POST['email'] == NULL){
					
					$error_4 = 'Required Field';

					
				}

				
				if($_POST['address'] == NULL){
					
					$error_5 = 'Required Field';
					
				}

				
				if($_POST['suburb'] == NULL){
					
					$error_6 = 'Required Field';
					
				}

				
				if($_POST['city'] == NULL){
					
					$error_7 = 'Required Field';
					
				}

				
				if($_POST['country'] == NULL){
					
					$error_8 = 'Required Field';
					
				}

				
				if($_POST['reg-no'] == NULL){
					
					$error_9 = 'Required Field';
					
				}

				
				if($_POST['nature-business'] == NULL){
					
					$error_10 = 'Required Field';
					
				}

				
				if(!isset($_POST['company-type'])){
					
					$error_11 = '<span class="error">Required Field</span>';
					
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
<div id="tab-top"></div>
<div id="container">
  <form id="form2" name="form2" method="post" action="register.php">
    <br />
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="list-border">
          <table border="0" cellpadding="2" cellspacing="3">
            <tr>
              <td colspan="4" class="td-header">&nbsp;</td>
            </tr>
            <tr class="even">
              <td width="106">Company:</td>
              <td width="367" class="error"><input name="company" type="text" class="tarea2" id="company" value="<?php if(isset($_POST['company'])){ echo $_POST['company']; } ?>" />                <?php
							
							if(isset($error_1)){
									 
							echo $error_1; 
							
							}
							?></td>
              <td width="111">Contact Person:</td>
              <td width="367" class="error"><input name="contact-person" type="text" class="tarea2" id="contact-person" value="<?php if(isset($_POST['contact-person'])){ echo $_POST['contact-person']; } ?>" />
                <?php 
							
							if(isset($error_2)){
									 
							echo $error_2; 
							
							}
							?></td>
            </tr>
            <tr class="odd">
              <td>Telephone:</td>
              <td class="error"><input name="telephone" type="text" class="tarea2" id="telephone" value="<?php if(isset($_POST['telephone'])){ echo $_POST['telephone']; } ?>" />
                <?php 
							
							if(isset($error_3)){
									 
							echo $error_3; 
							
							}
							?></td>
              <td>Email:</td>
              <td class="error"><input name="email" type="text" class="tarea2" id="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>" />
                <?php 
							
							if(isset($error_4)){
									 
							echo $error_4; 
							
							}
							?></td>
            </tr>
            <tr class="even">
              <td>Address:</td>
              <td class="error"><input name="address" type="text" class="tarea2" id="address" value="<?php if(isset($_POST['address'])){ echo $_POST['address']; } ?>" />
                <?php 
							
							if(isset($error_5)){
									 
							echo $error_5; 
							
							}
							?></td>
              <td>Suburb:</td>
              <td class="error"><input name="suburb" type="text" class="tarea2" id="suburb" value="<?php if(isset($_POST['suburb'])){ echo $_POST['suburb']; } ?>" />
                <?php 
							
							if(isset($error_6)){
									 
							echo $error_6; 
							
							}
							?></td>
            </tr>
            <tr class="odd">
              <td>City:</td>
              <td class="error"><input name="city" type="text" class="tarea2" id="city" value="<?php if(isset($_POST['city'])){ echo $_POST['city']; } ?>" />
                <?php 
							
							if(isset($error_7)){
									 
							echo $error_7; 
							
							}
							?></td>
              <td>Country:</td>
              <td class="error"><select name="country" class="tarea2" id="country">
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
							
							if(isset($error_8)){
									 
							echo $error_8; 
							
							}
							?></td>
            </tr>
            <tr class="even">
              <td>Company Reg No:</td>
              <td class="error"><input name="reg-no" type="text" class="tarea2" id="reg-no" value="<?php if(isset($_POST['reg-no'])){ echo $_POST['reg-no']; } ?>" />
                <?php 
							
							if(isset($error_9)){
									 
							echo $error_9; 
							
							}
							?></td>
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
							
							if(isset($error_10)){
									 
							echo $error_10; 
							
							}
							?></td>
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
								
								if(isset($error_11)){
										 
								echo $error_11; 
								
								}
								?></td>
            </tr>
            <tr>
              <td colspan="4" align="right" class="td-header"><div id="btn-padding">
                <div id="btn-register">
                  <input name="register" type="submit" class="btn-register" id="register" value="" />
                </div>
              </div></td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table>
  </form>
</div>
<div id="tab-btm"></div>
<div id="gooter"></div>
</body>
</html>