<?php
    $title_suffix = 'Home Page';
    include_once 'includes/header.php';
?>

<div class="main-container">
    <?php
        if (!array_key_exists('id', $_SESSION) or $_SESSION['id'] == null) {
    ?>
    <h1>Welcome to CareerOne!</h1>
    <h2>Please log in:</h2>
    <form action = "login_result.php" method = "POST">
        <p align=center>I am a
            <input type="radio" id="student"
            name="user_type" value="student" checked><label for="student">student user</label>
            /<input type="radio" id="company"
            name="user_type" value="company"><label for="company">company user</label>
        </p>
        <table align=center>
        <tr>
            <td><p>Email:</p></td>
            <td><input type="text" name="email" placeholder="Your email"></td>
        </tr>
        <tr>
            <td><p>Password:</p></td>
            <td><input type="password" name="pwd" placeholder="Your password"></td>
        </tr>
        </table>
        <p align=center><button type="submit" name="submit">Login</button></p>
    </form>
    <?php } else { ?>
    <h1>Welcome to CareerOne, <?php echo $_SESSION['name'];?>!</h1>
    <h2>Job Search:</h2>
    
    <form action = "search_result.php" method = "POST" align=center>
        <input type="text" name="keyword" placeholder="Keyword">
        <p align=center>Search keyword in</p>
        
        <table align=center>
        <tbody align=left>
        <tr>
            <td><input type="checkbox" id="title" name="searchin[]" value="title" checked></td>
            <td><label for="title">job title</label></td>
        </tr>
        <tr>
            <td><input type="checkbox" id="location" name="searchin[]" value="location" checked></td>
            <td><label for="location">job location</label></td>
        </tr>
        <tr>
            <td><input type="checkbox" id="title" name="searchin[]" value="description" checked></td>
            <td><label for="description">job description</label></td>
        </tr>
        </tbody>
        </table>
        <p align=center><button type="submit" name="submit">Search!</button></p>
    </form>
    <?php } ?>
</div>

<?php include_once 'includes/footer.php';?>