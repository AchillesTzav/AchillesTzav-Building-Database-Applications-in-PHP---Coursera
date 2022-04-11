<?php
session_start();

require_once "pdo.php";

if (!isset($_SESSION['name'])) {
    die('Not logged in');
} else {
    $name = $_SESSION['name'];
}

$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);






?>

<html>

<head>
    <title>ΑΧΙΛΛΕΥΣ ΣΤΥΛΙΑΝΟΣ ΤΖΑΒΑΛΑΣ</title>
</head>

<body>
    <h1>Tracking Autos for <?php echo $_SESSION['name']; ?></h1>

    <?php
    if (isset($_SESSION['success'])) {
        echo ('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
        unset($_SESSION['success']);
    }
    ?>

    <h2>Automobiles</h2>
    <p>
        <a href="add.php">Add New</a>

        <a href="logout.php">Logout</a>
    </p>

    <ul>
        <?php

        $stmt = $pdo->query("SELECT auto_id, make, year, mileage FROM autos");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li> ";
            echo $row['year'] . " ";
            echo htmlentities($row['make']) . " / ";
            echo $row['mileage'];
            echo "</li>";
        }
        ?>
    </ul>



</body>



</html>