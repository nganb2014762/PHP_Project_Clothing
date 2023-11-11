<?php

include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';

if (isset($_POST['add_to_wishlist'])) {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

    $check_wishlist_numbers = $pdo->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
    $check_wishlist_numbers->execute([$p_name, $user_id]);

    $check_cart_numbers = $pdo->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name, $user_id]);

    if ($check_wishlist_numbers->rowCount() > 0) {
        $message[] = 'already added to wishlist!';
    } elseif ($check_cart_numbers->rowCount() > 0) {
        $message[] = 'already added to cart!';
    } else {
        $insert_wishlist = $pdo->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
        $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
        $message[] = 'added to wishlist!';
    }

}

if (isset($_POST['add_to_cart'])) {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
    $p_qty = $_POST['p_qty'];
    $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

    $check_cart_numbers = $pdo->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name, $user_id]);

    if ($check_cart_numbers->rowCount() > 0) {
        $message[] = 'already added to cart!';
    } else {

        $check_wishlist_numbers = $pdo->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
        $check_wishlist_numbers->execute([$p_name, $user_id]);

        if ($check_wishlist_numbers->rowCount() > 0) {
            $delete_wishlist = $pdo->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->execute([$p_name, $user_id]);
        }

        $insert_cart = $pdo->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
        $message[] = 'added to cart!';
    }

}
;

if (isset($message)) {
    foreach ($message as $message) {
        // echo '<script>alert(" ' . $message . ' ");</script>';
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . htmlspecialchars($message) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
    }
}
;
?>
<title>Fashion</title>
</head>

