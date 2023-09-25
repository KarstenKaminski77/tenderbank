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

$sTxt3 = file_get_contents("content/multicell_text1.txt");
$oMulticell->multiCell(150, 6, "<h1>Examples:</h1>", 0, "L", 1);

/**
 * Alignments
 */
$oMulticell->multiCell(50, 6, "<h2>Alignments</h2>", 0, "L", 0);
$oMulticell->multiCell(50, 6, "align: <b>left</b>", 1, "L", 0);
$oMulticell->multiCell(50, 6, "align: <b>right</b>", 1, "R", 0);
$oMulticell->multiCell(50, 6, "align: <b>center</b>", 1, "C", 0);
$oMulticell->multiCell(50, 6, "align: <b>justified</b> this needs a longer text", 1, "J", 0);

$oPdf->Ln(5); //new line


/**
 * Justifications
 */
$oMulticell->multiCell(50, 6, "<h2>Justifications</h2>", 0, "J", 0);
$oMulticell->multiCell(100, 6, str_repeat("align: <b>justified</b> ", 10), 1, "J", 0);
$oPdf->Ln(5);
$oMulticell->multiCell(100, 6, $sTxt3, 1, "J", 0);

//full width
$oPdf->Ln(5);
$oMulticell->multiCell(0, 6, $sTxt3, 1, "J", 0);

$oPdf->Ln(5); //new line


/**
 * Paddings
 */
$oMulticell->multiCell(50, 6, "<h2>Paddings</h2>", 0, "J", 0);
$oMulticell->multiCell(0, 4, "Padding Left", 1, "L", 0, 5, 0, 0, 0);
$oMulticell->multiCell(0, 4, "Padding Top", 1, "L", 0, 0, 5, 0, 0);
$oMulticell->multiCell(0, 4, "Padding Right", 1, "R", 0, 0, 0, 5, 0);
$oMulticell->multiCell(0, 4, "Padding Bottom", 1, "L", 0, 0, 0, 0, 5);
$oMulticell->multiCell(0, 4, "Padding Left, Top, \n Right and Bottom", 1, "R", 0, 5, 5, 5, 5);

$oPdf->Ln(5); //new line


/**
 * Frames and colors
 */
$oMulticell->multiCell(50, 5, "<h2>Frames and colors</h2>", 0, "J", 0);
$oMulticell->multiCell(0, 4, $sTxt3, 0, "J", 0, 5, 5, 5, 5);
$oPdf->SetFillColor(0, 255, 0);
$oMulticell->multiCell(0, 4, $sTxt3, 1, "J", 1, 5, 5, 5, 5);

$oPdf->Ln(5); //new line


/**
 * Links
 */
$oMulticell->multiCell(50, 5, "<h2>Links</h2>", 0, "J", 0);
$oMulticell->multiCell(50, 5, "<a href='www.interpid.eu'>www.interpid.eu</a>", 0, "L", 0);
$oMulticell->multiCell(50, 5, "<h3 href='www.webdbadmin.com'>www.webdbadmin.com</h3>", 0, "L", 0);

$oPdf->Ln(5); //new line


// send the pdf to the browser
$oPdf->Output();
