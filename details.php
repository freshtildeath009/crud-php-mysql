<?php
if(!isset($_SESSION['UserLogin'])){
    session_start();
}

if(isset($_SESSION["Access"]) && $_SESSION["Access"] === "administrator"){
    echo "Welcome to details";
}else{
    header("location: index.php");
}

include_once "connection/connection.php";
$con = connection();

// Get id from url
$id = $_GET['id'];
// Query the database
$student = "SELECT * FROM student_list WHERE id = '$id'";
// Check if the user is not in the database
$stmt = $con->query($student) or die($con->error);
// Fetch the data from the $stmt
$row = $stmt->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <a href="index.php">Go Back</a> <br />
        <a href="edit.php?id=<?= $row['id']; ?>">Edit</a>
        <form action="delete.php?id=<?= $row['id']; ?>" method="post">
            <button type="submit" name="delete">delete</button>
            <input type="hidden" name="id" id="" value="<?= $row['id']; ?>">
        </form>
       <?php  echo "<h1>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . " " . htmlspecialchars($row['birth_day']) . " " . htmlspecialchars($row['gender']) ."</h1>"; ?>
</body>
</html>