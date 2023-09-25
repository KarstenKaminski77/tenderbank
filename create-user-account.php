<?php 
session_start();

require_once('Connections/tender.php'); 

require_once('functions/functions.php');

select_db();

login($con);

$level = 1;

restrict_access($level,$con);

if(isset($_POST['cancel'])){
	
	header('Location: create-user-account.php');
}

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
		$type = "New user account created";
		$url = "edit-user-account-pending.php";
		
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
		
		mysqli_query($con, "INSERT INTO tbl_users_temp (AlertId,Name,Surname,Username,Password,CompanyId,UserLevel,Guardian) VALUES ('$alertid','$name','$surname','$email','$password','$companyid','2','$guardian')")or die(mysqli_error($con));
		
		// Menu items allocated to user account
		
		$count = count($_POST['access']);
		
		$access = $_POST['access'];
		
		for($i=0;$i<$count;$i++){
			
			$menuid = $access[$i];
			
			mysqli_query($con, "INSERT INTO tbl_menu_relation_temp (AlertId,UserId,MenuId) VALUES ('$alertid','$userid','$menuid')")or die(mysqli_error($con));
		}
		
	}
}

/**************************************************
**************** UPDATE USER ACCOUNT **************
**************************************************/

if(isset($_POST['update'])){
	
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
		$type = "User account update";
		$url = "edit-user-account-pending.php";
		
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
    '. $requestor .' has updated a user account on Tender Bank.<br />
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
		
		$userid = $_GET['Id'];
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$oldid = $_GET['Id'];
		
		if(isset($_POST['guardian'])){
			
			$guardian = 1;
			
		} else {
			
			$guardian = 0;
			
		}
		
		mysqli_query($con, "INSERT INTO tbl_users_temp (AlertId,Name,Surname,Username,Password,Guardian,OldId) VALUES ('$alertid','$name','$surname','$email','$password','$guardian','$oldid')")or die(mysqli_error($con));

					
		$count = count($_POST['access']);
					
		$access = $_POST['access'];
					
		for($i=0;$i<$count;$i++){
			
			$menuid = $access[$i];
			
			mysqli_query($con, "INSERT INTO tbl_menu_relation_temp (AlertId,UserId,MenuId) VALUES ('$alertid','$userid','$menuid')")or die(mysqli_error($con));
		}
	}
}

/**************************************************
**************** DELETE USER ACCOUNT **************
**************************************************/

if(isset($_GET['delete'])){
	
	$id = $_GET['delete'];
	
	// Verify That There Are A Minimum Of 5 Guardian Accounts
	
	$query = mysqli_query($con, "SELECT * FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysqli_error($con));
	$numrows = mysqli_num_rows($query);
	
	if($numrows <= 5){
		
		$alert = 'A minimum of 5 guardians are required, please add another guardian before deleting this user account';
		
	} else {
	
	mysqli_query($con, "DELETE FROM tbl_users WHERE Id = '$id'")or die(mysqli_error($con));
	mysqli_query($con, "DELETE FROM tbl_menu_relation WHERE UserId = '$id'")or die(mysqli_error($con));
	
	}
	
}
	
$query_Recordset1 = "SELECT * FROM tbl_menu_items ORDER BY Name ASC";
$Recordset1 = mysqli_query($con, $query_Recordset1) or die(mysqli_error($con));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_SESSION['companyid'])) {
  $colname_Recordset2 = $_SESSION['companyid'];
}
$query_Recordset2 = "SELECT * FROM tbl_users WHERE CompanyId = '$colname_Recordset2'";
$Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error($con));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset3 = $_GET['Id'];
}
$query_Recordset3 = "SELECT * FROM tbl_users WHERE Id = '$colname_Recordset3'";
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

if(isset($_GET['Id'])){
	
	$value_1 = $row_Recordset3['Name'];
	$value_2 = $row_Recordset3['Surname'];
	$value_3 = $row_Recordset3['Username'];
	$value_4 = $row_Recordset3['Password'];
	$value_5 = $row_Recordset3['Guardian'];
	
} else {
	
	$value_1 = '';
	$value_2 = '';
	$value_3 = '';
	$value_4 = '';
	$value_5 = '';

}
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
    <a href="logout.php" class="menu-2">
      <img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?>
    </a> 
    <a href="logout.php" class="menu-3">
      Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?>
    </a>
    
  <?php invitation_alerts($con); ?>
  </div>

