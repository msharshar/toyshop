<?php 

    function checkAuth() {
        if(isset($_SESSION["userID"])){
            return true;
        }else{
            return false;
        }
    }

    function getUser($userID) {
        global $con;
        $stmt = $con->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute(array($userID));
        $user = $stmt->fetch();

        return $user;
    }

    function getProduct($productID) {
        global $con;
        $stmt = $con->prepare("SELECT * FROM items WHERE id=?");
        $stmt->execute(array($productID));
        $product = $stmt->fetch();

        return $product;
    }

    function inCart($userID, $productID, $user_type) {

        global $con;

        $stmt = $con->prepare("SELECT * FROM cart WHERE user_id=? AND item_id=? AND user_type=?");
        $stmt->execute(array($userID, $productID, $user_type));
        
        if($stmt->rowCount() > 0) {
            return true;
        }else{
            return false;
        }

    }

?>