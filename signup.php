<?php
    $title_suffix = 'Sign up';
    include_once 'includes/header.php';
?>

<div class="main-container">
    <?php
        include 'includes/logincheck.inc.php';
        if ($is_login) {
            header("Location: index.php");
            exit();
        }
    ?>
    <h2>Registration</h2>
    <form action = "signup_result.php" method = "POST">
        <p align=center>Sign up a
            <input type="radio" id="student"
            name="user_type" value="student" checked><label for="student">student user</label>
            /<input type="radio" id="company"
            name="user_type" value="company"><label for="company">company user</label> account
        </p>
        <table align=center>
        <tr>
            <td><p>Name:</p></td>
            <td><input type="text" name="name" placeholder="Your name"></td>
        </tr>
        <tr>
            <td><p>Email:</p></td>
            <td><input type="text" name="email" placeholder="Your email"></td>
        </tr>
        <tr>
            <td><p>Password:</p></td>
            <td><input type="password" name="pwd" placeholder="Your password"></td>
        </tr>
        </table>
        <p align=center><button type="submit" name="submit">Sign up</button></p>
    </form>
</div>

<?php include_once 'includes/footer.php';?>