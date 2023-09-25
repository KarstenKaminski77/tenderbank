<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

require_once('Connections/tender.php'); 

require_once('functions/functions.php');

select_db();

login($con);

$level = 1;

restrict_access($level,$con);

/**************************************************
**************** INSERT NEW ACCOUNT ***************
**************************************************/

if(isset($_POST['insert'])){
	
	// Set error messages
	
	if(empty($_POST['name'])){
		
		$error_1 = '<span class="error">Required Field</span>';
		
		}
		
		if(empty($_POST['surname'])){
			
			$error_2 = '<span class="error">Required Field</span>';
			
		}
		
		if(empty($_POST['email'])){
			
			$error_3 = '<span class="error">Required Field</span>';
			
		}
		
		if(empty($_POST['password'])){
			
			$error_4 = '<span class="error">Required Field</span>';
			
		}
		
		if(empty($_POST['access'])){
			
			$error_5 = '<span class="error">Required Field</span>';
			
		}
		
		// Verify required fields
		
		if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['access'])){
			
		// Send alert to guardians
		
		// Find the number of guardians
		
		$companyid = $_SESSION['companyid'];
		
		$query = mysql_query("SELECT SUM(Guardian) FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysql_error());
		$row = mysql_fetch_array($query);
		
		$no_guardians = $row['SUM(Guardian)'];
		
		$userid = $_SESSION['userid'];
		
		// Find the requestors name
		
		$query2 = mysql_query("SELECT * FROM tbl_users WHERE Id = '$userid'")or die(mysql_error());
		$row2 = mysql_fetch_array($query2);
		
		$requestor = $row2['Name'] .' '. $row2['Surname'];
		
		// Create the alert
		
		$date = date('Y-m-d');
		$characters = 6;
		generateCode($characters);
		$password = $_SESSION['password'];
		$type = "New user account created";
		$url = "edit-user-account-pending.php";
		
		mysql_query("INSERT INTO tbl_alerts (AlertType,Password,CompanyId,Requestor,Required,DateRequested,URL) VALUES ('$type','$password','$companyid','$requestor','$no_guardians','$date','$url')")or die(mysql_error());
		
		$query3 = mysql_query("SELECT * FROM tbl_alerts WHERE CompanyId = '$companyid' ORDER BY Id DESC LIMIT 1")or die(mysql_error());
		$row3 = mysql_fetch_array($query3);
		
		$alertid = $row3['Id'];
		
		$query4 = mysql_query("SELECT * FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysql_error());
		while($row4 = mysql_fetch_array($query4)){
			
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
    '. $requestor .' has created a new user account on Tender Bank.<br />
    <br />
    Please <a href="http://www.tenderbank.co.za/edit-details-pending.php?Id='.$alertid.'">Click here</a> to view the account and either approve or reject it. Please use the following reference code when prompted.
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
			 
			 $response = "The new user account will be processed once all guardians have authorised it.";

		}

		
		// Insert account details into temporary table to await verification by guardians
		
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		if(isset($_POST['guardian'])){
			
			$guardian = 1;
			
		} else {
			
			$guardian = 0;
			
		}
		
		mysql_query("INSERT INTO tbl_users_temp (Name,Surname,Username,Password,CompanyId,UserLevel,Guardian) VALUES ('$name','$surname','$email','$password','$companyid','2','$guardian')")or die(mysql_error());
		
		// Menu items allocated to user account
		
		$count = count($_POST['access']);
		
		$access = $_POST['access'];
		
		for($i=0;$i<$count;$i++){
			
			$menuid = $access[$i];
			
			mysql_query("INSERT INTO tbl_menu_relation_temp (AlertId,UserId,MenuId) VALUES ('$alertid','$userid','$menuid')")or die(mysql_error());
		}
		
	}
}

if(isset($_POST['update'])){
				
				if(empty($_POST['name'])){
					
					$error_1 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['surname'])){
					
					$error_2 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['email'])){
					
					$error_3 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['password'])){
					
					$error_4 = '<span class="error">Required Field</span>';
					
				}
				
				if(empty($_POST['access'])){
					
					$error_5 = '<span class="error">Required Field</span>';
					
				}
				
				if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['access'])){
					
					$userid = $_GET['Id'];
					
					$name = $_POST['name'];
					$surname = $_POST['surname'];
					$email = $_POST['email'];
					$password = $_POST['password'];
					
					if(isset($_POST['guardian'])){
						
						$guardian = 1;
						
					} else {
						
						$guardian = 0;
						
					}
					
					mysql_query("UPDATE tbl_users SET Name = '$name', Surname = '$surname', Username = '$email', Password = '$password', Guardian = '$guardian' WHERE Id = '$userid'")or die(mysql_error());
					
					mysql_query("DELETE FROM tbl_menu_relation WHERE UserId = '$userid'")or die(mysql_error());
					
					$count = count($_POST['access']);
					
					$access = $_POST['access'];
					
					for($i=0;$i<$count;$i++){
						
						$menuid = $access[$i];
						
						mysql_query("INSERT INTO tbl_menu_relation (UserId,MenuId) VALUES ('$userid','$menuid')")or die(mysql_error());
						
					}
				}
}