<div id="menu-container-2">
    <a href="active-tenders.php" class="tab">Active Tenders</a>
    <a href="rft.php" class="tab">Request For Tender</a>
    <a href="control.php" class="tab">Dashboard</a>
    <a href="#" class="tab-logout">Logout</a>
  </div>

  <div id="container-no-bg">
    <form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0" align="center" cellpadding="2" cellspacing="3">
        <tr>
          <td width="50%" valign="bottom" class="KT_field_error">
		  <?php 
		  if(isset($_SESSION['alert_error'])){
			  
			  echo $_SESSION['alert_error']; 
		  }
		  
		  if(isset($alert)){
			  
			  echo $alert; 
		  }
		  
		  ?>
          </td>
          <td width="50%" align="right"><span class="header"><?php echo $row_Recordset5['CompanyName']; ?><br />
            </span><br />
            <?php echo $row_Recordset5['Address']; ?><br />
            <?php echo $row_Recordset5['Suburb']; ?><br />
            <?php echo $row_Recordset5['City']; ?><br />
            <?php echo $row_Recordset5['Country']; ?></td>
        </tr>
      </table>
      <br />
      
      <?php
	  
	    if(isset($_GET['Id'])){
			
			$mode = 'Edit';
			
		} else {
			
			$mode = 'Create New';
		}
	  
	  ?>
      
      <div id="list-border2">
        <table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td colspan="4" class="td-header"><?php echo $mode; ?> User Account</td>
          </tr>
          <tr class="even">
            <td width="106" class="td-left">First Name:</td>
            <td width="367" class="td-right">
              <input name="name" type="text" class="tarea-100" id="name" value="<?php echo $value_1; ?>" />
              <?php
							
							if(isset($error_1)){
									 
							echo $error_1; 
							
							}
							?></td>
            <td width="111" class="td-left">Last Name:</td>
            <td width="367" class="td-right">
              <input name="surname" type="text" class="tarea-100" id="surname" value="<?php echo $value_2; ?>" />
              <?php 
							
							if(isset($error_2)){
									 
							echo $error_2; 
							
							}
							?></td>
          </tr>
          <tr class="odd">
            <td class="td-left">Email:</td>
            <td class="td-right">
              <input name="email" type="text" class="tarea-100" id="email" value="<?php echo $value_3; ?>" />
              <?php 
							
							if(isset($error_3)){
									 
							echo $error_3; 
							
							}
							?></td>
            <td class="td-left">Password:</td>
            <td class="td-right">
              <input name="password" type="text" class="tarea-100" id="password" value="<?php echo $value_4; ?>" />
              <?php 
							
							if(isset($error_4)){
									 
							echo $error_4; 
							
							}
							?></td>
          </tr>
          <tr>
            <td class="td-left">Accessability:</td>
            <td colspan="3" class="td-right"><table border="0">
              <tr>
                <?php
  $i = 0;
  
  do { // horizontal looper version 3
  
  $level_id = $row_Recordset1['Id'];
  $userid = $_GET['Id'];
  
  $query = mysqli_query($con, "SELECT * FROM tbl_menu_relation WHERE MenuId = '$level_id' AND UserId = '$userid'")or die(mysqli_error($con));
  $numrows = mysqli_num_rows($query);
  
  $i++;
  
?>
                <td><table border="0" cellspacing="3" cellpadding="2">
                  <tr>
                    <td><input name="access[]" type="checkbox" id="access[<?php echo $i; ?>]" value="<?php echo $row_Recordset1['Id']; ?>" <?php if($numrows >= 1){ echo 'checked="checked"'; } ?> />
                      &nbsp;
                      <label for="access[<?php echo $i; ?>]"><?php echo $row_Recordset1['Name']; ?></label></td>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
                <?php
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
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
          <tr>
            <td class="td-left">&nbsp;Guardian</td>
            <td colspan="3" class="td-right">&nbsp;
            <input name="guardian" type="checkbox" id="guardian" value="1" <?php if($row_Recordset3['Guardian'] == 1){ echo 'checked="checked"'; } ?> /></td>
          </tr>
          <tr>
            <td colspan="4" align="right">
            
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="50%">
                  
					<?php if(isset($_GET['Id'])){ ?>
                    <input name="update" type="submit" class="btn-generic" id="update" value="Update" />
                    <?php } else { ?>
                    <input name="insert" type="submit" class="btn-generic" id="insert" value="Insert" />
                    <?php } ?>
                  
                </td>
                  <td width="50%">
                
                    <input name="cancel" type="submit" class="btn-generic-red" id="cancel" value="Cancel" />
                
                  </td>
                </tr>
              </table>

            </td>
          </tr>
        </table>
      </div>
    </form>
    <br />
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="list-border">
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td width="208" class="td-header">First Name</td>
              <td class="td-header">&nbsp;Surname</td>
              <td class="td-header">Email</td>
              <td class="td-header">&nbsp;Password</td>
              <td colspan="2" class="td-header">&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='over';" onmouseout="this.className = this.oldClassName;">
              <td>&nbsp;<?php echo $row_Recordset2['Name']; ?></td>
              <td width="205">&nbsp;<?php echo $row_Recordset2['Surname']; ?></td>
              <td width="231">&nbsp;<?php echo $row_Recordset2['Username']; ?></td>
              <td width="220">&nbsp;<?php echo $row_Recordset2['Password']; ?></td>
              <td width="52">
              
				<?php 
				
				if($row_Recordset2['UserLevel'] == 2){
					
					$disabled = '';
					
				} else {
					
					$disabled = 'disabled="disabled"';
				}
				
				?>
                  <form id="form2" name="form2" method="post" action="create-user-account.php?delete=<?php echo $row_Recordset2['Id']; ?>">
                    <input name="button" type="submit" class="btn-generic-red" id="button" value="Delete" <?php echo $disabled; ?> />
                  </form>
              
              </td>
              <td width="37"><form id="form3" name="form3" method="post" action="create-user-account.php?Id=<?php echo $row_Recordset2['Id']; ?>">
                <input name="button2" type="submit" class="btn-generic" id="button2" value="Edit" />
              </form>
              </td>
            </tr>
            <?php } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2)); ?>
          </table>
        </div></td>
      </tr>
    </table>
</div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);

mysqli_free_result($Recordset2);

mysqli_free_result($Recordset5);
?>
