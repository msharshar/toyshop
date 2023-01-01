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
                    <form method="GET" action="">
                        <input type="hidden" name="action" value="filter">
                        <div>
                            <h5 class="form-label">Price range</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="form-label">From</label>
                                    <input type="number" name="min-price" class="form-control" placeholder="Min price" value="<?php if(isset($_GET["min-price"])){echo $_GET["min-price"];} ?>">
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">To</label>
                                    <input type="number" name="max-price" class="form-control" placeholder="Max price" value="<?php if(isset($_GET["max-price"])){echo $_GET["max-price"];} ?>">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5>Select brand</h5>
                        <!-- Get all brands dynamically -->
                        <?php
                            $stmt = $con->prepare("SELECT DISTINCT brand FROM items");
                            $stmt->execute();
                            $brands = $stmt->fetchAll();

                            foreach($brands as $brand) {
                                if(isset($_GET[$brand["brand"]])){
                                    echo '
                                    <div class="form-check">
                                        <input class="form-check-input" checked type="checkbox" name="'.$brand["brand"].'">
                                        <label class="form-check-label">
                                            '.$brand["brand"].'
                                        </label>
                                    </div>
                                    ';
                                }else{
                                    echo '
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="'.$brand["brand"].'">
                                        <label class="form-check-label">
                                            '.$brand["brand"].'
                                        </label>
                                    </div>
                                    ';
                                }
                            }
                        ?>

                        <hr>
                        <button type="submit" class="btn btn-success">Filter products</button>
                    </form>

                </div>
            </div>
            <div class="col-lg-9">
                <h2>Our products</h2>
                <p>Choose from a variety of products</p>

                <?php

                    if($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["action"] == "filter"){

                        if($_GET["min-price"] == ""){
                            $minPrice = 0;
                        }else{
                            $minPrice = $_GET["min-price"];
                        }

                        if($_GET["max-price"] == ""){
                            $maxPrice = 100000;
                        }else{
                            $maxPrice = $_GET["max-price"];
                        }

                        $selectedBrands = [];
                        foreach($brands as $brand) {
                            if(isset($_GET[$brand["brand"]])){
                                $selectedBrands[] = $brand["brand"];
                            }
                        }
                        if($selectedBrands == []) {
                            foreach($brands as $brand) {
                                $selectedBrands[] = $brand["brand"];
                            }
                        }
                        $selectedBrands = '("' . implode('","', $selectedBrands) .'")';

                        $stmt = $con->prepare('SELECT * FROM items WHERE brand IN' . $selectedBrands . 'AND price BETWEEN ? AND ?');
                        $stmt->execute(array($minPrice, $maxPrice));
                        $products = $stmt->fetchAll();

                    }else{
                        $stmt = $con->prepare("SELECT * FROM items");
                        $stmt->execute();
                        $products = $stmt->fetchAll();
                    }


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

<!-- Handle Add to Cart Request -->
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
