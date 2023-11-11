<?php

include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}
;

// Đoạn mã để lấy thông tin hồ sơ người dùng từ cơ sở dữ liệu
$user_profile_query = $pdo->prepare("SELECT * FROM `user` WHERE id = ?");
$user_profile_query->execute([$user_id]);
$fetch_profile = $user_profile_query->fetch(PDO::FETCH_ASSOC);

// Tiếp theo, bạn có thể kiểm tra xem dữ liệu có tồn tại hay không
if ($fetch_profile) {
  // Hiển thị thông tin hồ sơ người dùng
  $user_name = isset($fetch_profile['name']) ? $fetch_profile['name'] : '';
  $user_phone = isset($fetch_profile['phone']) ? $fetch_profile['phone'] : '';
  $user_email = isset($fetch_profile['email']) ? $fetch_profile['email'] : '';
  $user_address = isset($fetch_profile['address']) ? $fetch_profile['address'] : '';
} else {
  // Xử lý trường hợp không tìm thấy thông tin hồ sơ người dùng
  echo "Không thể tìm thấy thông tin hồ sơ người dùng.";
}


if (isset($_POST['order'])) {

  $method = $_POST['method'];
$method = filter_var($method, FILTER_SANITIZE_STRING);
  
  $address = filter_var($address, FILTER_SANITIZE_STRING);
  $placed_on = date('Y-m-d', strtotime('now'));


  $cart_total = 0;
  $cart_products[] = '';

  $cart_query = $pdo->prepare("SELECT * FROM `cart` WHERE user_id = ?");
  $cart_query->execute([$user_id]);
  if ($cart_query->rowCount() > 0) {
    while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
      $cart_products[] = $cart_item['name'] . ' ( ' . $cart_item['quantity'] . ' )';
      $sub_total = ($cart_item['price'] * $cart_item['quantity']);
      $cart_total += $sub_total;
    }
    ;
  }
  ;

  $total_products = implode(', ', $cart_products);

  $order_query = $pdo->prepare("SELECT * FROM `orders` WHERE  method = ?  AND total_products = ? AND total_price = ?");
  $order_query->execute([$method, $total_products, $cart_total]);
  
  if (empty($fetch_profile['address'])) {
    $message[] = 'add address ';
  }elseif($cart_total == 0) {
    $message[] = 'your cart is empty';
  } elseif ($order_query->rowCount() > 0) {
    $message[] = 'order placed already!';
  } else {
    $insert_order = $pdo->prepare("INSERT INTO `orders`(user_id,method,total_products, total_price, placed_on) VALUES(?,?,?,?,?)");
    $insert_order->execute([$user_id, $method, $total_products, $cart_total, $placed_on]);
    $delete_cart = $pdo->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$user_id]);
    $message[] = 'order placed successfully!';
  }
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
};
?>

<title>Checkout</title>
</head>

<div class="container">
  <main>
    <div class="my-5 pt-5 text-center">
      <div class="container title text-center mt-3 pt-5">
        <h2 class="position-relative d-inline-block">Checkout form</h2>
      </div>

    </div>

    <div class="row g-5">

      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary ">Your cart</span>
        </h4>
        <?php
        $cart_grand_total = 0;
        $select_cart_items = $pdo->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $select_cart_items->execute([$user_id]);
        if ($select_cart_items->rowCount() > 0) {
          while ($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)) {
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
            ?>
            <div>
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-sm">
                  <div>
                    <h6 class="my-0">Product name</h6>
                    <small class="text-muted">
                      <?= htmlspecialchars($fetch_cart_items['name']); ?>
                    </small>
                  </div>
                  <span class="text-muted">
                    <?= htmlspecialchars($fetch_cart_items['price']) . '$' ?>
                  </span>
                </li>

                <li class="list-group-item d-flex justify-content-between lh-sm">
                  <div>
                    <h6 class="my-0">Quantity</h6>
                  </div>
                  <span class="text-muted">
                    <?= htmlspecialchars($fetch_cart_items['quantity']); ?>
                  </span>
                </li>

              </ul>
            </div>

            <?php
          }
        } else {
          echo '<p class="empty"> Your bill is  empty!</p>';
        }
        ?>

        <li class="list-group-item d-flex justify-content-between lh-sm">
          <span><b>Total: </b></span>
          <strong>
            <?= htmlspecialchars($cart_grand_total); ?>$
          </strong>

          </span>
        </li>
      </div>

      <div class="col-md-7 col-lg-8 border-end">
        <h4 class="mb-3 text-primary">Billing address</h4>
        <form class="needs-validation" validate method="POST">
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label">Your name</label>
              <div class="form-control" name="name">
                <?= isset($fetch_profile['name']) ? htmlspecialchars($fetch_profile['name']) : ''; ?>

              </div>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-6">
              <label class="form-label">Phone</label>
              <div class="form-control" name="phone">
                <?= htmlspecialchars($fetch_profile['phone']); ?>

              </div>
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>


            <div class="col-12">
              <label for="email" class="form-label">Email </label>
              <div class="form-control" name="email">
                <?= htmlspecialchars($fetch_profile['email']); ?>

              </div>
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <div class="form-control" name="address">
                <?php
                if (!empty($fetch_profile['address'])) {
                  echo htmlspecialchars($fetch_profile['address']);
                } else {
                  echo 'Please enter your shipping address.';
                  echo '<a style="text-decoration: none;" href="user_edit_account.php">Change your information? Click here</a> ';
                }
                ?>
              </div>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <h4 class="mb-3 text-primary">Payment</h4>
            <select name="method" class="form-control" required>
              <option value="cash on delivery">Cash on delivery</option>
              <option value="credit card">Credit card</option>
              <option value="MoMo">MoMo</option>
              <option value="Zalo Pay">Zalo Pay</option>
            </select>
            
            <!-- <div class="col-12">
              <a style="text-decoration: none;" href="user_edit_account.php">Change your information? Click here</a>
            </div> -->
            <button class="w-100 btn btn-primary btn-lg  <?= ($cart_grand_total > 1) ? '' : 'disabled'; ?>" name="order"
              type="submit">Continue to order </button>

        </form>
      </div>
    </div>
  </main>

</div>
<?php

include_once __DIR__ . '../../partials/footer.php';