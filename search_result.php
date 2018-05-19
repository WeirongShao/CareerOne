<?php
    $title_suffix = 'Job Search';
    $error_message = '';
    include_once 'includes/dbh.inc.php';
    include 'includes/logincheck.inc.php';
    if (!$is_login) {
        header('Location: index.php');
        exit();
    }
    if (!isset($_POST['submit']))
        $error_message = "Unknown error.";
    else {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    
    $select = 'cid, jid, cname, title, location, description, available';
    $where = '';
    $or = '';
    if (!array_key_exists('searchin', $_POST) or in_array('title', $_POST['searchin'])) {
        $where = "$where$or title LIKE '%$keyword%'";
        $or = ' OR';
    }
    if (!array_key_exists('searchin', $_POST) or in_array('location', $_POST['searchin'])) {
        $where = "$where$or location LIKE '%$keyword%'";
        $or = ' OR';
    }
    if (!array_key_exists('searchin', $_POST) or in_array('description', $_POST['searchin'])) {
        $where = "$where$or description LIKE '%$keyword%'";
        $or = ' OR';
    }
    if ($where == '')
        $error_message = 'Please check fields to search in.';
    else {
        $result = $conn->query("SELECT $select FROM job NATURAL JOIN company WHERE $where");
        if ($result == null or $result->num_rows == 0)
            $content = "<h2>No Results.</h2>";
        else {
            $content = '<h2>Results</h2><table align=center class="filled"><tr>
<th>Company</th><th>Job</th><th>Location</th><th>Available</th></tr>';
            while($row = $result->fetch_assoc()) {
                if ($row['available'])
                    $ava = 'Yes';
                else
                    $ava = 'No';
                $content = $content . '<tr>
<td><a href="company.php?id=' . $row['cid'] . '">' . $row['cname'] . '</a></td>
<td><a href="job.php?id=' . $row['jid'] . '">' . $row['title'] . '</a></td>
<td>' . $row['location'] . "</a></td>
<td>$ava</td></tr>";
            }
            $content = "$content</table>";
    }}
    }
    
    include_once 'includes/header.php';
    
    echo '<div class="main-container">';
    if (strcmp($error_message, ''))
        echo '
            <h2>Error</h2><p align=center>' . $error_message . '
            Return to the <a href="index.php">home page</a> and try again.</p>';
    else
        echo "$content";
    echo '</div>';
    
    include_once 'includes/footer.php';
?>