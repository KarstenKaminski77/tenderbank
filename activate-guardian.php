<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once('functions/functions.php');

$con = mysqli_connect('dedi18b.your-server.co.za','tender','tender001','tender');

require_once('PHPMailer/PHPMailerAutoload.php');

login($con);

$userid = intval($_GET['Id']);

$query = mysqli_query($con, "SELECT * FROM tbl_users_temp WHERE Id = '$userid'")or die(mysqli_error($con));
$row = mysqli_fetch_assoc($query);
$numrows = mysqli_num_rows($query);

	$companyid = $row['CompanyId'];

// Check if user account exists in db

if($numrows == 1){
	
	$username = $row['Username'];
	$name = $row['Name'];
	$surname = $row['Surname'];
	$password = $row['Password'];
	$mobile = $row['Mobile'];
	
	mysqli_query($con, "INSERT INTO tbl_users (Username,Password,UserLevel,CompanyId,Name,Surname,Mobile,Guardian) VALUES ('$username','$password','1','$companyid','$name','$surname','$mobile','1')")or die(mysqli_error($con));
	
	// Get New User Id
	
	$query2 = mysqli_query($con, "SELECT * FROM tbl_users ORDER BY Id DESC LIMIT 1")or die(mysqli_error($con));
	$row2 = mysqli_fetch_array($query2);
	
	$id = $row2['Id'];
	
	$query3 = mysqli_query($con, "SELECT * FROM tbl_menu_items")or die(mysqli_error($con));
	while($row3 = mysqli_fetch_array($query3)){
		
		$menuid = $row3['Id'];
		mysqli_query($con, "INSERT INTO tbl_menu_relation (UserId,MenuId) VALUES ('$id','$menuid')")or die(mysqli_error($con));
	}
	
	// Clear The Database
	
	mysqli_query($con, "DELETE FROM tbl_users_temp WHERE Id = '$userid'")or die(mysqli_error($con));
	
	// Check That The Minimum Of 5 Guardians And Activate Account
	
	$query4 = mysqli_query($con, "SELECT * FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysqli_error($con));
	$guardians = mysqli_num_rows($query4);
	
	if($guardians >= 5){
		
		mysqli_query($con, "UPDATE tbl_registered_users SET Approved = '1' WHERE Id = '$companyid'")or die(mysqli_error($con));
	}
	
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
		<td><p>Good Day '.$name.'<br />
		  <br />
		  <br />
		Your account with Tender Bank has been successfully aproved.<br />
		<br />
		Please use the following username and associated password to   securely access the &quot;My Account&quot; Tab at <a href="http://www.tenderbank.co.za">http://www.tenderbank.co.za</a>.<br />
		<br />
		</p>
		  <table border="0" cellspacing="3" cellpadding="2" style="font-family:Arial; font-size:12px; color:002a76">
			<tr>
			  <td><strong>Username</strong></td>
			  <td>'.$username.'</td>
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
	$mail->addAddress($username, $name .' '. $surname);
	//Set the subject line
	$mail->Subject = $subject;
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML($message);
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

	header('Location: guardians-pending.php?Id='.$companyid);
}


?>
