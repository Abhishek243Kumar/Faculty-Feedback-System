<?php 
// session_start();
// include('../dbconfig.php');

extract($_POST);

if(isset($update)) {
    // Format date of birth
    $dob = $yy . "-" . $mm . "-" . $dd;

    // Concatenate hobbies as a string
    $hob = implode(",", $hob);

    // Update query with new fields for semester and Attendance
    $query = "UPDATE user SET 
                name='$n', 
                mobile='$mob', 
                gender='$gen', 
                hobbies='$hob', 
                dob='$dob', 
                semester='$sem', 
                attendance='$attendance' 
              WHERE email='" . $_SESSION['user'] . "'";

    mysqli_query($conn, $query);

    $err = "<font color='blue'>Profile updated successfully!</font>";
}

// Select old data for the form
$sql = mysqli_query($conn, "SELECT * FROM user WHERE email='" . $_SESSION['user'] . "'");
$res = mysqli_fetch_assoc($sql);
?>

<h2 align="center">Update Your Profile</h2>

<form method="post">
    <table class="table table-bordered">
        <tr>
            <td colspan="2"><?php echo @$err;?></td>
        </tr>

        <tr>
            <td>Enter Your Name</td>
            <td><input class="form-control" value="<?php echo $res['name'];?>" type="text" name="n"/></td>
        </tr>

        <tr>
            <td>Enter Your Email</td>
            <td><input class="form-control" type="email" readonly="true" value="<?php echo $res['email'];?>" name="e"/></td>
        </tr>

        <tr>
            <td>Enter Your Mobile</td>
            <td><input class="form-control" type="text" value="<?php echo $res['mobile'];?>" name="mob"/></td>
        </tr>

        <tr>
            <td>Select Your Gender</td>
            <td>
                Male <input type="radio" <?php if($res['gender']=="m"){echo "checked";} ?> name="gen" value="m"/>
                Female <input type="radio" <?php if($res['gender']=="f"){echo "checked";} ?> name="gen" value="f"/>
            </td>
        </tr>

        <tr>
            <td>Choose Your Hobbies</td>
            <td>
                <?php 
                $arrr = explode(",", $res['hobbies']);
                ?>

                Reading <input value="reading" <?php if(in_array("reading", $arrr)){echo "checked";} ?> type="checkbox" name="hob[]"/>
                Singing <input value="singing" <?php if(in_array("singing", $arrr)){echo "checked";} ?> type="checkbox" name="hob[]"/>
                Playing <input value="playing" <?php if(in_array("playing", $arrr)){echo "checked";} ?> type="checkbox" name="hob[]"/>
            </td>
        </tr>

        <tr>
            <td>Enter Your DOB</td>
            <?php 
            $arrr1 = explode("-", $res['dob']);
            ?>
            <td>
                <select class="form-control" style="width:100px;float:left" name="yy">
                    <option value="">Year</option>
                    <?php 
                    for($i = 1950; $i <= 2016; $i++) {
                        echo "<option " . ($arrr1[0] == $i ? "selected" : "") . ">$i</option>";
                    }
                    ?>
                </select>

                <select class="form-control" style="width:100px;float:left" name="mm">
                    <option value="">Month</option>
                    <?php 
                    for($i = 1; $i <= 12; $i++) {
                        echo "<option " . ($arrr1[1] == $i ? "selected" : "") . ">$i</option>";
                    }
                    ?>
                </select>

                <select class="form-control" style="width:100px;float:left" name="dd">
                    <option value="">Date</option>
                    <?php 
                    for($i = 1; $i <= 31; $i++) {
                        echo "<option " . ($arrr1[2] == $i ? "selected" : "") . ">$i</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Select Your Semester</td>
            <td>
                <select name="sem" class="form-control" required>
                    <option <?php if($res['semester']=="i"){echo "selected";} ?>>i</option>
                    <option <?php if($res['semester']=="ii"){echo "selected";} ?>>ii</option>
                    <option <?php if($res['semester']=="iii"){echo "selected";} ?>>iii</option>
                    <option <?php if($res['semester']=="iv"){echo "selected";} ?>>iv</option>
                    <option <?php if($res['semester']=="v"){echo "selected";} ?>>v</option>
                    <option <?php if($res['semester']=="vi"){echo "selected";} ?>>vi</option>
                    <option <?php if($res['semester']=="vii"){echo "selected";} ?>>vii</option>
                    <option <?php if($res['semester']=="viii"){echo "selected";} ?>>viii</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>Enter Your Attendance (%)</td> <!-- Updated Label -->
            <td><input class="form-control" type="text" value="<?php echo $res['attendance'];?>" name="attendance" required/></td> <!-- Updated Field -->
        </tr>

        <tr>
            <td colspan="2" align="center">
                <input type="submit" class="btn btn-default" value="Update My Profile" name="update"/>
                <input type="reset" class="btn btn-default" value="Reset"/>
            </td>
        </tr>
    </table>
</form>