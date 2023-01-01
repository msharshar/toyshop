<?php 
    include "init.php";
    include "inc/header.php";
    include "inc/navbar.php";

    if(checkAuth()) {
        header('Location: index.php');
    }
?>

<div class="container">

    <form class="login-form" method="POST">
        <?php
            if(isset($_SESSION["loginError"])) {
                echo '
                    <div class="alert alert-warning">'.$_SESSION["loginError"].'</div>
                ';
            }
        ?>
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="rememberme">
            <label class="form-check-label">Remember me</label>
        </div>

        <a href="register.php">Don't have account?</a><br><br>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>

</div>

<?php
    include "inc/footer.php";
    ob_end_flush();
?>

<!-- Handle Login Request -->
<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $con->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $stmt->execute(array($email, $password));
    $user = $stmt->fetch();

    if($user) {
        $_SESSION["userID"] = $user["id"];

        if(isset($_POST["rememberme"])) {
            setcookie("userID", $user["id"]);
        }

        header('Location: index.php');
    }else{
        $_SESSION["loginError"] = "User not found";
        header('Location: login.php');
    }

}
