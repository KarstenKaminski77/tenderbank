<html>
<head>
<title>ShotDev.Com Tutorial</title>
</head>
<body>
<?
	$Wrd = new COM("Word.Application");
	$Wrd->Application->Visible = False;
	$Wrd->Documents->Add();
	$DocName = "docs/MyWord.doc";

	//$strPath = realpath(basename(getenv($_SERVER["SCRIPT_NAME"]))); // C:/AppServ/www/myphp

	$Wrd->Selection->TypeText("Welcome To www.ShotDev.Com");
	
	//$Wrd->ActiveDocument->SaveAs($strPath."/".$DocName);
	$Wrd->ActiveDocument->SaveAs(realpath($DocName));
	$Wrd->Application->Quit;
	$Wrd = null;	
?>
Word Created <a href="<?=$DocName?>">Click here</a> to Download.
</body>
</html>
<!--- This file download from www.shotdev.com -->