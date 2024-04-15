<?php
// Azure SQL connection details
$serverName = "thoratserver.database.windows.net";
$connectionOptions = array(
    "Database" => "pratishdb",
    "Uid" => "thoratuser",
    "PWD" => "Madhavi@123456"
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

// Get and sanitize form data
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$number = htmlspecialchars($_POST['number']);
$address = htmlspecialchars($_POST['address']);
$color = htmlspecialchars($_POST['color']);
$date = date('Y-m-d', strtotime($_POST['date'])); // Adjust date format as needed
$time = date('H:i:s', strtotime($_POST['time'])); // Adjust time format as needed

// Insert data into Azure SQL
$tsql = "INSERT INTO Users (name, email, number, address, color, date, time) VALUES (?, ?, ?, ?, ?, ?, ?)";
$params = array($name, $email, $number, $address, $color, $date, $time);
$stmt = sqlsrv_query($conn, $tsql, $params);

if ($stmt === false) {
    die("Insertion failed: " . print_r(sqlsrv_errors(), true));
}

echo "Data submitted successfully";

// Close the connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
