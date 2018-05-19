<?php
    include_once 'includes/dbh.inc.php';
    if (array_key_exists('id', $_SESSION) and $_SESSION['id'] != null)
        $is_login = true;
    else
        $is_login = false;
    
    if ($is_login == true)
    {
        if ($_SESSION['user_type'] == 'student' and strrpos($_SERVER['SCRIPT_NAME'], 'c_')) {
            header('Location: index.php');
            exit();
        }
        if ($_SESSION['user_type'] == 'company' and strrpos($_SERVER['SCRIPT_NAME'], 's_')) {
            header('Location: index.php');
            exit();
        }
    }
    else if (!(
        strrpos($_SERVER['SCRIPT_NAME'], 'index.php') or
        strrpos($_SERVER['SCRIPT_NAME'], 'login_result.php') or
        strrpos($_SERVER['SCRIPT_NAME'], 'signup.php') or
        strrpos($_SERVER['SCRIPT_NAME'], 'signup_result.php'))) {
        header('Location: index.php');
        exit();
    }
?>