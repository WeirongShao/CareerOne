<?php
    $title_suffix = 'Push Job Announcements';
    include_once 'includes/header.php';
    $result = $conn->query("SELECT * FROM job WHERE cid =" . $_SESSION['id']);
?>

<div class="main-container">
    <?php if ($result == null or $result->num_rows == 0) { ?>
    <h2>Error</h2>
    <p align=center>You need to create a job position first! Return to the <a href="index.php">home page</a>.</p>
    <?php } else { ?>
    <h2>Who are suitable students?</h2>
    <form action = "c_pushjob_result.php" method = "POST" align=center>
        <table align=center>
        <tbody align=left>
        <tr>
            <td><input type="checkbox" id="university" name="searchin[]" value="university"></td>
            <td><label for="university">University contains</label></td>
            <td><input type="text" name="university" placeholder="Keyword in university"></td>
        </tr>
        <tr>
            <td><input type="checkbox" id="degree" name="searchin[]" value="degree"></td>
            <td><label for="degree">Degree is</label></td>
            <td><input type="text" name="degree" placeholder="MS/BS/PhD"></td>
        </tr>
        <tr>
            <td><input type="checkbox" id="major" name="searchin[]" value="major"></td>
            <td><label for="major">Major contains</label></td>
            <td><input type="text" name="major" placeholder="Keyword in major"></td>
        </tr>
        <tr>
            <td><input type="checkbox" id="gpa" name="searchin[]" value="gpa"></td>
            <td><label for="gpa">GPA ≥</label></td>
            <td><input type="text" name="gpa" placeholder="GPA (max 4.0)"></td>
        </tr>
        <tr>
            <td><input type="checkbox" id="resume" name="searchin[]" value="resume"></td>
            <td><label for="resume">Resume contains</label></td>
            <td><input type="text" name="resume" placeholder="Keyword in resume"></td>
        </tr>
        </tbody>
        </table>
        <p align=center><button type="submit" name="submit">Search!</button></p>
    </form>
</div>

<?php } include_once 'includes/footer.php';?>