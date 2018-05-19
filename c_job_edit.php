<?php
	include_once 'includes/header.php';
	$jid = $_POST['jid'];
	$sql = "SELECT * FROM job where jid = $jid";
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);
	for($i = 1; $i <= $num; $i=$i+1){
		$row = mysqli_fetch_array($result);
	}
?>
<section class="main-container-application">
	<div class="main-wrapper-application">
		<h2>Edit job <?php echo $row['title'];?></h2>
		<form class = "application-form" action="includes/c_job_edit.inc.php" method="POST">
        <tr>
            <td><p>Location:</p></td>
            <td><input type="text" name="location" value="<?php echo $row['location'];?>"></td>
        </tr>
        <tr>
            <td><p>Salary:</p></td>
            <td><input type="number" name="salary" value="<?php echo $row['salary'];?>"></td>
        </tr>
        <tr>
            <td><p>Required degree:</p></td>
            <td><input type="text" name="degree" value="<?php echo $row['required_degree'];?>"></td>
        </tr>
        <tr>
            <td><p>Required major:</p></td>
            <td><input type="text" name="major" value="<?php echo $row['required_major'];?>"></td>
        </tr>
        <tr>
            <td><p>Available:</p></td>
            <td><input type="checkbox" name="available" value="available" <?php if ($row['available']) echo 'checked';?>></td>
        </tr>
        <tr>
            <td><p>Description:</p></td>
            <td><textarea name="description"></textarea></td>
        </tr>
        <input type='hidden' name='jid' value=<?php echo '"' . $jid . '"'?>>
            <button type = "submit" name = "submit">Save</button>
		</form>
	</div>
</section>

<?php include_once 'includes/footer.php';?>