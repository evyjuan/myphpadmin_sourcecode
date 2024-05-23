<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
</head>
<body>
<?php include('config/db.php'); ?>
<table>
    <thead>
        <tr>
            <th>OrderID</th>
            <th>CustomerID</th>
            <th>OrderDate</th>
            <th>TotalAmount</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $order = "SELECT * FROM `order`";
        $result = mysqli_query($conn, $order) or die('error');

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><th>' . $row['OrderID'] . '</th><td>' . $row['CustomerID'] . '</td><td>' . $row['OrderDate'] . '</td><td>' . $row['TotalAmount'] . '</td></tr>';
        }
    ?>
    </tbody>
</table>

<form action="" method="post" autocomplete="off">
    <label for="OrderID">OrderID</label>
    <input type="text" name="OrderID" required value="">
    <label for="CustomerID">CustomerID</label>
    <input type="text" name="CustomerID" required value="">
    <label for="OrderDate">OrderDate</label>
    <input type="text" name="OrderDate" required value="">
    <label for="TotalAmount">TotalAmount</label>
    <input type="text" name="TotalAmount" required value="">
    <button name="submit">Submit</button>
</form>
<?php
if (isset($_POST['submit'])) {
    $OrderID = $_POST['OrderID'];
    $CustomerID = $_POST['CustomerID'];
    $OrderDate = $_POST['OrderDate'];
    $TotalAmount = $_POST['TotalAmount'];

    // Check if CustomerID exists in the customer table
    $checkCustomerQuery = "SELECT * FROM customer WHERE CustomerID = '$CustomerID'";
    $checkCustomerResult = mysqli_query($conn, $checkCustomerQuery);

    if (mysqli_num_rows($checkCustomerResult) > 0) {
        // CustomerID exists, now check if OrderID already exists
        $checkOrderIDQuery = "SELECT * FROM `order` WHERE OrderID = '$OrderID'";
        $checkOrderIDResult = mysqli_query($conn, $checkOrderIDQuery);

        if (mysqli_num_rows($checkOrderIDResult) == 0) {
            // OrderID does not exist, proceed with the order insertion
            $setQuery = "INSERT INTO `order` (OrderID, CustomerID, OrderDate, TotalAmount) VALUES ('$OrderID', '$CustomerID', '$OrderDate', '$TotalAmount')";
            if (mysqli_query($conn, $setQuery)) {
                echo '<script>alert("Successfully Added!");</script>';
            } else {
                echo '<script>alert("Error: ' . $setQuery . '<br>' . mysqli_error($conn) . '");</script>';
            }
        } else {
            // OrderID already exists, show an error message
            echo '<script>alert("Error: The specified OrderID already exists.");</script>';
        }
    } else {
        // CustomerID does not exist, show an error message
        echo '<script>alert("Error: The specified CustomerID does not exist.");</script>';
    }
}
?>
</body>
</html>
