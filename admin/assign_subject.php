<?php
// Include necessary files
include('../dbconfig.php');

// Fetch all faculties and subjects from the database
$faculty_query = "SELECT * FROM faculty";
$faculty_result = mysqli_query($conn, $faculty_query);

$subject_query = "SELECT * FROM subjects";
$subject_result = mysqli_query($conn, $subject_query);

// Handle form submission
if (isset($_POST['submit'])) {
    // Retrieve the faculty_id and subject_id from the form submission
    $faculty_id = $_POST['faculty_id'];
    $subject_id = $_POST['subject_id'];

    // Check if the subject is already assigned to the faculty
    $check_query = "SELECT * FROM faculty_subjects WHERE faculty_id = '$faculty_id' AND subject_id = '$subject_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If the subject is already assigned to the faculty, show an error message
        echo "<div class='alert alert-danger'>This subject is already assigned to the selected faculty.</div>";
    } else {
        // If not assigned, insert into the faculty_subjects table
        $insert_query = "INSERT INTO faculty_subjects (faculty_id, subject_id) VALUES ('$faculty_id', '$subject_id')";
        if (mysqli_query($conn, $insert_query)) {
            echo "<div class='alert alert-success'>Subject assigned successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error assigning subject: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<div class="container">
    <h2>Assign Subject to Faculty</h2>
    <form method="POST" action="dashboard.php?info=assign_subject">
        <div class="form-group">
            <label for="faculty_id">Faculty:</label>
            <select class="form-control" name="faculty_id" required style="width: 300px;">
                <option value="">Select Faculty</option>
                <?php while ($faculty = mysqli_fetch_assoc($faculty_result)) { ?>
                    <option value="<?= $faculty['id'] ?>"><?= $faculty['Name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="subject_id">Subject:</label>
            <select class="form-control" name="subject_id" required style="width: 300px;">
                <option value="">Select Subject</option>
                <?php while ($subject = mysqli_fetch_assoc($subject_result)) { ?>
                    <option value="<?= $subject['id'] ?>"><?= $subject['subject_name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Assign</button>
    </form>
</div>