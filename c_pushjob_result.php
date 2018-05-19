<?php
    $title_suffix = 'Push Job Announcements';
    $error_message = '';
    include_once 'includes/dbh.inc.php';
    include 'includes/logincheck.inc.php';
    if (!$is_login or $_SESSION['user_type'] != 'company') {
        header('Location: index.php');
        exit();
    }
    $where = '';
    $or = '';
    if (array_key_exists('searchin', $_POST) and in_array('university', $_POST['searchin'])) {
        $where = "$where$or university LIKE '%" .
            mysqli_real_escape_string($conn, $_POST['university']) . "%'";
        $or = ' AND';
    }
    if (array_key_exists('searchin', $_POST) and in_array('degree', $_POST['searchin'])) {
        $where = "$where$or degree LIKE '%" .
            mysqli_real_escape_string($conn, $_POST['degree']) . "%'";
        $or = ' AND';
    }
    if (array_key_exists('searchin', $_POST) and in_array('major', $_POST['searchin'])) {
        $where = "$where$or major LIKE '%" .
            mysqli_real_escape_string($conn, $_POST['major']) . "%'";
        $or = ' AND';
    }
    if (array_key_exists('searchin', $_POST) and in_array('gpa', $_POST['searchin'])) {
        $where = "$where$or GPA >= " .
            mysqli_real_escape_string($conn, $_POST['gpa']);
        $or = ' AND';
    }
    if (!array_key_exists('searchin', $_POST) or in_array('resume', $_POST['searchin']))
        $where = "$where$or resume LIKE '%" .
            mysqli_real_escape_string($conn, $_POST['resume']) . "%'";
    if ($where == '')
        $error_message = 'Please check fields to search in.';
    else {
        $result = $conn->query("SELECT * FROM student WHERE $where");
        if ($result == null or $result->num_rows == 0)
            $content = "<h2>No Results.</h2>";
        else {
            $content = '<h2>Results</h2><table align=center class="filled"><tr>
<th>Name</th><th>University</th><th>Degree</th><th>Major</th><th>GPA</th></tr>';
            while($row = $result->fetch_assoc()) {
                $content = $content . '<tr>
<td><a href="student.php?id=' . $row['sid'] . '">' . $row['sname'] . '</a></td>
<td>' . $row['university'] . '</a></td>
<td>' . $row['degree'] . '</a></td>
<td>' . $row['major'] . '</a></td>
<td>' . $row['GPA'] . '</a></td>
</tr>';
            }
            
            $content = "$content</table><p><br><br>Selected the job to push announcements to students above.</p>
            <form action='c_pushjob_result_result.php' method='POST'>
            <table align=center class='filled'><tr><th>Job ID</th><th>Title</th><th></th>";
            
            $result = $conn->query("SELECT * FROM job WHERE cid =" . $_SESSION['id']);
            while($row = $result->fetch_assoc())
                $content = "$content<tr>
                <td>".$row['jid']."</td>
                <td>".$row['title']."</td>
                <td>
                <input type='hidden' name='jid' value='".$row['jid']."'>
                <button type='submit' name='submit'>Push announcements of this job</button>
                </td></tr>";
            $content = "$content</table></form>";
            $_SESSION['where'] = $where;
        }
    }
    
    include_once 'includes/header.php';
    
    echo '<div class="main-container">';
    if (strcmp($error_message, ''))
        echo '
            <h2>Error</h2><p align=center>' . $error_message . '
            Return to the <a href="index.php">home page</a> and try again.</p>';
    else
        echo $content;
    echo '</div>';
    
    include_once 'includes/footer.php';
?>