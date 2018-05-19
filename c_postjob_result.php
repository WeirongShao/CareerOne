<?php
    $title_suffix = 'Post Job';
    $error_message = '';
    include_once 'includes/dbh.inc.php';
    
    if (!isset($_POST['submit']))
        $error_message = "Unknown error.";
    else {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $salary = mysqli_real_escape_string($conn, $_POST['salary']);
        $major = mysqli_real_escape_string($conn, $_POST['major']);
        $degree = mysqli_real_escape_string($conn, $_POST['degree']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        //error handlers
        //check if inputs are empty
        if (empty($title))
            $error_message = "Please enter the title!";
        else {
            //compute a new jid
            $result = $conn->query("SELECT MAX(jid) AS m FROM job");
            $row = mysqli_fetch_array($result);
            $id_value = $row["m"] + 1;
            $conn->query("
                INSERT INTO job
                VALUES ($id_value,".$_SESSION['id'].",'$title', '$location', '$salary', '$degree', '$major',NOW(),'$description',DEFAULT)");
            $conn->query("
                INSERT INTO noti_job
                select sid, $id_value, now(), 'unread' from following where cid=".$_SESSION['id']);
        }
    }
    
    include_once 'includes/header.php';
    
    echo '<div class="main-container">';
    if (strcmp($error_message, ''))
        echo '
            <h2>Error</h2><p align=center>' . $error_message . '
            Try <a href="c_postjob.php">post</a> again or return to the
            <a href="index.php">home page</a>.</p>';
    else
        echo '
            <h2>Job post successfully</h2>
            <p align=center>This job has also been pushed to your followers. Go to <a href="c_job.php">my jobs</a> or the <a href="index.php">home page</a>.';
    echo '</div>';
    
    include_once 'includes/footer.php';
?>