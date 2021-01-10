<?php
//deal with user auth
session_start();

if (isset($_SESSION['user'])) {
    // logged in
} else {
    // not logged in
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <base href="http://localhost/tad-php-action-from-html/">
    <title>Page Title</title>
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/DataTables/datatables.css">
    <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="vendor/angularjs/angular.js"></script>
    <script src="vendor/angularjs/angular-route.js"></script>
    <script src="vendor/angularjs/angular-animate.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.js"></script>
    <script src="vendor/bootstrap/js/bootstrap-datepicker.min.js"></script>
    <script src="vendor/DataTables/datatables.js"></script>
</head>

<body ng-app="myApp" style="padding:50px;">
<h2>Attendance Management</h2>
<table class="table" style="width:400px;">
    <tr>
        <td><a href="newEntry">
                <button class="btn btn-block">New Entry</button>
            </a></td>
        <td><a href="searchUser">
                <button class="btn btn-block">Search User</button>
            </a></td>
        <td><a href="reports">
                <button class="btn btn-block">Report</button>
            </a></td>
        <td>
            <form action="backend/logout.php" method="get"><input type="submit" value="Logout"  class="btn btn-block"></form>
        </td>
    </tr>
</table>
<div ng-view></div>
<script src="scripts/app.js"></script>
</body>
</html>