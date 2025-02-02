<?php
include('../dbconfig.php'); // Make sure to include your database connection file

// Check if the 'semester' is passed in the GET request
if (isset($_GET['semester'])) {
    $semester = $_GET['semester']; // Get the selected semester
    $semester = mysqli_real_escape_string($conn, $semester); // Prevent SQL Injection

    // Query the database to get the subjects for the selected semester
    $query = "SELECT subject_name FROM subjects WHERE semester = '$semester'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Check if any subjects are found
        if (mysqli_num_rows($result) > 0) {
            // Loop through each subject and output as an option element
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['subject_name'] . "'>" . $row['subject_name'] . "</option>";
            }
        } else {
            // If no subjects found, display a message
            echo "<option value=''>No subjects available</option>";
        }
    } else {
        // Query failed, output an error message
        echo "<option value=''>Error fetching subjects</option>";
    }
} else {
    // If semester is not passed, return the default message
    echo "<option value=''>--Select Subject--</option>";
}

?>



