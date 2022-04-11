<html>

<head>
    <title>ΑΧΙΛΛΕΥΣ ΣΤΥΛΙΑΝΟΣ ΤΖΑΒΑΛΑΣ</title>
</head>

<body>

    <?php

    require_once "pdo.php";

    if (isset($_GET['name'])) {
        echo "<h1>Tracking Autos for " . $_GET['name'] . "</h1>";
    } else {
        die("Name parameter missing");
    }

    if (isset($_POST['logout'])) {

        header("Location: index.php");
    } else {
        if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
            if (empty($_POST['make'])) {
                echo "<p style='color: red'>Make is required</p>";
            } else if (is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {
                $sql = "INSERT INTO autos (make, year, mileage) VALUES (:make, :year, :mileage)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':make' => $_POST['make'], ':year' => $_POST['year'], ':mileage' => $_POST['mileage']));



                echo "<p style='color: green'>Record inserted</p>";
            } else {

                echo "<p style='color: red'>Mileage and year must be numeric</p>";
            }
        }
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