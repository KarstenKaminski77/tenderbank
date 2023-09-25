<?php
session_start();

require_once('Connections/tender.php');

require_once('functions/functions.php');

$level = 1;

//restrict_access($level,$con);

login($con);

select_db();

$numrows = $numrows = count($_POST['id']);

// Add New Rows
$tenderid = $_GET['Id'];
$bidderid = $_COOKIE['bidder_id'];

if(isset($_POST['add-new'])){
		
	mysqli_query($con, "INSERT INTO tbl_tender_fields (TenderId,BidderId) VALUES ('$tenderid','$bidderid')")or die(mysqli_error($con));
	
	$numrows = count($_POST['id']) + 1;
	
}


$desc = $_POST['description'];
$quantity = $_POST['qty'];
$price = $_POST['price'];
$delete = $_POST['delete'];
$id = $_POST['id'];
$tenderid = $_GET['Id'];
$comments = addslashes($_POST['comments']);
$bidderid = $_COOKIE['bidder_id'];

if(isset($_POST['submit']) || isset($_POST['update']) || isset($_POST['delete']) || isset($_POST['add-new']) || isset($_POST['complete'])){
	
	mysqli_query($con, "UPDATE tbl_comments SET Comments = '$comments' WHERE TenderId = '$tenderid' AND BidderId = '$bidderid'")or die(mysqli_error($con));
	
	for($i=0;$i<$numrows;$i++){
		
		$description = $desc[$i];
	    $qty = $quantity[$i];
	    $price_1 = $price[$i];
	    $id_1 = $id[$i];
		$total = $price_1 * $qty;
		$datesubmitted = date('Y-m-d H:i:s');
		
		mysqli_query($con, "UPDATE tbl_tender_fields SET Description = '$description', Qty = '$qty', Price = '$price_1', Total = '$total', DateSubmitted = '$datesubmitted' WHERE Id = '$id_1'")or die(mysqli_error($con));
	}
}

if(isset($_POST['delete'])){
	
	foreach($delete as $c){
		
		$c = mysql_real_escape_string($c);
		
		mysqli_query($con, "DELETE FROM tbl_tender_fields WHERE Id = '$c'")or die(mysqli_error($con));
		
	}
}

if(isset($_POST['complete'])){
	
	mysqli_query($con, "UPDATE tbl_tender_fields SET Complete = '1' WHERE TenderId = '$tenderid'")or die(mysqli_error($con));
	
	header('Location: tender-submitted.php?Id='. $tenderid);
	
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['userid'])) {
  $colname_Recordset1 = intval($_SESSION['userid']);
}
$query_Recordset1 = "SELECT * FROM tbl_invitations_sent WHERE Id = '$colname_Recordset1'";
$Recordset1 = mysqli_query($con, $query_Recordset1) or die(mysqli_error($con));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$companyid = $row_Recordset1['CompanyId'];

$query_Recordset2 = "SELECT * FROM tbl_registered_users WHERE Id = '$companyid'";
$Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error($con));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset3 = intval($_GET['Id']);
}
$query_Recordset3 = "SELECT * FROM tbl_tenders WHERE Id = '$colname_Recordset3'";
$Recordset3 = mysqli_query($con, $query_Recordset3) or die(mysqli_error($con));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset4 = intval($_GET['Id']);
}
$colname2_Recordset4 = "-2";
if (isset($_COOKIE['bidder_id'])) {
  $colname2_Recordset4 = intval($_COOKIE['bidder_id']);
}
$query_Recordset4 = "SELECT * FROM tbl_tender_fields WHERE TenderId = '$colname_Recordset4' AND BidderId = '$colname2_Recordset4'";
$Recordset4 = mysqli_query($con, $query_Recordset4) or die(mysqli_error($con));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset5 = intval($_GET['Id']);
}
$colname2_Recordset5 = "0";
if (isset($_COOKIE['bidder_id'])) {
  $colname2_Recordset5 = intval($_COOKIE['bidder_id']);
}
$query_Recordset5 = "SELECT SUM(Total) FROM tbl_tender_fields WHERE TenderId = '$colname_Recordset5' AND BidderId = '$colname2_Recordset5'";
$Recordset5 = mysqli_query($con, $query_Recordset5) or die(mysqli_error($con));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);

