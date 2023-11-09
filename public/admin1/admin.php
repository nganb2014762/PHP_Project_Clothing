<?php

include_once __DIR__ . '../../../partials/boostrap.php';

include_once __DIR__ . '../../../partials/admin_header2.php';

require_once __DIR__ . '../../../partials/connect.php';


$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<title>Admin Page</title>
</head>
<body>


<section class="container my-3 py-3">
   <div class="container title text-center mt-3 pt-5">
      <h2 class="position-relative d-inline-block">Dashboard</h2>
      <!-- <hr class="mx-auto"> -->
   </div>
   <div class="row row-cols-2 row-cols-md-4 g-4 mt-3">
      <div class="col text-center">
         <div class="card h-100 p-4">
            <?php
            $total_pendings = 0;
            $select_pendings = $pdo->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_pendings->execute(['pending']);
            while ($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)) {
               $total_pendings += $fetch_pendings['total_price'];
            }
            ;
            ?>
            <h3>$
               <?= $total_pendings; ?>/-
            </h3>
            <p>total pendings</p>
            <a href="../admin/admin_orders.php" class="btn">see total pendings</a>
         </div>
      </div>

      <div class="col text-center">
         <div class="card h-100 p-4">
            <?php
            $total_completed = 0;
            $select_completed = $pdo->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_completed->execute(['completed']);
            while ($fetch_completed = $select_completed->fetch(PDO::FETCH_ASSOC)) {
               $total_completed += $fetch_completed['total_price'];
            }
            ;
            ?>
            <h3>$
               <?= $total_completed; ?>/-
            </h3>
            <p>completed orders</p>
            <a href="../admin/admin_completed_orders.php" class="btn">see completed orders</a>
         </div>
      </div>

      <div class="col text-center">
         <div class="card h-100 p-4">
            <?php
            $select_orders = $pdo->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount();
            ?>
            <h3>
               <?= $number_of_orders; ?>
            </h3>
            <p>orders placed</p>
            <a href="../admin/admin_orders.php" class="btn">see orders</a>
         </div>
      </div>

      <div class="col text-center">
         <div class="card h-100 p-4">
            <?php
            $select_products = $pdo->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount();
            ?>
            <h3>
               <?= $number_of_products; ?>
            </h3>
            <p>products added</p>
            <a href="../admin/admin_products.php" class="btn">see products</a>
         </div>
      </div>

      <div class="col text-center">
         <div class="card h-100 p-4">
            <?php
            $select_users = $pdo->prepare("SELECT * FROM `user` WHERE role = ?");
            $select_users->execute(['0']);
            $number_of_users = $select_users->rowCount();
            ?>
            <h3>
               <?= $number_of_users; ?>
            </h3>
            <p>total users</p>
            <a href="../admin/admin_total_users.php" class="btn">see users</a>
         </div>
      </div>

      <div class="col text-center">
         <div class="card h-100 p-4">
            <?php
            $select_admins = $pdo->prepare("SELECT * FROM `user` WHERE role = ?");
            $select_admins->execute(['1']);
            $number_of_admins = $select_admins->rowCount();
            ?>
            <h3>
               <?= $number_of_admins; ?>
            </h3>
            <p>total admins</p>
            <a href="../admin/admin_total_admins.php" class="btn">see admins</a>
         </div>
      </div>
      <div class="col text-center">
         <div class="card h-100 p-4">
            <?php
            $select_accounts = $pdo->prepare("SELECT * FROM `user`");
            $select_accounts->execute();
            $number_of_accounts = $select_accounts->rowCount();
            ?>
            <h3>
               <?= $number_of_accounts; ?>
            </h3>
            <p>total accounts</p>
            <a href="../admin/admin_total_accounts.php" class="btn">see accounts</a>
         </div>
      </div>

      <div class="col text-center">
         <div class="card h-100 p-4">
            <?php
            $select_messages = $pdo->prepare("SELECT * FROM `message`");
            $select_messages->execute();
            $number_of_messages = $select_messages->rowCount();
            ?>
            <h3>
               <?= $number_of_messages; ?>
            </h3>
            <p>total messages</p>
            <a href="../admin/admin_contacts.php" class="btn">see messages</a>
         </div>
      </div>
   </div>
</section>

<?php
include_once __DIR__ . '../../../partials/admin_footer.php';