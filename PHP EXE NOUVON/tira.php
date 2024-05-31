<?php

for ($row=0; $row < 9; $row++) { 
    if ($row == 5) {
        $temp = $row;
        $temp - 2;
        $row = $temp;
    }else if ($row == 6) {
        $temp = $row;
        $temp - 4;
        $row = $temp;
    }else if ($row == 7) {
        $temp = $row;
        $temp - 6;
        $row = $temp;
    }else if ($row == 8) {
        $temp = $row;
        $temp - 8;
        $row = $temp;
    }

    for ($col=0; $col < 5; $col++) { 
        if ($row >= $col) {
            echo "*";
        }else {
            echo " ";
        }
    }
    echo "<br>";

}

?>