<?php

function connection(){
    // Connect to the database
    $hostsss = "localhost:3307";
    $username = "root";
    $password = "";
    $database = "student_system";
    $con = new mysqli($hostsss, $username, $password, $database);

    // Check if the database is failing to connect
    if ($con->connect_error) {
        echo $con->connect_error;
    }else{
        return $con;
    }

}