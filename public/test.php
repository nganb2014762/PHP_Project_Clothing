<?php
include_once __DIR__ . '../../partials/boostrap.php';
include_once __DIR__ . '../../partials/header.php';
require_once __DIR__ . '../../partials/connect.php';

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit; // Thoát khỏi script nếu không có user_id
}

$sql = "SELECT orders.id as order_id, orders.total_products, orders.total_price, orders.placed_on, orders.check_date, orders.method, orders.payment_status, 
               products.id as product_id, products.name as product_name, products.price as product_price, products.image as product_image
        FROM orders
        JOIN orders_details ON orders.id = orders_details.order_id
        JOIN products ON orders_details.pid = products.id
        WHERE orders.user_id = :user_id";

$select_orders = $pdo->prepare($sql);
$select_orders->execute([':user_id' => $user_id]);

if ($select_orders->rowCount() > 0) { ?>
    <table>
        <tr>
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
            <th>Product Image</th>
        </tr>
        <?php
        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?= $fetch_orders['order_id']; ?></td>
                <td><?= $fetch_orders['total_products']; ?></td>
                <td><?= $fetch_orders['total_price']; ?></td>
                <td><?= $fetch_orders['placed_on']; ?></td>
                <td><?= $fetch_orders['check_date']; ?></td>
                <td><?= $fetch_orders['method']; ?></td>
                <td><?= $fetch_orders['payment_status']; ?></td>
                <td><?= $fetch_orders['product_id']; ?></td>
                <td><?= $fetch_orders['product_name']; ?></td>
                <td><?= $fetch_orders['product_price']; ?></td>
                <td><img src="admin/uploaded_img/<?= $fetch_orders['product_image']; ?>" alt=""></td>
            </tr>
            <td class="pt-4">
                                                <?= htmlspecialchars($row['total_products']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['total_price']); ?>$
                                            </td>
        <?php
        }
        ?>
    </table>
<?php
} else {
    echo '<p>No orders found for this user.</p>';
}
include_once __DIR__ . '/../partials/footer.php';
?>