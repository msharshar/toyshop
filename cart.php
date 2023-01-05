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
                        $products = $stmt->fetchAll();

                        foreach($products as $product) {
                            $product = getProduct($product["item_id"]);
                            ?>
                            <div class="cart-product">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <img src="uploads/products/<?php echo $product["image"]; ?>" alt="product_img">
                                    </div>
                                    <div class="col-lg-9">
                                        <p><?php echo $product["name"] ?></p>
                                        <span>£<?php echo $product["price"] ?></span>
                                        <div class="mt-3">
                                            <label class="form-label">Quantity: </label>
                                            <input type="number" name="quantity" class="form-control" value="1" required>
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
                    <p>Subtotal: <b>100</b></p>
                    <p>Taxes: <b>100</b></p>
                    <p>Delivery: <b>100</b></p>
                    <p>Discount: <b>100</b></p>
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