$colname_Recordset6 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset6 = intval($_GET['Id']);
}
$colname2_Recordset6 = "-1";
if (isset($_COOKIE['bidder_id'])) {
  $colname2_Recordset6 = intval($_COOKIE['bidder_id']);
}
$query_Recordset6 = "SELECT * FROM tbl_comments WHERE TenderId = '$colname_Recordset6' AND BidderId = '$colname2_Recordset6'";
$Recordset6 = mysqli_query($con, $query_Recordset6) or die(mysqli_error($con));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);

if($totalRows_Recordset4 == 0){
	
	$tenderid = $_GET['Id'];
	
	$tenderid = $_GET['Id'];
	$bidderid = $_COOKIE['bidder_id'];
	
	mysqli_query($con, "INSERT INTO tbl_tender_fields (TenderId,BidderId) VALUES ('$tenderid','$bidderid')")or die(mysqli_error($con));
	
}

if($totalRows_Recordset6 == 0){
	
	$tenderid = $_GET['Id'];
	$bidderid = $_COOKIE['bidder_id'];
	
	mysqli_query($con, "INSERT INTO tbl_comments (TenderId,BidderId) VALUES ('$tenderid','$bidderid')")or die(mysqli_error($con));
	
}

$query_totals = mysqli_query($con, "SELECT SUM(Total) AS Total FROM tbl_tender_fields WHERE TenderId = '$tenderid' AND BidderId = '$bidderid' GROUP BY BidderId")or die(mysqli_error($con));
$row_totals = mysqli_fetch_array($query_totals);


		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tender Bank</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />

	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
      <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

      <!-- TinyMCE -->
	  <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
	  <script type="text/javascript">
      tinymce.init({
          mode : "specific_textareas",
          editor_selector : "mceEditor",
          theme: "modern",
		  menubar:false,
		  statusbar: false,
		  relative_urls:false,
		  autoresize_bottom_margin : 0, 
		  
		  skin: "tinymce-4-lightgray-no-fonts-skin",
		  
		  remove_script_host : false,
		  document_base_url : "http://www.tenderbank.co.za/",
		  
		  external_filemanager_path:"/js/filemanager/",
		  filemanager_title:"Responsive Filemanager" ,
		  external_plugins: { "filemanager" : "/js/filemanager/plugin.min.js"},
		  content_css: "http://www.tenderbank.co.za/css/tinymce.css",		  
		  fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
          plugins: [
              "textcolor lists link image responsivefilemanager autoresize",
          ],
		  autoresize_on_init: true,

          toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | forecolor fontsizeselect | | link image"
      });
	  
	  
	  </script>
      <!-- End TinyMCE -->
      
      <!-- Date Picker -->
      <link rel="stylesheet" media="all" type="text/css" href="jquery-ui.css" />
      <link rel="stylesheet" media="all" type="text/css" href="jquery-ui-timepicker-addon.css" />
      <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
      
      <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
      <script type="text/javascript" src="jquery-ui-timepicker-addon.js"></script>
      <script type="text/javascript" src="jquery-ui-sliderAccess.js"></script>
      <!-- End Date Picker -->

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
<div id="banner-lower"></div>
<div id="menu-ontainer-tenderer">
  <table width="982" border="0" align="center" cellpadding="2" cellspacing="3">
    <tr>
      <td colspan="2" valign="bottom" nowrap="nowrap" class="header"><?php echo $row_Recordset1['CompanyName']; ?></td>
      <td width="50%" align="right"><span class="header"><?php echo $row_Recordset2['CompanyName']; ?><br />
      </span></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" nowrap="nowrap"><?php echo $row_Recordset1['ContactPerson']; ?></td>
      <td width="50%" align="right"><?php echo $row_Recordset2['Address']; ?><br />
        <?php echo $row_Recordset2['Suburb']; ?><br />
        <?php echo $row_Recordset2['City']; ?><br />
        <?php echo $row_Recordset2['Country']; ?></td>
    </tr>
  </table>
