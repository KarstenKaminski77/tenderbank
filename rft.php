<?php require_once('Connections/tender.php'); ?>
<?php
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
 
session_start();

require_once('Connections/tender.php');

require_once('functions/functions.php');

$colname_Recordset1 = "-1";
if (isset($_SESSION['userid'])) {
  $colname_Recordset1 = $_SESSION['userid'];
}

$query_Recordset1 = "SELECT * FROM tbl_users WHERE Id = '$colname_Recordset1'";
$Recordset1 = mysqli_query($con, $query_Recordset1) or die(mysqli_error($con));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if(isset($_SESSION['companyid'])){
  $colname_Recordset2 = $_SESSION['companyid'];
}

$query_Recordset2 = "SELECT * FROM tbl_registered_users WHERE Id = '$colname_Recordset2'";
$Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error($con));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$companyid = $_SESSION['companyid'];


$query_Recordset3 = "SELECT tbl_invitation_list.CompanyName, tbl_invitation_list.ContactPerson, tbl_invitation_list.Email, tbl_industries.Industry, tbl_users.Name, tbl_users.Surname, tbl_invitation_list.DateModified, tbl_invitation_list.IndustryType, tbl_invitation_list.CompanyId FROM ((tbl_invitation_list LEFT JOIN tbl_industries ON tbl_industries.Id=tbl_invitation_list.IndustryType) LEFT JOIN tbl_users ON tbl_users.Id=tbl_invitation_list.ModifiedBy) WHERE tbl_invitation_list.CompanyId = '$companyid' GROUP BY tbl_invitation_list.IndustryType";
$Recordset3 = mysqli_query($con, $query_Recordset3) or die(mysqli_error($con));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$level = 1;

//restrict_access($level,$con);

login($con);

select_db();	
	
function required_field($field){
	
	if(isset($_POST['submit'])){
		
		if(empty($field)){
			
			echo '<span class="error">Required Field</span>';
			
		}
	}
}
	
	if(!empty($_POST['subject']) && !empty($_POST['date']) && !empty($_POST['invitation-list']) && !empty($_POST['description'])){
		
		$query = mysqli_query($con, "SELECT * FROM tbl_ref_no ORDER BY Id DESC LIMIT 1")or die(mysqli_error());
		$row = mysqli_fetch_array($query);
		
		$tenderno = $row['Id'] + 1;
		
		mysqli_query($con, "INSERT INTO tbl_ref_no (Ref) VALUES ('$refno')")or die(mysqli_error());
		
		$userid = $_SESSION['companyid'];
		$subject = $_POST['subject'];
		$description = addslashes($_POST['description']);
		$start = date('Y-m-d');
		$end = $_POST['date'];
		$invitation_type = $_POST['invitation-list'];
		
		$query3 = mysqli_query($con, "SELECT * FROM tbl_invitation_list WHERE CompanyId = '$userid' AND IndustryType = '$invitation_type'")or die(mysqli_error());
		$numrows = mysqli_num_rows($query3);
		
		mysqli_query($con, "INSERT INTO tbl_tenders (UserId,TenderNo,TenderName,Description,InvitationDate,ClosingDate,InvitationType,Invitations) 
		VALUES ('$userid','$tenderno','$subject','$description','$start','$end','$invitation_type','$numrows')")or die(mysqli_error());	
		
		$query2 = mysqli_query($con, "SELECT * FROM tbl_tenders ORDER BY Id DESC LIMIT 1")or die(mysqli_error());
		$row2 = mysqli_fetch_array($query2);
				
		$tender_id = $row2['Id'];
			
		header('Location: tender-send.php?Id='. $tender_id.'&Type='.$invitation_type);
	
	}
	
		
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

<script type="text/javascript">
/************************************************************************************************************
(C) www.dhtmlgoodies.com, November 2005

This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.

Terms of use:
You are free to use this script as long as the copyright message is kept intact. However, you may not
redistribute, sell or repost it without our permission.

Thank you!

www.dhtmlgoodies.com
Alf Magne Kalleland

************************************************************************************************************/

var dhtmlgoodies_slideSpeed = 10;	// Higher value = faster
var dhtmlgoodies_timer = 10;	// Lower value = faster

var objectIdToSlideDown = false;
var dhtmlgoodies_activeId = false;
var dhtmlgoodies_slideInProgress = false;
var dhtmlgoodies_expandMultiple = false;

function showHideContent(e,inputId)
{
	if(dhtmlgoodies_slideInProgress)return;
	dhtmlgoodies_slideInProgress = true;
	if(!inputId)inputId = this.id;
	inputId = inputId + '';
	var numericId = inputId.replace(/[^0-9]/g,'');
	var answerDiv = document.getElementById('dhtmlgoodies_a' + numericId);

	objectIdToSlideDown = false;

	if(!answerDiv.style.display || answerDiv.style.display=='none'){
		if(dhtmlgoodies_activeId &&  dhtmlgoodies_activeId!=numericId && !dhtmlgoodies_expandMultiple){
			objectIdToSlideDown = numericId;
			slideContent(dhtmlgoodies_activeId,(dhtmlgoodies_slideSpeed*-1));
		}else{

			answerDiv.style.display='block';
			answerDiv.style.visibility = 'visible';

			slideContent(numericId,dhtmlgoodies_slideSpeed);
		}
	}else{
		slideContent(numericId,(dhtmlgoodies_slideSpeed*-1));
		dhtmlgoodies_activeId = false;
	}
}

function slideContent(inputId,direction)
{

	var obj =document.getElementById('dhtmlgoodies_a' + inputId);
	var contentObj = document.getElementById('dhtmlgoodies_ac' + inputId);
	height = obj.clientHeight;
	if(height==0)height = obj.offsetHeight;
	height = height + direction;
	rerunFunction = true;
	if(height>contentObj.offsetHeight){
		height = contentObj.offsetHeight;
		rerunFunction = false;
	}
	if(height<=1){
		height = 1;
		rerunFunction = false;
	}

	obj.style.height = height + 'px';
	var topPos = height - contentObj.offsetHeight;
	if(topPos>0)topPos=0;
	contentObj.style.top = topPos + 'px';
	if(rerunFunction){
		setTimeout('slideContent(' + inputId + ',' + direction + ')',dhtmlgoodies_timer);
	}else{
		if(height<=1){
			obj.style.display='none';
			if(objectIdToSlideDown && objectIdToSlideDown!=inputId){
				document.getElementById('dhtmlgoodies_a' + objectIdToSlideDown).style.display='block';
				document.getElementById('dhtmlgoodies_a' + objectIdToSlideDown).style.visibility='visible';
				slideContent(objectIdToSlideDown,dhtmlgoodies_slideSpeed);
			}else{
				dhtmlgoodies_slideInProgress = false;
			}
		}else{
			dhtmlgoodies_activeId = inputId;
			dhtmlgoodies_slideInProgress = false;
		}
	}
}



function initShowHideDivs()
{
	var divs = document.getElementsByTagName('DIV');
	var divCounter = 1;
	for(var no=0;no<divs.length;no++){
		if(divs[no].className=='dhtmlgoodies_question'){
			divs[no].onclick = showHideContent;
			divs[no].id = 'dhtmlgoodies_q'+divCounter;
			var answer = divs[no].nextSibling;
			while(answer && answer.tagName!='DIV'){
				answer = answer.nextSibling;
			}
			answer.id = 'dhtmlgoodies_a'+divCounter;
			contentDiv = answer.getElementsByTagName('DIV')[0];
			contentDiv.style.top = 0 - contentDiv.offsetHeight + 'px';
			contentDiv.className='dhtmlgoodies_answer_content';
			contentDiv.id = 'dhtmlgoodies_ac' + divCounter;
			answer.style.display='none';
			answer.style.height='1px';
			divCounter++;
		}
	}
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>

</head>

<body onload="MM_preloadImages('images/menu-1.png','images/menu-2.png','images/menu-3.png')">
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
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset1['Name']; ?> <?php echo $row_Recordset1['Surname']; ?></a> 
  <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset1['LastLogin'])); ?></a>
  <?php invitation_alerts($con); ?>
  </div>
  
