<?php

include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}
;

    $order_id = $_POST['order_id'];

    // Kiểm tra xem đơn đặt hàng có tồn tại không
    $check_order_query = $pdo->prepare("SELECT * FROM `orders` WHERE id = ? AND user_id = ?");
    $check_order_query->execute([$order_id, $user_id]);
    $order_data = $check_order_query->fetch(PDO::FETCH_ASSOC);

    if ($order_data) {
        // Cập nhật cột payment_status thành 'cancel'
        $update_order_query = $pdo->prepare("UPDATE `orders` SET payment_status = 'cancel', cancel_date = current_timestamp() WHERE id = ?");
        $update_order_query->execute([$order_id]);
        
        echo "Đơn hàng đã được hủy thành công!";
    } else {
        echo "Không tìm thấy đơn đặt hàng!";
    }
?>

<title>My order</title>
</head>

<!-- Cart -->
<section id="cart" class="pt-5">
    <div class="container">
        <div class="title text-center mt-5 pt-5">
            <h2 class="position-relative d-inline-block">My order</h2>
            <hr>
        </div>
        <?php
        $total = 0;
        $sub_total = 0;

        $sql = "SELECT orders.id as order_id, orders.total_products, orders.total_price, orders.placed_on, orders.check_date, orders.method, orders.payment_status, 
                products.id as product_id, products.name as product_name, products.price as product_price, products.image as product_image, orders_details.quantity as product_quantity
                FROM orders
                JOIN orders_details ON orders.id = orders_details.order_id
                JOIN products ON orders_details.pid = products.id
                WHERE orders.user_id = :user_id";

        $select_orders = $pdo->prepare($sql);
        $select_orders->execute([':user_id' => $user_id]);


        if ($select_orders->rowCount() > 0) { ?>
            <table class="mt-5 pt-5">
                <tr>
                    <th class="col-1">Order ID</th>
                    <th class="col-1">Product Image</th>
                    <th class="col-1">Product Name</th>
                    <th class="col-1">Product Price</th>
                    <th class="col-1">Product Quantity</th>
                    <th class="col-1">Total Products</th>
                    <th class="col-1">Total Price</th>
                    <th class="col-1">Placed On</th>
                    <th class="col-1">Check Date</th>
                    <th class="col-1">Payment Method</th>
                    <th class="col-1">Payment Status</th>
                    <th class="col-1">Cancel</th>
                </tr>
                <?php
                if ($select_orders->rowCount() > 0) {
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                        <tr>
                            <td>
                                <?= $fetch_orders['order_id']; ?>
                            </td>
                            <td>
                                <img src="admin/uploaded_img/<?= $fetch_orders['product_image']; ?>" alt="" class="w-100">
                            </td>
                            <td>
                                <?= $fetch_orders['product_name']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['product_price']; ?>
                            </td>
                            <td>
                                <?= $fetch_orders['product_quantity']; ?>
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
                                <!-- Trong HTML của trang hiển thị đơn đặt hàng -->
                                <form action="user_my_order.php" method="POST">
                                    <input type="hidden" name="order_id" value="<?= $fetch_orders['order_id'] ?>">
                                    <button type="submit" name="cancel_order" class="buy-btn">cancel</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>

                <?php
            }
        } else {
            ?>
            <div class="text-center pt-3">
                <h6 class="position-relative d-inline-block">No items found </h6>
                <div>
                    <a type="submit" class="buy-btn text-capitalize text-decoration-none mt-3" name="order now" href="cart.php">Order Now</a>
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
