<?php
include('../dbconfig.php'); // Include your database connection file

// Check if the 'subject' is passed in the GET request
if (isset($_GET['subject'])) {
    $subject = $_GET['subject']; // Get the selected subject
    $subject = mysqli_real_escape_string($conn, $subject); // Prevent SQL Injection

    // Query the database to get the faculty for the selected subject
    $query = "SELECT f.name AS faculty_name, f.email AS faculty_email
        FROM faculty f
        JOIN faculty_subjects fs ON f.id = fs.faculty_id
        JOIN subjects s ON fs.subject_id = s.id
        WHERE s.subject_name = '$subject'
    ";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Check if any faculty members are found
        if (mysqli_num_rows($result) > 0) {
            // Loop through each faculty member and output as an option element
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['faculty_email'] . "'>" . $row['faculty_name'] . "</option>";
            }
        } else {
            // If no faculty members found, display a message
            echo "<option value=''>No faculty available</option>";
        }
    } else {
        // Query failed, output an error message
        echo "<option value=''>Error fetching faculty</option>";
    }
} else {
    // If subject is not passed, return the default message
    echo "<option value=''>--Select Faculty--</option>";
}
