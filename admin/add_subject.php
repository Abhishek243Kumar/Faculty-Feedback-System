<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);

    // Validate if the semester is in lowercase Roman numeral format (i, ii, iii, iv, ...)
    if (!preg_match('/^[ivxlc]+$/', $semester)) {
        echo "<div class='alert alert-danger'>Invalid semester format. Please use lowercase Roman numerals (e.g., i, ii, iii, iv, ...).</div>";
    } else {
        // Insert subject into database
        $query = "INSERT INTO subjects (subject_name, semester) VALUES ('$subject_name', '$semester')";
        if (mysqli_query($conn, $query)) {
            echo "<div class='alert alert-success'>Subject added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error adding subject: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<div class="container">
    <h2>Add New Subject</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="subject_name">Subject Name:</label>
            <!-- <input type="text" class="form-control" id="subject_name" name="subject_name" required> -->
            <input type="text" class="form-control" id="subject_name" name="subject_name" required style="width: 300px;">

        </div>
        <div class="form-group">
            <label for="semester">Semester:</label>
            <input type="text" class="form-control" id="semester" name="semester" placeholder="Enter Semester (e.g., i, ii, iii, iv, ...)" required style="width: 300px;">
        </div>
        <button type="submit" class="btn btn-primary">Add Subject</button>
    </form>
</div>

