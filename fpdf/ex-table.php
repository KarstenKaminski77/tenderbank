<?php
require('html_table.php');

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

$html = '<table border="1">
<tr>
<td width="200" height="30" align="R">cell 1</td><td width="400" height="30" bgcolor="#D0D0FF">cell 2</td>
</tr>';
for($i=0;$i<=3;$i++){
$html .= '<tr>
<td width="200" height="30"><b><i>cell 3</i></b></td><td width="400" height="30">cell 4</td>
</tr>';
}
$html .= '<tr>
<td width="200" height="30"><b><i>cell 3</i></b></td><td width="400" height="30" bgcolor="#FF0000">cell 4</td>
</tr>
</table>';

$pdf->WriteHTML($html);
$pdf->Output();
?>