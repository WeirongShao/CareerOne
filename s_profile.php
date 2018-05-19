<?php
	include_once 'includes/header.php';
	$sid = $_SESSION['id'];
//echo '<h1>Welcome to CareerOne, ' . $_SESSION['id'] . '!</h1>'
	$sql = "SELECT * FROM Student where sid = '$sid'";
	#$sql = "delete *from book where bookid = 'M1245'";
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);
	for($i = 1; $i <= $num; $i=$i+1){
		$row = mysqli_fetch_array($result);
	}
?>
<section class="main-container-application">
	<div class="main-wrapper-application">
		<div class = "row">
		<h2>My Profile</h2>
		<form class = "application-form" action="includes/sprofile.inc.php" method="POST">
		<tr>
            <td><p>University:</p></td>
            <td><input type="text" name="university" value = "<?php echo $row['university']?>"></td></td>
        </tr>
        <tr>
            <td><p>Degree:</p></td>
            <td><input type="text" name="degree" value = "<?php echo $row['degree']?>"></td>
        </tr>
        <tr>
            <td><p>Major:</p></td>
            <td><input type="text" name="major" value = "<?php echo $row['major']?>"></td>
        </tr>
        <tr>
            <td><p>GPA:</p></td>
            <td><input type="float" name="GPA" value = "<?php echo $row['GPA']?>"></td>
        </tr>
        <tr>
            <td><p>Interests:</p></td>
            <td><input type="text" name="interests" value = "<?php echo $row['interests']?>"></td>
        </tr>
         <tr>
            <td><p>Qualifications:</p></td>
            <td><input type="text" name="qualifications" value = "<?php echo $row['qualifications']?>"></td>
        </tr>
         <tr>
            <td><p>Resume:</p></td>
            <td><textarea name="resume"><?php echo $row['resume']?></textarea></td>
        </tr>
			<button type = "submit" name = "submit">Save</button>
		</form>

	</div>
	</div>
</section>

<?php include_once 'includes/footer.php';?>

