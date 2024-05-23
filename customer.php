<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
</head>
<body>
<?php include('config/db.php'); ?>
<table>
    <thead>
        <tr>
            <th>CustomerID</th>
            <th>AddressID</th>
            <th>FirstName</th>
            <th>LastName</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $customer = "SELECT * FROM customer";
        $result = mysqli_query($conn, $customer) or die('error');

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><th>' . $row['CustomerID'] . '</th><td>' . $row['AddressID'] . '</td><td>' . $row['FirstName'] . '</td><td>' . $row['LastName'] . '</td></tr>';
        }
    ?>
    </tbody>
</table>

<form action="" method="post" autocomplete="off">
    <label for="CustomerID">CustomerID</label>
    <input type="text" name="CustomerID" required value="">
    <label for="AddressID">AddressID</label>
    <input type="text" name="AddressID" required value="">
    <label for="FirstName">FirstName</label>
    <input type="text" name="FirstName" required value="">
    <label for="LastName">LastName</label>
    <input type="text" name="LastName" required value="">
    <button name="submit">Submit</button>
</form>
<?php
if (isset($_POST['submit'])) {
    $CustomerID = $_POST['CustomerID'];
    $AddressID = $_POST['AddressID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];

    // Check if CustomerID exists in the customer table
    $checkCustomerQuery = "SELECT * FROM customer WHERE CustomerID = '$CustomerID'";
    $checkCustomerResult = mysqli_query($conn, $checkCustomerQuery);

    if (mysqli_num_rows($checkCustomerResult) > 0) {
        // CustomerID already exists, show an error message
        echo '<script>alert("Error: CustomerID already exists.");</script>';
    } else {
        // Check if AddressID exists in the address table
        $checkAddressQuery = "SELECT * FROM address WHERE AddressID = '$AddressID'";
        $checkAddressResult = mysqli_query($conn, $checkAddressQuery);

        if (mysqli_num_rows($checkAddressResult) > 0) {
            // AddressID exists, proceed with the customer insertion
            $setQuery = "INSERT INTO customer (CustomerID, AddressID, FirstName, LastName) VALUES ('$CustomerID', '$AddressID', '$FirstName', '$LastName')";
            if (mysqli_query($conn, $setQuery)) {
                echo '<script>alert("Successfully Added!");</script>';
            } else {
                echo '<script>alert("Error: ' . $setQuery . '<br>' . mysqli_error($conn) . '");</script>';
            }
        } else {
            // AddressID does not exist, show an error message
            echo '<script>alert("Error: The specified AddressID does not exist.");</script>';
        }
    }
}
?>
</body>
</html>
