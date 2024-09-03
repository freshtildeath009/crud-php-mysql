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
include_once("connection/connection.php");
$con = connection();

// Get the id from details page to edit page.
$id = $_GET['id'];

// Get the edited input from the user
if(isset($_POST["submit"])){
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $birthday = $_POST["birthday"];
    $gender = $_POST["gender"];

    // Check the input if has all fields filled
    if(empty($firstname) || empty($lastname) || empty($birthday) || empty($gender)){
        echo "<h1>Please fill all fields</h1>";
    }else{
        $query = "UPDATE student_list SET first_name = '$firstname', last_name = '$lastname', birth_day = '$birthday', gender = '$gender' WHERE id = '$id'";
        $con->query($query) or die($con->error);
        header("location: details.php?id=" . $id);

    }
}

// Query the database. This is for when the user click edit then they will automatically go to the edit page and already filled up all the filled with the data clicked itself.
// Step 1
$sql = "SELECT * FROM student_list WHERE id = '$id'";
$students = $con->query($sql) or die($con->error);
$row = $students->fetch_assoc();

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
    <form action="" method="POST">
        <!-- Step 2 -->
        <input type="text" name="firstname" value="<?= $row['first_name']; ?>" placeholder="Firstname">
        <input type="text" name="lastname" value="<?= $row['last_name'] ?>" placeholder="Lastname">
        <input type="date" name="birthday" value="<?= $row['birth_day'] ?>" placeholder="Birthday">
        <select name="gender" id="gender"  >
           
            <option value="Male" <?php echo $row['gender'] == "Male" ? "selected" : ''; ?>>Male</option>
            <option value="Female" <?php echo $row['gender'] == "Female" ? "selected" : ''; ?>>Female</option>
        </select>
        <button name="submit">Create</button>
    </form>
</body>
</html>