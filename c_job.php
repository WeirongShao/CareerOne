<?php
    $title_suffix = 'Home Page';
    include_once 'includes/header.php';
    include_once 'includes/dbh.inc.php';
    $cid = $_SESSION['id'] ;
    $sql = "SELECT * FROM job WHERE cid = $cid ORDER BY jid";
	  $result = mysqli_query($conn, $sql);
	  $num = mysqli_num_rows($result);

    $jid_type = 'jid';
    $_SESSION['j_id'] = $jid_type;
	//echo '<h1>Welcome to CareerOne, ' . $_SESSION['id'] . '!</h1>'

?>
<!DOCTYPE html>
<html>
 <head>
 <body>
 <div class='main-container'>
  <h1>My Jobs</h1>
  <?php if ($num==0){ echo '<p align=center>You have not post any job positions.</p>'; exit();}?>
   <table id = "view_table" align=center class="filled">
   <tr>
    <th> Title </th>
    <th> Location </th>
    <th> Salary </th>
    <th> Post Time </th>
    <th> Available </th>
    <th></th>
   </tr>
   <?php
     for($i = 1; $i <= $num; $i=$i+1){
		 $row = mysqli_fetch_array($result);
	?>
	 <td><a href=<?php echo'"job.php?id=' . $row['jid'] . '"'?>>
        <?php echo $row['title']?>
     </a></td>
	 <td><?php echo $row['location']?></td>
	 <td><?php echo $row['salary']?></td>
	 <td><?php echo $row['posttime']?></td>
	 <td><?php if ($row['available']) echo 'Yes'; else echo 'No';?></td>
     <td><form action='c_job_edit.php' method='POST'>
        <input type='hidden' name='jid' value=<?php echo '"'.$row['jid'].'"'?>>
        <button type='submit' name='submit'>Edit</button></form>
     </td>
	</tr>
	<?php
	 }
   ?>
  </table>
  </div>
  </body>
 </html>