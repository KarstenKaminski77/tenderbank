<?php
session_start();

$con = mysqli_connect('dedi18b.your-server.co.za','tender','tender001','tender');

function select_db(){
	
	mysql_connect('dedi18b.your-server.co.za','tender','tender001')or die(mysql_error());
	mysql_select_db('tender')or die(mysql_error());
}
  
  function login($con){
	  
	  select_db();
	  
	  if(isset($_POST['username'])){
		  
		  $username = $_POST['username'];
		  $password = $_POST['password'];
		  
		  $query = mysqli_query($con, "SELECT * FROM tbl_users WHERE Username = '$username' AND Password = '$password'")or die(mysqli_error($con));
		  $row = mysqli_fetch_array($query);
		  $numrows = mysqli_num_rows($query);
		  
		  $companyid = $row['CompanyId'];
		  
		  $query2 = mysqli_query($con, "SELECT * FROM tbl_users WHERE CompanyId = '$companyid'")or die(mysqli_error($con));
		  $numrows2 = mysqli_num_rows($query2);
		  
			  
		  if($numrows2 < 5){ 
			  
			  header('Location: guardians-pending.php?Id='.$companyid);
		  
		  } else {
			  
			  if($numrows >= 1){
				  
				  $_SESSION['userid'] = $row['Id'];
				  $_SESSION['userlevel'] = $row['UserLevel'];
				  $_SESSION['companyid'] = $row['CompanyId'];
										  
				  $last_login = date('Y-m-d H:i:s');
				  $userid = $_SESSION['userid'];
					  
				  mysqli_query($con, "UPDATE tbl_users SET LastLogin = '$last_login' WHERE Id = '$userid'")or die(mysqli_error($con));
					  
				  if($_SESSION['userlevel'] == 10){
						  
					  header('Location: admin.php');
			  
				  } else {
						  
					  // Accept terms & conditions
						  
					  if(isset($_COOKIE['terms'])){
							  
						  header('Location: control.php');
							  
					  } else {
							  
						  header('Location: accept-terms.php');
							  
					  }
					  
				  }
				  
			  } else {
				  
				  $query1 = mysqli_query($con, "SELECT * FROM tbl_users WHERE Username = '$username'")or die(mysqli_error($con));
				  $numrows1 = mysqli_num_rows($query1);
				  
				  if($numrows1 == 0){
					  
					  $string1 = 'username';
				  }
				  
				  $query = mysqli_query($con, "SELECT * FROM tbl_users WHERE Password = '$password'")or die(mysqli_error($con));
				  $numrows = mysqli_num_rows($query);
				  
				  if($numrows == 0){
					  
					  $string2 = '&password';
				  }
				  
				  header('Location: '.$_SERVER['HTTP_REFERER'].'?'.$string1.$string2);
			  }
		  }
	  }
  }
  
  function validate_username(){
	  
	  if(isset($_GET['username'])){
		  
		  echo "<br><span class=\"error\">Invalid Username</span>";
  }}
  
  function validate_password(){
	  
	  if(isset($_GET['password'])){
		  
		  echo "<br><span class=\"error\">Invalid Password</span>";
  }}
  
  function restrict_access($level,$con){
	  
	  select_db();
	  
	  $userid = $_SESSION['userid'];
	  
	  $query = mysqli_query($con, "SELECT * FROM tbl_users WHERE Id = '$userid'")or die(mysqli_error($con));
	  $row = mysqli_fetch_array($query);
	  
	  $userlevel = $row['UserLevel'];
		  
		  if(!isset($_SESSION['userid']) || ($userlevel < $level)){
							  
							  header('Location: '.$_SERVER['HOST'].'/login.php');
							  
							  }
  }
  
  function last_logout($con){
	  
	  select_db();
	  
	  $userid = $_SESSION['userid'];
	  
	  $query = mysqli_query($con, "SELECT * FROM tbl_users WHERE Id = '$userid'")or die(mysqli_error($con));
	  $row = mysqli_fetch_array($query);
	  
	  $last_login = explode(" ",$row['LastLogin']);
	  
	  $date = $last_login[0];
	  $time = $last_login[1];
	  
	  echo 'Date: '. $date .'<br>Time: '. $time;
	  
  }
  
  function count_invitations($industry_type,$con){
	  
	  $companyid = $_SESSION['companyid'];
	  
	  $query = mysqli_query($con, "SELECT * FROM tbl_invitation_list WHERE CompanyId = '$companyid' AND IndustryType = '$industry_type'")or die(mysqli_error($con));
	  $numrows = mysqli_num_rows($query);
	  
	  echo $numrows;
  }
  
  function count_invitations_temp($alertid,$con){
	  
	  $query = mysqli_query($con, "SELECT * FROM tbl_invitation_list_temp WHERE AlertId = '$alertid'")or die(mysqli_error($con));
	  $numrows = mysqli_num_rows($query);
	  
	  echo $numrows;
  }
  
  function invitation_alerts($con){
	  
	  $userid = $_SESSION['userid'];
	  $companyid = $_SESSION['companyid'];
	  
	  $query = mysqli_query($con, "SELECT * FROM tbl_users WHERE Id = '$userid' AND Guardian = '1'")or die(mysqli_error($con));
	  $numrows = mysqli_num_rows($query);
	  
	  if($numrows >= 1){
		  
		  $query2 = mysqli_query($con, "SELECT * FROM tbl_alerts WHERE CompanyId = '$companyid'")or die(mysqli_error($con));
		  $numrows2 = mysqli_num_rows($query2);
		  
		  $query3 = mysqli_query($con, "SELECT * FROM tbl_alert_responses WHERE UserId = '$userid'")or die(mysqli_error($con));
		  $numrows3 = mysqli_num_rows($query3);
		  
		  $alerts = $numrows2 - $numrows3;
		  
		  if($alerts >= 1){
			  
			  echo '<a href="http://www.tenderbank.co.za/pending-alerts.php" class="inv-alert">'. $alerts .' Alerts!</a>';
		  }
	  }
  }
  
  function generateCode($characters){
	  
	  $possible = '23456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMOPRSTUVWQYZ'; 
	  $code = '';
	  $i = 0;
	  
	  while ($i < $characters) { 
	  
		  $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
		  $i++;
	  }
		  $_SESSION['password'] = $code;
  }
  
  function invitation_icon($userid,$alertid,$con){
	  
	  $query = mysqli_query($con, "SELECT * FROM tbl_alert_responses WHERE UserId = '$userid' AND AlertId = '$alertid'")or die(mysqli_error($con));
	  $row = mysqli_fetch_array($query);
	  
	  $response = $row['Response'];
	  
	  if($response == '1'){
		  
		  echo '<img src="images/icon-accept.png" width="15" height="15" />';
		  
	  } elseif($response == '0'){
		  
		  echo '<img src="images/icon-decline.png" width="15" height="15" />';
		  
	  } else {
		  
		  echo '<img src="images/icon-pending.png" width="17" height="15" />';
		  
	  }
  }
	  
  
  ?>