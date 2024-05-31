<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHESSBOARD</title>
    <style>

        table{
            border-collapse: collapse;
        }
        td{
            width: 50px;
            height: 50px;
        }
        .black{
            background-color: black;
        }
        .white{
            background-color: white;
        }
    </style>
</head>
<body>
            <h1>PHP CHESSBOARD</h1>
        <table border = "3px solid black" width = "500px" height = "500px">
            <?php
            
                for ($row=0; $row <= 8; $row++) { 
                   echo "<tr>";

                     for ($col=0; $col <= 8; $col++) { 
                        $total = $row + $col;
                        if ($total % 2 == 0) {
                            echo "<td class = 'black' ></td>";
                        }else {
                            echo "<td class = 'white' ></td>";
                        }
                     }

                   echo "</tr>";
                }

            ?>
        </table>

</body>
</html>