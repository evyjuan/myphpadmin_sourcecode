<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Cache-Control" content="no-store">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address</title>
</head>
<body>
<?php include('config/db.php'); ?>
<table>
    <thead>
        <tr>
            <th>AddressID</th>
            <th>Street</th>
            <th>City</th>
            <th>ZipCode</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $address = "SELECT * FROM address";
        $result = mysqli_query($conn, $address) or die('error');

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><th>' . $row['AddressID'] . '</th><td>' . $row['Street'] . '</td><td>' . $row['City'] . '</td><td>' . $row['ZipCode'] . '</td></tr>';
        }
    ?>
    </tbody>
</table>
<form id="addressForm" action="" method="post">
    <label for="AddressID">AddressID</label>
    <input autocomplete="off" type="text" name="AddressID" required>
    <label for="Street">Street</label>
    <input autocomplete="off" type="text" name="Street" required>
    <label for="City">City</label>
    <input autocomplete="off" type="text" name="City" required>
    <label for="ZipCode">ZipCode</label>
    <input autocomplete="off" type="text" name="ZipCode" required>
    <button name="submit">Submit</button>
</form>
<?php
if (isset($_POST['submit'])) {
    $AddressID = $_POST['AddressID'];
    $Street = $_POST['Street'];
    $City = $_POST['City'];
    $ZipCode = $_POST['ZipCode'];

    // Check if AddressID already exists
    $checkQuery = "SELECT * FROM address WHERE AddressID = '$AddressID'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo '<script>alert("Error: AddressID already exists.");</script>';
    } else {
        // Insert into database
        $setQuery = "INSERT INTO address (AddressID, Street, City, ZipCode) VALUES ('$AddressID', '$Street', '$City', '$ZipCode')";
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
