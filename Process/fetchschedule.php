<?php
    include ('../dbcon.php');
    $output = "";

    //auto assessments query
    if(isset($_POST['query'])) {
        $class = mysqli_real_escape_string($db, $_POST['query']);
        $day = mysqli_real_escape_string($db, $_POST['day']);

        $query = 
        "SELECT * FROM schedule s 
        inner join class c on s.Class_ID = c.Class_ID inner join lecturer l on s.Lecturer_ID = l.Lecturer_ID inner join subject sub on s.Subject_Code = sub.Subject_Code 
        where c.Class_Name = '$class' AND s.Schedule_Day = '$day' AND NOT EXISTS 
        (select 1 from request r where r.Request_Description = CONCAT(s.Schedule_Day,' ', TIME_FORMAT(s.Schedule_TimeStart,'%H:%i'),' ',TIME_FORMAT(s.Schedule_TimeEnd,'%H:%i'),' ', l.Lecturer_Name,' ', c.Class_Name,' ', sub.Subject_Code, ' ',s.Schedule_Location) AND NOT Status_ID = '2')
        ";
    }

    if($query != ""){
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $time = date("h:i A", strtotime($row["Schedule_TimeStart"])) .' - '. date("h:i A", strtotime($row["Schedule_TimeEnd"]));
                $output .=
                '
                <div class = "scheduledata">
                    <p class = "subject" value = '.$row["Schedule_TimeStart"].'><b>'.$row["Subject_Code"].': &nbsp'.$time.'</b></p>
                    <p id = "subjecttitle">'.$row['Subject_Name'].'</p>
                    <p id = "lecturername">'.$row['Lecturer_Name'].'</p>
                    <p id = "platform">'.$row['Schedule_Location'].'</p>
                </div>
                ';
            }
            echo $output;
        }else {
            $output .= 
            '
            <div class = "scheduledata">
                <p class = "subject"><b>No Class Today</b></p>
                <p id = "subjecttitle"></p>
                <p id = "lecturername"></p>
                <p id = "platform"></p>
            </div>
            ';
            echo $output;
        }
    }
?>