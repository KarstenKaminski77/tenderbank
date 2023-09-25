<?php
require('html_table.php');

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

$html='<table border="1">
<tr>
<td width="200" height="30">cell 1</td><td width="400" height="30" bgcolor="#D0D0FF"><b><i>cell 2</i></b></td>
</tr>
<tr>
<td width="200" height="30">cell 3</td><td width="400" height="30">cell 4</td>
</tr>
</table>';

$pdf->WriteHTML($html);
$pdf->Output();
?>
