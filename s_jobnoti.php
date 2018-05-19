<?php
    $title_suffix = 'Home Page';
    include_once 'includes/header.php';
    include_once 'includes/dbh.inc.php';
    $sid = $_SESSION['id'];
    $sql = "SELECT  *
            FROM noti_job NATURAL JOIN job NATURAL JOIN company where sid = $sid order by notitime desc";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html>
 <head>
 <body>
 <div class='main-container'>
  <h1>Job notifications</h1>
  <?php if ($num==0) {echo '<p align=center>You have no notifications.</p>'; exit();}?>
   <table id = "view_table" align=center class="filled">
   <tr>
    <th> Company </th>
    <th> Job </th>
    <th> Time </th>
    <th> Status </th>
   </tr>
   <?php
     for($i = 1; $i <= $num; $i=$i+1){
     $row = mysqli_fetch_array($result);
  ?>
   <td><a href="company.php?id=<?php echo $row['cid'] ?>"><?php echo $row['cname']?></a></td>
   <td><a href="job.php?id=<?php echo $row['jid'] ?>"><?php echo $row['title']?></a></td>
   <td><?php echo $row['notitime']?></td>
   <td><?php echo $row['status']?></td>
  
  </tr>
  <?php
   }
   
   mysqli_query($conn, "update noti_job set status='read' where sid = ".$_SESSION['id']);
   //mysqli_query($conn, "update noti_job_fwd set status='read' where sid = ".$_SESSION['id']);
   ?>
  </table>
  </div>
  </body>
 </html>