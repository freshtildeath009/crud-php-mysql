<?php
// Check if the user is guest, login or admin
if(!isset($_SESSION['UserLogin'])){
    session_start();
}

if(isset($_SESSION["Access"])){
    echo "Welcome to details";
}else{
    header("location: index.php");
}
// Connect to database
include_once("connection/connection.php");
$con = connection();

if(isset($_POST["submit"])){
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $birthday = $_POST["birthday"];
    $gender = $_POST["gender"];

    if(empty($firstname) || empty($lastname) || empty($birthday) || empty($gender)){
        echo "<h1>Please fill all fields</h1>";
    }else{
        $query = "INSERT INTO student_list (first_name, last_name, birth_day, gender) VALUES ('$firstname', '$lastname', '$birthday', '$gender');";
        $con->query($query) or die($con->error);
        header("location: index.php");
    }

    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="global.css">
    <title>Document</title>
</head>
<body>
    <form action="add.php" method="POST">
        <input type="text" name="firstname" placeholder="Firstname">
        <input type="text" name="lastname" placeholder="Lastname">
        <input type="date" name="birthday" placeholder="Birthday">
        <select name="gender" id="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <button name="submit">Create</button>
    </form>
</body>
</html>