<div id="menu-container-2">
  <a href="active-tenders.php" class="tab">Active Tenders</a>
  <a href="rft.php" class="tab-active">Request For Tender</a>
  <a href="control.php" class="tab">Dashboard</a>
  <a href="#" class="tab-logout">Logout</a>
</div>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div id="container-no-bg">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>
          <table width="100%" border="0" align="center" cellpadding="2" cellspacing="3">
            <tr>
              <td colspan="2" valign="bottom" nowrap="nowrap" class="header">Request for Tender</td>
              <td align="right"><span class="header"><?php echo $row_Recordset2['CompanyName']; ?><br />
              </span></td>
            </tr>
            <tr>
              <td valign="bottom" nowrap="nowrap"><strong>Closing Date</strong></td>
              <td valign="bottom" nowrap="nowrap">
              
                <input name="date" class="tarea-generic" id="date" value="<?php echo $_POST['date']; ?>" />
                
				<script type="text/javascript">
                  $('#date').datepicker({
                  dateFormat: "yy-mm-dd"
                  });
                </script>
                
              </td>
              <td width="891" align="right">
              <?php echo $row_Recordset2['Address']; ?><br />
              <?php echo $row_Recordset2['Suburb']; ?><br />
              <?php echo $row_Recordset2['City']; ?><br />
              <?php echo $row_Recordset2['Country']; ?></td>
            </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            </table>
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
           <tr><td>
          <div id="list-border">
          <table width="100%" cellpadding="0" cellspacing="1">
          <tr>
            <td class="td-header"><strong>&nbsp;Procurement For</strong></td>
          </tr><tr>
            <td class="td-right"><input name="subject" type="text" class="tarea-100" id="subject" value="<?php echo $_POST['subject']; ?>" /></td>
          </tr>
          <tr>
            <td class="td-header">Invitation List</td>
          </tr>
          <tr>
            <td class="td-right">
            
              <select name="invitation-list" class="tarea-100-dd" id="invitation-list">
                <option value="">Select one...</option>
                <?php do {  ?>
                  <option value="<?php echo $row_Recordset3['IndustryType']?>"<?php if($row_Recordset3['IndustryType'] == $_POST['invitation-list']) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['Industry']?></option>
            <?php
			  } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
				$rows = mysqli_num_rows($Recordset3);
				if($rows > 0) {
					mysqli_data_seek($Recordset3, 0);
					$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
				}
			  ?>
          </select>            
            </td>
          </tr>
          <tr>
            <td class="td-header">Description</td>
          </tr>
          <tr>
            <td>
              <textarea name="description" class="tender-tarea mceEditor" id="description"><?php echo $_POST['description']; ?></textarea>
            </td>
          </tr>
          <tr>
            <td style="padding:0"><input name="submit" type="submit" class="btn-generic" id="submit" value="Request for Tender" /></td>
          </tr>
          </table>
          </div>
          </td></tr>
          </table></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php
mysqli_free_result($Recordset1);

mysqli_free_result($Recordset2);

mysqli_free_result($Recordset3);

?>
