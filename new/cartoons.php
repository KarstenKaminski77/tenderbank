<?php require_once('Connections/apple.php'); ?>
<?php
// Load the Navigation classes
require_once('includes/nav/NAV.php'); 

// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

$nav_Recordset1 = new NAV_Page_Navigation("nav_Recordset1", "Recordset1", "", KT_getPHP_SELF(), 6, 5);

$maxRows_Recordset1 = $_SESSION['max_rows_nav_Recordset1'];
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_apple, $apple);
$query_Recordset1 = "SELECT * FROM tbl_cartoons";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $apple) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$nav_Recordset1->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cartoonist Durban</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/fonts.css" rel="stylesheet" type="text/css" />
<link href="styles/menu.css" rel="stylesheet" type="text/css" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
  $NAV_SETTINGS = {
     'show_as_buttons': false
  }
</script>
<script type="text/javascript" src="highslide/highslide.js"></script>
<script type="text/javascript">
<!--
hs.graphicsDir = 'highslide/graphics/';
    hs.outlineType = 'rounded-white';

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
//-->
</script>
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="keywords">
  <h1>Cartoonist Durban</h1>
</div>
<div id="menu_clients">
<a href="index.php" class="menu_1"></a>
<a href="about.php" class="menu_2"></a>
<a href="portfolio.php" class="menu_3"></a>
<a href="clients.php" class="menu_4"></a>
<a href="contact.php" class="menu_5"></a></div>
<table width="1024px" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td>
<div id="left_panel"></div>
<div id="fluid">
<div id="top_panel"></div>
  <div id="main_panel_brochure">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <?php
  do { // horizontal looper version 3
?>
          <td align="center"><div id="logo_padding">
            <p>
			<a href="portfolio/<?php echo $row_Recordset1['Cartoon'];?>" class="look_inside" onclick="return hs.expand(this, {captionId: 'caption1'})">
			<img src="<?php echo tNG_showDynamicThumbnail("", "portfolio/", "{Recordset1.Cartoon}", 200, 200, true); ?>" border="0" /></a><br />
            </p>
            </div></td>
          <?php
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    if (!isset($nested_Recordset1)) {
      $nested_Recordset1= 1;
    }
    if (isset($row_Recordset1) && is_array($row_Recordset1) && $nested_Recordset1++ % 2==0) {
      echo "</tr><tr>";
    }
  } while ($row_Recordset1); //end horizontal looper version 3
?>
      </tr>
    </table>
    <div align="center" id="page_nav">
        <BR />
            <?php
      //Display Page Navigation 	
      $nav_Recordset1->Prepare();
      require("includes/nav/NAV_Page_Navigation.inc.php");
    ?>
    </div>
  </div>
  <div id="main_panel_lower"></div>
</div>
<div id="right_panel">
  <a href="newsletter.php" class="newsletter"></a>
<a href="comments.php" class="clients"></a>
<a href="circle.php" class="clients"></a>
<a href="web-promotions.php" class="clients"></a>
<div class="fb-like" data-href="http://www.applejack.co.za" data-send="true" data-width="170" data-show-faces="false" data-font="arial" layout="button_count" id="fb-like"></div></div>
</td></tr>
</table>
<div id="footer"><em><strong>WE LOVE TO GET OUR TEETH INTO JUICY CREATIVE WORK LIKE THIS</strong></em><br />
  COPYWRITING &amp; CARTOONING&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PRINT &amp; PACKAGING DESIGN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CORPORATE IMAGE &amp; LOGO DESIGN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WEB SITE DESIGN<br />
  CORPORATE NEWSLETTERS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RADIO &amp; TV CAMPAIGN IDEAS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ABOVE &amp; BELOW THE LINE CAMPAIGN CONCEPTS<br />
  CREATIVE ADVERTISING &amp; MARKETING CONCEPTS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CAMPAIGN STRATEGIES AND BRANDING WORKSHOPS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ILLUSTRATION ART</div>
<div id="btm_keywords">
  <h3>Cartoonist Durban</h3>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
