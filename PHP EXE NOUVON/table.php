<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No TABLE</title>
    <style>
        *{
            padding: 5px;
            margin: 5px;
            font-size: 20px;
            font-family: sans-serif;
        }
        table,td,th,tr{
            border: 3px solid black;
            border-collapse: collapse;
            width: 600px;
            height: 40px;
        }
        tr:nth-child(even) {
             background-color: gray;
        }

    </style>
</head>
<body>

    <table>
        <?php
        
          for ($i=1; $i <= 10; $i++) { 
            
            echo "<tr>";
                for ($j=1; $j <=10 ; $j++) { 
                    echo "<td>" .($i * $j). "</td>";
                }
            echo "</tr>";

          }

        ?>
    </table>


</body>
</html>