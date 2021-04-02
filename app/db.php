<?php


// make a database connection

$host = "localhost";
$user = "root";
$pass = "";
$db = "student_crud";


// connect function
function connect(){

    global $host,$user,$pass,$db;
    return $connection = new mysqli($host,$user,$pass,$db);

}



?>