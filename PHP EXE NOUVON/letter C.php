<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LETTER C</title>
</head>
<body>

        

        <?php
            for ($row=0; $row< 7; $row++) { 
                for ($col=0; $col < 5; $col++) { 
                    if (($row == 0 || $row == 6) && ($col != 0 && $col != 4)) {
                        echo "*";
                    }
                    elseif (($col == 0) && ($row != 0 && $row != 6)) {
                        echo "*";
                    }
                    elseif (($col == 4) && ($row == 1 || $row == 5)) {
                        echo "*";
                    }
                    else {
                        echo "&nbsp;";
                    }
                }
                echo "<br>";
            }
        ?> 


</body>
</html>