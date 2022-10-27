<?php
    include ('../dbcon.php');
    $output = "";

    //auto assessments query
    if(isset($_POST['query'])) {
        $class = mysqli_real_escape_string($db, $_POST['query']);
        $text = mysqli_real_escape_string($db, $_POST['text']);
        $query = "UPDATE class SET Class_Notes = '$text' where Class_Name = '$class'";
        $db->query($query);
    }
?>