</div>
<form action="tender-submit.php?Id=<?php echo $_GET['Id']; ?>#btm" method="post" enctype="multipart/form-data" name="form1" id="form1"post>
<div id="container-no-bg">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="list-border">
          <table width="100%" border="0" cellpadding="0" cellspacing="1">
            <tr>
              <td width="856" colspan="2" class="td-header">Procurement For</td>
              <td width="119" colspan="3" class="td-header">Closing Date</td>
              </tr>
            <tr>
              <td colspan="2" class="td-right">&nbsp;<?php echo $row_Recordset3['TenderName']; ?></td>
              <td colspan="3" class="td-right"><?php echo $row_Recordset3['ClosingDate']; ?></td>
              </tr>
            <tr>
              <td colspan="5" class="td-header">Description</td>
              </tr>
            <tr>
              <td colspan="5" class="td-right">
                <?php echo $row_Recordset3['Description']; ?>
              </td>
              </tr>
            <tr>
              <td colspan="5" class="td-header">Comments</td>
              </tr>
            <tr>
              <td colspan="5" class="td-right" style="padding:0">
                <textarea name="comments" class="tender-tarea mceEditor" id="comments"><?php echo $row_Recordset6['Comments']; ?></textarea>
              </td>
              </tr>
            <tr>
              <td class="td-header">Description</td>
              <td width="75" align="center" class="td-header">Qty</td>
              <td width="150" align="right" class="td-header">Price</td>
              <td width="150" align="right" class="td-header">Total</td>
              <td width="30" align="center" class="td-header" style="padding:0"><input name="add-new" type="submit" class="add-new-row" id="add-new" value="" /></td>
            </tr>
            
            <?php do{ ?>  
              
            <tr>
              <td class="td-right">
                <input name="description[]" type="text" class="tarea-100" id="description[]" value="<?php echo $row_Recordset4['Description']; ?>" placeholder="Description" />
              </td>
              <td class="td-right">
                <input name="qty[]" type="text" class="tarea-100" id="qty[]" value="<?php echo $row_Recordset4['Qty']; ?>" placeholder="0" style="text-align:center" />
              </td>
              <td class="td-right">
                <input name="price[]" type="text" class="tarea-100" id="price[]" value="<?php echo number_format($row_Recordset4['Price'],2); ?>" style="text-align:right" placeholder="0.00" />
              </td>
              <td class="td-right">
                <input name="total[]" type="text" class="tarea-100" id="total[]" value="<?php echo 'R'. number_format($row_Recordset4['Price'] * $row_Recordset4['Qty'],2); ?>" style="text-align:right" placeholder="0.00" readonly="readonly" />
              </td>
              <td align="center" class="td-right">
                <a name="btm" id="btm"></a>
                <input name="id[]" type="hidden" id="id[]" value="<?php echo $row_Recordset4['Id']; ?>" />
                <input name="delete[]" type="checkbox" id="delete[]" value="<?php echo $row_Recordset4['Id']; ?>" />
              </td>
              </tr>
              
              <?php } while ($row_Recordset4 = mysqli_fetch_array($Recordset4)); ?>
              
          </table>
        </div>
        
        
          
          <table width="247" border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td>
                <div id="list-border" style="overflow:hidden; margin-top:30px; margin-bottom:25px">
                
                  <table width="247" border="0" align="right" cellpadding="0" cellspacing="1">
                    <tr>
                      <td width="69" class="td-left">Sub Total</td>
                      <td width="122" align="right" class="td-right">R<?php echo number_format($row_totals['Total'],2); ?></td>
                    </tr>
                    <tr>
                      <td class="td-left">VAT</td>
                      <td align="right" class="td-right">R<?php echo number_format($row_totals['Total'] * 0.14,2); ?></td>
                    </tr>
                    <tr>
                      <td class="td-left">Total</td>
                      <td align="right" class="td-right">R<?php echo number_format(($row_totals['Total'] * 0.14) + $row_totals['Total'],2); ?></td>
                    </tr>
                  </table>
                
                </div>
              
              </td>
            </tr>
          </table>
        
        </td>
      </tr>
    </table>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="right"><div id="btn-padding">
            <table border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td width="120"><input name="submit" type="submit" class="btn-generic" id="submit" value="Save" /></td>
                <td width="120"><input name="complete" type="submit" class="btn-generic" id="complete" value="Submit Tender" /></td>
                </tr>
              </table>
            </div></td>
          </tr>
      </table>
    </td>
  </tr>
</table>
</div>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);
?>
