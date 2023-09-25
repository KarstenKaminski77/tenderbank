<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_tender = "dedi18b.your-server.co.za";
$database_tender = "tender";
$username_tender = "tender";
$password_tender = "tender001";
$tender = mysql_connect($hostname_tender, $username_tender, $password_tender) or trigger_error(mysql_error(),E_USER_ERROR); 

$con = mysqli_connect('dedi18b.your-server.co.za','tender','tender001','tender');
?>