<?php
//echo '<h1>Welcome to CareerOne, ' . $_SESSION['id'] . '!</h1>'
if (isset($_POST['submit'])) {

	include_once 'dbh.inc.php';
    $sid = $_SESSION['id'];
	$university = mysqli_real_escape_string($conn, $_POST['university']);
	$degree = mysqli_real_escape_string($conn, $_POST['degree']);
	$major = mysqli_real_escape_string($conn, $_POST['major']);
	$GPA = mysqli_real_escape_string($conn, $_POST['GPA']);
	$interests = mysqli_real_escape_string($conn, $_POST['interests']);
	$qualifications = mysqli_real_escape_string($conn, $_POST['qualifications']);
	$resume = mysqli_real_escape_string($conn, $_POST['resume']);
	//Error handlers
	//check for empty fields
	$sql = "UPDATE student SET university = '$university', degree = '$degree', major = '$major', 
	GPA = $GPA, interests = '$interests', qualifications = '$qualifications', resume = '$resume'
	WHERE sid = $sid ";
	//$row = $sql->fetch_assoc();
	mysqli_query($conn, $sql);
    header("Location: ../index.php");
	//stop)
	//$result = mysqli_query($conn, $sql);
	//echo '$result';
}
?>