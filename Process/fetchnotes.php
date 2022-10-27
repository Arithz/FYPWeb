<?php
    include ('../dbcon.php');
    $output = "";

    //auto assessments query
    if(isset($_POST['query'])) {
        $class = mysqli_real_escape_string($db, $_POST['query']);
        $query = "SELECT Class_Notes from class where Class_Name = '$class'";
    }

    if($query != ""){
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $output .= $row["Class_Notes"];
            }
            echo $output;
        }
    }
?>