<?php
    $title_suffix = 'Log in';
    $error_message = '';
    include_once 'includes/dbh.inc.php';
    include 'includes/logincheck.inc.php';
    if ($is_login)
        $error_message = "You are already logged in.";
    else if (!isset($_POST['submit']))
        $error_message = "Unknown error.";
    else {
        $user_type = $_POST['user_type'];
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

        //error handlers
        //check if inputs are empty
        if ($user_type != 'student' && $user_type != 'company')
            $error_message = "Unknown error.";
        else if (empty($email))
            $error_message = "Please enter your email!";
        else if (empty($pwd))
            $error_message = "Please enter your password!";
        else {
            if ($user_type == 'student') {                
                $id_type = 'sid';
                $name_type = 'sname';
                $result = $conn->query("
                    SELECT *
                    FROM student
                    WHERE semail = '$email' AND spassword = '$pwd'");
            } else {
                $id_type = 'cid';
                $name_type = 'cname';
                $result = $conn->query("
                    SELECT *
                    FROM company
                    WHERE cemail = '$email' AND cpassword = '$pwd'");
            }
            
            if ($result == null or $result->num_rows == 0)
                $error_message = "Error email or password.";
            else if ($result->num_rows > 1)
                $error_message = "Unknown error.";
            else {
                $row = mysqli_fetch_array($result);
                $id_value = $row[$id_type];
                $name = $row[$name_type];
                $_SESSION['id'] = $id_value;
                $_SESSION['pwd'] = $pwd;
                $_SESSION['name'] = $name;
                $_SESSION['user_type'] = $user_type;
                //header("Location: ../" . $user_type . ".php?$id_type=$id_value");
            }
        }
    }
    
    include_once 'includes/header.php';
    
    echo '<div class="main-container">';
    if (strcmp($error_message, ''))
        echo '
            <h2>Error</h2><p align=center>' . $error_message . '
            Return to the <a href="index.php">home page</a> and try again.</p>';
    else
        echo '
            <h2>Registration Successful</h2>
            <p align=center>Return to the <a href="index.php">home page</a>.';
    echo '</div>';
    
    include_once 'includes/footer.php';
?>