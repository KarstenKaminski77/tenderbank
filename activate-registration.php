<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('functions/functions.php');

login($con);

select_db();

$userid = $_GET['Id'];

$query = mysql_query("SELECT * FROM tbl_registered_users WHERE Id = '$userid'")or die(mysql_error());
$row = mysql_fetch_array($query);

$username = $row['Email'];
$name = $row['ContactPerson'];
$companyid = $row['Id'];

$possible = '23456789bcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
$password = '';
$i = 0;
while ($i <= 6) {
	
	$password .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
	$i++;
	}
	
mysql_query("INSERT INTO tbl_users (Username,Password,UserLevel,CompanyId) VALUES ('$username','$password','1','$companyid')")or die(mysql_error());

$query2 = mysql_query("SELECT * FROM tbl_users ORDER BY Id DESC LIMIT 1")or die(mysql_error());
$row2 = mysql_fetch_array($query2);

$id = $row2['Id'];

mysql_query("UPDATE tbl_registered_users SET Approved = '1', UserId = '$id' WHERE Id = '$userid'")or die(mysql_error());

$query3 = mysql_query("SELECT * FROM tbl_menu_items")or die(mysql_error());
while($row3 = mysql_fetch_array($query3)){
	
	$menuid = $row3['Id'];
	
	mysql_query("INSERT INTO tbl_menu_relation (UserId,MenuId) VALUES ('$id','$menuid')")or die(mysql_error());
	
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
    <td><p>Hi '.$name.'<br />
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

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'FROM: test@kwd.co.za' . "\r\n";
$headers .= 'Cc: nicky@seavest.co.za' . "\r\n";

mail($username, $subject, $message, $headers);

header('Location: admin/registered-users.php?Id='. $_GET['Id']);
?>
