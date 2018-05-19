<?php
    $title_suffix = 'Home Page';
    include_once 'includes/header.php';
    include_once 'includes/dbh.inc.php';
    
    if(isset($_POST["submit"])) {
      $sid=$_POST['id'];
 		$sid_requester=$_SESSION['id'];
	$text = $_POST["text"];
 		$sql1 = "INSERT INTO message VALUES ('$sid', '$sid_requester', NOW(),'$text', DEFAULT);";
 		mysqli_query($conn, $sql1);
		//echo $sql1;
    }
    
    $sid = $_SESSION['id'];
  $sql = "SELECT s.sid, sid_from, s.sname sname, s2.sname sname_from, mtime, mtext, status
FROM message natural JOIN student s JOIN student s2 ON s2.sid = sid_from WHERE message.sid = 101 OR sid_from = 101 ORDER BY mtime DESC";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  
  
  
?>
<!DOCTYPE html>
<html>
 <head>
 <body>
 <div class='main-container'>
  <h1>Messages</h1>
  <?php if ($num==0) {echo '<p align=center>You have no messages.</p>'; exit();}?>
   <table id = "view_table" align=center class="filled">
   <tr>
    <th> From </th>
    <th> To </th>
    <th> Text </th>
    <th> Time </th>
    
    <th> Status </th>
    <th></th>
   </tr>
   <?php
     for($i = 1; $i <= $num; $i=$i+1){
     $row = mysqli_fetch_array($result);
  ?>
   <td><a href=<?php echo '"student.php?id=' . $row['sid_from'] . '"'?>><?php echo $row['sname_from']?></td>
   <td><a href=<?php echo '"student.php?id=' . $row['sid'] . '"'?>><?php echo $row['sname']?></td>
   <td><?php
   $text = $row['mtext'];
   if (strpos($text, 'job.php?id=')) {
       $jidd=(int)filter_var($text, FILTER_SANITIZE_NUMBER_INT);
       $ress=mysqli_query($conn, 'select title from job where jid ='.$jidd);
       $roww= mysqli_fetch_array($ress);
       echo 'Shared a job: <a href="job.php?id='.$jidd.'">'.$roww['title'].'</a>';
   } else
       echo $text;
   ?></td>
   <td><?php echo $row['mtime']?></td>
   <td><?php echo $row['status']?></td>
   <td><form action="s_message.php" method = "post">
   <input type = "text" name = "text">
   <input type="hidden" name="id" value="<?php
   if ($row['sid_from'] == $sid) {echo $row['sid'];$a='Send';}else {echo $row['sid_from'];$a='Reply';}
   ?>">
   <input type = "submit" name = "submit"  value = "<?php echo $a?>" required >
   </form></td>
   
  </tr>
  <?php
   }
   
   mysqli_query($conn, "update message set status='read' where sid = ".$_SESSION['id']);
   
   ?>
  </table>
  </div>
  </body>
 </html>