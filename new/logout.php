<?php
session_start();

require_once('functions/functions.php');

select_db();

    $userid = $_SESSION['userid'];
	$last_login = date('Y-m-d H:i');
	
	mysql_query("UPDATE tbl_users SET LastLogin = '$last_login' WHERE Id = '$userid'")or die(mysql_error());

session_destroy();

header('Location: index.php');
?>
