<?php

include_once __DIR__ . '../../../partials/boostrap.php';

include_once __DIR__ . '../../../partials/admin_header.php';

require_once __DIR__ . '../../../partials/connect.php';



$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};


?>


<section class="container my-3 py-3 user-accounts">
    <div class="container title text-center mt-3 pt-5">
        <h2 class="position-relative d-inline-block">Manage Accounts</h2>
        <!-- <hr class="mx-auto"> -->
    </div>

    <div class="row row-cols-2 row-cols-md-3 g-4 mt-3">
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

    </div>
</section>



<?php
include_once __DIR__ . '../../../partials/admin_footer.php';