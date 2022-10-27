<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // initializing variables
    $errors = array(); 

    // connect to the database

    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timetabledb";

    $db = mysqli_connect($server,$username,$password,$dbname) or die("Couldn't connect"); 
?>