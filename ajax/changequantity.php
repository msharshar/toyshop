<?php

    session_start();
    include "../db.php";
    include "../functions.php";

    $productID = $_GET["product_id"];

    if(checkAuth()){
        $userID = $_SESSION["userID"];
        $userType = "user";
    }else{
        $userID = $_COOKIE["guestID"];
        $userType = "guest";
    }


    $stmt = $con->prepare("UPDATE cart SET quantity=? WHERE user_id=? AND item_id=? AND user_type=?");
    $stmt->execute(array($_GET["quantity"],$userID,$_GET["product_id"],$userType));