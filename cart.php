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
                    <hr>
                    <br>
                    <?php 
                        $stmt = $con->prepare("SELECT * FROM cart WHERE user_id=? AND user_type=?");
                        $stmt->execute(array($userID, $userType));
                        $cartProducts = $stmt->fetchAll();

                        if($stmt->rowCount() == 0){
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
                <div class="cart-products">
                    <h4>Shippment info</h4>
                    <hr><br>
                </div>
                <div class="cart-products">
                    <h4>Payment details</h4>
                    <hr><br>
                </div>
                <div class="text-right">
                    <button class="btn btn-success" style="display: block; margin-left: auto">Checkout</button>
                </div>
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
                    <p>Total: <b>100</b> <b>100</b></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include "inc/footer.php";
    ob_end_flush();
?>