<?php
    include ('../dbcon.php');
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date = date("Y-m-d H:i:s");
    $output = "";

    //auto assessments query
    if(isset($_POST['query'])) {
        $class = mysqli_real_escape_string($db, $_POST['query']);

        $query = "DELETE FROM assessment WHERE Assessment_Date < NOW() - INTERVAL 1 DAY;";
        $db->query($query);
        $query = "SELECT DATE_FORMAT(Assessment_Date, '%d %M %Y') as Assessment_Date,Assessment_Subject,Assessment_Description from assessment a inner join class c on a.Class_ID = c.Class_ID where c.Class_Name like '$class' ORDER BY Assessment_Date asc";
    }

    if($query != ""){
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $output .=
                '
                    <div class = "assessmentdata">
                        <p id = "deadline"><b>'.$row["Assessment_Date"].'</b></p>
                        <p id = "asssubject">'.$row["Assessment_Subject"].'</p>
                        <p id = "description">'.nl2br($row["Assessment_Description"]).'</p>
                    </div>
                ';
            }
            echo $output;
        }
    }
?>