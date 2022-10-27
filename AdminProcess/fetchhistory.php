<?php
    include ('../dbcon.php');
    session_start();
    $output = "";

    $query = "SELECT * from session inner join admins on session.Admin_ID = admins.Admin_ID order by Session_Date DESC";
    $result = mysqli_query($db, $query);
    if($query != "") {
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $output .= '<p>Username: '.$row['Admin_Username'].' - '.$row['Session_Date'].'</p>';
            }
            echo $output;
        }
    }
?>