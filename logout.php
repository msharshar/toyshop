<?php

    session_start();
    session_unset();
    session_destroy();
    setcookie("userID", null);
    header('Location: login.php');

?>