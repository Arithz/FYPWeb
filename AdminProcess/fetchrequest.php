<?php
    include ('../dbcon.php');
    $output = "";
    
    //auto complete for class query
    if(isset($_POST['query'])) {
        $query = $_POST['query'];
        if($query === 'lecturer') {
            load_lecturer($query);
        }else if($query === 'class') {
            load_class($query);
        }else if($query === 'subject') {
            load_subject($query);
        }else if($query === 'schedule') {
            load_schedule($query);
        }
    }

    function load_lecturer($query) {
        global $db; global $output;
        $query = "SELECT l.* FROM lecturer l WHERE EXISTS(SELECT 1 FROM request R WHERE R.Request_Description= l.Lecturer_Name AND R.Status_ID = '1')";
        if($query != "") {
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $output .= 
                    '
                        <div id = "item">
                            <p>Name:</p>
                            <a id = "decline" href = ../AdminProcess/approval.php?lectid='.$row["Lecturer_ID"].'&input=3>Decline</a>
                            <a id = "approve" href = ../AdminProcess/approval.php?lectid='.$row["Lecturer_ID"].'&input=2>Approve</a>
                            <p4>'.$row['Lecturer_Name'].'</p4>
                        </div>
                    ';
                }
                echo $output;
            }
        }
    }

    function load_class($query) {
        global $db; global $output;
        $query = "SELECT c.* FROM class c WHERE EXISTS(SELECT 1 FROM request R WHERE R.Request_Description= c.Class_Name AND R.Status_ID = '1')";
        if($query != "") {
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $output .= 
                    '
                        <div id = "item">
                            <p>Name:</p>
                            <a id = "decline" href = ../AdminProcess/approval.php?classid='.$row["Class_ID"].'&input=3>Decline</a>
                            <a id = "approve" href = ../AdminProcess/approval.php?classid='.$row["Class_ID"].'&input=2>Approve</a>
                            <p4>'.$row['Class_Name'].'</p4>
                        </div>
                    ';
                }
                echo $output;
            }
        }
    }

    function load_subject($query) {
        global $db; global $output;
        $query = "SELECT S.* FROM subject S WHERE EXISTS(SELECT 1 FROM request R WHERE R.Request_Description = CONCAT(S.Subject_Code, ' ', S.Subject_Name) AND R.Status_ID = '1')";
        
        if($query != "") {
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $output .= 
                    '
                        <div id = "item">
                            <p>Code: '.$row['Subject_Code'].'</p>
                            <a id = "decline" href = ../AdminProcess/approval.php?subjectid='.$row["Subject_Code"].'&input=3>Decline</a>
                            <a id = "approve" href = ../AdminProcess/approval.php?subjectid='.$row["Subject_Code"].'&input=2>Approve</a>
                            <p4>'.$row['Subject_Name'].'</p3>
                        </div>
                    ';
                }
                echo $output;
            }
        }
    }

    function load_schedule($query) {
        global $db; global $output;
        $query = 
        "SELECT * FROM schedule s 
        inner join class c on s.Class_ID = c.Class_ID inner join lecturer l on s.Lecturer_ID = l.Lecturer_ID inner join subject sub on s.Subject_Code = sub.Subject_Code 
        where EXISTS
        (select 1 from request r where r.Request_Description = CONCAT(s.Schedule_Day,' ', TIME_FORMAT(s.Schedule_TimeStart,'%H:%i'),' ',TIME_FORMAT(s.Schedule_TimeEnd,'%H:%i'),' ', l.Lecturer_Name,' ', c.Class_Name,' ', sub.Subject_Code, ' ',s.Schedule_Location) AND r.Status_ID = '1')
        ";
        
        if($query != "") {
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $output .= 
                    '
                    <div class = "sch" id = "item">
                        <p>Time: '.date("h:i A", strtotime($row["Schedule_TimeStart"])) .' - '. date("h:i A", strtotime($row["Schedule_TimeEnd"])).'</p>
                        <a id = "decline" href = ../AdminProcess/approval.php?scheduleid='.$row["Schedule_ID"].'&input=3>Decline</a>
                        <a id = "approve" href = ../AdminProcess/approval.php?scheduleid='.$row["Schedule_ID"].'&input=2>Approve</a>
                        <p4>Code: '.$row['Subject_Code'].'</p4>
                        <p4>Class: '.$row['Class_Name'].'</p4>
                        <p4>Day: '.$row['Schedule_Day'].'</p4>
                        <p4>Location: '.$row['Schedule_Location'].'</p4>
                        <p4>Lecturer: '.$row['Lecturer_Name'].'</p4>
                    </div>
                    ';
                }
                echo $output;
            }
        }
    }
?>