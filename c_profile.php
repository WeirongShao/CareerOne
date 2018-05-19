<?php
	include_once 'includes/header.php';
	$cid = $_SESSION['id'];
//echo '<h1>Welcome to CareerOne, ' . $_SESSION['id'] . '!</h1>'
	$sql = "SELECT * FROM Company where cid = '$cid'";
	#$sql = "delete *from book where bookid = 'M1245'";
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);
	for($i = 1; $i <= $num; $i=$i+1){
		$row = mysqli_fetch_array($result);
	}
?>
<section class="main-container-application">
	<div class="main-wrapper-application">
		<h2>My Profile</h2>
		<form class = "application-form" action="includes/cprofile.inc.php" method="POST">
        <tr>
            <td><p>Headquarter:</p></td>
            <td><input type="text" name="headquarter" placeholder="headquarter" value = "<?php echo $row['headquarter']?>"></td>
        </tr>
        <tr>
            <td><p>Industry:</p></td>
            <td><input type="text" name="industry" placeholder="industry" value = "<?php echo $row['industry']?>"></td>
        </tr>
        <tr>
		</form>
	</div>
</section>

<?php include_once 'includes/footer.php';?>