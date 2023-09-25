<?php
/**
* FPDF Advanced Multicell UTF8 - Example
* Copyright (c) 2005-2012, Andrei Bintintan, http://www.interpid.eu
*/

//include pdf class
require_once ("tfpdf.php");

// Include the Advanced Multicell Class
require_once ("classes/tfpdfmulticell.php");

/**
 * Include my Custom PDF class This is required only to overwrite the header
 */
require_once ("mypdf-multicell.php");

// create new PDF document
$oPdf = new myPDF();

$oPdf->Open();

//add the required fonts
$oPdf->AddFont('dejavusans', '', 'DejaVuSans.ttf', true);
$oPdf->AddFont('dejavusans', 'B', 'DejaVuSans-Bold.ttf', true);
$oPdf->AddFont('dejavusans', 'I', 'DejaVuSans-Oblique.ttf', true);
$oPdf->AddFont('dejavusans', 'BI', 'DejaVuSans-BoldOblique.ttf', true);
$oPdf->AddFont('dejavuserif', '', 'DejaVuSerif.ttf', true);
$oPdf->AddFont('dejavuserif', 'B', 'DejaVuSerif-Bold.ttf', true);
$oPdf->AddFont('dejavuserif', 'BI', 'DejaVuSerif-BoldItalic.ttf', true);

$oPdf->SetMargins(20, 20, 20);

//set default font/colors
$oPdf->SetFont('dejavusans', '', 11);
$oPdf->SetTextColor(200, 10, 10);
$oPdf->SetFillColor(254, 255, 245);

//add the page
$oPdf->AddPage();
$oPdf->AliasNbPages();

/**
 * Create the Advanced Multicell Object and pass the PDF object as a parameter to the constructor
 */
$oMulticell = new TfpdfMulticell($oPdf);

/**
 * Set the styles for the advanced multicell
 */
$oMulticell->SetStyle("p", "dejavusans", "", 11, "130,0,30");
$oMulticell->SetStyle("b", "dejavusans", "B",  11, "130,0,30");
$oMulticell->setStyle("i", "dejavusans", "I", 11, "80,80,260");
$oMulticell->setStyle("u", "dejavusans", "U", 11, "80,80,260");
$oMulticell->SetStyle("h1", "dejavusans", "", 11, "80,80,260");
$oMulticell->SetStyle("h3", "dejavuserif",  "B",  12, "203,0,48");
$oMulticell->SetStyle("h4", "dejavusans", "BI", 11, "0,151,200");
$oMulticell->SetStyle("hh", "dejavuserif",  "B",  11, "255,189,12");
$oMulticell->SetStyle("ss", "dejavusans", "", 7,  "203,0,48");
$oMulticell->SetStyle("font", "dejavusans", "", 10, "0,0,255");
$oMulticell->SetStyle("style", "dejavusans", "BI", 10, "0,0,220");
$oMulticell->SetStyle("size", "dejavuserif",  "BI", 12, "0,0,120");
$oMulticell->SetStyle("color", "dejavuserif",  "BI", 12, "0,255,255");

//read TAG formatted text from files
$sTxt1 = file_get_contents('content/createdby.txt');
$sTxt2 = file_get_contents('content/multicell.txt');

//create an advanced multicell
$oMulticell->multiCell(150, 5, $sTxt1, 1, "L", 1, 5, 5, 5, 5); 
$oPdf->Ln(10); //new line


$s = $sTxt2 . "\n\n\n\n\nRepeat the text to trigger a page break \n\n\n" . $sTxt2;

//create an advanced multicell
$oMulticell->multiCell(0, 5, $s, 1, "J", 1, 3, 3, 3, 3); 
$oPdf->Ln(10);   //new line

//send the pdf to the browser
$oPdf->Output();