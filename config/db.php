<?php
$host = 'sql12.freesqldatabase.com';
$username = 'sql12740692';
$password = 'ZBncRZJzP1';
$dbname = 'sql12740692';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
