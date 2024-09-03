<!-- <?php


include_once "connection/connection.php";
$con = connection();

if(!isset($_SESSION['Access'])){
    session_start();
}

if($_SESSION['Access']){
    $search = $_POST['search'];

        $query = "SELECT * FROM student_list WHERE first_name = '$search'";
        $stmt = $con->query($query) or die($con->error);
        $row = $stmt->fetch_assoc();
}else{
    header('location: index.php');
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
<a href="index.php">Back</a>
<?php
// Assuming $con is the database connection and $row is the fetched data

// Check if connection and data retrieval are successful
if (!$con) {
    echo "<h1>Student not found</h1>";
} else if (!$row) {
    echo "<h1>Student not found</h1>";
} else {
    // Safely output student data
    ?>
    <h1>ID: <?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?></h1>
    <h1>Firstname: <?= htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') ?></h1>
    <h1>Lastname: <?= htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8') ?></h1>
    <h1>Birthday: <?= htmlspecialchars($row['birth_day'], ENT_QUOTES, 'UTF-8') ?></h1>
    <h1>Gender: <?= htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8') ?></h1>
    <?php
}
?>
</body>
</html> -->

<?php
if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['UserLogin'])){
    echo "Welcome " . $_SESSION['UserLogin'] . " " . $_SESSION['Access'];
}else{
    echo "Welcome guest";
}

include_once("connection/connection.php");
$con = connection();
$search = $_GET['search'];
$userFound;
if(!empty($search)){
    // Query the database
    $sql = "SELECT * FROM student_list WHERE first_name or Last_name LIKE '%$search%' ORDER BY id DESC";
    $students = $con->query($sql) or die($con->error);
    $row = $students->fetch_assoc();
    $userFound = $students->num_rows;
}else{
     // Query the database
     $sql = "SELECT * FROM student_list ORDER BY id DESC";
     $students = $con->query($sql) or die($con->error);
     $row = $students->fetch_assoc();
}

// Render the results
// do {
//     echo $row["first_name"] . " " . $row["last_name"] . "<br/>";
// } while ($row = $students->fetch_assoc());
// // try {

//     $pdo = new PDO($dsn, $dbuser, $dbpass);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connection established";
// } catch (PDOException $e) {
//     echo "Connection to database error: " . $e->getMessage();
// }

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
    <section class="flex justify-center align-center w-full">
                    <?php 
                        if(isset($_SESSION['Access'])){
                            ?>
                              <form action="search.php" method="get">
                                <input type="text" name="search" placeholder="Type first name">
                            </form>
                            <?php
                        }
                        ?>
                    
                    <?php if (isset($_SESSION['UserLogin'])) {?>
                        <a href="logout.php">Logout</a>
                    <?php }else{?>
                        <a href="login.php">Login</a>
                    <?php } ?>
        <div class="flex justify-center align-center">
            <table class="text-center">
                <caption class="p-16">
                    <h1 class="text-6xl font-bold">Student System</h1>
                    <?= isset($_SESSION['Access']) ? '<a href="add.php">Add New</a>' : "" ?>
                </caption>
                
                <thead class="border-2 border-black">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">FIRSTNAME</th>
                        <th scope="col">LASTNAME</th>
                        <th scope="col">BIRTDAY</th>
                        <th scope="col">GENDER</th>
                        <th scope="col">ADDED AT</th>
                        <?php  echo isset($_SESSION['Access']) && $_SESSION['Access'] === 'administrator' ? '<th>Details</th>' : '';  ?>

                    </tr>
                </thead>
                <tbody>
                    <?php do{ ?>
                        <?php if($userFound > 0){ ?>
                        <tr>
                            <?php echo "<td >{$row["id"]}</td>" ?>
                            <?php echo "<td >{$row["first_name"]}</td>" ?>
                            <?php echo "<td >{$row["last_name"]}</td>" ?>
                            <?php echo "<td >{$row["birth_day"]}</td>" ?>
                            <?php echo "<td >{$row["gender"]}</td>" ?>
                            <?php echo "<td >{$row["added_at"]}</td>" ?>
                            <?php echo isset($_SESSION['Access']) && $_SESSION['Access'] === 'administrator'? "<th><a href='details.php?id={$row['id']}'>View</a></th>": ''; ?>
 

                        </tr>
                        <?php } else {?>
                            <td scope="col" colspan="7">Student not found</td>
                        <?php } ?>
                    <?php }while ($row = $students->fetch_assoc()); ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>