<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>
<body>
<?php include('config/db.php'); ?>
<table>
    <thead>
        <tr>
            <th>ProductID</th>
            <th>ProductName</th>
            <th>Price</th>
            <th>StockQuantity</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $product = "SELECT * FROM product";
        $result = mysqli_query($conn, $product) or die('error');

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><th>' . $row['ProductID'] . '</th><td>' . $row['ProductName'] . '</td><td>' . $row['Price'] . '</td><td>' . $row['StockQuantity'] . '</td></tr>';
        }
    ?>
    </tbody>
</table>
<form action="" method="post" autocomplete="off">
    <label for="">ProductID</label>
    <input autocomplete="off" type="text" name="ProductID" required>
    <label for="">ProductName</label>
    <input autocomplete="off" type="text" name="ProductName" required>
    <label for="">Price</label>
    <input autocomplete="off" type="text" name="Price" required>
    <label for="">StockQuantity</label>
    <input autocomplete="off" type="number" name="StockQuantity" required>
    <button name="submit">Submit</button>
</form>
<?php
if (isset($_POST['submit'])) {
    $ProductID = $_POST['ProductID'];
    $ProductName = $_POST['ProductName'];
    $Price = $_POST['Price'];
    $StockQuantity = $_POST['StockQuantity'];

    // Check if ProductID already exists
    $checkQuery = "SELECT * FROM product WHERE ProductID = '$ProductID'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo '<script>alert("Error: ProductID already exists.");</script>';
    } else {
        // Insert into database
        $setQuery = "INSERT INTO product (ProductID, ProductName, Price, StockQuantity) VALUES ('$ProductID', '$ProductName', '$Price', '$StockQuantity')";
        if (mysqli_query($conn, $setQuery)) {
            echo '<script>alert("Successfully Added!");</script>';
        } else {
            echo '<script>alert("Error: ' . $setQuery . '<br>' . mysqli_error($conn) . '");</script>';
        }
    }
}
?>
</body>
</html>
