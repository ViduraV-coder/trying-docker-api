<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Items</title>
    </head>
    <body>

        <?php 
            $json = file_get_contents('http://nginx:3000/items/show');

            $someArray = json_decode($json, true);
            
            if(count($someArray) > 0){
                for($x = 0; $x < count($someArray); $x++){

                    echo "<p>";
                    echo "name: ";
                    echo $someArray[$x]["name"];
                    echo "<br>price: ";
                    echo $someArray[$x]["price"];
                    echo "<br>quantity: ";
                    echo $someArray[$x]["quantity"];
                    echo "</p>";
                }
            }           
        ?>
        <br><br>
    </body>
</html>