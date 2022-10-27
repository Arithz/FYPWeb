<?php
    include ('../dbcon.php');
    $output = "";
    
    //auto complete for class query
    if(isset($_POST['query'])) {
        $search = mysqli_real_escape_string($db, $_POST['query']);
        $query = "SELECT C.* FROM class C WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description= C.Class_Name AND NOT Status_ID = '2') AND C.Class_Name like '%".$search."%'";
    }else {
        $query = "SELECT C.* FROM class C WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description= C.Class_Name AND NOT Status_ID = '2')";
    }

    if($query != "") {
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $output .= 
                "
                <a href = index.php?class=".$row['Class_Name'].">
                <div class = 'searchdata''>
                    <p id = 'dataclassname'>".$row['Class_Name']."</p>
                </div></a>";
            }
            echo $output;
        }else {
            echo 'Data not Found';
        }
    }else {
        echo 'Data not Found';
    }
    //end of auto complete for class query
?>