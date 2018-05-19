<?php
    $title_suffix = 'Push Job Announcements';
    $error_message = '';
    include_once 'includes/dbh.inc.php';
    include 'includes/logincheck.inc.php';
    if (!$is_login or $_SESSION['user_type'] != 'company' or !isset($_SESSION['where'])) {
        header('Location: index.php');
        exit();
    }
    
    if (!isset($_POST['submit']))
        $error_message = "Unknown error.";
    else {
        $where = $_SESSION['where'];
        $jid = $_POST['jid'];
        $conn->query("
            INSERT INTO Noti_Job
            SELECT sid, $jid, NOW(), 'Unread'
            FROM Student
            WHERE $where");
    }
    
    
    include_once 'includes/header.php';
    
    echo '<div class="main-container">';
    if (strcmp($error_message, ''))
        echo '
            <h2>Error</h2><p align=center>' . $error_message . '
            Try <a href="c_pushjob.php">push job announcements</a> again or return to the
            <a href="index.php">home page</a>.</p>';
    else
        echo '
            <h2>Announcements pushed successfully</h2>
            <p align=center>Return to the <a href="index.php">home page</a>.';
    echo '</div>';
    
    include_once 'includes/footer.php';
?>