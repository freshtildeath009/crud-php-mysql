<?php
// Check if the user is guest, login or admin
if(!isset($_SESSION['UserLogin'])){
    session_start();
}

if(isset($_SESSION["Access"]) && $_SESSION["Access"] == "administrator"){
    echo "Welcome to details";
}else{
    header("location: index.php");
}

// Connection to the database
include_once "connection/connection.php";
$con = connection();

$id = $_POST['id'];
// print_r($_POST);

if(isset($_POST['delete'])){
    // Querty to delete
    $query = "DELETE FROM student_list WHERE id = '$id'";
    // If query has an error show the error message and if not run the query
    $con->query($query) or die($con->error);
    // Route to the index.php
    header('location: index.php');
}else{
    header('location: index.php');
}

