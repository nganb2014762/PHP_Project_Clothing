<?php

include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}
;

// if (isset($_POST['update_order'])) {

//     $order_id = $_POST['order_id'];
//     $update_payment = $_POST['update_payment'];
//     $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
//     $update_orders = $pdo->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
//     $update_orders->execute([$update_payment, $order_id]);
//     $message[] = 'payment has been updated!';
//     $placed_on = date('d-M-Y');

// };

?>

<title>My order</title>
</head>

<section id="cart" class="pt-5">
    <div class="container">
        <div class="title text-center mt-5 pt-5">
            <h2 class="position-relative d-inline-block">My Orders</h2>
            <hr>
        </div>

        <?php
        $total = 0;
        $sub_total = 0;
        // $select_orders = $pdo->prepare("SELECT * FROM `orders` WHERE user_id = ?");
        // $select_orders->execute([$user_id]);
        

        $sql = "SELECT orders.id as order_id, orders.total_products, orders.total_price, orders.placed_on, orders.check_date, orders.method, orders.payment_status, 
products.id as product_id, products.name as product_name, products.price as product_price, products.image as product_image
FROM orders
JOIN orders_details ON orders.id = orders_details.order_id
JOIN products ON orders_details.pid = products.id
WHERE orders.user_id = :user_id";

        $select_orders = $pdo->prepare($sql);
        $select_orders->execute([':user_id' => $user_id]);


        if ($select_orders->rowCount() > 0) { ?>
            <table class="mt-5 pt-5">
                <tr>
                    <th class="col-1">Product Image</th>
                    <th>Order ID</th>
                    <th>Total Products</th>
                    <th>Total Price</th>
                    <th>Placed On</th>
                    <th>Check Date</th>
                    <th>Payment Method</th>
                    <th>Payment Status</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>

                </tr>
                <?php
                // $select_orders = $pdo->prepare("SELECT * FROM `orders`");
                // $select_orders->execute();
            
                if ($select_orders->rowCount() > 0) {
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                        <tr>
                            <td>
                                <img src="admin/uploaded_img/<?= $fetch_orders['product_image']; ?>" alt="" class="w-100">
                            </td>
                            <td>
                                <?= $fetch_orders['order_id']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['total_products']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['total_price']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['placed_on']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['check_date']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['method']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['payment_status']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['product_id']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['product_name']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['product_price']; ?>
                            </td>

                        </tr>
                        <?php
                    }
                    ?>
                </table>

                <?php
                }
        } else { ?>
            <div class="text-center pt-3">
                <h6 class="position-relative d-inline-block">No item found </h6>
                <div>
                    <a type="submit" class="buy-btn text-capitalize text-decoration-none mt-3" name="order now"
                        href="cart.php">order now</a>
                </div>
            </div>
            <!-- echo '<p class="empty" >no orders placed yet!</p>'; -->
            <?php
        }
        ?>
    </div>
</section>


<?php
include_once __DIR__ . '/../partials/footer.php';
