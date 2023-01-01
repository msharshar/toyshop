<?php 
    include "init.php";
    include "inc/header.php";
    include "inc/navbar.php";
?>

<div class="shop">

    <div class="container">
        <div class="row">
            <div class="col-lg-3" style="position:relative">
                <div class="sidebar">
                    <h2>Filter options</h2>
                    <p>Select what you need</p>
                    <hr>
                    <form action="">
                        <div>
                            <h5 class="form-label">Price range</h5>
                            <input type="range" class="form-range">
                        </div>

                        <br>
                        <h5>Select brand</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="">
                            <label class="form-check-label">
                                Brand
                            </label>
                        </div>

                        <br>
                        <button type="submit" class="btn btn-success">Filter products</button>
                    </form>

                </div>
            </div>
            <div class="col-lg-9">
                <h2>Our products</h2>
                <p>Choose from a variety of products</p>

                <?php
                    $stmt = $con->prepare("SELECT * FROM items");
                    $stmt->execute();
                    $products = $stmt->fetchAll();

                    foreach($products as $product) {
                ?>
                        <div class="product">
                            <div class="outside">
                                <div class="top" style="background: url(uploads/products/<?php echo $product["image"] ?>) no-repeat center center"></div>
                                <div class="bottom">
                                <div class="left">
                                    <div class="details">
                                    <h4><?php echo $product["name"] ?></h4>
                                    <p>£<?php echo $product["price"] ?></p>
                                    </div>
                                    <div class="buy"><i class="material-icons">add_shopping_cart</i></div>
                                </div>
                                <div class="right">
                                    <div class="done"><i class="material-icons">done</i></div>
                                    <div class="details">
                                    <h1>Chair</h1>
                                    <p>Added to your cart</p>
                                    </div>
                                    <div class="remove"><i class="material-icons">clear</i></div>
                                </div>
                                </div>
                            </div>
                            <div class="inside">
                                <div class="icon"><i class="material-icons">info_outline</i></div>
                                <div class="contents">
                                <table>
                                    <tr>
                                        <th>Brand</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $product["brand"] ?></td>
                                    </tr>

                                    <tr>
                                        <th><br></th>
                                    </tr>
                        
                                    <tr>
                                        <th>Description</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $product["description"] ?></td>
                                    </tr>
                                </table>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                ?>

            </div>
        </div>
    </div>
</div>

<?php
    include "inc/footer.php";
    ob_end_flush();
?>