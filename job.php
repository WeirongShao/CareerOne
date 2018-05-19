<?php
    $title_suffix = 'Home Page';
    include_once 'includes/header.php';
    include_once 'includes/dbh.inc.php';

    $jid=$_GET['id'];
    if (!is_numeric($jid) or floor($jid)!=$jid)
    {header ('Location: index.php');exit;}
    //echo $addq;
    $sid=$_SESSION['id'];

    if(isset($_POST["submit"])) {
 		$text = $_POST["text"];
 		$sql1 = "INSERT INTO job_application(applytime, sid, jid, applytext) VALUES (NOW(), '$sid', '$jid', '$text');";
 		$result1 = mysqli_query($conn, $sql1);
		header("Location: s_application.php");
        exit();
    }

	$sql = "SELECT * FROM job natural join company WHERE jid = $jid ";
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);
    if ($num==0) {header ('Location: index.php');exit;}
?>
<!DOCTYPE html>
<html>
 <head>
 <body>
  <div class='main-container'><?php
     for($i = 1; $i <= $num; $i=$i+1){
		 $row = mysqli_fetch_array($result);
	?>
  <h1>Job title: <?php echo $row['title'];?></h1>
    
   <table id = "view_table" align=center class="filled">
   <tr><th> Company </th><td><a href="company.php?id=<?php echo $row['cid'] ?>"><?php echo $row['cname']?></a></td></tr>
	<tr><th> Location </th><td><?php echo $row['location']?></td></tr>
	<tr><th> Salary </th><td><?php echo $row['salary']?></td></tr>
	<tr><th> Required degree </th><td><?php echo $row['required_degree']?></td></tr>
	<tr><th> Required major </th><td><?php echo $row['required_major']?></td></tr>
	<tr><th> Description </th><td><?php echo $row['description']?></td></tr>
	<tr><th> Post time </th><td><?php echo $row['posttime']?></td></tr>
	<tr><th> Available </th><td><?php if ($row['available']) echo 'Yes'; else echo 'No' ;?></td></tr>

	<?php
	 }
   ?>
  </table><?php if ($_SESSION['user_type']=='student') {?>
  <p>
  <form align=center action = <?php echo '"job.php?id=' .$_GET['id'].'"'?> method = "post">
  	 Apply Now? <input type = "text" name = "text" placeholder="Application"/>
     <input type = "submit" name = "submit"  value = "Confirm" required />
  </form></p><?php } ?>
  </div>
  </body>
 </html>