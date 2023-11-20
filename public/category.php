<?php
include_once __DIR__ . '../../partials/boostrap.php';
include_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '../../partials/connect.php';

// $user_id = $_SESSION['user_id'];
// if (!isset($user_id)) {
//     header('location:login.php');
// }
// ;

if (isset($_POST['add_to_wishlist'])) {

    $pid = $_POST['pid'];
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_image = $_POST['p_image'];

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
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_image = $_POST['p_image'];
    $p_qty = $_POST['p_qty'];

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
?>


<title>Products categories</title>
</head>

<!-- shop -->
<section id="category" class="pt-5">
    <div class="container">
        <div class="title text-center mt-5 pt-5">
            <h2 class="position-relative d-inline-block">Products categories</h2>
        </div>
        <?php
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<div class="alert alert-warning alert-dismissible fade show col-6 offset-3" role="alert" tabindex="-1">
                            ' . htmlspecialchars($message) . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
            }
        }
        ;
        ?>
        <div class="row g-0 container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mt-3">
                <?php
                $category_id = $_GET['id'];
                $select_products = $pdo->prepare("SELECT * FROM `products` WHERE category_id = ?");
                $select_products->execute([$category_id]);
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <form action="" method="POST" onsubmit="return addToWishllist();">
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
                                        <input type="hidden" name="pid" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                                        <input type="hidden" name="p_name"
                                            value="<?= htmlspecialchars($fetch_products['name']); ?>">
                                        <input type="hidden" name="p_price"
                                            value="<?= htmlspecialchars($fetch_products['price']); ?>">
                                        <input type="hidden" name="p_image"
                                            value="<?= htmlspecialchars($fetch_products['image']); ?>">

                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>

                <?php
                } else {
                    echo '<p class="empty">No products added yet!</p>';
                }
                ?>
        </div>
    </div>
</section>
<!-- end of shop -->

<?php
include_once __DIR__ . '/../partials/footer.php';