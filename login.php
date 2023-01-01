<?php 
    include "init.php";
    include "inc/header.php";
    include "inc/navbar.php";
?>

<div class="container">

    <form class="login-form">
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input">
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