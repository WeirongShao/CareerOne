<?php
    $title_suffix = 'Home Page';
    include_once 'includes/header.php';
    include_once 'includes/dbh.inc.php';
    $id = $_GET['id'];
    if (!is_numeric($id) or floor($id)!=$id)
    {header ('Location: index.php');exit;}
    if (isset($_POST['submit']))
        $result = mysqli_query($conn, "INSERT INTO following SELECT " . $_SESSION['id'] . ", $id");
    
    $sql = "SELECT * FROM company WHERE cid = '$id'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result)==0)
    {header ('Location: index.php');exit;}
?>
<!DOCTYPE html>
<html>
<head>
<body>
    <div class='main-container'>
        <h1><?php echo $row['cname'];?></h1>
        <table align=center class="filled">
            <tr><th>Email</th><td><?php echo $row['cemail']?></td></tr>
            <tr><th>Headquarter</th> <td><?php echo $row['headquarter']?></td></tr>
            <tr><th>Industry</th><td><?php echo $row['industry']?></td></tr>
        </table>
        <p align=center>
            <?php
            if ($_SESSION['user_type'] == 'student') { // Have logged in as student now
                $sql = "SELECT * FROM following WHERE cid = $id AND sid = " . $_SESSION['id'];
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result)==0) {
                    ?>
                    <form class="main-container-application" action="company.php?id=<?php echo $id ?>" method="POST">
                        <button type='submit' name='submit'>Follow</button>
                    </form>
                    <?php
                }
                else
                    echo "You have followed this company";
                }
            ?>
        </p>
        <table align=center>
        <tr>
        <th valign="top">
        <h2>Followers:</h2>
        <?php
        // show all students following this company
        $result = mysqli_query($conn, "
            SELECT sid, sname
            FROM following NATURAL JOIN student
            WHERE cid = $id");
        $num = mysqli_num_rows($result);
        if ($num == 0)
            echo "<p align=center>None.</p>";
        else {
        ?>
        <table align=center class="filled">
            <?php
            for($i = 0; $i < $num; $i++) {
                $row = mysqli_fetch_array($result);
            ?>
            <tr>
                <td>
                    <a href="student.php?id=<?php echo $row['sid'] ?>"><?php echo $row['sname']?></a>
                </td>
            </tr>
            <?php
            }
        }
        ?>
        </table>
        </th><th><h1>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</h1></th><th valign="top"><h2>Jobs:</h2>
            <table id = "view_table" align=center class="filled">
            <?php
            $sql = "SELECT * FROM job WHERE cid = $id";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
             for($i = 1; $i <= $num; $i=$i+1){
                 $row = mysqli_fetch_array($result);
            ?>
            <tr><td><a href="job.php?id=<?php echo $row['jid'] ?>"><?php echo $row['title']?></a></td></tr>
            <?php
             }
            ?>
            </table>
        </th>
    </div>
</body>
</html>