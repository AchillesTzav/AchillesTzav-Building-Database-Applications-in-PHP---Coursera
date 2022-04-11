<html>

<head>
    <title>ΑΧΙΛΛΕΥΣ ΣΤΥΛΙΑΝΟΣ ΤΖΑΒΑΛΑΣ</title>
</head>

<?php
session_start();

require_once "pdo.php";

//if (!isset($_SESSION['name'])) {
//    die('Not logged in');
//} else {
//    $name = $_SESSION['name'];
//}

if (isset($_GET['name'])) {
    echo "<h1>Tracking Autos for " . $_GET['name'] . "</h1>";
} else {
    die("Name parameter missing");
}


?>

<body>


    <h2>Automobiles</h2>
    <p>
        <a href="add.php">Add New</a>

        <a href="logout.php">Logout</a>
    </p>
</body>



</html>