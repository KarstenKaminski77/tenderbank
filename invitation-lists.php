<?php require_once('Connections/tender.php'); ?>
<?php 
session_start();

require_once('Connections/tender.php'); 

require_once('functions/functions.php');

$level = 1;

restrict_access($level,$con);

login($con);

select_db();

// Add rows to manual input

if(!isset($_POST['row-count'])){
	
	$list_rows = 1;
	
} else {
	
	$list_rows = $_POST['row-count'];
}

if(isset($_POST['invite-new'])){
	
	$list_rows = $_POST['row-count'] + 1;
}

if(isset($_POST['cancel'])){
	
	header('Location: invitation-lists.php');
}
	
/******************************************************
**************** INSERT INVITATION LIST ***************
******************************************************/

if(isset($_POST['insert'])){
		
	if(!empty($_FILES['csv']['name'])){
		
		// Upload CSV
		
		$target_path = "csv/";
		
		$target_path = $target_path . basename($_FILES['csv']['name']);
		
		if(move_uploaded_file($_FILES['csv']['tmp_name'], $target_path));
		
		$csv = $_FILES['csv']['name'];
		
		$filename = fopen("csv/$csv", "r");
	}
		
	// Send alert to guardians
	// Find the number of guardians
	$companyid = $_SESSION['companyid'];
	
	$query = mysqli_query($con, "SELECT SUM(Guardian) FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysqli_error());
	$row = mysqli_fetch_array($query);
	
	$no_guardians = $row['SUM(Guardian)'];
	
	$userid = $_SESSION['userid'];
	
	// Find the requestors name
	
	$query2 = mysqli_query($con, "SELECT * FROM tbl_users WHERE Id = '$userid'")or die(mysqli_error());
	$row2 = mysqli_fetch_array($query2);
	
	$requestor = $row2['Name'] .' '. $row2['Surname'];
	
	// Create the alert
	$date = date('Y-m-d');
	$characters = 6;
	generateCode($characters);
	$password = $_SESSION['password'];
	$type = "New invitation list request";
	$url = "invitation-list-pending.php";
	
	mysqli_query($con, "INSERT INTO tbl_alerts (AlertType,Password,CompanyId,Requestor,Required,DateRequested,URL) 
	VALUES ('$type','$password','$companyid','$requestor','$no_guardians','$date','$url')")or die(mysqli_error());
	
	$query3 = mysqli_query($con, "SELECT * FROM tbl_alerts WHERE CompanyId = '$companyid' ORDER BY Id DESC LIMIT 1")or die(mysqli_error());
	$row3 = mysqli_fetch_array($query3);
	
	$alertid = $row3['Id'];
	
	// Insert into temnppory table
	if(!empty($_FILES['csv']['name'])){
		
		while (($data = fgetcsv($filename, 1000, ",")) !== FALSE){
			
			$companyid = $_SESSION['companyid'];
			$company_name = addslashes($data[0]);
			$industry = $_POST['industry'];
			$contact_name = addslashes($data[2]);
			$email = addslashes($data[3]);
			$date = date('Y-m-d');
			$userid = $_SESSION['userid'];
			
			mysqli_query($con, "INSERT into tbl_invitation_list_temp(AlertId,CompanyId,IndustryType,CompanyName,ContactPerson,Email,DateModified,ModifiedBy) 
			VALUES('$alertid','$companyid','$industry','$company_name','$contact_name','$email','$date','$userid')") or die(mysqli_error());
		}
		
		fclose($filename);
		
	} else {
		
		for($i=0;$i<count($_POST['company']);$i++){
			
			$companyid = $_SESSION['companyid'];
			$company_name = $_POST['company'][$i];
			$name = $_POST['name'][$i];
			$email = $_POST['email'][$i];
			$companyid = $_SESSION['companyid'];
			$date = date('Y-m-d');
			$userid = $_SESSION['userid'];
			$industry = $_POST['industry-2'];
				
			mysqli_query($con, "INSERT into tbl_invitation_list_temp(AlertId,CompanyId,IndustryType,CompanyName,ContactPerson,Email,DateModified,ModifiedBy) 
			VALUES('$alertid','$companyid','$industry','$company_name','$name','$email','$date','$userid')") or die(mysqli_error());
		}
	}
	
	
			
	$query4 = mysqli_query($con, "SELECT * FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysqli_error());
	while($row4 = mysqli_fetch_array($query4)){
		
		$subject = 'Tender Bank Alert';
		$name = $row4['Name'];
		$to = $row4['Username'];
		$message = '
		  <body style="font-family:Arial; font-size:12px; color:002a76">
		  <table border="0" cellspacing="3" cellpadding="2" style="font-family:Arial; font-size:12px; color:002a76">
			<tr>
			  <td width="329"><img src="http://www.tenderbank.co.za/images/logo.jpg" width="305" height="60" /></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td><p>Hi '.$name.'<br />
				<br />
				<br />
			  '. $requestor .' has has added new records to your invitation list on Tender Bank.<br />
			  <br />
			  Please <a href="http://www.tenderbank.co.za/invitation-list-pending.php?Id='.$alertid.'">Click here</a> to view the records and either approve or reject them. Please use the following reference code when prompted.
			  <br><br>
			  <b>Password:</b> '. $password .'
			  </p>
			  <br><br><br><br><br>
		  </body>
		  ';

		  $headers  = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		  $headers .= 'FROM: test@kwd.co.za' . "\r\n";
		  
		  mail($to, $subject, $message, $headers);

	}
}

/******************************************************
**************** UPDATE INVITATION LIST ***************
******************************************************/

if(isset($_POST['update'])){
	
	// Send alert to guardians
	
	// Find the number of guardians
	
	$companyid = $_SESSION['companyid'];
	
	$query = mysqli_query($con, "SELECT SUM(Guardian) FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysqli_error());
	$row = mysqli_fetch_array($query);
		
	$no_guardians = $row['SUM(Guardian)'];
		
	$userid = $_SESSION['userid'];
		
	// Find the requestors name
		
	$query2 = mysqli_query($con, "SELECT * FROM tbl_users WHERE Id = '$userid'")or die(mysqli_error());
	$row2 = mysqli_fetch_array($query2);
		
	$requestor = $row2['Name'] .' '. $row2['Surname'];
		
	// Create the alert
		
	$date = date('Y-m-d');
	$characters = 6;
	generateCode($characters);
	$password = $_SESSION['password'];
	$type = "Invitation list update request";
	$url = "invitation-list-pending.php";
		
	mysqli_query($con, "INSERT INTO tbl_alerts (AlertType,Password,CompanyId,Requestor,Required,DateRequested,URL) VALUES ('$type','$password','$companyid','$requestor','$no_guardians','$date','$url')")or die(mysqli_error());
		
	$query3 = mysqli_query($con, "SELECT * FROM tbl_alerts WHERE CompanyId = '$companyid' ORDER BY Id DESC LIMIT 1")or die(mysqli_error());
	$row3 = mysqli_fetch_array($query3);
		
	$alertid = $row3['Id'];
		
	// Insert into temnppory table
		
	$count = count($_POST['company']);
	
	for($i=0;$i<$count;$i++){
		
		$company = $_POST['company'][$i];
		$name = $_POST['name'][$i];
		$email = $_POST['email'][$i];
		$companyid = $_SESSION['companyid'];
		$date = date('Y-m-d');
		$userid = $_SESSION['userid'];
		$id = $_POST['record-id'][$i];
		$industry = $_GET['Id'];
	        
		mysqli_query($con, "INSERT into tbl_invitation_list_temp(AlertId,OldId,CompanyId,IndustryType,CompanyName,ContactPerson,Email,DateModified,ModifiedBy) 
		VALUES('$alertid','$id','$companyid','$industry','$company','$name','$email','$date','$userid')") or die(mysqli_error());
		}
				
		$query4 = mysqli_query($con, "SELECT * FROM tbl_users WHERE CompanyId = '$companyid' AND Guardian = '1'")or die(mysqli_error());
		while($row4 = mysqli_fetch_array($query4)){
			
			$subject = 'Tender Bank Alert';
			$name = $row4['Name'];
			$to = $row4['Username'];
			$message = '
			  <body style="font-family:Arial; font-size:12px; color:002a76">
			  <table border="0" cellspacing="3" cellpadding="2" style="font-family:Arial; font-size:12px; color:002a76">
				<tr>
				  <td width="329"><img src="http://www.tenderbank.co.za/images/logo.jpg" width="305" height="60" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td><p>Hi '.$name.'<br />
					<br />
					<br />
				  '. $requestor .' has updated records on your invitation list on Tender Bank.<br />
				  <br />
				  Please <a href="http://www.tenderbank.co.za/invitation-list-pending.php?Id='.$alertid.'">Click here</a> to view the records and either approve or reject them. Please use the following reference code when prompted.
				  <br><br>
				  <b>Password:</b> '. $password .'
				  </p>
				  <br><br><br><br><br>
			  </body>
			  ';
			  
			  $headers  = 'MIME-Version: 1.0' . "\r\n";
			  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			  $headers .= 'FROM: test@kwd.co.za' . "\r\n";
			  
			  mail($to, $subject, $message, $headers);

		}
}


$colname_Recordset1 = "-1";
if (isset($_SESSION['companyid'])) {
  $colname_Recordset1 = $_SESSION['companyid'];
}
$query_Recordset1 = "SELECT * FROM tbl_registered_users WHERE Id = '$colname_Recordset1'";
$Recordset1 = mysqli_query($con, $query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$companyid = $_SESSION['companyid'];

$query_Recordset2 = "SELECT tbl_invitation_list.Id AS RecordId, tbl_invitation_list.CompanyName, tbl_invitation_list.ContactPerson, tbl_invitation_list.Email, tbl_industries.Industry, tbl_users.Name, tbl_users.Surname, tbl_invitation_list.DateModified, tbl_invitation_list.IndustryType, tbl_invitation_list.CompanyId FROM ((tbl_invitation_list LEFT JOIN tbl_industries ON tbl_industries.Id=tbl_invitation_list.IndustryType) LEFT JOIN tbl_users ON tbl_users.Id=tbl_invitation_list.ModifiedBy) WHERE tbl_invitation_list.CompanyId = '$companyid = $companyid' GROUP BY tbl_invitation_list.IndustryType";
$Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$query_Recordset3 = "SELECT * FROM tbl_industries ORDER BY Industry ASC";
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

$query_industries = mysqli_query($con, "SELECT * FROM tbl_industries ORDER BY Industry ASC")or die(mysqli_error($con));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tender Bank</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />

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
  <a href="logout.php" class="menu-2"><img src="images/man.png" width="11" height="10" border="0" /> Hello <?php echo $row_Recordset4['Name']; ?> <?php echo $row_Recordset4['Surname']; ?></a> 
  <a href="logout.php" class="menu-3">Last Login: <?php echo date('d M Y',strtotime($row_Recordset4['LastLogin'])); ?></a>
  <?php invitation_alerts($con); ?>
  </div>

<div id="menu-container-2">
    <a href="active-tenders.php" class="tab">Active Tenders</a>
    <a href="rft.php" class="tab">Request For Tender</a>
    <a href="control.php" class="tab">Dashboard</a>
    <a href="#" class="tab-logout">Logout</a>
  </div>

  <div id="container-no-bg">
    <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="2" cellspacing="3">
          <tr>
            <td width="50%">&nbsp;</td>
            <td width="50%" align="right"><span class="header"><?php echo $row_Recordset1['CompanyName']; ?><br />
              </span><br />
              <?php echo $row_Recordset1['Address']; ?><br />
              <?php echo $row_Recordset1['Suburb']; ?><br />
              <?php echo $row_Recordset1['City']; ?><br />
              <?php echo $row_Recordset1['Country']; ?></td>
          </tr>
        </table>
          <br />
            <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><table width="640" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><div id="list-border">
                        <table width="640" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><div class="dhtmlgoodies_question" id="show-hide" style="background-color:#C7C7C9; color:#333">
                              <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td>&nbsp;Upload Invitations CSV Format </td>
                                  <td align="right">
                                  <span class="dhtmlgoodies_question" style="margin-top:3px">
                                  <a href="#" onclick="return hs.htmlExpand(this, { contentId: 'highslide-html' } )" class="highslide">
                                  <img src="images/help.png" width="18" height="18" border="0" /></a><div class="highslide-html-content" id="highslide-html">
                                  
                                  <div class="highslide-header">
                                  
                                  <ul>
                                  <li class="highslide-move">
				                  <a href="#" onclick="return false">Move</a>
			                      </li>
                                  
                                  <li class="highslide-close">
                                  <a href="#" onclick="return hs.close(this)">Close</a>
                                  </li>
                                  </ul>
                                  
                                  </div>
                                  
                                  <div class="highslide-body">
		Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam dapibus leo quis nisl. In lectus. Vivamus consectetuer pede in nisl. Mauris cursus pretium mauris. Suspendisse condimentum mi ac tellus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec sed enim. Ut vel ipsum. Cras consequat velit et justo. Donec mollis, mi at tincidunt vehicula, nisl mi luctus risus, quis scelerisque arcu nibh ac nisi. Sed risus. Curabitur urna. Aliquam vitae nisl. Quisque imperdiet semper justo. Pellentesque nonummy pretium tellus.
	</div>
    <div class="highslide-footer">
        <div>
            <span class="highslide-resize" title="Resize">
                <span></span>
            </span>
        </div>
    </div>
</div>

</span></td>
                                </tr>
                              </table>
                            </div>
                              <div id="file-upload">
                                <div class="dhtmlgoodies_answer">
                                  <div style="background-color:#C7C7C9; margin:2px; clear:both">
                                    <table border="0" cellspacing="0" cellpadding="5">
                                      <tr>
                                        <td>
                                        <select name="industry" class="tarea-generic" id="industry">
                                          <option value="">Select industry...</option>
                                          <?php
do {  
?>
                                          <option value="<?php echo $row_Recordset3['Id']?>"><?php echo $row_Recordset3['Industry']?></option>
                                          <?php
} while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
  $rows = mysqli_num_rows($Recordset3);
  if($rows > 0) {
      mysqli_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
  }
?>
                                        </select></td>
                                        <td><input name="csv" type="file" class="btn-generic" id="csv" /></td>
                                      </tr>
                                    </table>
                                  </div>
                                </div>
                              </div></td>
                          </tr>
                          <tr>
                            <td><table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td><div class="dhtmlgoodies_question" id="show-hide" style="background-color:#e1e1e1; color:#333">&nbsp;Add Invitations Manually</div>
                                <div class="dhtmlgoodies_answer">
                                  <div style="background-color:#E1E1E1; margin:2px">
                                    <table width="100%" border="0" cellpadding="1" cellspacing="2">
                                      <tr class="rft-bold">
                                        <td colspan="3">
                                          <select name="industry-2" class="tarea-100-dd" id="industry-2">
                                            <option value="">Select an Industry...</option>
                                            <?php while($row_industry = mysqli_fetch_array($query_industries)){ ?>
                                              <option value="<?php echo $row_industry['Id']; ?>"><?php echo $row_industry['Industry']; ?></option>
                                            <?php } ?>
                                          </select>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <?php
                                      
									  $company = $_POST['company'];
									  $mail = $_POST['email'];
									  $name = $_POST['name'];
									  
									  if(isset($_GET['Id'])){
										  
										  $row_id = array();
										  $industry_type = $_GET['Id'];
										  $companyid = $_SESSION['companyid'];
										  
										  // Get record id
										  
										  $query = mysqli_query($con, "SELECT * FROM tbl_invitation_list WHERE CompanyId = '$companyid' AND IndustryType = '$industry_type'")or die(mysqli_error());
										  while($row = mysqli_fetch_array($query)){
										  
										  $id = $row['Id'];
										  
										  array_push($row_id, $id);
										  
										  $list_rows = count($row_id);
										  
										  }
									  }
										  
										  for($c=0;$c<$list_rows;$c++){
											  
											  if(isset($_GET['Id'])){
												  
												  $id = $row_id[$c];
												  
												  $query = mysqli_query($con, "SELECT * FROM tbl_invitation_list WHERE Id = '$id'")or die(mysqli_error());
												  $row = mysqli_fetch_array($query);
													  
													  $company1 = $row['CompanyName'];
													  $email = $row['Email'];
													  $name1 = $row['ContactPerson'];
													  $record_id = $row['Id'];
													  $industry1 = $row['IndustryType'];
													  
												  } else {
													  
													  
													  $company1 = $company[$c];
													  $email = $mail[$c];
													  $name1 = $name[$c];
													  $industry1 = $industry[$c];
													  
												  }
		                             ?>
                                      <tr>
                                        <td width="33%" align="center">
                                        <input name="company[]" type="text" class="tarea-rft" id="company[]" value="<?php echo $company1; ?>" placeholder="Company" />
                                        </td><td width="33%" align="center">
                                        <input name="name[]" type="text" class="tarea-rft" id="name[]" value="<?php echo $name1; ?>" placeholder="Contact Person" />
                                        <input name="nature_id" type="hidden" id="nature_id" value="<?php echo $row_Recordset1['Id']; ?>" />
                                         <input type="hidden" name="row-count" id="row-count" value="<?php echo $list_rows; ?>" />
                                         <input type="hidden" name="record-id[]" id="record-id[]" value="<?php echo $record_id; ?>" />
                                         <input type="hidden" name="industry-id" id="industry-id" value="<?php echo $industry1; ?>" /></td><td width="33%" align="center">
                                         <input name="email[]" type="text" class="tarea-rft" id="email[]" value="<?php echo $email; ?>" placeholder="Email Address" />
                                         </td><td align="center">
                                         <input type="checkbox" name="checkbox" id="checkbox" />
                                         </td><td align="center">
										 <?php if($c == 0){ ?><input name="invite-new" type="submit" class="new-nature-business" id="invite-new" value="" /><?php } ?>
                                         </td>
                                      </tr>
                                      <?php } ?>
                                    </table>
                                  </div>
                                </div></td>
                            </tr>
                          </table></td>
                          </tr>
                          <tr>
                            <td>
                            <?php if(isset($_GET['Id'])){ ?>
                                  <input name="update" type="submit" class="btn-generic" id="update" value="Update" />
                                  <input name="cancel" type="submit" class="btn-generic-red" id="cancel" value="Cancel" />
                                  <?php } else { ?>
                                  <input name="insert" type="submit" class="btn-generic" id="insert" value="Insert" />
                                  <?php } ?>
                            </td>
                          </tr>
                        </table>
                      </div></td>
                    </tr>
                  </table>
                    <script type="text/javascript">
initShowHideDivs();
<?php if(isset($_POST['invite-new']) || isset($_POST['update']) || isset($_GET['Id'])){ ?>
showHideContent(false,2);	// Automatically expand first item
<?php } ?>
                  </script></td>
                </tr>
              </table>
            </form>
          </td>
      </tr>
    </table>
    <?php if($totalRows_Recordset2 >= 1){ ?>
    <br />
    <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="list-border">
          <table width="992" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td class="td-header">&nbsp;Industry</td>
              <td width="150" class="td-header">Invitations</td>
              <td width="150" class="td-header">Last Modified By</td>
              <td width="150" class="td-header">Last Modified</td>
              <td width="37" class="td-header">&nbsp;</td>
              <td width="37" class="td-header">&nbsp;</td>
            </tr>
            <?php do { 
			
			$industry_type = $row_Recordset2['IndustryType'];
			?>
            <tr class="<?php echo ($ac_sw1++%2==0)?"even":"odd"; ?>" onmouseover="this.oldClassName = this.className; this.className='list-over';" onmouseout="this.className = this.oldClassName;">
              <td>&nbsp;<?php echo $row_Recordset2['Industry']; ?></td>
              <td width="150">  &nbsp;<?php count_invitations($industry_type,$con); ?></td>
              <td width="150">  &nbsp;<?php echo $row_Recordset2['Name']; ?> <?php echo $row_Recordset2['Surname']; ?></td>
              <td width="150">  &nbsp;<?php echo $row_Recordset2['DateModified']; ?></td>
              <td><form id="form2" name="form2" method="post" action="invitation-lists.php?Id=<?php echo $row_Recordset2['IndustryType']; ?>">
                <input name="edit" type="submit" class="btn-generic" id="edit" value="Edit" />
              </form></td>
              <td><form id="form3" name="form3" method="post" action="invitation-lists.php?Delete=<?php echo $row_Recordset2['IndustryType']; ?>">
                <input name="delete" type="submit" class="btn-generic-red" id="delete" value="Delete" />
              </form></td>
            </tr>
            <?php } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2)); ?>
          </table>
        </div></td>
      </tr>
    </table>
  <?php } ?>
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);

mysqli_free_result($Recordset2);

mysqli_free_result($Recordset3);

mysqli_free_result($Recordset4);
?>
