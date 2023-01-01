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

?>