<?php

//echo '<h1>Welcome to CareerOne, ' . $_SESSION['id'] . '!</h1>'
if (isset($_POST['submit'])) {

	include_once 'dbh.inc.php';
    $cid = $_SESSION['id'];
	$headquarter = mysqli_real_escape_string($conn, $_POST['headquarter']);
	$industry = mysqli_real_escape_string($conn, $_POST['industry']);
	//Error handlers
	//check for empty fields
	$sql = "UPDATE company SET headquarter = '$headquarter', industry = '$industry'
	WHERE cid = $cid ";
	mysqli_query($conn, $sql);
    header("Location: ../index.php");
	exit();//stop)
	//$result = mysqli_query($conn, $sql);
	//echo '$result';
}
?>