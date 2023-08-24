<?php
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

// Fetch user-specific data from the database using the $_SESSION["user_id"] variable

// Replace these with your actual database connection details
$conn = new mysqli("localhost", "root", "", "phpcrudflp");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT username, email FROM tblusers WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $username = $row["username"];
    $email = $row["email"];
} else {
    // Handle the case where user data is not found
    $username = "Unknown";
    $email = "Unknown";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <p>Your email: <?php echo $email; ?></p>
    <p>This is your dashboard. You can display user-specific actions or information here.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
