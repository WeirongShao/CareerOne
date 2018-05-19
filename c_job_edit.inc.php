<?php
include_once 'dbh.inc.php';
if (isset($_POST['submit'])) {
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $major = mysqli_real_escape_string($conn, $_POST['major']);
    $degree = mysqli_real_escape_string($conn, $_POST['degree']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    if ('available'==$_POST['available'])
        $available=1;
    else
        $available=0;

	include_once 'dbh.inc.php';
    $jid = $_POST['jid'];
	$sql = "UPDATE job SET
        location = '$location',
        salary = '$salary',
        required_major = '$major',
        required_degree = '$degree',
        description = '$description',
        available = $available
	WHERE jid = $jid";
	mysqli_query($conn, $sql);
    //echo $sql;
    header("Location: ../c_job.php");
	exit();
}
?>