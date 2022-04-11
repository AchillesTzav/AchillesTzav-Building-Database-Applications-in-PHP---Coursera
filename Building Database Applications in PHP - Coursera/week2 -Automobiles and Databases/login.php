<html>

<head>
    <title>ΑΧΙΛΛΕΥΣ ΣΤΥΛΙΑΝΟΣ ΤΖΑΒΑΛΑΣ</title>
</head>

<body>
    <h1>Please Log in</h1>


    <?php

    session_start();
    require_once "pdo.php";

    if (isset($_POST['cancel'])) {

        header("Location: index.php");
    }



    if (isset($_POST['who']) && isset($_POST['pass'])) {


        if (empty($_POST['who']) || empty($_POST['pass'])) {
            echo '<p style="color: red">User name and password are required</p>';
        } else if (strpos($_POST['who'], '@') === false) {
            echo '<p style="color: red">Email must have an at-sign (@)</p>';
        } else {

            $sql = "SELECT name From users WHERE email = :em AND password = :pw";



            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':em' => $_POST['who'], ':pw' => $_POST['pass']));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);




            if ($row === FALSE) {
                $hash = hash('sha256', $_POST['pass']);
                error_log("Login failed " . $_POST['who'] . " $hash");
                echo "<p style='color: red'>Incorrect password</p>";
            } else {
                error_log("Login success " . $_POST['who']);
                echo "<h1>Login success</h1>\n";
                header("Location: view.php?name=" . urlencode($_POST['who']));
            }
        }
    }







    //if (($_POST['email'])) {
    //$pattern = "/@/i";
    //preg_match($pattern, $_POST['email']);
    //echo "email must contain @";}


    ?>




    <form method="post">
        <input type="text" name="who" placeholder="email">
        <input type="password" name="pass" placeholder="Password">
        <input type="submit" name="login" value="Log In" />

        <input type="submit" name="cancel" value="Cancel" />
        <a href="<?php echo ($_SERVER['PHP_SELF']); ?>">Refresh</a></p>


    </form>
</body>

</html>