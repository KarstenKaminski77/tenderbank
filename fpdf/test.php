<?php require_once('../Connections/tender.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Load the required classes
require_once('../includes/tfi/TFI.php');
require_once('../includes/tso/TSO.php');
require_once('../includes/nav/NAV.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_tender = new KT_connection($tender, $database_tender);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

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

// Filter
$tfi_listtbl_tender_fields1 = new TFI_TableFilter($conn_tender, "tfi_listtbl_tender_fields1");
$tfi_listtbl_tender_fields1->addColumn("tbl_tender_fields.Description", "STRING_TYPE", "Description", "%");
$tfi_listtbl_tender_fields1->addColumn("tbl_tender_fields.Qty", "NUMERIC_TYPE", "Qty", "=");
$tfi_listtbl_tender_fields1->addColumn("tbl_tender_fields.Price", "DOUBLE_TYPE", "Price", "=");
$tfi_listtbl_tender_fields1->addColumn("tbl_tender_fields.Total", "DOUBLE_TYPE", "Total", "=");
$tfi_listtbl_tender_fields1->addColumn("tbl_tender_fields.OverallTotal", "DOUBLE_TYPE", "OverallTotal", "=");
$tfi_listtbl_tender_fields1->addColumn("tbl_tender_fields.TenderId", "NUMERIC_TYPE", "TenderId", "=");
$tfi_listtbl_tender_fields1->addColumn("tbl_tender_fields.BidderId", "NUMERIC_TYPE", "BidderId", "=");
$tfi_listtbl_tender_fields1->addColumn("tbl_tender_fields.Complete", "NUMERIC_TYPE", "Complete", "=");
$tfi_listtbl_tender_fields1->addColumn("tbl_tender_fields.DateSubmitted", "DATE_TYPE", "DateSubmitted", "=");
$tfi_listtbl_tender_fields1->Execute();

// Sorter
$tso_listtbl_tender_fields1 = new TSO_TableSorter("rstbl_tender_fields1", "tso_listtbl_tender_fields1");
$tso_listtbl_tender_fields1->addColumn("tbl_tender_fields.Description");
$tso_listtbl_tender_fields1->addColumn("tbl_tender_fields.Qty");
$tso_listtbl_tender_fields1->addColumn("tbl_tender_fields.Price");
$tso_listtbl_tender_fields1->addColumn("tbl_tender_fields.Total");
$tso_listtbl_tender_fields1->addColumn("tbl_tender_fields.OverallTotal");
$tso_listtbl_tender_fields1->addColumn("tbl_tender_fields.TenderId");
$tso_listtbl_tender_fields1->addColumn("tbl_tender_fields.BidderId");
$tso_listtbl_tender_fields1->addColumn("tbl_tender_fields.Complete");
$tso_listtbl_tender_fields1->addColumn("tbl_tender_fields.DateSubmitted");
$tso_listtbl_tender_fields1->setDefault("tbl_tender_fields.Description");
$tso_listtbl_tender_fields1->Execute();

// Navigation
$nav_listtbl_tender_fields1 = new NAV_Regular("nav_listtbl_tender_fields1", "rstbl_tender_fields1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rstbl_tender_fields1 = $_SESSION['max_rows_nav_listtbl_tender_fields1'];
$pageNum_rstbl_tender_fields1 = 0;
if (isset($_GET['pageNum_rstbl_tender_fields1'])) {
  $pageNum_rstbl_tender_fields1 = $_GET['pageNum_rstbl_tender_fields1'];
}
$startRow_rstbl_tender_fields1 = $pageNum_rstbl_tender_fields1 * $maxRows_rstbl_tender_fields1;

// Defining List Recordset variable
$NXTFilter_rstbl_tender_fields1 = "1=1";
if (isset($_SESSION['filter_tfi_listtbl_tender_fields1'])) {
  $NXTFilter_rstbl_tender_fields1 = $_SESSION['filter_tfi_listtbl_tender_fields1'];
}
// Defining List Recordset variable
$NXTSort_rstbl_tender_fields1 = "tbl_tender_fields.Description";
if (isset($_SESSION['sorter_tso_listtbl_tender_fields1'])) {
  $NXTSort_rstbl_tender_fields1 = $_SESSION['sorter_tso_listtbl_tender_fields1'];
}
mysql_select_db($database_tender, $tender);

$query_rstbl_tender_fields1 = "SELECT tbl_tender_fields.Description, tbl_tender_fields.Qty, tbl_tender_fields.Price, tbl_tender_fields.Total, tbl_tender_fields.OverallTotal, tbl_tender_fields.TenderId, tbl_tender_fields.BidderId, tbl_tender_fields.Complete, tbl_tender_fields.DateSubmitted, tbl_tender_fields.Id FROM tbl_tender_fields WHERE {$NXTFilter_rstbl_tender_fields1} ORDER BY {$NXTSort_rstbl_tender_fields1}";
$query_limit_rstbl_tender_fields1 = sprintf("%s LIMIT %d, %d", $query_rstbl_tender_fields1, $startRow_rstbl_tender_fields1, $maxRows_rstbl_tender_fields1);
$rstbl_tender_fields1 = mysql_query($query_limit_rstbl_tender_fields1, $tender) or die(mysql_error());
$row_rstbl_tender_fields1 = mysql_fetch_assoc($rstbl_tender_fields1);

if (isset($_GET['totalRows_rstbl_tender_fields1'])) {
  $totalRows_rstbl_tender_fields1 = $_GET['totalRows_rstbl_tender_fields1'];
} else {
  $all_rstbl_tender_fields1 = mysql_query($query_rstbl_tender_fields1);
  $totalRows_rstbl_tender_fields1 = mysql_num_rows($all_rstbl_tender_fields1);
}
$totalPages_rstbl_tender_fields1 = ceil($totalRows_rstbl_tender_fields1/$maxRows_rstbl_tender_fields1)-1;
//End NeXTenesio3 Special List Recordset

// Make an insert transaction instance
$ins_tbl_tender_fields = new tNG_multipleInsert($conn_tender);
$tNGs->addTransaction($ins_tbl_tender_fields);
// Register triggers
$ins_tbl_tender_fields->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_tbl_tender_fields->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_tbl_tender_fields->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_tbl_tender_fields->setTable("tbl_tender_fields");
$ins_tbl_tender_fields->addColumn("Description", "STRING_TYPE", "POST", "Description");
$ins_tbl_tender_fields->addColumn("Qty", "NUMERIC_TYPE", "POST", "Qty");
$ins_tbl_tender_fields->addColumn("Price", "DOUBLE_TYPE", "POST", "Price");
$ins_tbl_tender_fields->addColumn("Total", "DOUBLE_TYPE", "POST", "Total");
$ins_tbl_tender_fields->addColumn("OverallTotal", "DOUBLE_TYPE", "POST", "OverallTotal");
$ins_tbl_tender_fields->addColumn("TenderId", "NUMERIC_TYPE", "POST", "TenderId");
$ins_tbl_tender_fields->addColumn("BidderId", "NUMERIC_TYPE", "POST", "BidderId");
$ins_tbl_tender_fields->addColumn("Complete", "NUMERIC_TYPE", "POST", "Complete");
$ins_tbl_tender_fields->addColumn("DateSubmitted", "DATE_TYPE", "POST", "DateSubmitted");
$ins_tbl_tender_fields->setPrimaryKey("Id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_tbl_tender_fields = new tNG_multipleUpdate($conn_tender);
$tNGs->addTransaction($upd_tbl_tender_fields);
// Register triggers
$upd_tbl_tender_fields->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_tbl_tender_fields->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_tbl_tender_fields->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_tbl_tender_fields->setTable("tbl_tender_fields");
$upd_tbl_tender_fields->addColumn("Description", "STRING_TYPE", "POST", "Description");
$upd_tbl_tender_fields->addColumn("Qty", "NUMERIC_TYPE", "POST", "Qty");
$upd_tbl_tender_fields->addColumn("Price", "DOUBLE_TYPE", "POST", "Price");
$upd_tbl_tender_fields->addColumn("Total", "DOUBLE_TYPE", "POST", "Total");
$upd_tbl_tender_fields->addColumn("OverallTotal", "DOUBLE_TYPE", "POST", "OverallTotal");
$upd_tbl_tender_fields->addColumn("TenderId", "NUMERIC_TYPE", "POST", "TenderId");
$upd_tbl_tender_fields->addColumn("BidderId", "NUMERIC_TYPE", "POST", "BidderId");
$upd_tbl_tender_fields->addColumn("Complete", "NUMERIC_TYPE", "POST", "Complete");
$upd_tbl_tender_fields->addColumn("DateSubmitted", "DATE_TYPE", "POST", "DateSubmitted");
$upd_tbl_tender_fields->setPrimaryKey("Id", "NUMERIC_TYPE", "GET", "Id");

// Make an instance of the transaction object
$del_tbl_tender_fields = new tNG_multipleDelete($conn_tender);
$tNGs->addTransaction($del_tbl_tender_fields);
// Register triggers
$del_tbl_tender_fields->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_tbl_tender_fields->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_tbl_tender_fields->setTable("tbl_tender_fields");
$del_tbl_tender_fields->setPrimaryKey("Id", "NUMERIC_TYPE", "GET", "Id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstbl_tender_fields = $tNGs->getRecordset("tbl_tender_fields");
$row_rstbl_tender_fields = mysql_fetch_assoc($rstbl_tender_fields);
$totalRows_rstbl_tender_fields = mysql_num_rows($rstbl_tender_fields);

$nav_listtbl_tender_fields1->checkBoundries();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: false,
  show_as_grid: true,
  merge_down_value: true
}
</script>
<script src="../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: false,
  duplicate_navigation: false,
  row_effects: true,
  show_as_buttons: true,
  record_counter: false
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_Description {width:140px; overflow:hidden;}
  .KT_col_Qty {width:140px; overflow:hidden;}
  .KT_col_Price {width:140px; overflow:hidden;}
  .KT_col_Total {width:140px; overflow:hidden;}
  .KT_col_OverallTotal {width:140px; overflow:hidden;}
  .KT_col_TenderId {width:140px; overflow:hidden;}
  .KT_col_BidderId {width:140px; overflow:hidden;}
  .KT_col_Complete {width:140px; overflow:hidden;}
  .KT_col_DateSubmitted {width:140px; overflow:hidden;}
</style>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['Id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Tbl_tender_fields </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rstbl_tender_fields > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="Description_<?php echo $cnt1; ?>">Description:</label></td>
            <td><input type="text" name="Description_<?php echo $cnt1; ?>" id="Description_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstbl_tender_fields['Description']); ?>" size="32" />
              <?php echo $tNGs->displayFieldHint("Description");?> <?php echo $tNGs->displayFieldError("tbl_tender_fields", "Description", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="Qty_<?php echo $cnt1; ?>">Qty:</label></td>
            <td><input type="text" name="Qty_<?php echo $cnt1; ?>" id="Qty_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstbl_tender_fields['Qty']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("Qty");?> <?php echo $tNGs->displayFieldError("tbl_tender_fields", "Qty", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="Price_<?php echo $cnt1; ?>">Price:</label></td>
            <td><input type="text" name="Price_<?php echo $cnt1; ?>" id="Price_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstbl_tender_fields['Price']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("Price");?> <?php echo $tNGs->displayFieldError("tbl_tender_fields", "Price", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="Total_<?php echo $cnt1; ?>">Total:</label></td>
            <td><input type="text" name="Total_<?php echo $cnt1; ?>" id="Total_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstbl_tender_fields['Total']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("Total");?> <?php echo $tNGs->displayFieldError("tbl_tender_fields", "Total", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="OverallTotal_<?php echo $cnt1; ?>">OverallTotal:</label></td>
            <td><input type="text" name="OverallTotal_<?php echo $cnt1; ?>" id="OverallTotal_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstbl_tender_fields['OverallTotal']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("OverallTotal");?> <?php echo $tNGs->displayFieldError("tbl_tender_fields", "OverallTotal", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="TenderId_<?php echo $cnt1; ?>">TenderId:</label></td>
            <td><input type="text" name="TenderId_<?php echo $cnt1; ?>" id="TenderId_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstbl_tender_fields['TenderId']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("TenderId");?> <?php echo $tNGs->displayFieldError("tbl_tender_fields", "TenderId", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="BidderId_<?php echo $cnt1; ?>">BidderId:</label></td>
            <td><input type="text" name="BidderId_<?php echo $cnt1; ?>" id="BidderId_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstbl_tender_fields['BidderId']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("BidderId");?> <?php echo $tNGs->displayFieldError("tbl_tender_fields", "BidderId", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="Complete_<?php echo $cnt1; ?>">Complete:</label></td>
            <td><input type="text" name="Complete_<?php echo $cnt1; ?>" id="Complete_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstbl_tender_fields['Complete']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("Complete");?> <?php echo $tNGs->displayFieldError("tbl_tender_fields", "Complete", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="DateSubmitted_<?php echo $cnt1; ?>">DateSubmitted:</label></td>
            <td><input type="text" name="DateSubmitted_<?php echo $cnt1; ?>" id="DateSubmitted_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rstbl_tender_fields['DateSubmitted']); ?>" size="10" maxlength="22" />
              <?php echo $tNGs->displayFieldHint("DateSubmitted");?> <?php echo $tNGs->displayFieldError("tbl_tender_fields", "DateSubmitted", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_tbl_tender_fields_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rstbl_tender_fields['kt_pk_tbl_tender_fields']); ?>" />
        <?php } while ($row_rstbl_tender_fields = mysql_fetch_assoc($rstbl_tender_fields)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['Id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, '')" />
            </div>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
            <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
            <?php }
      // endif Conditional region1
      ?>
<input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../includes/nxt/back.php')" />
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;
<div class="KT_tng" id="listtbl_tender_fields1">
  <h1> Tbl_tender_fields
    <?php
  $nav_listtbl_tender_fields1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form2">
      <div class="KT_options"> <a href="<?php echo $nav_listtbl_tender_fields1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region2
  if (@$_GET['show_all_nav_listtbl_tender_fields1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listtbl_tender_fields1']; ?>
          <?php 
  // else Conditional region2
  } else { ?>
          <?php echo NXT_getResource("all"); ?>
          <?php } 
  // endif Conditional region2
?>
<?php echo NXT_getResource("records"); ?></a> &nbsp;
        &nbsp;
        <?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listtbl_tender_fields1'] == 1) {
?>
          <a href="<?php echo $tfi_listtbl_tender_fields1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
          <?php 
  // else Conditional region2
  } else { ?>
          <a href="<?php echo $tfi_listtbl_tender_fields1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
          <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="Description" class="KT_sorter KT_col_Description <?php echo $tso_listtbl_tender_fields1->getSortIcon('tbl_tender_fields.Description'); ?>"> <a href="<?php echo $tso_listtbl_tender_fields1->getSortLink('tbl_tender_fields.Description'); ?>">Description</a></th>
            <th id="Qty" class="KT_sorter KT_col_Qty <?php echo $tso_listtbl_tender_fields1->getSortIcon('tbl_tender_fields.Qty'); ?>"> <a href="<?php echo $tso_listtbl_tender_fields1->getSortLink('tbl_tender_fields.Qty'); ?>">Qty</a></th>
            <th id="Price" class="KT_sorter KT_col_Price <?php echo $tso_listtbl_tender_fields1->getSortIcon('tbl_tender_fields.Price'); ?>"> <a href="<?php echo $tso_listtbl_tender_fields1->getSortLink('tbl_tender_fields.Price'); ?>">Price</a></th>
            <th id="Total" class="KT_sorter KT_col_Total <?php echo $tso_listtbl_tender_fields1->getSortIcon('tbl_tender_fields.Total'); ?>"> <a href="<?php echo $tso_listtbl_tender_fields1->getSortLink('tbl_tender_fields.Total'); ?>">Total</a></th>
            <th id="OverallTotal" class="KT_sorter KT_col_OverallTotal <?php echo $tso_listtbl_tender_fields1->getSortIcon('tbl_tender_fields.OverallTotal'); ?>"> <a href="<?php echo $tso_listtbl_tender_fields1->getSortLink('tbl_tender_fields.OverallTotal'); ?>">OverallTotal</a></th>
            <th id="TenderId" class="KT_sorter KT_col_TenderId <?php echo $tso_listtbl_tender_fields1->getSortIcon('tbl_tender_fields.TenderId'); ?>"> <a href="<?php echo $tso_listtbl_tender_fields1->getSortLink('tbl_tender_fields.TenderId'); ?>">TenderId</a></th>
            <th id="BidderId" class="KT_sorter KT_col_BidderId <?php echo $tso_listtbl_tender_fields1->getSortIcon('tbl_tender_fields.BidderId'); ?>"> <a href="<?php echo $tso_listtbl_tender_fields1->getSortLink('tbl_tender_fields.BidderId'); ?>">BidderId</a></th>
            <th id="Complete" class="KT_sorter KT_col_Complete <?php echo $tso_listtbl_tender_fields1->getSortIcon('tbl_tender_fields.Complete'); ?>"> <a href="<?php echo $tso_listtbl_tender_fields1->getSortLink('tbl_tender_fields.Complete'); ?>">Complete</a></th>
            <th id="DateSubmitted" class="KT_sorter KT_col_DateSubmitted <?php echo $tso_listtbl_tender_fields1->getSortIcon('tbl_tender_fields.DateSubmitted'); ?>"> <a href="<?php echo $tso_listtbl_tender_fields1->getSortLink('tbl_tender_fields.DateSubmitted'); ?>">DateSubmitted</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listtbl_tender_fields1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listtbl_tender_fields1_Description" id="tfi_listtbl_tender_fields1_Description" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtbl_tender_fields1_Description']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listtbl_tender_fields1_Qty" id="tfi_listtbl_tender_fields1_Qty" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtbl_tender_fields1_Qty']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listtbl_tender_fields1_Price" id="tfi_listtbl_tender_fields1_Price" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtbl_tender_fields1_Price']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listtbl_tender_fields1_Total" id="tfi_listtbl_tender_fields1_Total" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtbl_tender_fields1_Total']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listtbl_tender_fields1_OverallTotal" id="tfi_listtbl_tender_fields1_OverallTotal" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtbl_tender_fields1_OverallTotal']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listtbl_tender_fields1_TenderId" id="tfi_listtbl_tender_fields1_TenderId" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtbl_tender_fields1_TenderId']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listtbl_tender_fields1_BidderId" id="tfi_listtbl_tender_fields1_BidderId" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtbl_tender_fields1_BidderId']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listtbl_tender_fields1_Complete" id="tfi_listtbl_tender_fields1_Complete" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtbl_tender_fields1_Complete']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listtbl_tender_fields1_DateSubmitted" id="tfi_listtbl_tender_fields1_DateSubmitted" value="<?php echo @$_SESSION['tfi_listtbl_tender_fields1_DateSubmitted']; ?>" size="10" maxlength="22" /></td>
              <td><input type="submit" name="tfi_listtbl_tender_fields1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rstbl_tender_fields1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="11"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rstbl_tender_fields1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt2++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_tbl_tender_fields" class="id_checkbox" value="<?php echo $row_rstbl_tender_fields1['Id']; ?>" />
                  <input type="hidden" name="Id" class="id_field" value="<?php echo $row_rstbl_tender_fields1['Id']; ?>" /></td>
                <td><div class="KT_col_Description"><?php echo KT_FormatForList($row_rstbl_tender_fields1['Description'], 20); ?></div></td>
                <td><div class="KT_col_Qty"><?php echo KT_FormatForList($row_rstbl_tender_fields1['Qty'], 20); ?></div></td>
                <td><div class="KT_col_Price"><?php echo KT_FormatForList($row_rstbl_tender_fields1['Price'], 20); ?></div></td>
                <td><div class="KT_col_Total"><?php echo KT_FormatForList($row_rstbl_tender_fields1['Total'], 20); ?></div></td>
                <td><div class="KT_col_OverallTotal"><?php echo KT_FormatForList($row_rstbl_tender_fields1['OverallTotal'], 20); ?></div></td>
                <td><div class="KT_col_TenderId"><?php echo KT_FormatForList($row_rstbl_tender_fields1['TenderId'], 20); ?></div></td>
                <td><div class="KT_col_BidderId"><?php echo KT_FormatForList($row_rstbl_tender_fields1['BidderId'], 20); ?></div></td>
                <td><div class="KT_col_Complete"><?php echo KT_FormatForList($row_rstbl_tender_fields1['Complete'], 20); ?></div></td>
                <td><div class="KT_col_DateSubmitted"><?php echo KT_formatDate($row_rstbl_tender_fields1['DateSubmitted']); ?></div></td>
                <td><a class="KT_edit_link" href="test.php?Id=<?php echo $row_rstbl_tender_fields1['Id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
              </tr>
              <?php } while ($row_rstbl_tender_fields1 = mysql_fetch_assoc($rstbl_tender_fields1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listtbl_tender_fields1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a></div>
        <span>&nbsp;</span>
        <select name="no_new" id="no_new">
          <option value="1">1</option>
          <option value="3">3</option>
          <option value="6">6</option>
        </select>
        <a class="KT_additem_op_link" href="test.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a></div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</p>
</body>
</html>
<?php
mysql_free_result($rstbl_tender_fields1);
?>
