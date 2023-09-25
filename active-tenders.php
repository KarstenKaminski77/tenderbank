<?php require_once('Connections/tender.php'); ?>
<?php
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
 
session_start();

require_once('Connections/tender.php'); 

require_once('functions/functions.php');

login($con);

select_db();

if(isset($_POST['update']) && $_POST['description'] != NULL && $_POST['date'] != NULL && $_POST['subject'] != NULL){
	
	$tender = $_GET['Id'];
	$subject = $_POST['subject'];
	$description = addslashes($_POST['description']);
	$date = $_POST['date'];
	
	mysqli_query($con, "UPDATE tbl_tenders SET TenderName = '$subject', Description = '$description', ClosingDate = '$date' WHERE Id = '$tender'")or die(mysqli_error());
	
}

$colname_Recordset3 = "-1";
if (isset($_SESSION['companyid'])) {
  $colname_Recordset3 = $_SESSION['companyid'];
}
$query_Recordset3 = "SELECT * FROM tbl_registered_users WHERE Id = '$colname_Recordset3'";
$Recordset3 = mysqli_query($con, $query_Recordset3) or die(mysqli_error());
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_SESSION['userid'])) {
  $colname_Recordset4 = $_SESSION['userid'];
}
$query_Recordset4 = "SELECT * FROM tbl_users WHERE Id = '$colname_Recordset4'";
$Recordset4 = mysqli_query($con, $query_Recordset4) or die(mysqli_error());
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$colname_Recordset1 = "-1";
if (isset($_GET['Id'])) {
  $colname_Recordset1 = $_GET['Id'];
}
$query_Recordset1 = "SELECT * FROM tbl_tenders WHERE Id = '$colname_Recordset1'";
$Recordset1 = mysqli_query($con, $query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$userid = $_SESSION['companyid'];

$query_Recordset2 = "SELECT * FROM tbl_tenders WHERE UserId = '$userid' ORDER BY InvitationDate ASC";
$Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
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
    
    <div id="banner-lower">
      <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?></a> 
      <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?></a>
      <?php invitation_alerts($con); ?>
    </div>
    
    <div id="menu-container-2">
      <a href="active-tenders.php" class="tab-active">Active Tenders</a>
      <a href="rft.php" class="tab">Request For Tender</a>
      <a href="control.php" class="tab">Dashboard</a>
      <a href="#" class="tab-logout">Logout</a>
    </div>


  <div id="container-no-bg">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="2" cellspacing="3">
          <tr>
            <td width="50%">&nbsp;</td>
            <td width="50%" align="right"><span class="header"><?php echo $row_Recordset3['CompanyName']; ?><br />
              </span><br />
              <?php echo $row_Recordset3['Address']; ?><br />
              <?php echo $row_Recordset3['Suburb']; ?><br />
              <?php echo $row_Recordset3['City']; ?><br />
            <?php echo $row_Recordset3['Country']; ?></td>
          </tr>
        </table>
          <?php if(isset($_POST['edit']) || isset($_POST['update'])){ ?>
          <br />
          <form id="form1" name="form1" method="post" action="">
          
<div id="list-border">
          <table width="100%" border="0" cellpadding="0" cellspacing="1">
              <tr>
                <td class="td-header">&nbsp;Subject</td>
              </tr>
              <tr>
                <td align="center" class="td-right">
                  <input name="subject" type="text" class="tarea-100" id="subject" value="<?php echo $row_Recordset1['TenderName']; ?>" />
                </td>
              </tr>
              <tr>
                <td class="td-header">&nbsp;Description</td>
              </tr>
              <tr>
                <td align="center" class="td-right" style="padding:0"><textarea name="description" class="tarea-100 mceEditor" style="height:400px" id="description"><?php echo $row_Recordset1['Description']; ?></textarea></td>
              </tr>
              <tr>
                <td class="td-header">&nbsp;Closing Date</td>
              </tr>
              <tr>
                <td class="td-right">
                
                  <input name="date" class="tarea-100" id="date" value="<?php echo $row_Recordset1['ClosingDate']; ?>" />
                  
				  <script type="text/javascript">
                    $('#date').datepicker({
                    dateFormat: "yy-mm-dd"
                    });
                  </script>

                </td>
              </tr>
              <tr>
                <td align="right" style="padding:0"><input name="update" type="submit" class="btn-generic" id="update" value="Update" /></td>
              </tr>
          </table>
          </div>
          </form></td>
      </tr>
    </table>
    <?php } ?>
    <br />
    <?php if($totalRows_Recordset2 >= 1){ ?>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>
        <form id="form3" name="form3" method="post" action="active-tenders.php?Id=<?php echo $row_Recordset2['Id']; ?>">
<div id="list-border">
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td width="148" align="center" class="td-header">&nbsp;Tender No.</td>
              <td width="601" class="td-header">&nbsp;Subject</td>
              <td width="75" align="center" class="td-header">No. Sent</td>
              <td width="37" class="td-header">&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
              <td width="148" align="center">&nbsp;<?php echo $row_Recordset2['TenderNo']; ?></td>
              <td>&nbsp;<?php echo $row_Recordset2['TenderName']; ?></td>
              <td width="75" align="center"><?php echo $row_Recordset2['Invitations']; ?></td>
              <td><input name="edit" type="submit" class="btn-generic" id="edit" value="Edit" /></td>
            </tr>
            <?php } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2)); ?>
          </table>
        </div>
         </form>
        </td>
      </tr>
    </table>
    <?php } else { ?>
    <div align="center">You have no active tenders.</div>
    <?php } ?>
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset3);

mysqli_free_result($Recordset4);

mysqli_free_result($Recordset1);

mysqli_free_result($Recordset2);
?>
