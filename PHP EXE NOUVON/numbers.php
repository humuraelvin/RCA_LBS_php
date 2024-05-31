<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUMBERS</title>
    <style>
        *{
            margin: 5px;
            padding: 5px;
            font-family: sans-serif;
            font-size: 20px;
        }
    </style>
</head>
<body>

        <?php
        
          for ($i=00; $i <=100 ; $i++) { 
       
            echo sprintf("%02d", $i);
            if ($i <=99) {
                echo ", ";
            }

          }

        ?>

</body>
</html>