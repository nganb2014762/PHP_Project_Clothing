<?php

include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';


if (isset($_POST['order'])) {

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $number = $_POST['number'];
  $number = filter_var($number, FILTER_SANITIZE_STRING);
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $address = $_POST['address'];

  $method = $_POST['method'];
  $method = filter_var($method, FILTER_SANITIZE_STRING);

  $address = filter_var($address, FILTER_SANITIZE_STRING);
  $placed_on = date('d-M-Y');
  $future_date = date('d-M-Y', strtotime($placed_on . ' +3 days'));

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

  $order_query = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");

  $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

  if ($cart_total == 0) {
    $message[] = 'your cart is empty';
  } elseif ($order_query->rowCount() > 0) {
    $message[] = 'order placed already!';
  } else {
    $insert_order = $pdo->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, future_date) VALUES(?,?,?,?,?,?,?,?,?,?)");
    $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on, $future_date,]);
    $delete_cart = $pdo->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$user_id]);
    $message[] = 'order placed successfully!';
  }
};

if (isset($message)) {
  foreach ($message as $message) {
      // echo '<script>alert(" ' . $message . ' ");</script>';
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          ' . htmlspecialchars($message) . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>';
  }
}
?>

<div class="container">
  <main>
    <div class=" my-5 py-5 text-center">
      <div class="container title text-center mt-3 pt-5">
        <h2 class="position-relative d-inline-block">Checkout form</h2>
      </div>

    </div>

    <div class="row g-5">



      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>

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
                      <?= $fetch_cart_items['name']; ?>
                    </small>
                  </div>
                  <span class="text-muted">
                    <?= $fetch_cart_items['price'] . '$' ?>
                  </span>
                </li>

                <li class="list-group-item d-flex justify-content-between lh-sm">
                  <div>
                    <h6 class="my-0">Quantity</h6>
                  </div>
                  <span class="text-muted">
                    <?= $fetch_cart_items['quantity']; ?>
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
            <?= $cart_grand_total; ?>$
          </strong>

          </span>
        </li>
      </div>

      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3 text-primary">Billing address</h4>
        <form class="needs-validation" validate method="POST">
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label">Your name</label>
              <input type="text" class="form-control" id="firstName" name="name" placeholder="enter your name" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-6">
              <label class="form-label">Phone</label>
              <input type="text" class="form-control" id="lastName" name="number" placeholder="enter your number"
                required>
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>


            <div class="col-12">
              <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" class="form-control" id="email" name="email" placeholder="enter your email" >
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="your address" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>
            <hr class="my-4">

            <!-- <div class="form-check">
              <input type="checkbox" class="form-check-input" id="same-address">
              <label class="form-check-label" for="same-address">Shipping address is the same as my billing
                address</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="save-info">
              <label class="form-check-label" for="save-info">Save this information for next time</label>
            </div> -->

            <hr class="my-4">

            <h4 class="mb-3">Payment</h4>
            <select name="method" class="form-control" required>
              <option value="cash on delivery">Cash on delivery</option>
              <option value="credit card">Credit card</option>
              <option value="MoMo">MoMo</option>
              <option value="Zalo Pay">Zalo Pay</option>
            </select>


            <hr class="my-4">
            <br>


            <button class="w-100 btn btn-primary btn-lg  <?= ($cart_grand_total > 1) ? '' : 'disabled'; ?>" name="order"
              type="submit">Continue to checkout</button>
        </form>
      </div>
    </div>
  </main>

</div>
<?php

include_once __DIR__ . '../../partials/footer.php';