<?php
$title_suffix = 'Post Job';
	include_once 'includes/header.php';
?>
<section class="main-container-application">
	<div class="main-wrapper-application">
		<div class = "row">
		<h2>Post new job</h2>
		<form class = "application-form" action="c_postjob_result.php" method="POST">
		<tr>
            <td><p>Title:</p></td>
            <td><input type="text" name="title"></td></td>
        </tr>
        <tr>
            <td><p>Location:</p></td>
            <td><input type="text" name="location"></td>
        </tr>
        <tr>
            <td><p>Salary:</p></td>
            <td><input type="number" name="salary"></td>
        </tr>
        <tr>
            <td><p>Required degree:</p></td>
            <td><input type="text" name="degree"></td>
        </tr>
        <tr>
            <td><p>Required major:</p></td>
            <td><input type="text" name="major"></td>
        </tr>
        <tr>
            <td><p>Description:</p></td>
            <td><textarea name="description"></textarea></td>
        </tr>
            <button type = "submit" name = "submit">Post</button>
		</form>

	</div>
	</div>
</section>

<?php include_once 'includes/footer.php';?>

