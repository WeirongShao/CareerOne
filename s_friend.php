<?php
    $title_suffix = 'Home Page';
    include_once 'includes/header.php';
    include_once 'includes/dbh.inc.php';
    $sid =$_SESSION['id'];
 	
    if(isset($_POST["Accept"]) || isset($_POST["Reject"])) {
		$applytime = $_POST["applytime"];
        $jid = $_POST["sid_requester"];
        $text = $_POST["text"];
        if(isset($_POST["Accept"])){
            $resss = 'Accepted';
            mysqli_query($conn, "INSERT INTO friend VALUES ($jid, $sid)");
            mysqli_query($conn, "INSERT INTO friend VALUES ($sid, $jid)");
        }
        else
            $resss = 'Rejected';
        $sql1 = "INSERT INTO friend_req_reply VALUES ('$applytime', $jid, $sid, NOW(), '$resss','$text', default);";
        mysqli_query($conn, $sql1);
        //echo $sql1; exit();
    }
    
    
	$sql1 = "SELECT sid, sname
	from student natural join friend
	where sid2 = $sid";
        
	$result1 = mysqli_query($conn, $sql1);
	$num1 = mysqli_num_rows($result1);
    
    //$sql = "SELECT * FROM  friend_request  join student on friend_request.sid_requester = student.sid WHERE friend_request.sid = $sid";
   
   
   
    $sql = "select * from (
(select 'Received from' d, l.requesttime requesttime, r.sid sid, sname, requesttext, l.status status, replytext, result
from (friend_request l join student r on l.sid_requester = r.sid)
left join friend_req_reply f on l.sid_requester = f.sid and l.sid = f.sid_replier and l.requesttime = f.requesttime
where l.sid = $sid)
union
(select 'Sent to' d, l.requesttime requesttime, l.sid sid, sname, requesttext, l.status status, replytext, result
from (friend_request l natural join student)
left join friend_req_reply f on l.sid_requester = f.sid and l.sid = f.sid_replier and l.requesttime = f.requesttime
where l.sid_requester = $sid)) u ORDER BY requesttime DESC";
        
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);

?>
<!DOCTYPE html>
<html>
 <body>
 <div class='main-container'>
  <h1>Friends</h1>
  <?php if ($num1==0) {echo '<p align=center>You have not added any friends.</p>'; }//exit();}?>
  <form method = "post">
  </form>
  <table id = "view_table" align=center class="filled">
   <!--<tr>
    <th> sid </th>
	<th> sid2 </th>
	<th> sname </th>
   </tr>-->
   <?php
     for($i = 1; $i <= $num1; $i=$i+1){
		 $row = mysqli_fetch_array($result1);
	?>
	 <!--<td><?php echo $row['sid2']?></td>
	 <td><?php echo $row['sid']?></td>-->
	 <td><a href="student.php?id=<?php echo $row['sid'] ?>"><?php echo $row['sname']?></a></td>
	</tr>
	<?php
	 }
   ?>
  </table>
  
  <h1>Friend requests</h1>
  <?php if ($num==0) {echo '<p align=center>You have not received any requests.</p>'; exit();}?>
   <table id = "view_table" align=center class="filled">
   <tr>
   <th></th>
    <th> Requester </th>
	<th> Text </th>
	<th> Time </th>
    <th> Status </th>
	<th> Reply </th>
	<th> Result </th>
   </tr>
   <?php
     for($i = 1; $i <= $num; $i=$i+1){
		 $row = mysqli_fetch_array($result);
	?><tr>
    <td><?php echo $row['d']?></td>
	 <td><a href="student.php?id=<?php echo $row['sid'] ?>"><?php echo $row['sname']?></a></td>
	 <td><?php echo $row['requesttext']?></td>
     <td><?php echo $row['requesttime']?></td>
	 <td><?php echo $row['status']?></td>
	 <?php if ($row['result'] != '')
     { ?><td><?php echo $row['replytext']?></td>
	  <td><?php echo $row['result']?></td></tr>
        <?php } else if($row['d']=='Received from') {
         ?><td><form action = "s_friend.php" method = "post">
	  <input type = "text" name = "text" placeholder="Reply text"/></td>
      <input type='hidden' name='applytime' value=<?php echo '"'.$row['requesttime'].'"'?>>
      <input type='hidden' name='sid_requester' value=<?php echo '"'.$row['sid'].'"'?>>
      <td><input type = "submit" name = "Accept"  value = "Accept" required />
      <input type = "submit" name = "Reject"  value = "Reject" required /></form></td>
	  </tr>
       <?php } else { ?>
       <td></td><td></td> </tr>
	<?php
	 }}mysqli_query($conn, "update friend_request set status='read' where sid = ".$_SESSION['id']);
     mysqli_query($conn, "update friend_req_reply set status='read' where sid = ".$_SESSION['id']);
   ?>
   </table>	
   <br>
</div>
   </body>
 </html>
 <?php include_once 'includes/footer.php';?>