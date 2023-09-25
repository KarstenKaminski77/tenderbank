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
$oMulticell->SetStyle("b", "dejavusans", "B",  11, "130,0,30");

$sTxt = "This is a demo of <b>NON BREAKING > S P>A C E EXAMPLE</b>";

//create an advanced multicell
$oMulticell->multiCell(0, 5, "Default line breaking characters:  ,.:;", 0); 
$oMulticell->multiCell(100, 5, $sTxt, 1); 
$oPdf->Ln(10); //new line

//create an advanced multicell
$oMulticell->multiCell(0, 5, "Setting > as line breaking character", 0); 
$oMulticell->setLineBreakingCharacters(">");
$oMulticell->multiCell(100, 5, $sTxt, 1); 
$oPdf->Ln(10); //new line


//create an advanced multicell
$oMulticell->multiCell(0, 5, "Reseting the line breaking characters", 0); 
$oMulticell->resetLineBreakingCharacters();
$oMulticell->multiCell(100, 5, $sTxt, 1); 
$oPdf->Ln(10); //new line


//send the pdf to the browser
$oPdf->Output();