<?php
include_once __DIR__ . "../../../partials/admin_boostrap.php";
session_start();
require_once __DIR__ . '../../../partials/connect.php';

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}
;


if (isset($_POST['update_order'])) {

    $id = $_POST['id'];

    $payment_status = $_POST['payment_status'];
    $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);

    $update_orders = $pdo->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_orders->execute([$payment_status, $id]);

    $message[] = 'order updated successfully!';
    header('location:list_orders.php');
    // $query = "UPDATE `orders` SET payment_status = ? WHERE id = ?";
    // $before_update = $pdo->query("SELECT payment_status FROM orders WHERE id = $id")->fetchColumn();

    // $update_orders = $pdo->prepare($query);
    // $update_orders->execute([$payment_status, $id]);

    // $after_update = $pdo->query("SELECT payment_status FROM orders WHERE id = $id")->fetchColumn();

    // if ($before_update == $after_update) {
    //     // $message[] = 'Update failed';
    //     echo 'Update failed';
    // } else {
    //     // $message[] = 'Order updated successfully!';
    //     echo 'Order updated successfully';
    // }
};

if (isset($message)) {
    foreach ($message as $message) {
        echo '<script>alert(" ' . $message . ' ");</script><alert>';
    }
}
?>

<title>Edit Products</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include_once __DIR__ . "../../../partials/admin_header_column.php";
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include_once __DIR__ . "../../../partials/admin_header.php";
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Cập nhật trạng thái đơn hàng</h1>
                        <a href="list_orders.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-solid fa-list fa-sm text-white-50"></i> Danh sách đơn hàng</a>
                    </div>
                    <section class="">
                        <!-- <div class="container text-center">
                            <h2 class="position-relative d-inline-block"></h2>
                            
                        </div> -->
                        <div class="mx-auto container">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <?php
                                    $update_id = $_GET['update'];
                                    $select_orders = $pdo->prepare("SELECT * FROM `orders` WHERE id = ?");
                                    $select_orders->execute([$update_id]);
                                    if ($select_orders->rowCount() > 0) {
                                        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                            ?>

                                            <form id="order-form" class="text_center form-horizontal" action="" method="post"
                                                enctype="multipart/form-data">

                                                <div class="form-group">
                                                    <input class="form-control" type="hidden" name="id"
                                                        value="<?= $fetch_orders['id']; ?>">
                                                </div>

                                                <div class="form-group">
                                                    <select name="payment_status" class="form-control" required>
                                                        <option selected>
                                                            <?= $fetch_orders['payment_status']; ?>
                                                        </option>
                                                        <option value="pending">pending</option>
                                                        <option value="transport">transport</option>
                                                        <option value="completed">completed</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <div class="flex-btn">
                                                        <input type="submit" class="btn w-100 btn-primary shadow-sm"
                                                            value="update" name="update_order">
                                                    </div>
                                                </div>
                                            </form>

                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php
    include_once __DIR__ . '../../../partials/admin_footer.php';