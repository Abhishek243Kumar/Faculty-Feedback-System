<?php
session_start();
include('dbconfig.php');

if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    // Check if new password and confirm password match
    if ($new_pass !== $confirm_pass) {
        $error = "Passwords do not match.";
    } else {
        // Hash the new password
        $hashed_pass = md5($new_pass);
        
        // Update the new password in the database
        $sql = mysqli_query($conn, "UPDATE user SET pass='$hashed_pass' WHERE email='$email'");

        if ($sql) {
            $msg = "Your password has been updated successfully. You can now log in.";
            // Optionally redirect to login page or send a success message
            header("Location: index.php"); // Redirecting to login page
            exit();
        } else {
            $error = "Failed to update password. Please try again.";
        }
    }
}

// Get the email from the query parameter
$email = isset($_GET['email']) ? $_GET['email'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <title>Reset Password</title>
    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 400px;
            margin-top: 100px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
            color: #555;
        }

        .form-control {
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .text-danger {
            text-align: center;
            margin-top: 10px;
        }

        .text-success {
            text-align: center;
            margin-top: 10px;
            color: #28a745;
        }
    </style>
</head>
<body>

<center><div class="container">
    <h2>Set New Password</h2>
    <form method="post">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" />
        <div class="form-group">
            <label for="new_pass">Enter New Password:</label>
            <input type="password" name="new_pass" class="form-control" required />
        </div>
        <div class="form-group">
            <label for="confirm_pass">Confirm New Password:</label>
            <input type="password" name="confirm_pass" class="form-control" required />
        </div>
        <input type="submit" name="update" value="Update Password" class="btn btn-primary" />
        <div class="text-danger"><?php echo @$error; ?></div>
        <div class="text-success"><?php echo @$msg; ?></div>
    </form>
</div></center>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
