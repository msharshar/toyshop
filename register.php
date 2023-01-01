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
        <h4>Create your account</h4>
        <br>

        <?php
            if(isset($_SESSION["registerError"])) {
                echo '
                    <div class="alert alert-warning">'.$_SESSION["registerError"].'</div>
                ';
            }
        ?>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" required>
            <div class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        
        <a href="login.php">Already registered?</a><br><br>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>

</div>

<?php
    include "inc/footer.php";
    ob_end_flush();
?>


<!-- Handle Register Request -->
<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $con->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute(array($email));

    if($stmt->rowCount() > 0) {
        $_SESSION["registerError"] = "This email is already registered";
        header('Location: register.php');
    }else{
        $stmt = $con->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(array(
            "name" => $name,
            "email" => $email,
            "password" => $password
        ));
    
        $stmt = $con->prepare("SELECT * FROM users WHERE email=? AND password=?");
        $stmt->execute(array($email, $password));
        $newUser = $stmt->fetch();
    
        $_SESSION["userID"] = $newUser["id"];
    
        header('Location: index.php');
    }

}

?>