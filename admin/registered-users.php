<?php require_once('../Connections/tender.php'); ?>
<?php
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

$colname_Recordset1 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset1 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset1 = sprintf("SELECT * FROM tbl_registered_users WHERE UserId = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_tender, $tender);
$query_Recordset2 = "SELECT * FROM tbl_registered_users ORDER BY CompanyName ASC";
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<?php 
require_once('../Connections/tender.php'); 

require_once('../functions/functions.php');

select_db();

login();

$level = 10;

restrict_access($level);

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
                        <td width="728" align="center"><br />
                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><div id="list-border">
                              <table width="698" border="0" cellpadding="2" cellspacing="3">
                                <tr class="even">
                                  <td colspan="4" class="td-header">&nbsp;</td>
                                </tr>
                                <tr class="even">
                                  <td width="103">Company:</td>
                                  <td width="218" align="center" class="error"><input name="company" type="text" class="tarea2" id="company" value="<?php if(isset($_POST['company'])){ echo $_POST['company']; } ?>" />
                                    <?php
							
							if(isset($error_1)){
									 
							echo $error_1; 
							
							}
							?></td>
                                  <td width="127">Contact Person:</td>
                                  <td width="219" align="center" class="error"><input name="contact-person" type="text" class="tarea2" id="contact-person" value="<?php if(isset($_POST['contact-person'])){ echo $_POST['contact-person']; } ?>" />
                                    <?php 
							
							if(isset($error_2)){
									 
							echo $error_2; 
							
							}
							?></td>
                                </tr>
                                <tr class="odd">
                                  <td>Telephone:</td>
                                  <td align="center" class="error"><input name="telephone" type="text" class="tarea2" id="telephone" value="<?php if(isset($_POST['telephone'])){ echo $_POST['telephone']; } ?>" />
                                    <?php 
							
							if(isset($error_3)){
									 
							echo $error_3; 
							
							}
							?></td>
                                  <td>Email:</td>
                                  <td align="center" class="error"><input name="email" type="text" class="tarea2" id="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>" />
                                    <?php 
							
							if(isset($error_4)){
									 
							echo $error_4; 
							
							}
							?></td>
                                </tr>
                                <tr class="even">
                                  <td>Address:</td>
                                  <td align="center" class="error"><input name="address" type="text" class="tarea2" id="address" value="<?php if(isset($_POST['address'])){ echo $_POST['address']; } ?>" />
                                    <?php 
							
							if(isset($error_5)){
									 
							echo $error_5; 
							
							}
							?></td>
                                  <td>Suburb:</td>
                                  <td align="center" class="error"><input name="suburb" type="text" class="tarea2" id="suburb" value="<?php if(isset($_POST['suburb'])){ echo $_POST['suburb']; } ?>" />
                                    <?php 
							
							if(isset($error_6)){
									 
							echo $error_6; 
							
							}
							?></td>
                                </tr>
                                <tr class="odd">
                                  <td>City:</td>
                                  <td align="center" class="error"><input name="city" type="text" class="tarea2" id="city" value="<?php if(isset($_POST['city'])){ echo $_POST['city']; } ?>" />
                                    <?php 
							
							if(isset($error_7)){
									 
							echo $error_7; 
							
							}
							?></td>
                                  <td>Country:</td>
                                  <td align="center" class="error"><select name="country" class="tarea2" id="country">
                                    <option value="">Select one...</option>
                                    <?php
do {  
?>
                                    <option value="<?php echo $row_Recordset2['Country']?>"<?php if ($row_Recordset2['Country'] == $_POST['country']) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['Country']?></option>
                                    <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                                    </select>
                                    <?php 
							
							if(isset($error_8)){
									 
							echo $error_8; 
							
							}
							?></td>
                                </tr>
                                <tr class="even">
                                  <td>Company Reg No:</td>
                                  <td align="center" class="error"><input name="reg-no" type="text" class="tarea2" id="reg-no" value="<?php if(isset($_POST['reg-no'])){ echo $_POST['reg-no']; } ?>" />
                                    <?php 
							
							if(isset($error_9)){
									 
							echo $error_9; 
							
							}
							?></td>
                                  <td>Nature of Business:</td>
                                  <td align="center" class="error"><select name="nature-business" class="tarea2" id="nature-business">
                                    <option value="">Select one...</option>
                                    <?php
do {  
?>
                                    <option value="<?php echo $row_Recordset1['Type']?>"<?php if ($_POST['nature-business'] == $row_Recordset1['Type']) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['Type']?></option>
                                    <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                                    </select>
                                    <?php 
							
							if(isset($error_10)){
									 
							echo $error_10; 
							
							}
							?></td>
                                </tr>
                                <tr class="odd">
                                  <td>Company Type:</td>
                                  <td colspan="3">
                                    <label>
                                      <input <?php if ($_POST['company-type'] == "Private") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="Private" id="company-type_0" />
                                      Private</label>
                                    <label> &nbsp; 
                                      &nbsp;
                                      <input <?php if ($_POST['company-type'] == "Public") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="Public" id="company-type_1" />
                                      Public</label>
                                    <label> &nbsp; 
                                      &nbsp;
                                      <input <?php if ($_POST['company-type'] == "State / Government") {echo "checked=\"checked\"";} ?> type="radio" name="company-type" value="State / Government" id="company-type_2" />
                                      State / Government</label>
                                    <?php 
								
								if(isset($error_11)){
										 
								echo $error_11; 
								
								}
								?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="4" align="right" class="td-header">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                        </table>
                        <br />
                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>
<div id="list-border">
                          <table width="698" border="0" align="center" cellpadding="2" cellspacing="3">
                            <tr>
                              <td class="td-header">&nbsp;Company Name</td>
                              <td class="td-header">&nbsp;Contact Person</td>
                              <td class="td-header">&nbsp;Telephone</td>
                              <td colspan="2" class="td-header">&nbsp;</td>
                            </tr>
                            <?php do { ?>
                            <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
                              <td>&nbsp;<?php echo $row_Recordset2['CompanyName']; ?></td>
                              <td width="200">&nbsp;<?php echo $row_Recordset2['ContactPerson']; ?></td>
                              <td width="100">&nbsp<?php echo $row_Recordset2['Telephone']; ?></td>
                              <td width="65"><a href="nature-business.php?delete=<?php echo $row_Recordset2['Id']; ?>"></a><a href="nature-business.php?delete=<?php echo $row_Recordset2['Id']; ?>"></a>
                                <form id="form1" name="form1" method="post" action="nature-business.php?delete=<?php echo $row_Recordset2['Id']; ?>">
                                  <div id="btn-delete">
                                    <input name="delete" type="submit" class="btn-delete" id="delete" value="" />
                                  </div>
                                </form></td>
                              <td width="65"><form id="form3" name="form3" method="post" action="nature-business.php?Id=<?php echo $row_Recordset2['Id']; ?>">
                                <div id="btn-edit">
                                  <input name="edit" type="submit" class="btn-edit" id="edit" value="" />
                                </div>
                              </form></td>
                            </tr>
                              <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
                            <tr>
                              <td colspan="5" align="right" class="td-header">&nbsp;</td>
                          </table>
                        </div>                            </td>
                          </tr>
                        </table></td>
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
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
