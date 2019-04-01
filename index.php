<!--Simple Login Form with POST. You are suggested to develop own database based login system-->

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && isset($_POST['password'])) {

        if ($_POST['id'] == 'admin' && $_POST['password'] == 'fitness!@#$') {

            //USER AUTH SESSION
            session_start();
            $_SESSION['user'] = $_POST['id'];
            header('Location: frontend/home.php');
        }
    } else {
        header('Location: index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>

    <title>Page Title</title>

</head>

<body style="padding:50px;">
<h2 align="center">Welcome to Attendance Management System</h2>

<form action="index.php" method="post">
    User Id: &nbsp;&nbsp;<input type="text" placeholder="Type your User Id" name="id" style="width:180px;">
    <br>
    <br>
    Password: <input type="password" placeholder="Type your Password" name="password">
    <br>
    <br>
    <input type="submit" value="Login"/>

</form>

</body>
</html lang="uk">