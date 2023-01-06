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

    
    $stmt = $con->prepare("SELECT * FROM cart WHERE user_id=? AND item_id=? AND user_type=?");
    $stmt->execute(array($userID, $productID, $userType));
    if($stmt->rowCount() > 0){
        $stmt= $con->prepare('DELETE FROM cart WHERE user_id = :user_id AND item_id = :item_id AND user_type = :user_type');
        $stmt->execute(array(
            "user_id" => $userID,
            "item_id" => $productID,
            "user_type" => $userType
        ));
    }
