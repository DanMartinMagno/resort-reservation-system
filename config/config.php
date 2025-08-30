<?php

//host
define("HOST","localhost");

//dbname
define("DBNAME", "highway411");

//user
define("USER", "root");

//password
define("PASS","");

$conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME."", USER, PASS);

// if($conn == true) {
//     echo "db connection is success";
// } else{
//     echo "error";
// }