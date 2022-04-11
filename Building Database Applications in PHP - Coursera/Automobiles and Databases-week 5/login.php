<?php
session_start();

require_once "pdo.php";









if (isset($_POST['email']) && isset($_POST['pass'])) {


    if (($_POST['cancel'])) {

        header("Location: index.php");
        return;
    }



    if (empty($_POST['email']) || empty($_POST['pass'])) {
        $_SESSION['error'] = "User name and password are required";
        header("Location: login.php");
        return;
    } else if (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    } else {
        if ($row === FALSE) {
            $hash = hash('sha256', $_POST['pass']);
            error_log("Login failed " . $_POST['email'] . " $hash");
            $_SESSION['error'] = "Incorrect password";
            header('Location: login.php');
            return;
        } else {
            error_log("Login success " . $_POST['email']);
            $_SESSION['success'] = "Login success.";
            $_SESSION['name'] = $_POST['email'];
            header('Location: index.php');
            return;
        }
    }
}







//if (($_POST['email'])) {
//$pattern = "/@/i";
//preg_match($pattern, $_POST['email']);
//echo "email must contain @";}


?>

<html>

<head>
    <title>ΑΧΙΛΛΕΥΣ ΣΤΥΛΙΑΝΟΣ ΤΖΑΒΑΛΑΣ</title>
</head>




<body>
    <h1>Please Log in</h1>

    <?php

    if (isset($_SESSION['error'])) {
        echo ('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>




    <form method="post" action="login.php">
        <input type="text" name="email" placeholder="email">
        <input type="password" name="pass" placeholder="Password">
        <input type="submit" name="login" value="Log In" />

        <input type="submit" name="cancel" value="Cancel" />
        <a href="<?php echo ($_SERVER['PHP_SELF']); ?>">Refresh</a></p>


    </form>
</body>

</html>