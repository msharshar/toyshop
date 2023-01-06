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

<div class="cart">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="cart-products">
                    <h4>Cart products</h4>
                    <span>Check them out</span>
                    <hr>
                    <br>
                    <?php 
                        $stmt = $con->prepare("SELECT * FROM cart WHERE user_id=? AND user_type=?");
                        $stmt->execute(array($userID, $userType));
                        $cartProducts = $stmt->fetchAll();

                        $productsCount = $stmt->rowCount();

                        if($productsCount == 0){
                            echo '<div class="alert alert-warning text-center">Your cart is empty. <a href="index.php">Go shopping now!</a></div>';
                        }
                        $subtotal = 0;
                        foreach($cartProducts as $cartProduct) {
                            $product = getProduct($cartProduct["item_id"]);
                            ?>
                            <div class="cart-product">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <img src="uploads/products/<?php echo $product["image"]; ?>" alt="product_img">
                                    </div>
                                    <div class="col-lg-9">
                                        <h5><?php echo $product["name"] ?></h5>
                                        <span class="price">£<?php echo $product["price"]*$cartProduct["quantity"] ?></span>
                                        <?php $subtotal += $product["price"]*$cartProduct["quantity"]; ?>
                                        <div class="mt-3">
                                            <label class="form-label">Quantity: </label>
                                            <input type="number" name="quantity" class="form-control quantity" min="1" value="<?php echo $cartProduct["quantity"]  ?>" required>
                                            <input type="hidden" class="originaPrice" value="<?php echo $product["price"] ?>">
                                            <input type="hidden" class="productID" value="<?php echo $product["id"] ?>">
                                        </div>
                                        <button class="btn btn-danger remove-btn">Remove</button>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <?php
                        }
                    ?>
                </div>

                <?php
                if($productsCount > 0) {
                ?>
                <form method="POST">
                <div class="cart-products">
                    <h4>Shippment info</h4>
                    <span>All fields required</span>
                    <hr><br>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="form-label">Fullname</label>
                            <input type="text" name="cus_name" class="form-control" value="<?php if(checkAuth()){echo $user["name"];} ?>" required>
                        </div>

                        <div class="col-lg-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="cus_email" class="form-control" value="<?php if(checkAuth()){echo $user["name"];} ?>" required>
                        </div>

                        <div class="col-lg-12">
                            <br>
                        </div>

                        <div class="col-lg-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="cus_phone" class="form-control" required>
                        </div>

                        <div class="col-lg-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="cus_address" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="cart-products">
                    <h4>Payment details</h4>
                    <span>All fields required</span>
                    <hr><br>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="form-label">Card number</label>
                            <input type="number" name="cus_card_number" class="form-control" required>
                        </div>

                        <div class="col-lg-6">
                            <label class="form-label">Card holder name</label>
                            <input type="text" name="cus_card_holder" class="form-control" required>
                        </div>

                        <div class="col-lg-12">
                            <br>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="form-label">Expiration month</label>
                                    <input type="number" name="cus_card_month" class="form-control" required>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Expiration year</label>
                                    <input type="number" name="cus_card_year" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <label class="form-label">CVV</label>
                            <input type="number" name="cus_card_cvv" class="form-control" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="totalPrice" name="totalPrice" value="<?php echo round($subtotal+$subtotal*.14, 2) ?>">
                <div class="text-right">
                    <button type="submit" class="btn btn-success" style="display: block; margin-left: auto">Checkout</button>
                </div>
                </form>
                <br><br>
            </div>
            <div class="col-lg-3" style="position:relative">
                <div class="summary">
                    <h4>Summary</h4>
                    <hr>
                    <br>
                    <p>Subtotal: <b id="subtotal">£<?php echo $subtotal ?></b></p>
                    <p>Taxes: <b>14%</b></p>
                    <p>Delivery: <b style="color: green">0</b></p>
                    <p>Discount: <b id="discount">0</b></p>
                    <hr>
                    <label class="form-label">Promo code </label>
                    <input type="text" name="promocode" class="form-control promocode" placeholder="Any text will work">
                    <div class="alert alert-warning mt-2 promocode-error" style="display:none"></div>
                    <div class="alert alert-success mt-2 promocode-success" style="display:none">Now you enjoy 20% disocunt</div>
                    <button class="btn btn-primary mt-1 promocode-btn" style="margin-left: auto; display: block">Apply code!</button>
                    <hr>
                    <p>Total: <b id="original-total" style="color: red; margin-left:10px; text-decoration:line-through"></b> <b id="total" style="color:green">£<?php echo round($subtotal+$subtotal*.14, 2) ?></b></p>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $stmt = $con->prepare("SELECT * FROM cart WHERE user_id=? AND user_type=?");
    $stmt->execute(array($userID, $userType));
    $cartData = $stmt->fetchAll();

    $products_list = "";
    foreach($cartData as $product){
        $products_list .= $product["item_id"]."_".$product["quantity"]."__";
    }
    $products_list = substr($products_list, 0, -2);

    $stmt = $con->prepare("INSERT INTO orders(user_id, user_type, total, name, email, phone, address, products) VALUES (:user_id, :user_type, :total, :name, :email, :phone, :address, :products)");
    $stmt->execute(array(
        "user_id" => $userID,
        "user_type" => $userType,
        "total" => $_POST["totalPrice"],
        "name" => $_POST["cus_name"],
        "email" => $_POST["cus_email"],
        "phone" => $_POST["cus_phone"],
        "address" => $_POST["cus_address"],
        "products" => $products_list
    ));

    // Get inserted order ID
    $stmt = $con->prepare("SELECT * FROM orders ORDER BY id DESC");
    $stmt->execute();
    $lastProduct = $stmt->fetchAll()[0];

    // Empty the cart
    $stmt= $con->prepare('DELETE FROM cart WHERE user_id = :user_id AND user_type = :user_type');
    $stmt->execute(array(
        "user_id" => $userID,
        "user_type" => $userType
    ));

    header('Location: orders.php?orderID='.$lastProduct["id"]);
    // header('Location: orders.php');
}

?>

<?php
    include "inc/footer.php";
    ob_end_flush();
?>