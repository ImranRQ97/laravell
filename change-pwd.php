<?php
session_start();

// Database Connection
include('connect.php');

if (isset($_SESSION['user_id'])) {

	$eid = $_SESSION['user_id'];

} else {

	header("Location: login.php");
	exit();
}

if (isset($_POST['submit'])) {
	$userId = $_SESSION['user_id'];
	$oldPassword = $_POST['old_password'];
	$newPassword = $_POST['new_password'];
	$confirmPassword = $_POST['confirm_password'];

	// Verify old password
	$sql = "SELECT Password FROM tblusers WHERE ID='$userId'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
	$storedPassword = $row['Password'];

	if ($oldPassword !== $storedPassword) {
		echo "<script>alert('Old password is incorrect.');</script>";
		echo "<script type='text/javascript'>document.location ='change-pwd.php';</script>";
		exit();
	}

	// Perform password validation
	if ($newPassword !== $confirmPassword) {
		echo "<script>alert('New password and confirm password do not match. Please try again.');</script>";
		echo "<script type='text/javascript'>document.location ='change-pwd.php';</script>";
		exit();
	}

    // Update the password in the database (plain text)
    $updateSql = "UPDATE tblusers SET Password='$newPassword' WHERE ID='$userId'";
    $updateQuery = mysqli_query($con, $updateSql);

    if ($updateQuery) {
        echo "<script>alert('Password changed successfully.');</script>";
        echo "<script type='text/javascript'>document.location ='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
        echo "<script type='text/javascript'>document.location ='change-pwd.php';</script>";
        exit();
    }
}
?>
<title> Change Password </title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
	body {
		color: #566787;
		background: #f5f5f5;
		font-family: 'Roboto', sans-serif;
	}

	.table-responsive {
		margin: 30px 0;
	}

	.table-wrapper {
		min-width: 1000px;
		background: #fff;
		padding: 20px;
		box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
	}

	.table-title {
		font-size: 15px;
		padding-bottom: 10px;
		margin: 0 0 10px;
		min-height: 45px;
	}

	.table-title h2 {
		margin: 5px 0 0;
		font-size: 24px;
	}

	.table-title select {
		border-color: #ddd;
		border-width: 0 0 1px 0;
		padding: 3px 10px 3px 5px;
		margin: 0 5px;
	}

	.table-title .show-entries {
		margin-top: 7px;
	}

	.search-box {
		position: relative;
		float: right;
	}

	.search-box .input-group {
		min-width: 200px;
		position: absolute;
		right: 0;
	}

	.search-box .input-group-addon,
	.search-box input {
		border-color: #ddd;
		border-radius: 0;
	}

	.search-box .input-group-addon {
		border: none;
		border: none;
		background: transparent;
		position: absolute;
		z-index: 9;
	}

	.search-box input {
		height: 34px;
		padding-left: 28px;
		box-shadow: none !important;
		border-width: 0 0 1px 0;
	}

	.search-box input:focus {
		border-color: #3FBAE4;
	}

	.search-box i {
		color: #a0a5b1;
		font-size: 19px;
		position: relative;
		top: 8px;
	}

	table.table tr th,
	table.table tr td {
		border-color: #e9e9e9;
	}

	table.table th i {
		font-size: 13px;
		margin: 0 5px;
		cursor: pointer;
	}

	table.table td:last-child {
		width: 130px;
	}

	table.table td a {
		color: #a0a5b1;
		display: inline-block;
		margin: 0 5px;
	}

	table.table td a.view {
		color: #03A9F4;
	}

	table.table td a.edit {
		color: #FFC107;
	}

	table.table td a.delete {
		color: #E34724;
	}

	table.table td i {
		font-size: 19px;
	}

	.pagination {
		float: right;
		margin: 0 0 5px;
	}

	.pagination li a {
		border: none;
		font-size: 13px;
		min-width: 30px;
		min-height: 30px;
		padding: 0 10px;
		color: #999;
		margin: 0 2px;
		line-height: 30px;
		border-radius: 30px !important;
		text-align: center;
	}

	.pagination li a:hover {
		color: #666;
	}

	.pagination li.active a {
		background: #03A9F4;
	}

	.pagination li.active a:hover {
		background: #0397d6;
	}

	.pagination li.disabled i {
		color: #ccc;
	}

	.pagination li i {
		font-size: 16px;
		padding-top: 6px
	}

	.hint-text {
		float: left;
		margin-top: 10px;
		font-size: 13px;
	}
</style>
</head>

<body>
	<div class="container">
		<div class="change-pwd-form">
			<h2>Change Password</h2>
			<form method="POST">
				<div class="form-group">
					<label for="old_password">Old Password</label>
					<input type="password" id="old_password" name="old_password" required>
				</div>
				<div class="form-group">
					<label for="new_password">New Password</label>
					<input type="password" id="new_password" name="new_password" required>
				</div>
				<div class="form-group">
					<label for="confirm_password">Confirm Password</label>
					<input type="password" id="confirm_password" name="confirm_password" required>
				</div>
				<div class="form-group">
					<button type="submit" name="submit">Change Password</button>
				</div>
			</form>
		</div>
	</div>
</body>

</html>