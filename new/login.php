<?php
require_once('functions/functions.php');

login();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
<div id="tab-top"></div>
<div id="container-centred">
  <div id="login-bg">
    <form id="form1" name="form1" method="post" action="">
    <div id="tfield-login">
      <input name="username" type="text" class="login-fields" />
    </div>
    <div id="tfield-login">
    <input name="password" type="text" class="login-fields" />
    </div>
    <input name="button" type="submit" class="btn-login" id="button" value="" />
    </form>
  </div>
</div>
<div id="tab-btm"></div>
<div id="gooter"></div>
</body>
</html>