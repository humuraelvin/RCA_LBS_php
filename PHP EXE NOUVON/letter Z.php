<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>letter Z</title>
</head>
<body>

        <?php

          
        for ($row = 0; $row < 7; $row++) {
            for ($col = 0; $col < 7; $col++) {
                if ($row == 0 || $row == 6 || $row + $col == 6) {
                    echo "*";
                } else {
                    echo "&nbsp; ";
                }
            }
            echo "<br>";
        }



        ?>        

</body>
</html>