<body>

    <!-- slide -->
    <header id="header" class="vh-100 carousel slide" data-bs-ride="carousel" style="padding-top: 104px;">
        <div class="container h-100 d-flex align-items-center carousel-inner">
            <div class="text-center carousel-item active">
                <h2 class="text-capitalize text-white">best collection</h2>
                <h1 class="text-uppercase py-2 fw-bold text-white">new collection</h1>
                <a href="shop.php" class="btn mt-3 text-uppercase">shop now</a>
            </div>

            <div class="text-center carousel-item">
                <h2 class="text-capitalize text-white">best sale</h2>
                <h1 class="text-uppercase py-2 fw-bold text-white">new sale</h1>
                <a href="shop.php" class="btn mt-3 text-uppercase">shop now</a>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#header" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </header>
    <!-- end of slide -->

    <!-- <section id="collection" class="pt-5">
        <div class="container">
            <div class="title text-center ">
                <h2 class="position-relative d-inline-block">Shop by category</h2>
            </div>

            <div class="row g-0 justify-content-center">
                <div class="d-flex flex-wrap justify-content-center mt-5 filter-button-group">
                    <button type="button" class="btn m-2 text-dark active-filter-btn" data-filter="*">All</button>
                    <button type="button" class="btn m-2 text-dark" data-filter=".best">Best Sellers</button>
                    <button type="button" class="btn m-2 text-dark" data-filter=".feat">Featured</button>
                    <button type="button" class="btn m-2 text-dark" data-filter=".new">New Arrival</button>
                </div>
                <div class="col-md-8 col-lg-3 col-xl-3 p-2 best">
                    <div class=" position-relative "
                        style="display: flex; flex-direction: column; align-items: center; text-align: center;">

                        <img src="img/shop/cat-1.jpg" alt="">
                        <br>
                        <a href="category.php?category=Shirts" class="btn">Shirt</a>

                    </div>
                </div>

                <div class="col-md-8 col-lg-3 col-xl-3 p-2 best">
                    <div class=" position-relative"
                        style="display: flex; flex-direction: column; align-items: center; text-align: center;">

                        <img src="img/shop/cat-2.jpg" alt="">
                        <br>
                        <a href="category.php?category=Pan" class="btn">Pan</a>

                    </div>
                </div>

                <div class="col-md-8 col-lg-3 col-xl-3 p-2 best ">
                    <div class=" position-relative "
                        style="display: flex; flex-direction: column; align-items: center; text-align: center;">

                        <img src="img/shop/cat-3.jpg" alt="">
                        <br>

                        <a href="category.php?category=Dress" class="btn">Dress</a>

                    </div>
                </div>

            </div>
        </div>
    </section> -->


    <!-- shop -->
    <section id="collection" class="pt-5">
        <div class="container">
            <div class="title text-center">
                <h2 class="position-relative d-inline-block">New Collection</h2>
            </div>

            <div class="row g-0 container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mt-3">
                    <?php
                    $select_products = $pdo->prepare("SELECT * FROM `products` LIMIT 8");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <form action="" method="POST">
                                <div class="col">
                                    <div class="card shadow rounded h-100">
                                        <div class="collection-img position-relative">
                                            <img class="rounded-top p-0 card-img-top"
                                                src="admin/uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-8">
                                                    <p class="card-text text-capitalize text-truncate fw-bold">
                                                        <?= htmlspecialchars($fetch_products['name']); ?>
                                                    </p>
                                                </div>

                                                <div class="col-4 text-end"><button class="text-capitalize border-0 bg-white"
                                                        type="submit" name="add_to_wishlist"><i
                                                            class="fa-regular fa-heart fa-lg text-dark heart"></i></button>
                                                </div>

                                            </div>

                                            <p class="text-truncate text-capitalize">
                                                <?= htmlspecialchars($fetch_products['details']); ?>
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold d-block h5">$
                                                    <?= htmlspecialchars($fetch_products['price']); ?>
                                                </span>
                                                <div class="btn-group">
                                                    <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>"
                                                        class="btn btn-primary">View</a>
                                                </div>
                                            </div>
                                            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                            <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                                            <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                                            <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">

                                        </div>
                                    </div>
                                </div>
                            </form>

                            <?php
                        }
                        ?>
                    </div>

                    <nav aria-label="Page navigation example" class="pt-5">
                        <ul class="pagination justify-content-center">
                            <li class="page-item btn">
                                <a class="text-decoration-none text-dark" href="shop.php">See All</a>
                            </li>
                        </ul>
                    </nav>
                    <?php
                    } else {
                        echo '<p class="empty">no products added yet!</p>';
                    }
                    ?>
            </div>
        </div>
    </section>
    <!-- end of shop -->

    <!-- offer -->
    <section id="offers" class="py-5">
        <div class="container">
            <div
                class="row d-flex align-items-center justify-content-center text-center justify-content-lg-start text-lg-start">
                <div class="offers-content">
                    <span class="text-white">Discount Up To 40%</span>
                    <h2 class="mt-2 mb-4 text-white">Grand Sale Offer!</h2>
                    <a href="shop.php" class="btn">Buy Now</a>
                </div>
            </div>
        </div>
    </section>
    <!-- end of offer -->

    <!-- about us -->
    <section id="about" class="my-5">
        <div class="container">
            <div class="title text-center">
                <h2 class="position-relative d-inline-block ms-4">About Us</h2>
                <hr class="mx-auto">
            </div>
            <div class="row gy-lg-5 align-items-center">
                <div class="col-lg-6 order-lg-1 text-center text-lg-start">
                    <div class="pt-3 pb-3">
                        <h2 class="position-relative d-inline-block">BORN IN VIETNAM</h2>
                    </div>
                    <p class="lead text-muted px-3">At FASHION, we easily mix fabrics, cuts and seasons. Leather with
                        patterns, tight and loose, summer in winter and winter in sum- mer.
                        A mix of styles inspired by these women who embody FASHION. Hyperactive and free, they are
                        fearless
                        and have no limit. They wear whatever they want, whenever they want. <br>
                        From 2023 and the opening of its first VIETNAM boutique in CANTHO, FASHION has become a brand in
                        its
                        own right, desired and sought-after by all women of major cities.</p>
                    <button class="btn mx-4 my-4"><a href="about.php" class="text-decoration-none text-dark">Read
                            more</a></button>
                </div>

                <div class="col-lg-6 order-lg-0 pt-3 pb-3">
                    <img src="img/poster/11.jpg" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <!-- end of about us -->

    <!-- blogs -->
    <section id="blogs" class="my-5">
        <div class="container">
            <div class="title text-center">
                <h2 class="position-relative d-inline-block mb-3">An Extraordinary Commitment To Quality</h2>
                <p>No matter what item you choose, you’ll find these things to be true:</p>
            </div>
            <div class="row g-3">
                <div class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
                    <img src="../img/poster/durable.webp" alt="">
                    <div class="card-body px-0">
                        <h4 class="card-title">DURABLE. <br> NOT DISPOSABLE.</h4>
                        <p class="card-text mt-3 text-muted"></p>
                    </div>
                </div>

                <div class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
                    <img src="../img/poster/assets_7acommunity.webp" alt="">
                    <div class="card-body px-0">
                        <h4 class="card-title">COMMUNITY POWERED <br> SUPPLY CHAIN.</h4>
                        <p class="card-text mt-3 text-muted"></p>
                    </div>
                </div>

                <div class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
                    <img src="../img/poster/made.webp" alt="">
                    <div class="card-body px-0">
                        <h4 class="card-title">MADE RIGHT. <br> RIGHT HERE.</h4>
                        <p class="card-text mt-3 text-muted"></p>
                    </div>
                </div>
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item btn">
                        <a class="text-decoration-none text-dark" href="blog.php">Read more</a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
    <!-- end of blogs -->

    <?php

    include_once __DIR__ . '/../partials/footer.php';