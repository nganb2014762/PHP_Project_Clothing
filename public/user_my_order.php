<?php

include_once __DIR__ . '/../partials/boostrap.php';

include_once __DIR__ . '/../partials/header.php';

require_once __DIR__ . '/../partials/connect.php';

// session_start();

// $admin_id = $_SESSION['admin_id'];

// if(!isset($admin_id)){
//    header('location:login.php');
// };

if (isset($_POST['update_order'])) {

    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
    $update_orders = $pdo->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_orders->execute([$update_payment, $order_id]);
    $message[] = 'payment has been updated!';
    $placed_on = date('d-M-Y');

};



?>

<title>My Orders</title>
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
        $select_orders = $pdo->prepare("SELECT * FROM `orders` WHERE user_id = ?");
        $select_orders->execute([$user_id]);
        ?>
        <?php if ($select_orders->rowCount() > 0) { ?>
            <table class="mt-5 pt-5">
                <tr>
                    <th>Product</th>
                    <th>Order date</th>
                    <th>Delivery date</th>
                    <th>Payment method</th>
                    <th>Subtotal</th>
                    <th>Status</th>
                </tr>
                <?php
                $select_orders = $pdo->prepare("SELECT * FROM `orders`");
                $select_orders->execute();
                if ($select_orders->rowCount() > 0) {
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {

                ?>
                        <div>
                            <tr>

                                <td>
                                    <div class="product-info">
                                        <!-- <img src="admin/uploaded_img/<?= $fetch_orders['image']; ?>" alt=""> -->
                                        <div>
                                            <div class=" name text-capitalize">
                                                <?= $fetch_orders['total_products']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="product-price">
                                        <div class="price">
                                            <?= $fetch_orders['placed_on']; ?>
                                        </div>
                                    </span>
                                </td>

                                <td>
                                    <span class="product-price">
                                        <div class="price">
                                            <?= $fetch_orders['check_date']; ?>
                                        </div>
                                    </span>
                                </td>

                                <td>
                                    <span class="product-price">
                                        <div class="price">
                                            <?= $fetch_orders['method']; ?>
                                        </div>
                                    </span>
                                </td>

                                <td>
                                    <span class="product-price">
                                        <div class="price">
                                            <?= $fetch_orders['total_price']; ?>$
                                        </div>
                                    </span>
                                </td>

                                <td>
                                    <span class="product-price">
                                    Pending confirmation
                                    </span>
                                </td>
                            </tr>
                        </div>
                    <?php

                    }


                    ?>
            </table>

    <?php
                }
            } else {
                echo '<p class="empty" >no orders placed yet!</p>';
            }
    ?>
    </div>
</section>


<?php
include_once __DIR__ . '/../partials/footer.php';
