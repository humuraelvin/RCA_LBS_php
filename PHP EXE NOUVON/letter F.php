<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LETTER F</title>
</head>
<body>

        <?php
        
            for ($row=0; $row < 7; $row++) { 
                for ($col=0; $col < 5; $col++) { 
                    if ($row == 0 || $col == 0) {
                        echo "*";
                    }
                    elseif ($row == 3 && $col < 4) {
                        echo "*";
                    }
                    else {
                        echo " ";
                    }
                }
                echo "<br>";
            }

        ?>

</body>
</html>