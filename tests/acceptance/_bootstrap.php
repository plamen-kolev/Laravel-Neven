<?php
// Here you can initialize variables that will be available to your tests
$dbh = new PDO('mysql:host=localhost;dbname=neven;charset=utf8', 'root', 'password');
\Codeception\Module\Dbh::$dbh = $dbh;