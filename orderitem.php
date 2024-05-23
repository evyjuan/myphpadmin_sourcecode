<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrderItem</title>
</head>
<body>
<?php include('config/db.php'); ?>
<table>
    <thead>
        <tr>
            <th>OrderItemID</th>
            <th>OrderID</th>
            <th>ProductID</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $orderitem = "SELECT * FROM orderitem";
        $result = mysqli_query($conn, $orderitem) or die('error');

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><th>' . $row['OrderItemID'] . '</th><td>' . $row['OrderID'] . '</td><td>' . $row['ProductID'] . '</td><td>' . $row['Quantity'] . '</td></tr>';
        }
    ?>
    </tbody>
</table>

<form action="" method="post" autocomplete="off">
    <label for="OrderItemID">OrderItemID</label>
    <input type="text" name="OrderItemID" required value="">
    <label for="OrderID">OrderID</label>
    <input type="text" name="OrderID" required value="">
    <label for="ProductID">ProductID</label>
    <input type="text" name="ProductID" required value="">
    <label for="Quantity">Quantity</label>
    <input type="number" name="Quantity" required value="">
    <button name="submit">Submit</button>
</form>
<?php
if (isset($_POST['submit'])) {
    $OrderItemID = $_POST['OrderItemID'];
    $OrderID = $_POST['OrderID'];
    $ProductID = $_POST['ProductID'];
    $Quantity = $_POST['Quantity'];

    // Check if OrderID exists in the order table
    $checkOrderQuery = "SELECT * FROM `order` WHERE OrderID = '$OrderID'";
    $checkOrderResult = mysqli_query($conn, $checkOrderQuery);

    if (mysqli_num_rows($checkOrderResult) > 0) {
        // Check if OrderItemID is unique
        $checkOrderItemQuery = "SELECT * FROM orderitem WHERE OrderItemID = '$OrderItemID'";
        $checkOrderItemResult = mysqli_query($conn, $checkOrderItemQuery);

        if (mysqli_num_rows($checkOrderItemResult) == 0) {
            // Proceed with the order item insertion
            $setQuery = "INSERT INTO orderitem (OrderItemID, OrderID, ProductID, Quantity) VALUES ('$OrderItemID', '$OrderID', '$ProductID', '$Quantity')";
            if (mysqli_query($conn, $setQuery)) {
                echo '<script>alert("Successfully Added!");</script>';
            } else {
                echo '<script>alert("Error: ' . $setQuery . '<br>' . mysqli_error($conn) . '");</script>';
            }
        } else {
            // OrderItemID already exists, show an error message
            echo '<script>alert("Error: The specified OrderItemID already exists.");</script>';
        }
    } else {
        // OrderID does not exist, show an error message
        echo '<script>alert("Error: The specified OrderID does not exist.");</script>';
    }
}
?>
</body>
</html>
