<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">The Toy Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php"><i class="bi bi-house-fill"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="bi bi-cart-fill"></i> Cart</a>
                </li>
                <li class="nav-item">
                    <?php
                        if(checkAuth()) {
                            echo '
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-fill"></i> '.
                                    $user["name"].'
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                                </ul>
                            </li>';
                        }else{
                            echo '<a class="nav-link" href="login.php"><i class="bi bi-person-fill"></i> Login</a>';
                        }
                    ?>
                    
                </li>
            </ul>
            <form method="GET" action="index.php" class="d-flex" role="search" style="flex-grow: 1; margin-left: 30px">
                <input type="hidden" name="action" value="search">
                <input class="form-control me-2" name="query" type="search" placeholder="Search by product name or brand" aria-label="Search" value="<?php if(isset($_GET["query"])){ echo $_GET["query"]; } ?>">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>