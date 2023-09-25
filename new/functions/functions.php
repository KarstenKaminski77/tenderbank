<?php
session_start();

function select_db(){
	
	mysql_connect('dedi18b.your-server.co.za','tender','tender001')or die(mysql_error());
    mysql_select_db('tender')or die(mysql_error());
	
}

function login(){
	
	select_db();
	
	if(isset($_POST['username'])){
		
		$username = $_POST['username'];
		$password = $_POST['password'];

$query = mysql_query("SELECT * FROM tbl_users WHERE Username = '$username' AND Password = '$password'")or die(mysql_error());
$row = mysql_fetch_array($query);
$numrows = mysql_num_rows($query);

if($numrows == 1){
		
	$_SESSION['userid'] = $row['Id'];
	$_SESSION['userlevel'] = $row['UserLevel'];
	$_SESSION['companyid'] = $row['CompanyId'];
	$last_login = date('Y-m-d H:i:s');
	
	$userid = $_SESSION['userid'];
	
	mysql_query("UPDATE tbl_users SET LastLogin = '$last_login' WHERE Id = '$userid'")or die(mysql_error());
	
	if($_SESSION['userlevel'] == 10){
		
		header('Location: admin.php');
		
	} else {
		
		header('Location: control.php?welcome');
		
	}
	
	} else {

$query1 = mysql_query("SELECT * FROM tbl_users WHERE Username = '$username'")or die(mysql_error());
$numrows1 = mysql_num_rows($query1);

if($numrows1 == 0){
	
	$string1 = 'username';
}

$query = mysql_query("SELECT * FROM tbl_users WHERE Password = '$password'")or die(mysql_error());
$numrows = mysql_num_rows($query);

if($numrows == 0){
	
	$string2 = '&password';
}
header('Location: '.$_SERVER['HTTP_REFERER'].'?'.$string1.$string2);
}}}

function validate_username(){
	
	if(isset($_GET['username'])){
		
		echo "<br><span class=\"error\">Invalid Username</span>";
}}

function validate_password(){
	
	if(isset($_GET['password'])){
		
		echo "<br><span class=\"error\">Invalid Password</span>";
}}

function restrict_access($level){
	
	select_db();
	
	$userid = $_SESSION['userid'];
	
	$query = mysql_query("SELECT * FROM tbl_users WHERE Id = '$userid'")or die(mysql_error());
	$row = mysql_fetch_array($query);
	
	$userlevel = $row['UserLevel'];
		
		if(!isset($_SESSION['userid']) || ($userlevel < $level)){
							
							header('Location: '.$_SERVER['HOST'].'/login.php');
							
							}
}

function last_logout(){
	
	select_db();
	
	$userid = $_SESSION['userid'];
	
	$query = mysql_query("SELECT * FROM tbl_users WHERE Id = '$userid'")or die(mysql_error());
	$row = mysql_fetch_array($query);
	
	$last_login = explode(" ",$row['LastLogin']);
	
	$date = $last_login[0];
	$time = $last_login[1];
	
	echo 'Date: '. $date .'<br>Time: '. $time;
	
}

?>