<?php
    include ('../dbcon.php');
    session_start();


    //lecturer approval
    if(isset($_GET["lectid"])) {
        $id = $_GET["lectid"];
        $input = $_GET["input"];
        
        $query = "SELECT R.* FROM request R inner join lecturer l on l.Lecturer_Name=r.Request_Description where l.Lecturer_ID = '$id'";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $requestid = $row['Request_ID'];
        $updatequery = "UPDATE request SET Status_ID = '$input' where Request_ID = '$requestid.'";
        $db->query($updatequery);

        if($updatequery) {
            if($input == 3) {
                $deletequery = "DELETE FROM lecturer where Lecturer_ID = '$id'";
                $db->query($deletequery);
            }
            echo "<script>alert('Data updated')</script>";
            print "<script>window.location.assign('../Admin/dashboard.php');</script>";
        }else {
            echo "<script>alert('Data failed to update!')</script>";
            print "<script>window.location.assign('../Admin/dashboard.php');</script>";
        }
    }

    //class approval
    if(isset($_GET["classid"])) {
        $id = $_GET["classid"];
        $input = $_GET["input"];

        $query = "SELECT R.* FROM request R inner join class c on c.Class_Name=r.Request_Description where c.Class_ID = '$id'";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $requestid = $row['Request_ID'];
        $updatequery = "UPDATE request SET Status_ID = '$input', Request_Date = NOW() where Request_ID = '$requestid.'";
        $db->query($updatequery);

        if($updatequery) {
            if($input == 3) {
                $deletequery = "DELETE FROM class where Class_ID = '$id'";
                $db->query($deletequery);
            }
            echo "<script>alert('Data updated')</script>";
            print "<script>window.location.assign('../Admin/dashboard.php');</script>";
        }else {
            echo "<script>alert('Data failed to update!')</script>";
            print "<script>window.location.assign('../Admin/dashboard.php');</script>";
        }
    }


    //subject approval
    if(isset($_GET["subjectid"])) {
        $id = $_GET["subjectid"];
        $input = $_GET["input"];

        $query = "SELECT R.* FROM request R inner join subject s on R.Request_Description = CONCAT(s.Subject_Code, ' ', s.Subject_Name) where s.Subject_Code = '$id'";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $requestid = $row['Request_ID'];
        $updatequery = "UPDATE request SET Status_ID = '$input' where Request_ID = '$requestid.'";
        $db->query($updatequery);

        if($updatequery) {
            if($input == 3) {
                $deletequery = "DELETE FROM subject where Subject_Code = '$id'";
                $db->query($deletequery);
            }
            echo "<script>alert('Data updated')</script>";
            print "<script>window.location.assign('../Admin/dashboard.php');</script>";
        }else {
            echo "<script>alert('Data failed to update!')</script>";
            print "<script>window.location.assign('../Admin/dashboard.php');</script>";
        }
    }

    //schedule approval
    if(isset($_GET["scheduleid"])) {
        $id = $_GET["scheduleid"];
        $input = $_GET["input"];

        $query = 
        "SELECT * FROM schedule s 
        inner join class c on s.Class_ID = c.Class_ID inner join lecturer l on s.Lecturer_ID = l.Lecturer_ID inner join subject sub on s.Subject_Code = sub.Subject_Code 
        inner join request r on r.Request_Description = CONCAT(s.Schedule_Day,' ', TIME_FORMAT(s.Schedule_TimeStart,'%H:%i'),' ',TIME_FORMAT(s.Schedule_TimeEnd,'%H:%i'),' ', l.Lecturer_Name,' ', c.Class_Name,' ', sub.Subject_Code, ' ',s.Schedule_Location) where s.Schedule_ID = '$id'
        ";

        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $requestid = $row['Request_ID'];
        $updatequery = "UPDATE request SET Status_ID = '$input' where Request_ID = '$requestid.'";
        $db->query($updatequery);

        if($updatequery) {
            if($input == 3) {
                $deletequery = "DELETE FROM schedule where Schedule_ID = '$id'";
                $db->query($deletequery);
            }
            echo "<script>alert('Data updated')</script>";
            print "<script>window.location.assign('../Admin/dashboard.php');</script>";
        }else {
            echo "<script>alert('Data failed to update!')</script>";
            print "<script>window.location.assign('../Admin/dashboard.php');</script>";
        }
    }
?>