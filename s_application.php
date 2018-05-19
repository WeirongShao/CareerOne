<?php
    $title_suffix = 'Home Page';
    include_once 'includes/header.php';
    include_once 'includes/dbh.inc.php';
    $sid = $_SESSION['id'];
	$sql = "
SELECT * from (SELECT cid, cname, jid, title, applytext, applytime, status, 'Sent to' d, '' res
FROM job_application natural join job natural join company WHERE sid = $sid
union
select cid, cname, jid, title, replytext, replytime, status, 'Received from' d, result res
from job_app_reply natural join job natural join company WHERE sid = $sid) t order by applytime desc";
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);
 	
?>
<!DOCTYPE html>
<html>
 <head>
 <body>
 <div class="main-container">
  <h1>My Applications</h1>
  <?php if ($num==0) {echo '<p align=center>You have not applied to any jobs.</p>'; exit();}?>
   <table id = "view_table" align=center class="filled">
   <tr>
   <th></th>
    <th> Company </th>
	<th> Job Title </th>
	<th> Text </th>
	<th> Time </th>
    <th> Result </th>
	<th> Status </th>
   </tr>
   <?php
     for($i = 1; $i <= $num; $i=$i+1){
		 $row = mysqli_fetch_array($result);
	?>
    <td><?php echo $row['d']?></td>
	<td><a href="company.php?id=<?php echo $row['cid'] ?>"><?php echo $row['cname']?></a></td>
     <td><a href="job.php?id=<?php echo $row['jid'] ?>"><?php echo $row['title']?></a></td>
	 <td><?php echo $row['applytext']?></td>
     <td><?php echo $row['applytime']?></td>
     <td><?php echo $row['res']?></td>
	 <td><?php echo $row['status']?></td>
	</tr>
	<?php
	 }
     mysqli_query($conn, "update job_app_reply set status='read' where sid = ".$_SESSION['id']);
   ?>
  </table>
  </div>
  </body>
 </html>