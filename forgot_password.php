<?php
session_start();
include('dbconfig.php');

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $dob = $_POST['yy'] . '-' . str_pad($_POST['mm'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($_POST['dd'], 2, '0', STR_PAD_LEFT);

    // Query to check if the email and DOB match
    $sql = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' AND dob='$dob'");
    $row = mysqli_fetch_assoc($sql);

    if ($row) {
        // If user exists, redirect to reset password page
        header("Location: reset_password.php?email=$email");
        exit();
    } else {
        $error = "Invalid email or date of birth.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <title>Forgot Password</title>
    <style>
        body {
            background-color: paleturquoise;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            margin-top: 200px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
            width: 200px;
            color: #555;
        }
        .form-group input {
            /* font-weight: bold; */
            width: 200px;
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
            width: 150px;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: bold;
        }

        .btn:hover {
            background-color: green; 
            /* #0056b3 */
        }

        .text-danger {
            text-align: center;
            margin-top: 10px;
            color: #dc3545;
        }

        .text-success {
            text-align: center;
            margin-top: 10px;
            color: #28a745;
        }

        table {
            width: 100%;
        }

        table td {
            padding: 10px;
        }

        @media (max-width: 480px) {
            .container {
                margin: 20px;
                padding: 15px;
            }

            h2 {
                font-size: 1.5rem;
            }

            .btn {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
<center>
<div class="container">
    <h2>Reset Password</h2>
    <form method="post">
        <table>
            <tr>
                <td>
                    <div class="form-group">
                        <label for="email">Enter Your Email:</label>
                        <!-- <input type="email" name="email" class="form-control" required /> -->
                    </div>
                </td>
                <td>
            
                        <!-- <label for="email">Enter Your Email:</label> -->
                        <input type="email" name="email" class="form-control" width="200px" required />
                    

                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <label for="dob">Enter Your Date of Birth:</label>
                    </div>
                </td>
                <td>
                <div class="form-group">
                        <div>
                            <select style="width:50px; float:left; margin-right:5px;" name="yy" class="form-control" required>
                                <option value="">Year</option>
                                <?php
                                for ($i = 1950; $i <= 2016; $i++) {
                                    echo "<option>" . $i . "</option>";
                                }
                                ?>
                            </select>
                            <select style="width:60px; float:left; margin-right:5px;" name="mm" class="form-control" required>
                                <option value="">Month</option>
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    echo "<option>" . $i . "</option>";
                                }
                                ?>
                            </select>
                            <select style="width:50px; float:left;" name="dd" class="form-control" required>
                                <option value="">Date</option>
                                <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    echo "<option>" . $i . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </td>
            </tr>
            
                   
              
        </table>
        <input type="submit" name="reset" value="Reset" class="btn btn-primary" />
        <div class="text-danger"><?php echo @$error; ?></div>
        <div class="text-success"><?php echo @$msg; ?></div>
    </form>
</div>
</center>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
