<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if (!isset($_SESSION['name'])) {
    die('Not logged in');
} else {
    $name = $_SESSION['name'];
}



if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])  && isset($_POST['mileage'])) {

    if (($_POST['cancel'])) {

        header("Location: index.php");
        return;
    }

    if (empty($_POST['make']) && empty($_POST['model']) && empty($_POST['year']) && empty($_POST['mileage'])) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    } else if (is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {
        $sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:make,:model, :year, :mileage)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':make' => $_POST['make'], ':model' => $_POST['model'], ':year' => $_POST['year'], ':mileage' => $_POST['mileage']));



        $_SESSION['success'] = "Record added";
        header("Location: index.php");
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
        <p>Model:
            <input type="text" name="model" size="40" />
        </p>
        <p>Year:
            <input type="text" name="year" />
        </p>
        <p>Mileage:
            <input type="text" name="mileage" />
        </p>
        <input type="submit" name="Add" value="Add">
        <input type="submit" name="cancel" value="Cancel">

    </form>

    <h2>Automobiles</h2>
    <ul>
        <?php

        $stmt = $pdo->query("SELECT auto_id, make, model, year, mileage FROM autos");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li> ";
            echo $row['auto_id'] . " / ";

            echo htmlentities($row['make']) . " / ";
            echo $row['model'] . " ";
            echo $row['year'] . " / ";
            echo $row['mileage'];
            echo "</li>";
        }
        ?>
    </ul>
</body>

</html>