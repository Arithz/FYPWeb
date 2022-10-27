<?php
    include ('../dbcon.php');

    //fetch password for add new data
    if(isset($_POST['password'])){
        $passsearch = mysqli_real_escape_string($db, $_POST['password']);
        if (count($errors) == 0) {
            $query = "SELECT Requester_Password FROM requester WHERE Requester_Password like '$passsearch'";
            $results = mysqli_query($db, $query);
            
            if (mysqli_num_rows($results) == 1) {
                echo "Found";
            }else {
                echo "Not Found";
            }
        }
    }
?>