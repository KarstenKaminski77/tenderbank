<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once('Connections/tender.php'); 

require_once('functions/functions.php');

select_db();

login($con);

$level = 1;

restrict_access($level,$con);


if(isset($_POST['register'])){
	
	// Verify required fields
	
	if($_POST['company'] != NULL && $_POST['contact-person'] != NULL && $_POST['telephone'] != NULL && $_POST['address'] != NULL && $_POST['suburb'] != NULL && $_POST['city'] != NULL && $_POST['country'] != NULL && $_POST['reg-no'] != NULL && $_POST['nature-business'] != NULL && isset($_POST['company-type'])){
		
		// Send alert to guardians
		
		// Find the number of guardians
		
		$companyid = $_SESSION['companyid'];
		
		$query = mysqli_query($con, "SELECT SUM(Guardian) FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysqli_error($con));
		$row = mysqli_fetch_array($query);
		
		$no_guardians = $row['SUM(Guardian)'];
		
		$userid = $_SESSION['userid'];
		
		// Find the requestors name
		
		$query2 = mysqli_query($con, "SELECT * FROM tbl_users WHERE Id = '$userid'")or die(mysqli_error($con));
		$row2 = mysqli_fetch_array($query2);
		
		$requestor = $row2['Name'] .' '. $row2['Surname'];
		
		// Create the alert
		
		$date = date('Y-m-d');
		$characters = 6;
		generateCode($characters);
		$password = $_SESSION['password'];
		$type = "Company details update request";
		$url = "edit-details-pending.php";
		
		mysqli_query($con, "INSERT INTO tbl_alerts (AlertType,Password,CompanyId,Requestor,Required,DateRequested,URL) VALUES ('$type','$password','$companyid','$requestor','$no_guardians','$date','$url')")or die(mysqli_error($con));
		
		$query3 = mysqli_query($con, "SELECT * FROM tbl_alerts WHERE CompanyId = '$companyid' ORDER BY Id DESC LIMIT 1")or die(mysqli_error($con));
		$row3 = mysqli_fetch_array($query3);
		
		$alertid = $row3['Id'];
		
		$query4 = mysqli_query($con, "SELECT * FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysqli_error($con));
		while($row4 = mysqli_fetch_array($query4)){
			
			$subject = 'Tender Bank Alert';
			$name = $row4['Name'];
			$to = $row4['Username'];
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
    '. $requestor .' has updated the company information on Tender Bank.<br />
    <br />
    Please <a href="http://www.tenderbank.co.za/edit-details-pending.php?Id='.$alertid.'">Click here</a> to view the changes and either approve or reject them. Please use the following reference code when prompted.
	<br><br>
	<b>Password:</b> '. $password .'
    </p>
	<br><br><br><br><br>
</body>
';
             $headers  = 'MIME-Version: 1.0' . "\r\n";
			 $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			 $headers .= 'FROM: test@kwd.co.za' . "\r\n";
			 
			 mail($to, $subject, $message, $headers);
			 
			 // Alert to user after submiting the form 
			 
			 $response = "Your update will be processed once all guardians have authorised the changes.";

		}

		
		// Insert updates into temporary table to await verification by guardians
		
		$company = $_POST['company'];
		$name = $_POST['contact-person'];
		$email = $_POST['email'];
		$telephone = $_POST['telephone'];
		$address = $_POST['address'];
		$suburb = $_POST['suburb'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$regno = $_POST['reg-no'];
		$nature = $_POST['nature-business'];
		$type = $_POST['company-type'];
		$date = date('Y-m-d');
		
		mysqli_query($con, "INSERT INTO tbl_registered_users_temp (AlertId,CompanyId,CompanyName,ContactPerson,Email,Telephone,Address,Suburb,City,Country,CompanyRegNo,NatureOfBusiness,CompanyType,DateModified,ModifiedBy) VALUES ('$alertid','$companyid','$company','$name','$email','$telephone','$address','$suburb','$city','$country','$regno','$nature','$type','$date','$userid')")or die(mysqli_error($con));
		
	}
}

$KTColParam1_Recordset1 = "0";
if (isset($_SESSION["companyid"])) {
  $KTColParam1_Recordset1 = $_SESSION["companyid"];
}

$query_Recordset1 = "SELECT tbl_users.Username, tbl_users.Password, tbl_registered_users.CompanyName, tbl_registered_users.ContactPerson, tbl_registered_users.Email, tbl_registered_users.Telephone, tbl_registered_users.Address, tbl_registered_users.Suburb, tbl_registered_users.Approved, tbl_registered_users.City, tbl_registered_users.Country, tbl_registered_users.CompanyRegNo, tbl_registered_users.NatureOfBusiness, tbl_registered_users.CompanyType, tbl_registered_users.SupplierType FROM (tbl_users LEFT JOIN tbl_registered_users ON tbl_registered_users.Id=tbl_users.Id) WHERE tbl_registered_users.Id = '$KTColParam1_Recordset1' ";
$Recordset1 = mysqli_query($con, $query_Recordset1) or die(mysqli_error($con));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


$query_Recordset2 = "SELECT * FROM tbl_countries ORDER BY Country ASC";
$Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error($con));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);


$query_Recordset3 = "SELECT * FROM tbl_nature_business ORDER BY Type ASC";
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

$colname_Recordset5 = "-1";
if (isset($_SESSION['companyid'])) {
  $colname_Recordset5 = $_SESSION['companyid'];
}

$query_Recordset5 = "SELECT * FROM tbl_registered_users WHERE Id = '$colname_Recordset5'";
$Recordset5 = mysqli_query($con, $query_Recordset5) or die(mysqli_error($con));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
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
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <div id="container-generic">
    <table width="100%" border="0" cellpadding="2" cellspacing="3">
      <tr>
        <td width="50%" valign="bottom" class="error"><?php echo $response; ?></td>
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
              <td width="372" align="center" class="error"><input name="company" type="text" class="tarea2" id="company" value="<?php echo $row_Recordset1['CompanyName']; ?>" />
                <?php
							
							if(isset($error_1)){
									 
							echo $error_1; 
							
							}
							?></td>
              <td width="111"><strong>Contact Person:</strong></td>
              <td width="367" align="center" class="error"><input name="contact-person" type="text" class="tarea2" id="contact-person" value="<?php echo $row_Recordset1['ContactPerson']; ?>" />
                <?php 
							
							if(isset($error_2)){
									 
							echo $error_2; 
							
							}
							?></td>
            </tr>
            <tr class="odd">
              <td><strong>Telephone:</strong></td>
              <td align="center" class="error"><input name="telephone" type="text" class="tarea2" id="telephone" value="<?php echo $row_Recordset1['Telephone']; ?>" />
                <?php 
							
							if(isset($error_3)){
									 
							echo $error_3; 
							
							}
							?></td>
              <td><strong>Email:</strong></td>
              <td align="center" class="error"><input name="email" type="text" class="tarea2" id="email" value="<?php echo $row_Recordset1['Email']; ?>" />
                <?php 
							
							if(isset($error_4)){
									 
							echo $error_4; 
							
							}
							?></td>
            </tr>
            <tr class="even">
              <td><strong>Address:</strong></td>
              <td align="center" class="error"><input name="address" type="text" class="tarea2" id="address" value="<?php echo $row_Recordset1['Address']; ?>" />
                <?php 
							
							if(isset($error_5)){
									 
							echo $error_5; 
							
							}
							?></td>
              <td><strong>Suburb:</strong></td>
              <td align="center" class="error"><input name="suburb" type="text" class="tarea2" id="suburb" value="<?php echo $row_Recordset1['Suburb']; ?>" />
                <?php 
							
							if(isset($error_6)){
									 
							echo $error_6; 
							
							}
							?></td>
            </tr>
            <tr class="odd">
              <td><strong>City:</strong></td>
              <td align="center" class="error"><input name="city" type="text" class="tarea2" id="city" value="<?php echo $row_Recordset1['City']; ?>" />
                <?php 
							
							if(isset($error_7)){
									 
							echo $error_7; 
							
							}
							?></td>
              <td><strong>Country:</strong></td>
              <td align="center" class="error"><select name="country" class="tarea2" id="country">
                <option value="" <?php if (!(strcmp("", $row_Recordset1['Country']))) {echo "selected=\"selected\"";} ?>>Select one...</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['Country']?>"<?php if (!(strcmp($row_Recordset2['Country'], $row_Recordset1['Country']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['Country']?></option>
                <?php
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
  $rows = mysqli_num_rows($Recordset2);
  if($rows > 0) {
      mysqli_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
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
              <td><strong>Company Reg No:</strong></td>
              <td align="center" class="error"><input name="reg-no" type="text" class="tarea2" id="reg-no" value="<?php echo $row_Recordset1['CompanyRegNo']; ?>" />
                <?php 
							
							if(isset($error_9)){
									 
							echo $error_9; 
							
							}
							?></td>
              <td><strong>Nature of Business:</strong></td>
              <td align="center" class="error">
              <select name="nature-business" class="tarea2" id="nature-business">
                <option value="" <?php if (!(strcmp("", $row_Recordset1['NatureOfBusiness']))) {echo "selected=\"selected\"";} ?>>Select one...</option>
                <?php do {  ?>
                <option value="<?php echo $row_Recordset3['Type']?>"<?php if ($row_Recordset3['Type'] == $row_Recordset1['NatureOfBusiness']) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['Type']?></option>
                <?php
} while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
  $rows = mysqli_num_rows($Recordset3);
  if($rows > 0) {
      mysqli_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
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
              <td><strong> Company Type:</strong></td>
              <td colspan="3"><label>
                <input <?php if (!(strcmp($row_Recordset1['CompanyType'],"Private"))) {echo "checked=\"checked\"";} ?> <?php if ($_POST['company-type'] == "Private") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="Private" id="company-type_0" />
                Private</label>
                <label> &nbsp; 
                  &nbsp;
                  <input <?php if (!(strcmp($row_Recordset1['CompanyType'],"Public"))) {echo "checked=\"checked\"";} ?> <?php if ($_POST['company-type'] == "Public") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="Public" id="company-type_1" />
                  Public</label>
                <label> &nbsp; 
                  &nbsp;
                  <input <?php if (!(strcmp($row_Recordset1['CompanyType'],"State / Government"))) {echo "checked=\"checked\"";} ?> <?php if ($_POST['company-type'] == "State / Government") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="State / Government" id="company-type_2" />
                  State / Government</label>
                <?php 
								
								if(isset($error_11)){
										 
								echo $error_11; 
								
								}
								?></td>
            </tr>
            <tr>
              <td colspan="4" align="right" class="td-header"><div id="btn-padding">
                <input name="register" type="submit" class="btn-generic" id="register" value="Update" />
              </div></td>
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
mysqli_free_result($Recordset1);

mysqli_free_result($Recordset2);

mysqli_free_result($Recordset5);
?>
