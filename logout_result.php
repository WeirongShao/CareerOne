<!DOCTYPE html>
<html>

<?php
    $title_suffix = 'Log out';
    include_once 'includes/header.php';
?>

<div class="main-container">
    <h2>Are you sure to log out?</h2>
    <form action = "includes/logout.inc.php" align=center method="POST">
        <p><button type="submit" name="submit">Yes. Log out and go to the home page</button></p>
    </form>
    <form align=center>
        <p><input type="button" value="No. Go back" onclick="history.back()"></p>
    </form>
</div>

<?php include_once 'includes/footer.php';?>

</html>