<?php
include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}
;

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_cart_item = $pdo->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart_item->execute([$delete_id]);
    header('location:cart.php');
}
;

if (isset($_GET['delete_all'])) {
    $delete_cart_item = $pdo->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart_item->execute([$user_id]);
    header('location:cart.php');
}
;

if (isset($_POST['update_qty'])) {
    $cart_id = $_POST['cart_id'];
    $p_qty = $_POST['p_qty'];
    $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);
    $update_qty = $pdo->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
    $update_qty->execute([$p_qty, $cart_id]);
    $message[] = 'cart quantity updated';
}
;

if (isset($message)) {
    foreach ($message as $message) {
        // echo '<script>alert(" ' . $message . ' ");</script>';
        echo '<div class="alert alert-warning alert-dismissible fade show col-4 offset-4" role="alert" tabindex="-1">
                ' . htmlspecialchars($message) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}
;
?>

<title>Cart</title>
</head>

<body>
    <!-- Cart -->
    <section id="cart" class="pt-5">
        <div class="container">
            <div class="title text-center mt-5 pt-5">
                <h2 class="position-relative d-inline-block">Your Cart</h2>
                <hr>
            </div>

            <?php
            $total = 0;
            $sub_total = 0;
            $select_cart = $pdo->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            ?>
            <?php if ($select_cart->rowCount() > 0) { ?>
                <table class="mt-5 pt-5">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php
                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                        $product_subtotal = $fetch_cart['price'] * $fetch_cart['quantity'];
                        $sub_total += $product_subtotal;
                        ?>
                        <tr>

                            <td>
                                <div class="product-info">
                                    <img src="admin/uploaded_img/<?= htmlspecialchars($fetch_cart['image']); ?>" alt="">
                                    <div>
                                        <div class=" name text-capitalize">
                                            <?= htmlspecialchars($fetch_cart['name']); ?>
                                        </div>
                                        <div class="price">
                                            <?= htmlspecialchars($fetch_cart['price']); ?>$
                                        </div>
                                        <br>
                                        <a class="text-capitalize text-align"
                                            href="cart.php?delete=<?= htmlspecialchars($fetch_cart['id']); ?>"
                                            onclick="return confirm('delete this from cart?');">remove</a>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="quantity">
                                    <?= htmlspecialchars($fetch_cart['quantity']); ?>
                                </div>
                            </td>

                            <td>
                                <span class="product-price">$
                                    <?= htmlspecialchars($product_subtotal); ?>
                                </span>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>


                <div class="cart-total">
                    <table>
                        <tr>
                            <td>Total</td>
                            <td>$
                                <?= $sub_total; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Subtotal</td>
                            <td><span>$
                                    <?= $sub_total; ?>
                                </span></td>
                        </tr>
                    </table>
                </div>

                <div class="checkout-container">
                    <a class="btn checkout-btn" href="checkout.php">Checkout</a>
                </div>

                <?php
            } else {
                ?>
                <div class="text-center pt-3">
                    <h6 class="position-relative d-inline-block">No item found </h6>
                    <div>
                        <a type="submit" class="buy-btn text-capitalize text-decoration-none mt-3" name="shop now"
                            href="shop.php">shop now</a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>



    <?php
    include_once __DIR__ . '../../partials/footer.php';
    ?>

</body>

</html>