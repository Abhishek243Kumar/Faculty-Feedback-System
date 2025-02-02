<?php 
include('../dbconfig.php');

// Fetching feedback data for the faculty
$q=mysqli_query($conn, "SELECT * FROM feedback WHERE faculty_id='".$_SESSION['faculty_login']."'");

$r=mysqli_num_rows($q);

if ($r == false) {
    echo "<h3 style='color:Red'>No records found!</h3>";
} else {
?>

<div class="row">
    <div class="col-sm-12" style="color:orange;">
        <h1 align="center">Feedback for <?php echo $faculty['Name']; ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered">
            <thead>
                <tr class="success">
                    <th>Sr.No</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q5</th>
                    <th>Q6</th>
                    <th>Q7</th>
                    <th>Q8</th>
                    <th>Q9</th>
                    <th>Q10</th>
                    <th>Q11</th>
                    <th>Q12</th>
                    <th>Suggestion</th>
                </tr>
            </thead>
            
            <?php
            $i = 1;
            $totals = array_fill(0, 12, 0); // Initialize an array to store total of each question
            $overall_total = 0;  // To calculate the total score of all questions for each student
            $count = 0;  // Number of feedbacks for overall average calculation

            while ($row = mysqli_fetch_array($q)) {
                echo "<tr>";
                echo "<td>".$i."</td>";

                $student_total = 0; // Total score for each student (Q1-Q12)
                
                // Loop through each question (Q1 to Q12) and display the values
                for ($j = 3; $j <= 14; $j++) {
                    echo "<td>".$row[$j]."</td>";
                    $totals[$j - 3] += $row[$j]; // Add the value to the respective question's total
                    $student_total += $row[$j]; // Add score for this student to their total
                }

                echo "<td>".$row[15]."</td>"; // Suggestion
                echo "</tr>";

                // Add the student's total to the overall total
                $overall_total += $student_total;
                $count++;

                $i++;
            }

            // Calculate averages for each question
            $numRows = $r;
            $averages = array_map(function($total) use ($numRows) {
                return $numRows > 0 ? $total / $numRows : 0;
            }, $totals);

            // Convert averages to JSON format for JavaScript
            $averages_json = json_encode($averages);

            // Calculate overall average for all students
            $overall_average = $count > 0 ? $overall_total / ($count * 12) : 0; // Average over all questions for all students
            ?>

            <tfoot>
                <tr class="success">
                    <th colspan="1">Average</th>
                    <?php 
                    // Display average for each question
                    for ($i = 0; $i < 12; $i++) {
                        echo "<th>".number_format($averages[$i], 2)."</th>";
                    }
                    echo "<th></th>"; // Empty cell for Suggestion column
                    ?>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Overall Average -->
<div class="row">
    <div class="col-sm-12" style="color:green;">
        <h3 align="center">Overall Average for All Feedbacks: <?php echo number_format($overall_average, 2); ?></h3>
    </div>
</div>

<!-- Pie Chart -->
<div class="row">
    <div class="col-sm-12">
        <h3 align="center">Average Feedback </h3>

        <div style="display: flex; justify-content: center; align-items: center;">
            <canvas id="feedbackPieChart" width="900" height="400"></canvas>
        </div>
        <!-- <canvas id="feedbackPieChart" width="500" height="500"></canvas> -->
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Render Pie Chart -->
<script>
    // Averages from PHP
    const averages = <?php echo $averages_json; ?>;

    // Labels for each question
    const labels = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10', 'Q11', 'Q12'];

    // Colors for the pie chart
    const backgroundColors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', 
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
    ];

    // Chart Configuration
    const config = {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Average Feedback',
                data: averages,
                backgroundColor: backgroundColors,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: false,
			// maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `${tooltipItem.label}: ${tooltipItem.raw.toFixed(2)}`;
                        }
                    }
                }
            }
        }
    };

    // Render Chart
    const ctx = document.getElementById('feedbackPieChart').getContext('2d');
    new Chart(ctx, config);
</script>

<?php } ?>
