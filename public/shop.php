<?php

include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '/../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';

?>
<title>Shop</title>
</head>

<body>
    <!-- shop -->
    <section id="collection" class="pt-5">
        <div class="container">
            <div class="title text-center mt-5 pt-5">
                <h2 class="position-relative d-inline-block">Collection</h2>
            </div>

            <div class="row g-0 container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mt-3">
                    <?php
                    $select_products = $pdo->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="col">
                                <div class="card shadow rounded">
                                    <div class="collection-img position-relative">
                                        <img class="rounded-top p-0" src="admin/uploaded_img/<?= $fetch_products['image']; ?>"
                                            alt="">
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <p class="card-text text-capitalize text-truncate fw-bold">
                                                    <?= $fetch_products['name']; ?>
                                                </p>
                                            </div>
                                            <div class="col-4 text-end"><a href="#"><i
                                                        class="fa-regular fa-heart fa-lg text-dark heart"></i></a></div>
                                        </div>
                                        <p class="text-truncate">
                                            <?= $fetch_products['details']; ?>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold d-block h5">$
                                                <?= $fetch_products['price']; ?>
                                            </span>
                                            <div class="btn-group">
                                                <a href="view_page.php?pid=<?= $fetch_products['id']; ?>"
                                                    class="btn btn-primary">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                        ?>
                    </div>

                    <nav aria-label="Page navigation example" class="pt-5">
                        <ul class="pagination justify-content-end">
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

    <?php
    include_once __DIR__ . '/../partials/footer.php';