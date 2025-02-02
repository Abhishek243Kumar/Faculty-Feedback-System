<?php
error_reporting(1);
include('../dbconfig.php');
extract($_POST);
if (isset($save)) {
    if (strlen($mob) < 10 || strlen($mob) > 10) {
        $err = "<font color='red'>Mobile number must be 10 digits</font>";
    } else {
        // Generate user_alias from name and mobile (but not inserted into DB)
        $temp = substr($name, 0, 4);
        $temp1 = substr($mob, 0, 4);
        $user_name = $temp . $temp1;

        // Check if email already exists
        $q = mysqli_query($conn, "SELECT * FROM faculty WHERE email='$email'");
        $r = mysqli_num_rows($q);
        if ($r) {
            $err = "<font color='red'>This email already exists, choose a different email.</font>";
        } else {
            // Insert faculty into the database without user_name
            mysqli_query($conn, "INSERT INTO faculty (name, designation, programme, email, password, mobile, date, status) 
                                 VALUES ('$name', '$Designation', '$prg', '$email', '$pass', '$mob', NOW(), '0')");
            
            // Send welcome email
            $subject = "New User Account Creation";
            $from = "info@phptpoint.com";
            $message = "User name: " . $user_name . " Password: " . $pass;
            $headers = "From: " . $from;
            mail($email, $subject, $message, $headers);

            $err = "<font color='green'>New Faculty Successfully Added.</font>";
        }
    }
}
?>

<h1 class="page-header">Add Faculty</h1>
<div class="col-lg-8" style="margin:15px;">
    <form method="post">
        <div class="control-group form-group">
            <div class="controls">
                <label><?php echo @$err; ?></label>
            </div>
        </div>

        <div class="control-group form-group">
            <div class="controls">
                <label>Name:</label>
                <input type="text" value="<?php echo @$name; ?>" name="name" class="form-control" required>
            </div>
        </div>

        <div class="control-group form-group">
            <div class="controls">
                <label>Designation:</label>
                <input type="text" value="<?php echo @$Designation; ?>" name="Designation" class="form-control" required>
            </div>
        </div>

        <div class="control-group form-group">
            <div class="controls">
                <label>Email:</label>
                <input type="email" value="<?php echo @$email; ?>" name="email" class="form-control" required>
            </div>
        </div>

        <div class="control-group form-group">
            <div class="controls">
                <label>Password:</label>
                <input type="password" value="<?php echo @$pass; ?>" name="pass" class="form-control" required>
            </div>
        </div>

        <div class="control-group form-group">
            <div class="controls">
                <label>Programme:</label>
                <input type="text" name="prg" value="<?php echo @$prg; ?>" class="form-control" required>
            </div>
        </div>

        <div class="control-group form-group">
            <div class="controls">
                <label>Mobile Number:</label>
                <input type="number" id="mob" value="<?php echo @$mob; ?>" class="form-control" maxlength="10" name="mob" required>
            </div>
        </div>

        <div class="control-group form-group">
            <div class="controls">
                <input type="submit" class="btn btn-success" name="save" value="Add New Faculty">
            </div>
        </div>
    </form>
</div>
