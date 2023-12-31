<?php

$nColumns = 3;

//Initialize the table class, 3 columns
$oTable->initialize(array(40, 50, 30));

$aHeader = array();

//Table Header
for ($i = 0; $i < $nColumns; $i ++) {
    $aHeader[$i]['TEXT'] = "Header #" . ($i + 1);
}

//add the header
$oTable->addHeader($aHeader);

for ($j = 1; $j < 5; $j ++) {
    $aRow = Array();
    $aRow[0]['TEXT'] = "Line $j Text 1"; //text for column 0
    $aRow[0]['TEXT_ALIGN'] = "L"; //text align
    $aRow[1]['TEXT'] = "Line $j Text 2"; //text for column 1
    $aRow[2]['TEXT'] = "Line $j Text 3"; //text for column 2
    $aRow[2]['TEXT_ALIGN'] = "R"; //text align
    

    //add the row
    $oTable->addRow($aRow);
}

//close the table
$oTable->close();
    
