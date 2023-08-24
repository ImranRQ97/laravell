<?php
session_start();

// Check if the user is already logged in, if yes, redirect to the dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: edit.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Replace these with your actual database connection details
    $conn = new mysqli("localhost", "root", "", "phpcrudflp");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate and sanitize input (not shown here for brevity)

    // Query the database to check if the provided username exists and the password matches
    $sql = "SELECT id, `role` FROM tblusers WHERE Email = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["userrole"] = $row["role"];
        header("Location: edit.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>
