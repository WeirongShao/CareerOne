<?php
    $title_suffix = 'Home Page';
    include_once 'includes/header.php';
    include_once 'includes/dbh.inc.php';
    
    if(isset($_POST["Accept"]) || isset($_POST["Reject"])) {
		$applytime = $_POST["applytime"];
        $jid = $_POST["jid"];
        $sid = $_POST["sid"];
        $text = $_POST["text"];
        if(isset($_POST["Accept"]))
            $resss = 'Accepted';
        else
            $resss = 'Rejected';
        $sql1 = "INSERT INTO job_app_reply VALUES ('$applytime', $jid, $sid, NOW(), '$resss','$text', default);";
        mysqli_query($conn, $sql1);
    }
    
    $cid = $_SESSION['id'];
	$sql = " SELECT * FROM company natural join job natural join
    (SELECT applytext, replytext,l.applytime applytime, l.sid sid,l.jid jid, l.status status, result from
    job_application l left join job_app_reply r on l.applytime=r.applytime and l.sid=r.sid and l.jid=r.jid
    ) t natural join student WHERE cid = $cid  ORDER BY applytime DESC";
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);

	
?>
<!DOCTYPE html>
<html>
 <head>
 <body>
 <div class="main-container">
  <h1>Applicants</h1>
  <?php if ($num==0) {echo '<p align=center>You have no received any applications.</p>'; exit();}?>
   <table id = "view_table" align=center class="filled">
   <tr>
    <th> Time </th>
    <th> Student </th>
	<th> Job </th>
	<th> Application </th>
	<th> Status </th>
	<th> Reply </th>
	<th> Result </th>
   </tr>
   <?php
     for($i = 1; $i <= $num; $i=$i+1){
		 $row = mysqli_fetch_array($result);
	?><tr>
	 <td><?php echo $row['applytime']?></td>
	 <td><a href="student.php?id=<?php echo $row['sid'] ?>"><?php echo $row['sname']?></a></td>
     <td><a href="job.php?id=<?php echo $row['jid'] ?>"><?php echo $row['title']?></a></td>
	 <td><?php echo $row['applytext']?></td>
	 <td><?php echo $row['status']?></td>
     <?php if ($row['result'] == '') { ?>
	 <form action = "c_application.php" method = "post">
	  <td>
      <input type='hidden' name='applytime' value=<?php echo '"'.$row['applytime'].'"'?>>
      <input type='hidden' name='sid' value=<?php echo '"'.$row['sid'].'"'?>>
      <input type='hidden' name='jid' value=<?php echo '"'.$row['jid'].'"'?>>
      <input type = "text" name = "text" placeholder="Reply text"/></td>
	  <td><input type = "submit" name = "Accept"  value = "Accept" required /><input type = "submit" name = "Reject"  value = "Reject" required /></td></tr>
    </form>
     <?php } else {
         ?>
     <form action = "c_application.php" method = "post">
	  <td><?php echo $row['replytext']?></td>
	  <td><?php echo $row['result']?></td></tr>
    </form>
<?php
	 }
	 }
     mysqli_query($conn, "update job_application set status='read' where jid in (select jid from job where cid = ".$_SESSION['id'].')');
   ?> 
   </table>
  


  </div>
  </body>
 </html>