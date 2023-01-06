<?php 
    include "init.php";
    include "inc/header.php";
    include "inc/navbar.php";

    if(checkAuth()) {
        $userID = $_SESSION["userID"];
        $userType = "user";
    }else{
        $userID = $_COOKIE["guestID"];
        $userType = "guest";
    }
?>

<div class="profile">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="profile-sidebar">
                    <a href="profile.php">Edit profile</a>
                    <a href="orders.php">Show orders</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="orders">
                    <?php
                        $stmt = $con->prepare("SELECT * FROM users WHERE id=?");
                        $stmt->execute(array($userID));
                        $user = $stmt->fetch();   

                        if(isset($_GET["success"])){
                            echo '<div class="alert alert-success">Your data has been updated successfully</div>';
                        }
                        
                    ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo $user['name'] ?>" >
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" disabled value="<?php echo $user['email'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required value="<?php echo $user['password'] ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Update profile</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php 

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $stmt = $con->prepare("UPDATE users SET name=?, password=? WHERE id=?");
    $stmt->execute(array($_POST["name"], $_POST["password"], $userID));
    header('Location: profile.php?success');

}

?>

<?php
    include "inc/footer.php";
    ob_end_flush();
?>