<?php
require_once "pdo.php";
session_start();

require_once "pdo.php";
if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])  && isset($_POST['mileage'])) {

    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'Mileage and year must be numeric';
        header("Location: add.php");
        return;
    } elseif (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1  || strlen($_POST['mileage']) < 1  || strlen($_POST['year']) < 1) {
        $_SESSION['error'] = 'Missing Data';
        header("Location: add.php");
        return;
    }

    $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE auto_id = :auto_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':make' => $_POST['make'], ':model' => $_POST['model'], ':year' => $_POST['year'], ':mileage' => $_POST['mileage'], ':auto_id' => $_GET['auto_id']));



    $_SESSION['success'] = "Record edited";
    header("Location: index.php");
    return;
}
if (!isset($_GET['auto_id'])) {
    $_SESSION['error'] = "Missing auto_id";
    header('Location: index.php');
    return;
}


$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :id");
$stmt->execute(array(":id" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header('Location: index.php');
    return;
}


if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
}


?>
<html>

<head>
    <title>ΑΧΙΛΛΕΥΣ ΣΤΥΛΙΑΝΟΣ ΤΖΑΒΑΛΑΣ</title>
</head>

<body>
    <p>Edit User</p>

    <form method="post">
        <p>Make:
            <input type="text" name="make" value="<?php echo $row['make']; ?>">
        </p>
        <p>Model:
            <input type="text" name="model" value="<?php echo $row['model']; ?>">
        </p>
        <p>Year:
            <input type="text" name="year" value="<?php echo $row['year']; ?>">
        </p>
        <p>Mileage:
            <input type="text" name="mileage" value="<?php echo $row['mileage']; ?>">
        </p>
        <input type="hidden" name="auto_id" value="<?php $row['auto_id'] ?>">
        <p>
            <input type="submit" value="Save" />
            <a href="index.php">Cancel</a>
        </p>
    </form>
</body>

</html>