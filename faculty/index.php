<?php
session_start();
include('../dbconfig.php');
error_reporting(1);

// Check if the user is logged in
$user = $_SESSION['faculty_login'];
if ($user == "") {
    header('location:../index.php');
}

// Fetch faculty information
$sql = mysqli_query($conn, "SELECT * FROM faculty WHERE email='$user'");
$faculty = mysqli_fetch_assoc($sql);

// Fetch subjects for the faculty
$faculty_id = $faculty['id'];
$subjects_query = mysqli_query($conn, "
    SELECT s.subject_name 
    FROM faculty_subjects fs 
    INNER JOIN subjects s ON fs.subject_id = s.id 
    WHERE fs.faculty_id = '$faculty_id'
");
$subjects = [];
while ($row = mysqli_fetch_assoc($subjects_query)) {
    $subjects[] = $row['subject_name'];
}

// Create a comma-separated string of subjects
$subjects_list = implode(", ", $subjects);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Faculty Feedback System</title>

    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
    <script src="../js/ie-emulation-modes-warning.js"></script>
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" style="background:#428bca">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="color:#FFFFFF" href="#">Hello <?php echo $faculty['Name']; ?></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php" style="color:#FFFFFF">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active"><a href="index.php">Dashboard <span class="sr-only">(current)</span></a></li>
                    <li><a href="index.php?page=update_password"><span class="glyphicon glyphicon-user"></span> Update
                            Password</a></li>
                    <li><a href="index.php?page=update_profile"><span class="glyphicon glyphicon-asterisk"></span>
                            Update Profile</a></li>
                    <li><a href="index.php?page=feedback"><span class="glyphicon glyphicon-thumbs-up"></span>
                            Feedback</a></li>
                    <li><a href="index.php?page=iframe"><span class="glyphicon glyphicon-thumbs-up"></span> Feedback
                            Conclusion</a></li>
                </ul>
            </div>

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <?php
                @$page = $_GET['page'];
                if ($page != "") {
                    if ($page == "update_password") {
                        include('update_password.php');
                    } elseif ($page == "update_profile") {
                        include('update_profile.php');
                    } elseif ($page == "feedback") {
                        include('feedback.php');
                    } elseif ($page == "iframe") {
                        include('iframe.php');
                    }
                } else {
                ?>
                    <h1 class="page-header">Dashboard</h1>
                    <h2>Faculty Information</h2>
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td><?php echo $faculty['Name']; ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo $faculty['email']; ?></td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td><?php echo $faculty['mobile']; ?></td>
                        </tr>
                        <tr>
                            <th>Programme</th>
                            <td><?php echo $faculty['programme']; ?></td>
                        </tr>
                        <tr>
                            <th>Designation</th>
                            <td><?php echo $faculty['designation']; ?></td>
                        </tr>
                        <tr>
                            <th>Subjects</th>
                            <td><?php echo $subjects_list; ?></td>
                        </tr>
                    </table>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="../js/vendor/jquery.min.js"><\/script>')
    </script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/vendor/holder.min.js"></script>
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
</body>

</html>
