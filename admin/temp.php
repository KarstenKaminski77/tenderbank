<?php 
require_once('../Connections/tender.php'); 

require_once('../functions/functions.php');

select_db();

$level = 10;

restrict_access($level);

login();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tender Bank</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function clickclear(thisfield, defaulttext) {
if (thisfield.value == defaulttext) {
thisfield.value = "";
}
}

function clickrecall(thisfield, defaulttext) {
if (thisfield.value == "") {
thisfield.value = defaulttext;
}
}
</script>
</head>

<body>
<div id="top-bg"><img src="../images/top_01.jpg" width="594" height="100" /></div>
<div id="menu-container">
  <div id="menu-inner">
  <a href="../index.php" class="btn">Home</a>
  <a href="../about.php" class="btn">About Tender Bank</a>
  <?php if(!isset($_SESSION['userid'])){ ?>
  <a href="../register.php" class="btn">Register</a>
  <?php } ?>
  <a href="../terms.php" class="btn">Term & Conditions</a>
  <a href="../contact.php" class="btn">Contact Us</a>
  </div>
</div>
<div id="main"></div>
<div id="main2">
            <table width="1000" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top">
                  <div id="left-bar">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="27" colspan="2"><div id="top-bar"></div></td>
                      </tr>
                      <tr>
                        <td width="27">&nbsp;</td>
                        <td width="728" align="center">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div id="btm-bar">
                  </div>
                </td>
                <td width="245" align="right" valign="top"><?php include($_SERVER['DOCUMENT_ROOT'].'/menu.php'); ?></td>
              </tr>
  </table>
          </div>

<div id="footer"></div>
</body>

</html>