if(isset($_GET['delete'])){
	
	$id = $_GET['delete'];
	
	mysql_query("DELETE FROM tbl_users WHERE Id = '$id'")or die(mysql_error());
	mysql_query("DELETE FROM tbl_menu_relation WHERE UserId = '$id'")or die(mysql_error());
	
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

$alertid = $_GET['Id'];

mysql_select_db($database_tender, $tender);
$query_Recordset1 = "SELECT tbl_menu_relation_temp.AlertId, tbl_menu_relation_temp.UserId, tbl_menu_relation_temp.MenuId, tbl_menu_items.Name FROM (tbl_menu_relation_temp LEFT JOIN tbl_menu_items ON tbl_menu_items.Id=tbl_menu_relation_temp.MenuId) WHERE tbl_menu_relation_temp.AlertId = '$alertid' ";
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset3 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset3 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset3 = sprintf("SELECT * FROM tbl_users_temp WHERE AlertId = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $tender) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset2 = "-1";
if (isset($row_Recordset3['OldId'])) {
  $colname_Recordset2 = $row_Recordset3['OldId'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset2 = sprintf("SELECT * FROM tbl_users WHERE Id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

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

if($row_Recordset3['Name'] != $row_Recordset2['Name']){
	
	$style1 = ' style="color:#FF0000"';
	
} else {
	
	$style1 = '';
	
}

if($row_Recordset3['Surname'] != $row_Recordset2['Surname']){
	
	$style2 = ' style="color:#FF0000"';
	
} else {
	
	$style2 = '';
	
}

if($row_Recordset3['Username'] != $row_Recordset2['Username']){
	
	$style3 = ' style="color:#FF0000"';
	
} else {
	
	$style3 = '';
	
}

if($row_Recordset3['Password'] != $row_Recordset2['Password']){
	
	$style4 = ' style="color:#FF0000"';
	
} else {
	
	$style4 = '';
	
}

if($row_Recordset3['Address'] != $row_Recordset2['Address']){
	
	$style5 = ' style="color:#FF0000"';
	
} else {
	
	$style5 = '';
	
}

if($row_Recordset3['Guardian'] != $row_Recordset2['Guardian']){
	
	$style6 = ' style="color:#FF0000"';
	
} else {
	
	$style6 = '';
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tender Bank</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="Calendar.js"></script>
<script type="text/javascript" src="includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="includes/resources/calendar.js"></script>
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
</div>  <div id="container-generic">
    <form id="form1" name="form1" method="post" action="edit-user-account-code.php?Id=<?php echo $_GET['Id']; ?>">
      <table width="992" border="0" align="center" cellpadding="2" cellspacing="3">
        <tr>
          <td width="50%" valign="bottom" class="KT_field_error"><table border="0" cellspacing="0" cellpadding="0">
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
						} while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); 
						}
						?>
                </table>
              </div></td>
            </tr>
          </table>
          <?php if(isset($_SESSION['alert_error'])){ echo $_SESSION['alert_error']; } ?></td>
          <td width="50%" align="right"><span class="header"><?php echo $row_Recordset5['CompanyName']; ?><br />
            </span><br />
            <?php echo $row_Recordset5['Address']; ?><br />
            <?php echo $row_Recordset5['Suburb']; ?><br />
            <?php echo $row_Recordset5['City']; ?><br />
          <?php echo $row_Recordset5['Country']; ?></td>
        </tr>
      </table>
      <br />
      <div id="list-border">
        <table width="100%" border="0" cellpadding="2" cellspacing="3">
          <tr class="even">
            <td width="106"><strong>First Name:</strong></td>
            <td width="367"<?php echo $style1; ?>>&nbsp;<?php echo $row_Recordset3['Name']; ?></td>
            <td width="111"><strong>Last Name:</strong></td>
            <td width="367"<?php echo $style2; ?>>&nbsp;<?php echo $row_Recordset3['Surname']; ?></td>
          </tr>
          <tr class="odd">
            <td><strong>Email:</strong></td>
            <td<?php echo $style3; ?>>&nbsp;<?php echo $row_Recordset3['Username']; ?></td>
            <td><strong>Password:</strong></td>
            <td<?php echo $style4; ?>>&nbsp;<?php echo $row_Recordset3['Password']; ?></td>
          </tr>
          <tr class="even">
            <td><strong>&nbsp;Accessability:</strong></td>
            <td colspan="3"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <?php
  $i = 0;
  
  do { // horizontal looper version 3
  
  $level_id = $row_Recordset1['MenuId'];
  $userid = $row_Recordset1['UserId'];
  
  $query = mysql_query("SELECT * FROM tbl_menu_relation WHERE MenuId = '$level_id' AND UserId = '$userid'")or die(mysql_error());
  $row = mysql_fetch_array($query);
  $numrows = mysql_num_rows($query);
  
  if(!empty($row['MenuId'])){
	  
	  $oldmenu = $row['MenuId'];
	  
  } else {
	  
	  $oldmenu = '0';
	  
  }
  
  if($oldmenu != $level_id){
	  
	  $style = ' style="color: #FF0000"';
	  
  } else {
	  
	  $style = '';
	  
  }
  
  $i++;
  
?>
                <td><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td<?php echo $style; ?>><?php echo $row_Recordset1['Name']; if($i < $totalRows_Recordset1){ echo ','; } ?></td>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
                <?php
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    if (!isset($nested_Recordset1)) {
      $nested_Recordset1= 1;
    }
    if (isset($row_Recordset1) && is_array($row_Recordset1) && $nested_Recordset1++ % 4==0) {
      echo "</tr><tr>";
    }
  } while ($row_Recordset1); //end horizontal looper version 3
  
?>
              </tr>
            </table></td>
          </tr>
          <tr class="odd">
            <td><strong>&nbsp;Guardian</strong></td>
            <td colspan="3">
            <?php if($row_Recordset3['Guardian'] == '1'){
				
				echo 'Yes';
				
			} else {
				
				echo 'No';
				
			}
			?>
            </td>
          </tr>
          <tr>
            <td colspan="4" align="right" class="td-header"><table border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td><input name="approve" type="submit" class="btn-generic" id="approve" value="Authorise" /></td>
                <td><input name="reject" type="submit" class="btn-generic-red" id="reject" value="Decline" /></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </div>
    </form>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
