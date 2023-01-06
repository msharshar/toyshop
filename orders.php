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
        <?php
        if(!isset($_GET["orderID"])) {
            if(!checkAuth()){
                header('Location: login.php');
            }
            ?>
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
                            $stmt = $con->prepare("SELECT * FROM orders WHERE user_id=? AND user_type=? ORDER BY id DESC");
                            $stmt->execute(array($userID, $userType));
                            $orders = $stmt->fetchAll();   
                            
                            foreach($orders as $order){
                                ?>
                                <div class="order">
                                    <span class="order-info">Order tracking ID: <?php echo $order["id"] ?></span>
                                    <span class="order-info">Total: £<?php echo $order["total"] ?></span>
                                    <span class="order-info">Ordered at: <?php echo date_format(date_create($order["created_at"]), 'd/m/Y') ?></span>
                                    <hr>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Product ID</th>
                                                <th scope="col">Product name</th>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $products_data = explode("__", $order["products"]);
                                                foreach($products_data as $product_data){
                                                    $product_id = explode("_", $product_data)[0];
                                                    $product_quantity = explode("_", $product_data)[1];

                                                    $stmt = $con->prepare("SELECT * FROM items WHERE id=?");
                                                    $stmt->execute(array($product_id));
                                                    $product = $stmt->fetch();  
        
                                                    echo "
                                                    <tr>
                                                        <th scope='row'><img src='uploads/products/".$product['image']."'></th>
                                                        <td>$product_id</td>
                                                        <td>".$product['name']."</td>
                                                        <td>".$product['brand']."</td>
                                                        <td>£".$product['price']."</td>
                                                        <td>".$product_quantity."</td>
                                                        <td>£".$product["price"]*$product_quantity."</td>
                                                    </tr> 
                                                    ";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left" class="order-status">Order Status: 
                                        <i class="bi bi-check-circle-fill"></i><span class="badge text-bg-secondary">Preparing</span>
                                        <?php if($order["status"] > 0){ echo '<i class="bi bi-check-circle-fill"></i>'; } ?><span class="badge text-bg-primary">On the way</span>
                                        <?php if($order["status"] > 1){ echo '<i class="bi bi-check-circle-fill"></i>'; } ?><span class="badge text-bg-success">Delivered</span>
                                    </p>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }else{
            $orderID = $_GET["orderID"];

            $stmt = $con->prepare("SELECT * FROM orders WHERE id=?");
            $stmt->execute(array($orderID));
            $order = $stmt->fetch(); 
            ?>
            <div class="order">
                <span class="order-info">Order tracking ID: <?php echo $order["id"] ?></span>
                <span class="order-info">Total: £<?php echo $order["total"] ?></span>
                <span class="order-info">Ordered at: <?php echo date_format(date_create($order["created_at"]), 'd/m/Y') ?></span>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Product name</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $products_data = explode("__", $order["products"]);
                            foreach($products_data as $product_data){
                                $product_id = explode("_", $product_data)[0];
                                $product_quantity = explode("_", $product_data)[1];

                                $stmt = $con->prepare("SELECT * FROM items WHERE id=?");
                                $stmt->execute(array($product_id));
                                $product = $stmt->fetch();  

                                echo "
                                <tr>
                                    <th scope='row'><img src='uploads/products/".$product['image']."'></th>
                                    <td>$product_id</td>
                                    <td>".$product['name']."</td>
                                    <td>".$product['brand']."</td>
                                    <td>£".$product['price']."</td>
                                    <td>".$product_quantity."</td>
                                    <td>£".$product["price"]*$product_quantity."</td>
                                </tr> 
                                ";
                            }
                        ?>
                    </tbody>
                </table>
                <p style="text-align: left" class="order-status">Order Status: 
                    <i class="bi bi-check-circle-fill"></i><span class="badge text-bg-secondary">Preparing</span>
                    <?php if($order["status"] > 0){ echo '<i class="bi bi-check-circle-fill"></i>'; } ?><span class="badge text-bg-primary">On the way</span>
                    <?php if($order["status"] > 1){ echo '<i class="bi bi-check-circle-fill"></i>'; } ?><span class="badge text-bg-success">Delivered</span>
                </p>
            </div>
            <?php

        }
        ?>
        
    </div>
</div>

<?php
    include "inc/footer.php";
    ob_end_flush();
?>