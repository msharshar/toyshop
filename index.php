<?php 
    include "init.php";
    include "inc/header.php";
    include "inc/navbar.php";
?>

<div class="shop">

    <div class="container">
        <h2>Our Products</h2>
        <p>Choose from a variety of products</p>

        <?php
            $stmt = $con->prepare("SELECT * FROM items");
            $stmt->execute();
            $products = $stmt->fetchAll();

            foreach($products as $product) {
        ?>
                <div class="product">
                    <div class="outside">
                        <div class="top"></div>
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
                            <th>Width</th>
                            <th>Height</th>
                            </tr>
                            <tr>
                            <td>3000mm</td>
                            <td>4000mm</td>
                            </tr>
                            <tr>
                            <th>Something</th>
                            <th>Something</th>
                            </tr>
                            <tr>
                            <td>200mm</td>
                            <td>200mm</td>
                            </tr>
                            <tr>
                            <th>Something</th>
                            <th>Something</th>
                            </tr>
                            <tr>
                            <td>200mm</td>
                            <td>200mm</td>
                            </tr>
                            <tr>
                            <th>Something</th>
                            <th>Something</th>
                            </tr>
                            <tr>
                            <td>200mm</td>
                            <td>200mm</td>
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

<?php
    include "inc/footer.php";
    ob_end_flush();
?>