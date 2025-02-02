<form method="post">
<table class="table table-hover">
<tr>
    <th>Select Faculty</th>
    <td>
        <select name="faculty" class="form-control">
            <?php
            $sql = mysqli_query($conn, "select * from faculty");
            while ($r = mysqli_fetch_array($sql)) {
                echo "<option value='" . $r['email'] . "'>" . $r['Name'] . "</option>";
            }
            ?>
        </select>
    </td>
    <td><input name="sub" type="submit" value="Check Average" class="btn btn-success"/></td>
</tr>
</table>
</form>
<hr style="border:1px solid red"/>

<?php
if (isset($_POST['sub'])) {
    $faculty = $_POST['faculty'];

    // Initialize variables to store counts
    $stongly_agree = $agree = $neutral = $disagree = $strongly_disagree = 0;
    $stongly_agree1 = $agree1 = $neutral1 = $disagree1 = $strongly_disagree1 = 0;
    $count = 0;

    // Count total votes
    $r = mysqli_query($conn, "select * from feedback where faculty_id='$faculty'");
    $c = mysqli_num_rows($r);
    echo "<h4>Total Student Attempts: " . $c . "</h4>";

    // Question 1 processing
    $q = mysqli_query($conn, "select * from feedback where faculty_id='$faculty'");
    while ($res = mysqli_fetch_array($q)) {
        switch ((int)$res[3]) {
            case 5:
                $stongly_agree++;
                break;
            case 4:
                $agree++;
                break;
            case 3:
                $neutral++;
                break;
            case 2:
                $disagree++;
                break;
            case 1:
                $strongly_disagree++;
                break;
        }
    }

    // Question 2 processing
    $q2 = mysqli_query($conn, "select * from feedback where faculty_id='$faculty'");
    while ($res = mysqli_fetch_array($q2)) {
        switch ((int)$res[4]) {
            case 5:
                $stongly_agree1++;
                break;
            case 4:
                $agree1++;
                break;
            case 3:
                $neutral1++;
                break;
            case 2:
                $disagree1++;
                break;
            case 1:
                $strongly_disagree1++;
                break;
        }
    }

    // Sum counts from both questions
    $t = $stongly_agree + $stongly_agree1;
    echo "<h4>Total Strongly Agree Responses (Q1 + Q2): $t</h4>";

    // Summing up feedback scores for all questions
    $q = mysqli_query($conn, "select * from feedback where faculty_id='$faculty'");
    while ($res = mysqli_fetch_array($q)) {
        for ($i = 3; $i <= 15; $i++) {
            $count += (int)$res[$i];
        }
    }
    echo "<h4>Total Feedback Score: $count</h4>";
}
?>