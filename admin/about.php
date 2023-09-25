<?php require_once('../Connections/tender.php'); 

require_once('../functions/functions.php');

$level = 1;

restrict_access($level);

login();

select_db();

if(isset($_POST['about'])){
	
	$about = addslashes($_POST['about']);
	
	mysql_query("UPDATE tbl_about SET Content = '$about'")or die(mysql_error());
	
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
$query_Recordset1 = "SELECT * FROM tbl_about";
$Recordset1 = mysql_query($query_Recordset1, $tender) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

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
  <script type="text/javascript">
    // You must set _editor_url to the URL (including trailing slash) where
    // where xinha is installed, it's highly recommended to use an absolute URL
    //  eg: _editor_url = "/path/to/xinha/";
    // You may try a relative URL if you wish]
    //  eg: _editor_url = "../";
    // in this example we do a little regular expression to find the absolute path.
    _editor_url  = "../Xinha"
    _editor_lang = "en";      // And the language we need to use in the editor.
    _editor_skin = "blue-metallic";   // If you want use a skin, add the name (of the folder) here
  </script>

  <!-- Load up the actual editor core -->
  <script type="text/javascript" src="../Xinha/XinhaCore.js"></script>

  <script type="text/javascript">
    xinha_editors = null;
    xinha_init    = null;
    xinha_config  = null;
    xinha_plugins = null;

    // This contains the names of textareas we will make into Xinha editors
    xinha_init = xinha_init ? xinha_init : function()
    {
      /** STEP 1 ***************************************************************
       * First, what are the plugins you will be using in the editors on this
       * page.  List all the plugins you will need, even if not all the editors
       * will use all the plugins.
       ************************************************************************/

      xinha_plugins = xinha_plugins ? xinha_plugins :
      [
        'CharacterMap', 'SpellChecker', 'Linker', 'ContextMenu'
      ];
             // THIS BIT OF JAVASCRIPT LOADS THE PLUGINS, NO TOUCHING  :)
             if(!Xinha.loadPlugins(xinha_plugins, xinha_init)) return;

      /** STEP 2 ***************************************************************
       * Now, what are the names of the textareas you will be turning into
       * editors?
       ************************************************************************/

      xinha_editors = xinha_editors ? xinha_editors :
      [
        'about'
      ];

      /** STEP 3 ***************************************************************
       * We create a default configuration to be used by all the editors.
       * If you wish to configure some of the editors differently this will be
       * done in step 4.
       *
       * If you want to modify the default config you might do something like this.
       *
       *   xinha_config = new Xinha.Config();
       *   xinha_config.width  = 640;
       *   xinha_config.height = 420;
       *
       *************************************************************************/

       xinha_config = xinha_config ? xinha_config : new Xinha.Config();
       xinha_config.fullPage = true;
       xinha_config.CharacterMap.mode = 'panel';
       xinha_config.ContextMenu.customHooks = { 'a': [ ['Label', function() { alert('Action'); }, 'Tooltip', '/xinha/images/ed_copy.gif' ] ] }
/*
       // We can load an external stylesheet like this - NOTE : YOU MUST GIVE AN ABSOLUTE URL
      //  otherwise it won't work!
      xinha_config.stylistLoadStylesheet(document.location.href.replace(/[^\/]*\.html/, 'files/stylist.css'));

      // Or we can load styles directly
      xinha_config.stylistLoadStyles('p.red_text { color:red }');

      // If you want to provide "friendly" names you can do so like
      // (you can do this for stylistLoadStylesheet as well)
      xinha_config.stylistLoadStyles('p.pink_text { color:pink }', {'p.pink_text' : 'Pretty Pink'});
*/
      /** STEP 3 ***************************************************************
       * We first create editors for the textareas.
       *
       * You can do this in two ways, either
       *
       *   xinha_editors   = Xinha.makeEditors(xinha_editors, xinha_config, xinha_plugins);
       *
       * if you want all the editor objects to use the same set of plugins, OR;
       *
       *   xinha_editors = Xinha.makeEditors(xinha_editors, xinha_config);
       *   xinha_editors['myTextArea'].registerPlugins(['Stylist']);
       *   xinha_editors['anotherOne'].registerPlugins(['CSS','SuperClean']);
       *
       * if you want to use a different set of plugins for one or more of the
       * editors.
       ************************************************************************/

      xinha_editors   = Xinha.makeEditors(xinha_editors, xinha_config, xinha_plugins);

      /** STEP 4 ***************************************************************
       * If you want to change the configuration variables of any of the
       * editors,  this is the place to do that, for example you might want to
       * change the width and height of one of the editors, like this...
       *
       *   xinha_editors.myTextArea.config.width  = 640;
       *   xinha_editors.myTextArea.config.height = 480;
       *
       ************************************************************************/


      /** STEP 5 ***************************************************************
       * Finally we "start" the editors, this turns the textareas into
       * Xinha editors.
       ************************************************************************/

      Xinha.startEditors(xinha_editors);
      window.onload = null;
    }

    window.onload   = xinha_init;
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
                                <table border="0" cellspacing="3" cellpadding="2">
                                  <tr>
                                    <td class="td-header">&nbsp;About Us</td>
                                  </tr>
                                  <tr>
                                    <td class="even"><textarea name="about" cols="45" rows="5" class="backend-tarea" id="about"><?php echo $row_Recordset1['Content']; ?></textarea></td>
                                  </tr>
                                  <tr>
                                    <td align="right" class="td-header"><div id="btn-padding">
                                      <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td><div id="bt-update">
                                            <input name="button2" type="submit" class="btn-update" id="button2" value="" />
                                          </div></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                  </tr>
                                </table>
                              </div></td>
                            </tr>
                          </table>
                        </form></td>
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
?>
