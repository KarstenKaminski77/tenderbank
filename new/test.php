
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Styling file upload input box in css - demo</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
#divinputfile{
	height:25px;
	width:385px;
	margin:0px;
	background-image: url(images/upload.png);
	background-repeat: no-repeat;
	background-position: 100% 1px;
}

#divinputfile #filepc{
	opacity: 0.0;
	-moz-opacity: 0.0;
	filter: alpha(opacity=00);
	font-size:18px;
}

#fakeinputfile{
	margin-top:-28px;
}

#fakeinputfile #fakefilepc{
	width:265px;
	height:25px;
	font-size:18px;
	font-family:Arial;
}

</style>
</head>

<body>


<h1>Styling File Input Box in CSS Demo</h1>

<p>

<form name="form1" method="post" action="#">
<div id="divinputfile">
	<input name="filepc" type="file" size="30" id="filepc" onchange="document.getElementById('fakefilepc').value = this.value;"/>
	<div id="fakeinputfile"><input name="fakefilepc" type="text" id="fakefilepc" /></div>
</div>
</form>

</p>
<p>by <a href="http://www.burhankhan.com/">Burhan Khan</a></p>

</body>
</html>