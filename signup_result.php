<?php
    $title_suffix = 'Sign up';
    $error_message = '';
    include_once 'includes/dbh.inc.php';
    
    if (!isset($_POST['submit']))
        $error_message = "Unknown error.";
    else {
        $user_type = $_POST['user_type'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

        //error handlers
        //check if inputs are empty
        if ($user_type != 'student' && $user_type != 'company')
            $error_message = "Unknown error.";
        else if (empty($name))
            $error_message = "Please enter your name!";
        else if (empty($email))
            $error_message = "Please enter your email!";
        else if (empty($pwd))
            $error_message = "Please enter your password!";
        else if (!preg_match("/^[a-z A-Z]*$/", $name)) //check if input characters are valid
            $error_message = "Name is invalid!";
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) //check if email is valid
            $error_message = "Email is invalid!";
        else {
            if ($user_type == 'student')
                $result = $conn->query("SELECT * FROM student WHERE semail = '$email'");
            else
                $result = $conn->query("SELECT * FROM company WHERE cemail = '$email'");
            if ((mysqli_num_rows($result)) != 0)
                $error_message = "This email has been registrated!";
            else {
                //compute a new sid/cid
                if ($user_type == 'student') {
                    $id_type = 'sid';
                    $name_type = 'sname';
                } else {
                    $id_type = 'cid';
                    $name_type = 'cname';
                }
                $result = $conn->query("SELECT MAX($id_type) AS m FROM $user_type");
                $row = mysqli_fetch_array($result);
                $id_value = $row["m"] + 1;
                if ($user_type == 'student')
                    $conn->query("
                        INSERT INTO student(sid, semail, sname, spassword)
                        VALUES ('$id_value', '$email', '$name', '$pwd')");
                else {
                    $conn->query("
                        INSERT INTO company(cid, cemail, cname, cpassword)
                        VALUES ('$id_value', '$email', '$name', '$pwd')");
                }
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
            Try <a href="signup.php">sign up</a> again or return to the
            <a href="index.php">home page</a>.</p>';
    else
        echo '
            <h2>Registration Successful</h2>
            <p align=center>Return to the <a href="index.php">home page</a>.';
    echo '</div>';
    
    include_once 'includes/footer.php';
?>