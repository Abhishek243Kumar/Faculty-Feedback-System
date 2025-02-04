<?php
extract($_POST);
$attendance = isset($_POST['attendance']) ? $_POST['attendance'] : null;

if (isset($save)) {
	// Validate Gmail address
	if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $e)) {
		$err = "<font color='red'><h3 align='center'>Please enter a valid Gmail address</h3></font>";
	} else {
		// Check if user already exists
		$sql = mysqli_query($conn, "SELECT * FROM user WHERE email='$e'");
		$r = mysqli_num_rows($sql);

		if ($r == true) {
			$err = "<font color='red'><h3 align='center'>This user already exists</h3></font>";
		} else {
			// Date of birth
			$dob = $yy . "-" . $mm . "-" . $dd;

			// Hobbies
			$hob = implode(",", $hob);

			// Image
			if ($_FILES['img']['name'] != "") {
				$imageName = $_FILES['img']['name'];
				// Create directory for the user and move uploaded file
				mkdir("images/$e");
				move_uploaded_file($_FILES['img']['tmp_name'], "images/$e/" . $_FILES['img']['name']);
			} else {
				$imageName = "images/person.jpg";  // Use the default image
			}

			// Encrypt password
			$pass = md5($p);

			// Insert query with CGPA
			$query = "INSERT INTO user VALUES('', '$n', '$e', '$pass', '$mob', '$pro', '$sem', '$gen', '$hob', '$imageName', '$dob', NOW(), '$attendance')";
			mysqli_query($conn, $query);

			$err = "<font color='blue'><h3 align='center'>Registration successful!</h3></font>";
		}
	}
}
?>


<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
		<form method="post" enctype="multipart/form-data">
			<table class="table table-bordered" style="margin-bottom:50px">
				<caption>
					<h2 align="center">Registration Form</h2>
				</caption>
				<Tr>
					<Td colspan="2"><?php echo @$err; ?></Td>
				</Tr>

				<tr>
					<td>Enter Your name</td>
					<Td><input type="text" name="n" class="form-control" required /></td>
				</tr>
				<tr>
					<td>Enter Your email</td>
					<td>
						<input
							type="email"
							name="e"
							class="form-control"
							required
							pattern="[a-zA-Z0-9._%+-]+@gmail\.com"
							title="Please enter a valid Gmail address, e.g., abc@gmail.com" />
					</td>
				</tr>

				<tr>
					<td>Enter Your Password </td>
					<Td><input type="password" name="p" class="form-control" required /></td>
				</tr>

				<tr>
					<td>Enter Your Mobile </td>
					<Td><input type="text" name="mob" class="form-control" required /></td>
				</tr>

				<tr>
					<td>Select Your Programme</td>
					<Td><select name="pro" class="form-control" required>

							<option>BCA</option>
							<option>MCA</option>
							<option>B.Tech</option>
							<option>M.Tech</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>Select Your Semester</td>
					<Td><select name="sem" class="form-control" required>

							<option>i</option>
							<option>ii</option>
							<option>iii</option>
							<option>iv</option>
							<option>v</option>
							<option>vi</option>
							<option>vii</option>
							<option>viii</option>
						</select>
					</td>
				</tr>
                <tr>
                    <td>Enter Your Attendance(%)</td>
                    <td><input type="text" name="attendance" class="form-control" required /></td>
                </tr>

				<tr>
					<td>Select Your Gender</td>
					<Td>
						Male<input type="radio" name="gen" value="m" />
						Female<input type="radio" name="gen" value="f" />
					</td>
				</tr>

				<tr>
					<td>Choose Your hobbies</td>
					<Td>
						Reading<input value="reading" type="checkbox" name="hob[]" />
						Singing<input value="singin" type="checkbox" name="hob[]" />

						Playing<input value="playing" type="checkbox" name="hob[]" />
					</td>
				</tr>


				<tr>
					<td>Upload Your Image </td>
					<Td><input type="file" name="img" class="form-control" /></td>
				</tr>

				<tr>
					<td>Enter Your DOB</td>
					<Td>
						<select style="width:100px;float:left" name="yy" class="form-control" required>
							<option value="">Year</option>
							<?php
							for ($i = 1950; $i <= 2016; $i++) {
								echo "<option>" . $i . "</option>";
							}
							?>

						</select>

						<select style="width:100px;float:left" name="mm" class="form-control" required>
							<option value="">Month</option>
							<?php
							for ($i = 1; $i <= 12; $i++) {
								echo "<option>" . $i . "</option>";
							}
							?>

						</select>


						<select style="width:100px;float:left" name="dd" class="form-control" required>
							<option value="">Date</option>
							<?php
							for ($i = 1; $i <= 31; $i++) {
								echo "<option>" . $i . "</option>";
							}
							?>

						</select>

					</td>
				</tr>

				<tr>


					<Td colspan="2" align="center">
						<input type="submit" value="Save" class="btn btn-info" name="save" />
						<input type="reset" value="Reset" class="btn btn-info" />

					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="col-sm-2"></div>
</div>
</body>

</html>