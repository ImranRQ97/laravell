<?php
session_start();
// Establish database connection
$conn = new mysqli("localhost", "root", "", "jqcrudop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate and sanitize input (not shown here for brevity)

    $sql = "SELECT id, user_login FROM user_login  WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["id"];
        header("Location: Dash.php");
    } else {
        $error = "Invalid username or password";
    }
}

$conn->close();
?>
