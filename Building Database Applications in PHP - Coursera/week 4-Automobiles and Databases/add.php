<?php
session_start();

require_once "pdo.php";

if (!isset($_SESSION['name'])) {
    die('Not logged in');
} else {
    $name = $_SESSION['name'];
}



if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {

    if (empty($_POST['make'])) {
        $_SESSION['error'] = 'Make is required';
        header("Location: add.php");
        return;
    } else if (is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {
        $sql = "INSERT INTO autos (make, year, mileage) VALUES (:make, :year, :mileage)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':make' => $_POST['make'], ':year' => $_POST['year'], ':mileage' => $_POST['mileage']));



        $_SESSION['success'] = "Record inserted";
        header("Location: view.php");
        return;
    } else {

        $_SESSION['error'] = "Mileage and year must be numeric";
        header("Location: add.php");
        return;
    }
}


?>

<html>

<head>
    <title>ΑΧΙΛΛΕΥΣ ΣΤΥΛΙΑΝΟΣ ΤΖΑΒΑΛΑΣ</title>
</head>

<body>
    <h1>Tracking Autos for <?php echo $_SESSION['name']; ?></h1>
    <?php
    if (isset($_SESSION["error"])) {
        echo ('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
        unset($_SESSION["error"]);
    }
    ?>





    <form method="post">
        <p>Make:
            <input type="text" name="make" size="60" />
        </p>
        <p>Year:
            <input type="text" name="year" />
        </p>
        <p>Mileage:
            <input type="text" name="mileage" />
        </p>
        <input type="submit" name="Add" value="Add">
        <input type="submit" name="logout" value="Logout">
    </form>

    <h2>Automobiles</h2>
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