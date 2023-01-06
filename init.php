<?php
    ob_start();
    session_start();
    include "db.php";
    include "functions.php";

    if(isset($_COOKIE["userID"])) {
        $_SESSION["userID"] = $_COOKIE["userID"];
    }

    if(isset($_SESSION["userID"])) {
        $user = getUser($_SESSION["userID"]);
    }

    if(!isset($_COOKIE["guestID"])) {
        setcookie("guestID", rand(1000, 10000000));
    }

?>