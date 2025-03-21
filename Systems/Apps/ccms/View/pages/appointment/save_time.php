<?php
$servername = "localhost";
$username = "root";  // Change this if needed
$password = "";      // Change this if needed
$dbname = "cclinic";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookedTime = $_POST["a_bookedTime"];

    // Convert to MySQL DATETIME format
    $date = date("Y-m-d");
    $timeFormatted = date("H:i:s", strtotime($bookedTime));
    $datetime = $date . " " . $timeFormatted;

    $sql = "INSERT INTO appointments VALUES ('$datetime')";

    if ($conn->query($sql) === TRUE) {
        echo "Time booked successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
