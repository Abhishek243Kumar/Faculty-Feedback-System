<?php
// session_start();
include('../dbconfig.php');
extract($_POST);
if (isset($sub)) {
  $user = $_SESSION['user'];

  $sql = mysqli_query($conn, "select * from feedback where student_id='$user' and faculty_id='$faculty'");
  $r = mysqli_num_rows($sql);

  if ($r == true) {
    echo "<h2 style='color:red'>You already given feedback to this faculty</h2>";
  } else {
    $query = "insert into feedback values('','$user','$faculty','$quest1','$quest2','$quest3','$quest4','$quest5','$quest6','$quest7','$quest8','$quest9','$quest10','$quest11','$quest12','$suggestion',now())";

    mysqli_query($conn, $query);

    echo "<h2 style='color:green'>Thank you </h2>";
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script>
    function validateForm() {
      const faculty = document.querySelector("select[name='faculty']").value;
      if (faculty === "") {
        alert("Please select a faculty member before submitting.");
        return false;
      }
      return true;
    }

    function loadSubjects() {
      const semester = document.getElementById("semester").value; // Get selected semester

      // Clear previous options in subject dropdown
      document.getElementById("subject").innerHTML = "<option value=''>--Select Subject--</option>";

      if (semester) {
        // Make a fetch request to get the subjects for the selected semester
        fetch(`get_subjects.php?semester=${semester}`)
          .then(response => response.text())
          .then(data => {
            // Insert the received subjects into the subject dropdown
            document.getElementById("subject").innerHTML = data;
          })
          .catch(error => {
            console.error('Error loading subjects:', error);
          });
      }
    }

    function loadFaculty() {
      const subject = document.getElementById("subject").value; // Get selected subject

      // Clear previous options in faculty dropdown
      document.getElementById("faculty").innerHTML = "<option value=''>--Select Faculty--</option>";

      if (subject) {
        // Make a fetch request to get the faculty for the selected subject
        fetch(`get_faculty.php?subject=${subject}`)
          .then(response => response.text())
          .then(data => {
            // Insert the received faculty options into the faculty dropdown
            document.getElementById("faculty").innerHTML = data;
          })
          .catch(error => {
            console.error('Error loading faculty:', error);
          });
      }
    }
  </script>
</head>

<body>
  <form method="POST" onsubmit="return validateForm()">
    <fieldset>
      <center><u>Student's FeedBack Form</u></center><br>

      <fieldset>



        <h3>Please give your answer about the following question by circling the given grade on the scale:</h3>


        <button type="button" style="font-size:7pt;color:white;background-color:green;border:2px solid #336600;padding:3px">Strongly Agree 5</button>
        <button type="button" style="font-size:7pt;color:white;background-color:Brown;border:2px solid #336600;padding:3px">Agree 4</button>
        <button type="button" style="font-size:7pt;color:white;background-color:blue;border:2px solid #336600;padding:3px">Neutral 3</button>
        <button type="button" style="font-size:7pt;color:white;background-color:Black;border:2px solid #336600;padding:3px"> Disagree 2</button>
        <button type="button" style="font-size:7pt;color:white;background-color:red;border:2px solid #336600;padding:3px">Strongly Disagree 1</button><br>

        <label>Select Semester:</label>
        <select name="semester" id="semester" onchange="loadSubjects();">
          <option value="">--Select Semester--</option>
          <option value="i">i</option>
          <option value="ii">ii</option>
          <option value="iii">iii</option>
          <option value="iv">iv</option>
          <option value="v">v</option>
          <option value="vi">vi</option>
          <option value="vii">vii</option>
          <option value="viii">viii</option>
        </select>

        <label>Select Subject:</label>
        <select name="subject" id="subject" onchange="loadFaculty();">
          <option value="">--Select Subject--</option>
        </select>

        <label>Select Faculty:</label>
        <select name="faculty" id="faculty">
          <option value="">--Select Faculty--</option>
        </select>


        <h3>1-Course Material</h3>
        <table class="table table-bordered">
          <tr>
            <td><b>1:</b> Teacher provided the course outline having weekly content plan with list of required text book:</td>
            <td><input type="radio" name="quest1" value="5" required> 5
              <input type="radio" name="quest1" value="4">4
              <input type="radio" name="quest1" value="3"> 3
              <input type="radio" name="quest1" value="2">2
              <input type="radio" name="quest1" value="1">1
            </td>
          </tr>

          <tr>
            <td><b>2:</b>Course objectives,learning outcomes and grading criteria are clear to me:</td>
            <td><input type="radio" name="quest2" value="5" required>5
              <input type="radio" name="quest2" value="4">4
              <input type="radio" name="quest2" value="3">3
              <input type="radio" name="quest2" value="2">2
              <input type="radio" name="quest2" value="1">1
            </td>
          </tr>

          <tr>
            <td>
              <b>3:</b>Course integrates throretical course concepts with the real world examples:
            </td>
            <td>
              <input type="radio" name="quest3" value="5" required> 5
              <input type="radio" name="quest3" value="4">4
              <input type="radio" name="quest3" value="3"> 3
              <input type="radio" name="quest3" value="2">2
              <input type="radio" name="quest3" value="1">1
            </td>
          </tr>
        </table>

        <h3>2-Class Teaching</h3>
        <table class="table table-bordered">
          <Td><b>4:</b> Teacher is punctual,arrives on time and leaves on time:</td>
          <td> <input type="radio" name="quest4" value="5" required> 5
            <input type="radio" name="quest4" value="4">4
            <input type="radio" name="quest4" value="3"> 3
            <input type="radio" name="quest4" value="2">2
            <input type="radio" name="quest4" value="1">1
          </td>

          <tr>
            <td>
              <b>5:</b> Teacher is good at stimulating the interest in the course content:
            </td>
            <td>
              <input type="radio" name="quest5" value="5" required> 5
              <input type="radio" name="quest5" value="4">4
              <input type="radio" name="quest5" value="3"> 3
              <input type="radio" name="quest5" value="2">2
              <input type="radio" name="quest5" value="1">1
            </td>
          </tr>
          <tr>
            <td><b>6:</b> Teacher is good at explaining the subject matter:</td>
            <td>
              <input type="radio" name="quest6" value="5" required> 5
              <input type="radio" name="quest6" value="4">4
              <input type="radio" name="quest6" value="3"> 3
              <input type="radio" name="quest6" value="2">2
              <input type="radio" name="quest6" value="1">1
            </td>
          </tr>

          <tr>
            <td>
              <b>7:</b> Teacher's presentation was clear,loud ad easy to understand:
            </td>
            <td> <input type="radio" name="quest7" value="5" required> 5
              <input type="radio" name="quest7" value="4">4
              <input type="radio" name="quest7" value="3"> 3
              <input type="radio" name="quest7" value="2">2
              <input type="radio" name="quest7" value="1">1
            </td>
          <tr>
            <td>
              <b>8:</b> Teacher is good at using innovative teaching methods/ways:
            </td>
            <td>
              <input type="radio" name="quest8" value="5" required> 5
              <input type="radio" name="quest8" value="4">4
              <input type="radio" name="quest8" value="3">3
              <input type="radio" name="quest8" value="2">2
              <input type="radio" name="quest8" value="1">1
            </td>
          </tr>
          <tr>
            <td>
              <b>9:</b> Teacher is available and helpful during counseling hours:
            </td>
            <td><input type="radio" name="quest9" value="5" required>5
              <input type="radio" name="quest9" value="4">4
              <input type="radio" name="quest9" value="3"> 3
              <input type="radio" name="quest9" value="2">2
              <input type="radio" name="quest9" value="1">1
            </td>
          </tr>
          <tr>
            <td>
              <b>10:</b> Teacher has competed the whole course as per course outline:
            </td>
            <td>
              <input type="radio" name="quest10" value="5" required> 5
              <input type="radio" name="quest10" value="4">4
              <input type="radio" name="quest10" value="3"> 3
              <input type="radio" name="quest10" value="2">2
              <input type="radio" name="quest10" value="1">1
            </td>
          </tr>
        </table>

        <h3>3-Class Assessment</h3>
        <table class="table table-bordered">
          <tr>
            <td><b>11:</b>Teacher was always fair and impartial:</td>
            <td>
              <input type="radio" name="quest11" value="5" required> 5
              <input type="radio" name="quest11" value="4">4
              <input type="radio" name="quest11" value="3"> 3
              <input type="radio" name="quest11" value="2">2
              <input type="radio" name="quest11" value="1">1
            </td>
          </tr>
          <tr>
            <td><b>12:</b>Assessments conducted are clearly connected to maximize learining objectives:</td>
            <Td>
              <input type="radio" name="quest12" value="5" required> 5
              <input type="radio" name="quest12" value="4">4
              <input type="radio" name="quest12" value="3"> 3
              <input type="radio" name="quest12" value="2">2
              <input type="radio" name="quest12" value="1">1
            </td>
          </tr>
        </table>

        <center><b>Suggestion:</b><br></center>
        <center>
          <textarea name="suggestion" rows="5" cols="60" id="comments" style="font-family:sans-serif;font-size:1.2em;"></textarea>
        </center><br><br>

        <p align="center"><button type="submit" style="font-size:7pt;color:white;background-color:brown;border:2px solid #336600;padding:7px" name="sub">Submitt</button></p>


  </form>
  </fieldset>

</body>

</html>