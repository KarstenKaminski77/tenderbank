<?php require_once('../Connections/tender.php'); ?>
<?php
require_once('../functions/functions.php');

$level = 10;

restrict_access($level);

login();

$list_rows = $_POST['row-count'];

if(!isset($_POST['nature-business']) || !isset($_POST['nature-business-new']) || !isset($_POST['insert'])){
	
	$list_rows = 1;
	
}

if(isset($_POST['nature-business-new'])){
	
	$list_rows = $_POST['row-count'] + 1;
	
	}

if(isset($_POST['insert'])){
	
	$nature_business = $_POST['nature-business'];
	
	$list_rows = $_POST['row-count'];
	
	for($i=0;$i<$list_rows;$i++){ 
		
		$nature_of_business = $nature_business[$i];
		
		mysql_query("INSERT INTO tbl_nature_business (Type) VALUES ('$nature_of_business')")or die(mysql_error());
		
	}
	
	header('Location: reset.php');
}

if(isset($_GET['Id']) && isset($_POST['nature-business'])){
	
	$nature_business = $_POST['nature-business'][0];
	$id = $_GET['Id'];
	
	mysql_query("UPDATE tbl_nature_business SET Type = '$nature_business' WHERE Id = '$id'")or die(mysql_error());
		
}

if(isset($_GET['delete'])){
	
		$id = $_GET['delete'];
		
		mysql_query("DELETE FROM tbl_nature_business WHERE Id = '$id'")or die(mysql_error());
		
}

if(isset($_POST['delete'])){
	
	$delete = $_POST['delete-box'];
	
	foreach($delete as $c){
		
		mysql_query("DELETE FROM tbl_nature_business WHERE Id = '$c'")or die(mysql_error());
		
	}
}

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

mysql_select_db($database_tender, $tender);
$query_Recordset1 = "SELECT * FROM tbl_nature_business";
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);$colname_Recordset1 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset1 = $_GET['Id'];
}
mysql_select_db($database_tender, $tender);
$query_Recordset1 = sprintf("SELECT * FROM tbl_nature_business WHERE Id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_tender, $tender);
$query_Recordset2 = "SELECT * FROM tbl_nature_business ORDER BY Type ASC";
$Recordset2 = mysql_query($query_Recordset2, $tender) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

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
                        <form id="form2" name="form2" method="post" action="">
                          <table border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td><div id="list-border">
                              <table width="450" border="0" cellpadding="2" cellspacing="3">
                            <tr class="even">
                              <td colspan="2" class="td-header">&nbsp;</td>
                              </tr>
                            <?php 
							
							$nature_of_business = $_POST['nature-business'];
							
							for($c=0;$c<$list_rows;$c++){ 
							
							$nature_business = $nature_of_business[$c]
							?>
                            <tr class="even">
                              <td align="center"><input name="nature-business[]" type="text" class="tarea-nature-business" id="nature-business[]" value="<?php if(isset($_GET['Id'])){ echo $row_Recordset1['Type']; } else { echo $nature_business; } ?>" />
                              <input name="nature_id" type="hidden" id="nature_id" value="<?php echo $row_Recordset1['Id']; ?>" />
                              <input type="hidden" name="row-count" id="row-count" value="<?php echo $list_rows; ?>" /></td>
                              <td width="20" align="center"><?php if($c == 0){ ?><input name="nature-business-new" type="submit" class="new-nature-business" id="nature-business-new" value="" /><?php } ?></td>
                            </tr>
                            <tr>
                            <?php }  ?>
                              <td colspan="2" align="right" class="td-header"><div id="btn-padding">
  <?php if(!isset($_GET['Id'])){ ?>
                                    <div id="bt-insert">
                                      <input name="insert" type="submit" class="btn-insert" id="insert" value="" />
                                  </div>
                                    <?php } ?>
                                      <?php if(isset($_GET['Id'])){ ?>
                                      <div id="bt-update">
                                      <input name="update" type="submit" class="btn-update" id="update" value="" />
                                      </div>
                                      <?php } ?>
</div></td>
                              </tr>
                          </table>
                              </div></td>
                            </tr>
                          </table>
                        </form>                    <br />
                    <form id="form1" name="form1" method="post" action="">
                        <table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><div id="list-border">
                              <table border="0" align="center" cellpadding="2" cellspacing="3">
                                <tr>
                                  <td width="20" class="td-header">&nbsp;</td>
                                  <td colspan="3" class="td-header">&nbsp;Nature of Business</td>
                                </tr>
                                <?php do { ?>
                                <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
                                  <td width="20"><input type="checkbox" name="delete-box[]" id="delete-box[]" value="<?php echo $row_Recordset2['Id']; ?>" /></td>
                                  <td width="300">&nbsp;<?php echo $row_Recordset2['Type']; ?></td>
                                  <td width="65"><a href="nature-business.php?delete=<?php echo $row_Recordset2['Id']; ?>"> <img src="../images/btn_delete.png" width="65" height="30" border="0" /> </a></td>
                                  <td width="65"><a href="nature-business.php?Id=<?php echo $row_Recordset2['Id']; ?>"> <img src="../images/btn-edit.png" width="65" height="30" border="0" /> </a></td>
                                </tr>
                                <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
                                <tr>
                                  <td colspan="4" align="right" class="td-header"><div id="btn-padding">
                                    <table border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td><input name="delete" type="submit" class="btn-delete" id="delete" value="" /></td>
                                        <td align="right"><a href="nature-business.php"><img src="../images/btn-add-new.png" width="104" height="30" border="0" /></a></td>
                                      </tr>
                                    </table>
                                    <a href="nature-business.php"></a></div></td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                        </table>
                    </form>
</td>
                      </tr>
                    </table>
                    <br />
                  </div>
                  <div id="btm-bar">
                  </div>
                </td>
                <td width="245" align="right" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="245" valign="top"><?php include($_SERVER['DOCUMENT_ROOT'].'/menu.php'); ?></tr>
                  </table></td>
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
