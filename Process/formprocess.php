<?php
    include ('../dbcon.php');
    date_default_timezone_set("Asia/Kuala_Lumpur");
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

//start of login process
    if (isset($_POST['btn_loginuser'])) {
        $date = date("Y-m-d H:i:s");
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
      
        if (empty($username)) {array_push($errors, "Username is required"); }
        if (empty($password)) {array_push($errors, "Password is required"); }
        if (count($errors) == 0) {
            $password = ($password);
            $query = "SELECT * FROM admins WHERE Admin_Username='$username' AND Admin_Password='$password'";
            $results = mysqli_query($db, $query);
            while($row = mysqli_fetch_array($results)) {
                $id = $row['Admin_ID'];
            }
          
            if (mysqli_num_rows($results) == 1) {
                $_SESSION['username'] = $username;

                $query = "INSERT INTO session(Session_Date,Admin_ID) values ('$date','$id')";
                $db->query($query);
                print "<script>alert('Welcome $username to the Dashboard');</script>";
                header ("Refresh:0; url = ../Admin/dashboard.php");
                die();         
            }else {
                print "<script>alert('Wrong username/password combination')</script>";
                print "<script>window.location.assign('../index.php');</script>";
            }
        }
    }
//end of login process

//start of inserting data

    //start of class register
    if (isset($_POST['btn_classregister'])) {
        $class = mysqli_real_escape_string($db,$_POST['class_txt']);
        $date = date("Y-m-d H:i:s");

        $check_query = "SELECT Class_Name FROM class where Class_Name = '$class'";
        $result = mysqli_query($db, $check_query);
  	    $check = mysqli_fetch_assoc($result);
        if($check !== NULL) {
            echo "<script>alert('Data already exist')</script>";
            print "<script>window.location.assign('../index.php');</script>";
        }else {
            $query = "  INSERT INTO class(Class_Name) value ('$class'); 
                        INSERT INTO request(Request_Description, Request_Category, Request_Date, Status_ID) value ('$class', 'Class','$date','1')";
            $db->multi_query($query);

            if ($query) {
                echo "<script>alert('Class registered successfully')</script>";
                print "<script>window.location.assign('../index.php');</script>";
            } else {
                echo "<script>alert('Data failed to register')</script>";
                print "<script>window.location.assign('../index.php');</script>";
            }
        }
    }
    //end of class register

    //start of lecturer register
    if (isset($_POST['btn_lecturerregister'])) {
        $lecturer = mysqli_real_escape_string($db,$_POST['lecturer_txt']);
        $date = date("Y-m-d H:i:s");

        $check_query = "SELECT Lecturer_Name FROM lecturer where Lecturer_Name = '$lecturer'";
        $result = mysqli_query($db, $check_query);
  	    $check = mysqli_fetch_assoc($result);
        if($check !== NULL) {
            echo "<script>alert('Data already exist')</script>";
            print "<script>window.location.assign('../index.php');</script>";
        }else {
            $query = "  INSERT INTO lecturer(Lecturer_Name) values ('$lecturer');
                        INSERT INTO request(Request_Description, Request_Category, Request_Date, Status_ID) value ('$lecturer', 'Lecturer','$date','1')";
            $db->multi_query($query);

            if($query) {
                echo "<script>alert('Lecturer registered successfully')</script>";
                print "<script>window.location.assign('../index.php');</script>";
            } else {
                echo "<script>alert('Data failed to register')</script>";
                print "<script>window.location.assign('../index.php');</script>";
            }
        }
    }
    //end of lecturer register

    /* extra info 
    $data = " name = '".$firstname." ".$lastname."' ";
    $data .= ", mobile = '$mobile' ";
    $data .= ", email = '$email' ";
    $data .= ", user_id = '$sessionid' ";
    $save = $conn->query("INSERT INTO orders set ".$data);
    */

    //start of subject register
    if (isset($_POST['btn_subjectregister'])) {
        $code = mysqli_real_escape_string($db,$_POST['subjectcode_txt']);
        $name = mysqli_real_escape_string($db,$_POST['subjectname_txt']);
        $desc = $code . ' ' . $name;
        $date = date("Y-m-d H:i:s");

        $check_query = "SELECT * FROM subject where Subject_Code = '$code' AND Subject_Name = '$name'";
        $result = mysqli_query($db, $check_query);
  	    $check = mysqli_fetch_assoc($result);
        if($check !== NULL) {
            echo "<script>alert('Data already exist')</script>";
            print "<script>window.location.assign('../index.php');</script>";
        }else {
            $query = "  INSERT INTO subject(Subject_Code,Subject_Name) values ('$code','$name');
                        INSERT INTO request(Request_Description, Request_Category, Request_Date, Status_ID) value ('$desc', 'Subject','$date','1')";
            $db->multi_query($query);

            if($query) {
                echo "<script>alert('Subject registered successfully')</script>";
                print "<script>window.location.assign('../index.php');</script>";
            } else {
                echo "<script>alert('Data failed to register')</script>";
                print "<script>window.location.assign('../index.php');</script>";
            }
        }
    }
    //end of subject register

    //start of schedule register
    if (isset($_POST['btn_scheduleregister'])) {
        $timestart = mysqli_real_escape_string($db,$_POST['scheduletimestart']);
        $timeend = mysqli_real_escape_string($db,$_POST['scheduletimeend']);
        $location = mysqli_real_escape_string($db, $_POST['schedulelocation']);
        $day = mysqli_real_escape_string($db, $_POST['scheduleday']);
        $schsubject = mysqli_real_escape_string($db, $_POST['schedulesubject']);
        $schclass = mysqli_real_escape_string($db, $_POST['scheduleclass']);
        $schlecturer = mysqli_real_escape_string($db, $_POST['schedulelecturer']);
        $date = date("Y-m-d H:i:s");

        $check_query = "SELECT * from schedule where Schedule_Day = '$day' AND Schedule_TimeStart = '$timestart' AND Class_ID = '$schclass'";
        $result = mysqli_query($db, $check_query);
  	    $check = mysqli_fetch_assoc($result);
        if($check !== NULL) {
            echo "<script>alert('Data already exist/ There is class occupied on that time')</script>";
            print "<script>window.location.assign('../index.php');</script>";
        }else if ($timestart > $timeend) {
            echo "<script>alert('Class time start cannot be more than time end')</script>";
            print "<script>window.location.assign('../index.php');</script>";
        }else {

            //schedule register query
            $query = "  INSERT INTO schedule (Schedule_Day, Schedule_TimeStart, Schedule_TimeEnd, Lecturer_ID, Class_ID, Subject_Code, Schedule_Location) 
                        values ('$day','$timestart','$timeend','$schlecturer','$schclass','$schsubject','$location')";

            $db->query($query);

            //request register query
            $querylecturer = "SELECT Lecturer_Name FROM lecturer where Lecturer_ID = '$schlecturer'";
            $lecturerdata = mysqli_query($db,$querylecturer);
            $lecturerresult = mysqli_fetch_array($lecturerdata);

            $queryclass = "SELECT Class_Name FROM class where Class_ID = '$schclass'";
            $classdata = mysqli_query($db,$queryclass);
            $classresult = mysqli_fetch_array($classdata);

            $desc = $day.' '.$timestart.' '.$timeend.' '.$lecturerresult['Lecturer_Name'].' '.$classresult['Class_Name'].' '.$schsubject.' '.$location;
            
            $query = "  INSERT INTO request(Request_Description, Request_Category, Request_Date, Status_ID) 
                        values ('$desc', 'Schedule','$date','1')";
            $db->query($query);

            if($query) {
                echo "<script>alert('Schedule registered successfully')</script>";
                print "<script>window.location.assign('../index.php');</script>";
            } else {
                echo "<script>alert('Data failed to register')</script>";
                print "<script>window.location.assign('../index.php');</script>";
            }
        }
    }
    //end of schedule register

    //start of assessment register
    if (isset($_POST['btn_assregister'])) {
        $details = mysqli_real_escape_string($db,$_POST['assdetails']);
        $details_txt = nl2br(htmlentities($details, ENT_QUOTES, 'UTF-8'));
        $deadline = mysqli_real_escape_string($db,$_POST['assdeadline']);
        $asubject = mysqli_real_escape_string($db,$_POST['asssubject']);
        $date = date("Y-m-d H:i:s");

        $classsession = $_SESSION["class"];
        $query = "SELECT * FROM class WHERE Class_Name = '$classsession'";
        $results = mysqli_query($db, $query);
        if ($deadline < $date) {
            echo "<script>alert('Assessment time cannot be less than today')</script>";
            print "<script>window.location.assign('../index.php?class=$classsession');</script>";
        }else {
            while ($row = mysqli_fetch_array($results)) {
                $class_id = $row['Class_ID'];
            }
    
            $query = "  INSERT INTO assessment(Assessment_Date,Assessment_Subject, Assessment_Description, Class_ID) 
                        values ('$deadline','$asubject','$details_txt','$class_id')";
            $db->query($query);
    
            if($query) {
                echo "<script>alert('Assessment registered successfully')</script>";
                print "<script>window.location.assign('../index.php?class=$classsession');</script>";
            }else {
                echo "<script>alert('Data failed to register')</script>";
                print "<script>window.location.assign('../index.php?class=$classsession');</script>";
            }
        }
    }
    //end of assessment register
    //print "<script>window.location.assign('../index.php');</script>";
//end of inserting data
?>