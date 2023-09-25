<?php require_once('Connections/tender.php'); ?>
<?php
// Load the tNG classes
require_once('includes/tng/tNG.inc.php');
 
session_start();

require_once('Connections/tender.php');

require_once('functions/functions.php');

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

$colname_Recordset1 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset1 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset1 = sprintf("SELECT * FROM tbl_tenders WHERE Id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$invitation_list = $row_Recordset1['InvitationType'];

$colname_Recordset2 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset2 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset2 = sprintf("SELECT * FROM tbl_invitations_sent WHERE TenderId = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset3 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset3 = sprintf("SELECT * FROM tbl_tenderers WHERE TenderId = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $tender) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$invitations = $totalRows_Recordset2;
$id = $_GET['Id'];

ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php 
		
		// Loop through the invitation list and que to be sent
		
		$companyid = $_SESSION['companyid'];
		$invitation_type = $_GET['Type'];
		
		$query4 = mysql_query("SELECT * FROM tbl_invitation_list WHERE CompanyId = '$companyid' AND IndustryType = '$invitation_type'")or die(mysql_error());
		while($row4 = mysql_fetch_array($query4)){
			
			$company = $row4['CompanyName'];
			$contact = $row4['ContactPerson'];
			$email = $row4['Email'];
		    $tender_id = $_GET['Id'];
			$end = $row_Recordset1['ClosingDate'];
			$bidderid = $row4['Id'];
			
			$possible = '23456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMOPRSTUVWQYZ'; 
			$code = '';
			$i = 0;
			
			while ($i < 7) {
				
				$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
				$i++;
			}

			$password = md5($code);
			
			mysql_query("INSERT into tbl_invitations_sent(CompanyId,TenderId,BidderId,CompanyName,ContactPerson,Email,Password,ExpiryDate)
			VALUES('$companyid','$tender_id','$bidderid','$company','$contact','$email','$password','$end')") or die(mysql_error());
			


?>
<body>
<?php
  $sectemailObj = new tNG_EmailPageSection();
  $sectemailObj->getCSSFrom(__FILE__);
  $sectemailObj->setTo($row4['Email']);
  $sectemailObj->setFrom("test@kwd.co.za");
  $sectemailObj->setSubject("Request For Tender");
  $sectemailObj->setFormat("HTML/Text");
  $sectemailObj->setEncoding("UTF-8");
  $sectemailObj->setImportance("Normal");
  $sectemailObj->BeginContent();
?>
    <table border="0" cellspacing="3" cellpadding="2" style="font-family:Arial; font-size:12px; color:#002a76; font-weight:normal">
      <tr>
        <td width="329"><img src="http://www.tenderbank.co.za/images/logo.jpg" width="305" height="60" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><p>Hi <?php echo $contact; ?><br />
          <br />
          You have been invited .....</p>
          <p><strong>Username: </strong><?php echo $email; ?><br />
            <strong>Password: </strong>
          <?php echo $code; ?></p>
          <p><a href="http://www.tenderbank.co.za/tender-login.php?Id=<?php echo $tender_id; ?>&CompanyId=<?php echo $row4['CompanyId']; ?>&User=<?php echo $row4['Email']; ?>&Password=<?php echo $code; ?>">Click here</a> to login and submit your tender<br />
            <br />
          </p>
          <p>        Kind Regards</p>
          <p>Tender Bank<br />
        </p></td>
      </tr>
    </table>
  <?php
  $sectemailObj->EndContent();
  $sectemailObj->Execute();
?>
</body>
<?php }  ?>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

//Redirect Email sectemailObj
  $redObj = new tNG_Redirect(null);
  $redObj->setURL("tender-confirm.php");
  $redObj->setKeepURLParams(false);
  $redObj->Execute();
//End Redirect Email sectemailObj
?>
