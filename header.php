<?php include_once 'includes/dbh.inc.php';?>

<!DOCTYPE html>

<html>

<head>
    <title>CareerOne<?php // if (!empty($title_suffix)) { echo ' - ' . $title_suffix; }?></title>
    <link rel="stylesheet" type="text/css" href="style<?php if(isset($from1)) echo 1 ?>.css">
</head>

<body>
<header>
    <nav>
        <?php
            // get the current page name
            $page_name = $_SERVER['SCRIPT_NAME'];
            $page_name = substr($page_name, strrpos($page_name, "/") + 1);
            $page_name = str_replace('_result', '', $page_name);
            $nav = '<a href="index.php">Home</a>';
            
            include 'includes/logincheck.inc.php';
            if ($is_login) {
                // has "logged in" (although may be a invalid cookie)
                if ($_SESSION['user_type'] == 'student') {
                    $sid=$_SESSION['id'];
                    $nav = $nav . '<a href="s_application.php">My application';
                    $result = mysqli_query($conn, "SELECT * FROM job_app_reply WHERE sid = $sid AND status = 'UNREAD'");
                    $num = mysqli_num_rows($result);
                    if ($num)
                        $nav = "$nav <font color='gold'><b>($num)</b></font>";
                    
                    $nav = $nav . '</a><a href="s_message.php">Messages';
                    $result = mysqli_query($conn, "SELECT * FROM message WHERE sid = $sid AND status = 'UNREAD'");
                    $num = mysqli_num_rows($result);
                    if ($num)
                        $nav = "$nav <font color='gold'><b>($num)</b></font>";
                    
                    $nav = $nav . '</a><a href="s_jobnoti.php">Job notifications';
                    $result = mysqli_query($conn, "SELECT * FROM noti_job WHERE sid = $sid AND status = 'UNREAD'");
                    $num = mysqli_num_rows($result);
                    if ($num)
                        $nav = "$nav <font color='gold'><b>($num)</b></font>";
                    
                    $nav = $nav . '</a><a href="s_friend.php">Friends';
                    $result = mysqli_query($conn, "SELECT * FROM friend_request WHERE sid = $sid AND status = 'UNREAD'");
                    $num = mysqli_num_rows($result);
                    if ($num)
                        $nav = "$nav <font color='gold'><b>($num)</b></font>";
                    
                    $nav = $nav . '</a><a class="header_right" href="includes/logout.inc.php">Log out</a>
                        <a class="header_right" href="s_profile.php">Edit my profile</a>
                        </a><a class="header_right" href="student.php?id=' . $sid . '">' .
                        $_SESSION['name'] . '</a>';
                }
                else {
                    $cid=$_SESSION['id'];
                    $nav = $nav . '<a href="c_job.php">My jobs';
                    
                    $nav = $nav . '</a><a href="c_application.php">Received Applications';
                    $result = mysqli_query($conn, "SELECT * FROM job_application NATURAL JOIN company WHERE cid = $cid AND status = 'UNREAD'");
                    $num = mysqli_num_rows($result);
                    if ($num)
                        $nav = "$nav <font color='gold'><b>($num)</b></font>";
                    
                    $nav = $nav . '</a><a href="c_postjob.php">Post new job';
                    
                    $nav = $nav . '</a><a href="c_pushjob.php">Push job announcements';
                    
                    $nav = $nav . '</a><a class="header_right" href="includes/logout.inc.php">Log out</a>
                        <a class="header_right" href="c_profile.php">Edit my profile</a>
                        <a class="header_right" href="company.php?id=' . $_SESSION['id'] . '">' .
                            $_SESSION['name'] . '</a>';
                }
            } else {
                //if 
                $nav = $nav . '
                    <p>(not logged in)</p>
                    <a class="header_right" href="signup.php">Sign up</a>
                    <p class="header_right">New user?</p>';
            }
            // let current page be "current"
            $nav = str_replace('href="' . $page_name, 'class="current" href="' . $page_name, $nav);
            $nav = str_replace('class="header_right" class="current"', 'class="current_right"', $nav);
            echo $nav;
        ?>
    </nav>
</header>