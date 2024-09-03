<?php
include_once "connection/connection.php";
$con = connection();

session_start();

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM student_users WHERE username = '$username' AND password = '$password'";
    $user = $con->query($query) or die($con->error);
    $row = $user->fetch_assoc();
    $total = $user->num_rows;
    
    
    if($total > 0){
        $_SESSION['UserLogin'] = $row['username'];
        $_SESSION['Access'] = $row['access'];
        
        header("Location: index.php");
    }else{
        echo "No user found";
    }
  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <input type="text" name="username" id="username" placeholder="Username">    
        <input type="password" name="password" id="password" placeholder="Password">
        <button name="login" id="login">Submit</button>  
    </form>
</body>
</html>