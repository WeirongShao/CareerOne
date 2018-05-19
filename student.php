<?php
    $title_suffix = 'Home Page';
    include_once 'includes/header.php';
    include_once 'includes/dbh.inc.php';

    $sid=$_GET['id'];
    if (!is_numeric($sid) or floor($sid)!=$sid)
    {header ('Location: index.php');exit;}
    if(isset($_POST["submit"])) {
 		$sid_requester=$_SESSION['id'];
	$text = $_POST["text"];
 		$sql1 = "INSERT INTO friend_request(requesttime, sid, sid_requester, requesttext) VALUES (NOW(), '$sid', '$sid_requester', '$text');";
 		mysqli_query($conn, $sql1);
		header('Location: s_friend.php');
        exit();
    }
    
    //echo $addq;
    $sql = "SELECT * FROM student WHERE sid = '$sid'";
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);
    if ($num==0) {header ('Location: index.php');exit;}
    

	
 	//echo $sid_requester;
 	//echo $date_add(NOW(), interval 3 MONTH);
 	$sid =$_GET['id'];
	$sql2 = "SELECT cid,cname FROM following NATURAL JOIN company WHERE sid = $sid ";
	$result2 = mysqli_query($conn, $sql2);
	$num2 = mysqli_num_rows($result2);
    
    
    $result3 = mysqli_query($conn, "SELECT sid,sname FROM friend NATURAL JOIN student WHERE sid2 = $sid");
    $num3 = mysqli_num_rows($result3);
?>
<!DOCTYPE html>
<html>
 <head>
 <body>
  <div class='main-container'>
  <?php
    $row = mysqli_fetch_array($result);
	?>
  <h1><?php echo $row['sname'];?></h1>
    
   <table id = "view_table" align=center class="filled">
   
   
    <tr><th> Email </th><td><?php echo $row['semail']?></td></tr>
	<tr><th> University </th><td><?php echo $row['university']?></td></tr>
	<tr><th> Degree </th><td><?php echo $row['degree']?></td></tr>
	<tr><th> Major </th><td><?php echo $row['major']?></td></tr>
    <?php
    $show=false;
    if (!$row['restricted'])
        $show=true;
    else if($_SESSION['user_type'] == 'student') {
        $sql = "SELECT * FROM friend WHERE sid = $sid AND sid2 = " . $_SESSION['id'];
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result))
            $show=true;
    }
    else {
        $sql = "SELECT * FROM follow WHERE sid = $sid AND cid = " . $_SESSION['id'];
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result))
            $show=true;
        else{$sql = "SELECT * FROM job_application NATURAL JOIN job WHERE sid = $sid AND cid = " . $_SESSION['id'];
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result))
            $show=true;
        }
    }
    if($show){
    ?>
	<tr><th> GPA </th><td><?php echo $row['GPA']?></td></tr>
	<tr><th> Interests </th><td><?php echo $row['interests']?></td></tr>
	<tr><th> Qualifications </th><td><?php echo $row['qualifications']?></td></tr>
	<tr><th> Resume </th><td><?php echo $row['resume']?></td></tr>
    <?php } ?>

	
  </table>
  <p align=center>
  <?php 
  if ($_SESSION['user_type'] == 'student') { // Have logged in as student now
    if(    $sid != $_SESSION['id']){
                $sql = "SELECT * FROM friend WHERE sid = $sid AND sid2 = " . $_SESSION['id'];
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result)==0) {
                    ?>
                    <form action = <?php echo '"student.php?id=' .$_GET['id'].'"'?> method = "post" align=center>
                     
                      Add Friend? <input type = "text" name = "text" placeholder="Friend request text"/>
                      <input type = "submit" name = "submit"  value = "Send request" required />
                     
                  </form>
                    <?php
                }
                else
                    echo 'You two are friends</p><p align=center>
                <form action="s_message.php" method = "post" align=center>
                Send message: <input type = "text" name = "text">
                <input type="hidden" name="id" value="'. $_GET['id'].'">
                      <input type = "submit" name = "submit"  value = "Send" required >
                      </form>
                ';
  }}
                
                ?></p>
<table align=center>
<tr><th valign="top">
  <h2>Friends:</h2>
  <table id = "view_table" align=center class="filled">
  <?php
     for($i = 1; $i <= $num3; $i=$i+1){
		 $row = mysqli_fetch_array($result3);
	?>
  <tr><td><a href=<?php echo '"student.php?id=' . $row['sid'] . '"'?>><?php echo $row['sname']?></td></tr>
  <?php
	 }
   ?>
  </table>
  </th><th><h1>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</h1></th><th valign="top">
  
  <h2>Followed companies:</h2>
  <table id = "view_table" align=center class="filled">
   
   <?php
     for($i = 1; $i <= $num2; $i=$i+1){
		 $row = mysqli_fetch_array($result2);
	?>
    
	 <tr><td><a href=<?php echo '"company.php?id=' . $row['cid'] . '"'?>><?php echo $row['cname']?></td>
	</tr>
	<?php
	 }
   ?>
   </th></tr></table>
  </div>
  </body>
 </html>