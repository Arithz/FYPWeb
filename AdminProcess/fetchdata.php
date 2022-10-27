<?php
    include ('../dbcon.php');
    $output = "";

    if(isset($_POST['query'])) {
        $category = $_POST['query'];
        $search = "";
        if(isset($_POST['search'])) {
            $search = $_POST['search'];
        }
        
        if($category === 'class') {
            load_class($search);
        }else if($category === 'lecturer') {
            load_lecturer($search);
        }else if($category === 'subject') {
            load_subject($search);
        }else if($category === 'schedule') {
            load_schedule($search);
        }
        echo $output;
    }

    if(isset($_POST['data'])) {
        $data = $_POST['data'];
        $type = $_POST['type'];
        delete_data($data,$type);
    }

    function load_class($search) {
        global $db; global $output;

        if($search !== "") {
            $query = "SELECT C.* FROM class C WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description= C.Class_Name AND NOT Status_ID = '2') AND Class_Name like '%".$search."%'";
        }else {
            $query = "SELECT C.* FROM class C WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description= C.Class_Name AND NOT Status_ID = '2')";
        }

        if($query != "") {
            $result = mysqli_query($db, $query);
            $output .= 
            '
            <div id = "classtable" class = "cactive">
                    <ul class="responsive-table">
                        <li class="table-header">
                            <div class="col col-1">Class ID</div>
                            <div class="col col-2">Class Name</div>
                            <div class="col col-3">Category</div>
                            <div class="col col-4">Action</div>
                        </li>
            ';

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $output .= 
                    '
                            <li class="table-row">
                                <div class="col col-1" data-label="Class ID">'.$row["Class_ID"].'</div>
                                <div class="col col-2" data-label="Class Name">'.$row["Class_Name"].'</div>
                                <div class="col col-3" data-label="Category">Class</div>
                                <div class="col col-4" data-label="Action"><i class="bi bi-trash" data = '.$row["Class_ID"].' type = "class">&nbsp;Delete</i></div>
                            </li>
                    ';
                }
                $output .= '</ul></div>';
            }
        }
    }

    function load_lecturer($search) {
        global $db; global $output;

        if($search !== "") {
            $query = "SELECT l.* FROM lecturer l WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description= l.Lecturer_Name AND NOT Status_ID = '2') AND Lecturer_Name like '%".$search."%'";
        }else {
            $query = "SELECT l.* FROM lecturer l WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description= l.Lecturer_Name AND NOT Status_ID = '2')";
        }

        if($query != "") {
            $result = mysqli_query($db, $query);
            $output .= 
            '
            <div id = "classtable" class = "cactive">
                    <ul class="responsive-table">
                        <li class="table-header">
                            <div class="col col-1">Lecturer ID</div>
                            <div class="col col-2">Lecturer Name</div>
                            <div class="col col-3">Category</div>
                            <div class="col col-4">Action</div>
                        </li>
            ';

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $output .= 
                    '
                            <li class="table-row">
                                <div class="col col-1" data-label="Class ID">'.$row["Lecturer_ID"].'</div>
                                <div class="col col-2" data-label="Class Name">'.$row["Lecturer_Name"].'</div>
                                <div class="col col-3" data-label="Category">Lecturer</div>
                                <div class="col col-4" data-label="Action"><i class="bi bi-trash" data = '.$row["Lecturer_ID"].' type = "lecturer">&nbsp;Delete</i></div>
                            </li>
                    ';
                }
                $output .= '</ul></div>';
            }
        }
    }

    function load_subject($search) {
        global $db; global $output;

        if($search !== "") {
            $query = "SELECT S.* FROM subject S WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description = CONCAT(S.Subject_Code, ' ', S.Subject_Name) AND NOT Status_ID = '2') AND S.Subject_Code like '%".$search."%' OR S.Subject_Name like '%".$search."%'";
        }else {
            $query = "SELECT S.* FROM subject S WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description = CONCAT(S.Subject_Code, ' ', S.Subject_Name) AND NOT Status_ID = '2')";
        }

        if($query != "") {
            $result = mysqli_query($db, $query);
            $output .= 
            '
            <div id = "classtable" class = "cactive">
                    <ul class="responsive-table">
                        <li class="table-header">
                            <div class="col col-1">Subject Code</div>
                            <div class="col col-2">Subject Name</div>
                            <div class="col col-3">Category</div>
                            <div class="col col-4">Action</div>
                        </li>
            ';

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $output .= 
                    '
                            <li class="table-row">
                                <div class="col col-1" data-label="Class ID">'.$row["Subject_Code"].'</div>
                                <div class="col col-2" data-label="Class Name">'.$row["Subject_Name"].'</div>
                                <div class="col col-3" data-label="Category">Subject</div>
                                <div class="col col-4" data-label="Action"><i class="bi bi-trash" data = '.$row["Subject_Code"].' type = "subject">&nbsp;Delete</i></div>
                            </li>
                    ';
                }
                $output .= '</ul></div>';
            }
        }
    }

    function load_schedule($search) {
        global $db; global $output;
        $time = date("H:i:s", strtotime($search));
        
        if($search !== "") {
            $query = 
            "SELECT * FROM schedule s 
            inner join class c on s.Class_ID = c.Class_ID inner join lecturer l on s.Lecturer_ID = l.Lecturer_ID inner join subject sub on s.Subject_Code = sub.Subject_Code 
            where NOT EXISTS 
            (select 1 from request r where r.Request_Description = CONCAT(s.Schedule_Day,' ', TIME_FORMAT(s.Schedule_TimeStart,'%H:%i'),' ',TIME_FORMAT(s.Schedule_TimeEnd,'%H:%i'),' ', l.Lecturer_Name,' ', c.Class_Name,' ', sub.Subject_Code, ' ',s.Schedule_Location) AND NOT Status_ID = '2')
            AND s.Schedule_Day like '%".$search."%' OR s.Schedule_TimeStart like '%".$time."%' OR s.Schedule_TimeEnd like '%".$time."%' OR s.Schedule_Location like '%".$search."%' OR l.Lecturer_Name like '%".$search."%' OR l.Lecturer_Name like '%".$search."%' OR c.Class_Name like '%".$search."%' 
            OR sub.Subject_Code like '%".$search."%' 
            ORDER BY Schedule_ID";

        }else {
            $query = 
            "SELECT * FROM schedule s 
            inner join class c on s.Class_ID = c.Class_ID inner join lecturer l on s.Lecturer_ID = l.Lecturer_ID inner join subject sub on s.Subject_Code = sub.Subject_Code 
            where NOT EXISTS 
            (select 1 from request r where r.Request_Description = CONCAT(s.Schedule_Day,' ', TIME_FORMAT(s.Schedule_TimeStart,'%H:%i'),' ',TIME_FORMAT(s.Schedule_TimeEnd,'%H:%i'),' ', l.Lecturer_Name,' ', c.Class_Name,' ', sub.Subject_Code, ' ',s.Schedule_Location) AND NOT Status_ID = '2')
            ORDER BY Schedule_ID";
        }

        if($query != "") {
            $result = mysqli_query($db, $query);
            $output .= 
            '
            <div id = "classtable" class = "cactive">
                    <ul class="responsive-table">
                        <li class="table-header">
                            <div class="col sc-1">ID</div>
                            <div class="col sc-2">Lecturer Name</div>
                            <div class="col sc-3">Class Name</div>
                            <div class="col sc-4">Subject Code</div>
                            <div class="col sc-5">Location</div>
                            <div class="col sc-6">Day</div>
                            <div class="col sc-7">Time</div>
                            <div class="col sc-8">Action</div>
                        </li>
            ';

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $time = date("h:i A", strtotime($row["Schedule_TimeStart"])) .' - '. date("h:i A", strtotime($row["Schedule_TimeEnd"]));
                    $output .= 
                    '
                        <li class="table-row">
                            <div class="col sc-1" data-label="Schedule ID">'.$row['Schedule_ID'].'</div>
                            <div class="col sc-2" data-label="Lecturer Name">'.$row['Lecturer_Name'].'</div>
                            <div class="col sc-3" data-label="Class Name">'.$row['Class_Name'].'</div>
                            <div class="col sc-4" data-label="Subject Code">'.$row['Subject_Code'].'</div>
                            <div class="col sc-5" data-label="Location">'.$row['Schedule_Location'].'</div>
                            <div class="col sc-6" data-label="Day">'.$row['Schedule_Day'].'</div>
                            <div class="col sc-7" data-label="Time">'.$time.'</div>
                            <div class="col sc-8" data-label="Action"><i class="bi bi-trash" data = '.$row["Schedule_ID"].' type = "schedule">&nbsp;Delete</i></div>
                        </li>
                    ';
                }
                $output .= '</ul></div>';
            }
        }
    }

    function delete_data($data, $type) {
        global $db;
        if($type === 'subject') {
            $query = "DELETE FROM $type where ".$type."_Code = '$data'";
        }else {
            $query = "DELETE FROM $type where ".$type."_ID = '$data'";
        }
        $db->query($query);
    }
?>