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

// Get the page number
if(isset($_GET['page_no']) && $_GET['page_no'] !== ""){
    $page_no = $_GET['page_no'];
}else{
    $page_no = 1;
}

// Total rows of results to display
$total_results_per_page = 10;
// Get  the page offset for the LIMIT query
$offset = ($page_no - 1) * $total_results_per_page;
// Get previous page
$previous_page = $page_no -1;
// Get next page
$next_page = $page_no + 1;

// Get the total number of records
$result_count = mysqli_query($con, "SELECT COUNT(*) as total_records FROM student_system.student_list") or die($con->error);
// Total records
$records = mysqli_fetch_array($result_count);
// Store total_records to a variable
$total_records = $records['total_records'];
// Get the total pages
$total_no_of_pages = ceil($total_records / $total_results_per_page);

// print_r($offset);
// Query the database
$sql = "SELECT * FROM student_list ORDER BY id DESC LIMIT $offset , $total_results_per_page";
$students = $con->query($sql) or die($con->error);
$row = $students->fetch_assoc();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <section class="flex justify-center align-center flex-col w-full">
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
                    <div class="flex text-center flex-col w-full">
                        <caption class="p-16">
                        <h1 class="text-6xl font-bold">Student System</h1>
                    
                    </caption>
                    <?= isset($_SESSION['Access']) ? '<a href="add.php">Add New</a>' : "" ?>
                    </div>
               
        <div class="flex justify-center align-center">
            
            <table class="text-center">
           
          
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
                        <tr>
                            <?php echo "<td >{$row["id"]}</td>" ?>
                            <?php echo "<td >{$row["first_name"]}</td>" ?>
                            <?php echo "<td >{$row["last_name"]}</td>" ?>
                            <?php echo "<td >{$row["birth_day"]}</td>" ?>
                            <?php echo "<td >{$row["gender"]}</td>" ?>
                            <?php echo "<td >{$row["added_at"]}</td>" ?>
                            <?php echo isset($_SESSION['Access']) && $_SESSION['Access'] === 'administrator'? "<th><a href='details.php?id={$row['id']}'>View</a></th>": ''; ?>
 
                            
                        </tr>
                    <?php }while ($row = $students->fetch_assoc()); ?>
              
                </tbody>
            </table>
        </div>
       <div class="flex w-full justify-center p-10">
       <nav aria-label="Page navigation example ">
                    <ul class="pagination flex justify-center align-center flex-col text-center">

                       <div class="flex">
                       <li class="page-item"><a class="page-link <?= ($page_no <= 1) ? 'disabled' : ''; ?>"  <?= ($page_no > 1) ? 'href=?page_no=' . $previous_page : ''; ?>>Previous</a></li>

                        <?php 
                            $minus1 = 1;
                            $minus2 = -2;
                            $minus3 = -3;
                            $minus4 = -4;

                            for($counter = 1; $counter <= 5 + 1 ; $counter++){ 
                            ?>
                                <?php if($page_no != $counter) {?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page_no=<?= $counter > 5 ? $page_no += 1 : $page_no ?> ">
                                                <?= $counter > 5 ? $page_no : $counter ?>
                                        
                                            </a></li>
                                <?php } else {?>
                                        <li class="page-item"><a class="page-link active"><?= $counter ?> </a></li>
                                <?php }?>
                            <?php }?>
                            <li class="page-item"><a class="page-link <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>" <?= ($page_no < $total_no_of_pages) ? "href=?page_no=" . $next_page : ''; ?>>Next</a></li>

                       </div>
                        <p>Page <?= $page_no ?> of <?= $total_no_of_pages ?></p>
                    </ul>
        </nav>
       </div>
        <div>
            
        </div>
    </section>
</body>
</html>