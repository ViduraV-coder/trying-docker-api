<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $json = file_get_contents('http://adminapi:6000/items/show');

            $someArray = json_decode($json, true);

            if (count($someArray) > 0) {
                for ($x = 0; $x < count($someArray); $x++) {

                    echo "<tr><td>";
                    echo $someArray[$x]["name"];
                    echo "</td><td>";
                    echo $someArray[$x]["price"];
                    echo "</td><td>";
                    echo $someArray[$x]["quantity"];
                    echo "</td><td>";
                    echo "<a href='index.php?delete=" . $someArray[$x]["id"] . "'>DELETE</a>";
                    echo "</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <br><br>
    <form action="index.php" method="POST">
        <input type="text" value="" placeholder="Name" name="name" id="name">&nbsp;&nbsp;&nbsp;
        <input type="text" value="" placeholder="Price" name="price" id="price">&nbsp;&nbsp;&nbsp;
        <input type="text" value="" placeholder="Quantity" name="quantity" id="quantity"><br><br>
        <input type="submit" value="click" name="submit">
    </form>
</body>

</html>

<?php
function display()
{
    $input_name = (array_key_exists('name', $_POST)) ? $_POST['name'] : "";
    $input_price = (array_key_exists('price', $_POST)) ? $_POST['price'] : "";
    $input_quantity = (array_key_exists('quantity', $_POST)) ? $_POST['quantity'] : "";

    $data = array(
        'name'     => $input_name,
        'price'    => $input_price,
        'quantity' => $input_quantity
    );

    $options = array(
        'http' => array(
            'method'  => 'POST',
            'content' => json_encode($data),
            'header' =>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
        )
    );

    $url = "http://adminapi:6000/items/create";
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
}

function delete()
{
    $id = $_GET['delete'];
    $opt = array(
        'http' => array(
            'method'  => "DELETE",
            'header' =>  "Accept: application/json\r\n"
        )
    );
    $url = "http://adminapi:6000/items/discard/" . $id;
    $context  = stream_context_create($opt);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
}

if (isset($_POST['submit'])) {
    display();
    echo ("<meta http-equiv='refresh' content='0'>");
}

if (isset($_GET['delete'])) {
    delete();
    echo "<script type='text/javascript'>";
    echo "window.location.href = 'http://localhost:81/index.php';";
    echo "</script>";
}
?>