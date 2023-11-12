<?php

include_once __DIR__ . "../../../partials/admin_boostrap.php";
session_start();
require_once __DIR__ . '../../../partials/connect.php';

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit(); // Đảm bảo ngừng việc thực thi mã ngay sau lệnh header
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_orders = $pdo->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_orders->execute([$delete_id]);
    header('location:list_orders.php');
    exit(); // Đảm bảo ngừng việc thực thi mã ngay sau lệnh header
}

if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . htmlspecialchars($message) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
    }
}

?>

<title>List Orders</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Danh sách đơn hàng</h1>
                        <a href="status_orders.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fa-solid fa-pen-to-square"></i> Trạng thái đơn hàng</a>
                    </div>

                    <div class="table-responsive">

                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col" class="col-auto">STT</th>
                                    <th scope="col" class="col-auto">Fullname</th>
                                    <th scope="col" class="col-auto">Email</th>
                                    <th scope="col" class="col-auto">Phone</th>
                                    <th scope="col" class="col-auto">Address</th>
                                    <th scope="col" class="col-auto">Date Place</th>
                                    <th scope="col" class="col-auto">Cancel Date</th>
                                    <th scope="col" class="col-auto">Check Date</th>
                                    <th scope="col" class="col-auto">Receive Date</th>
                                    <th scope="col" class="col-auto">Total Products</th>
                                    <th scope="col" class="col-auto">Total Price</th>
                                    <th scope="col" class="col-auto">Payment Method</th>
                                    <th scope="col" class="col-auto">Payment Status</th>
                                    <th scope="col" class="col-auto">Edit</th>
                                    <th scope="col" class="col-auto">Delete</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                $i = 1;
                                $select_info = $pdo->prepare("SELECT user.name, user.email, user.phone, user.address,
                                                                    orders.placed_on, orders.check_date,orders.cancel_date,orders.received_date, orders.total_products,
                                                                    orders.total_price, orders.method, orders.payment_status, orders.id
                                                                FROM user
                                                                INNER JOIN orders ON user.id = orders.user_id
                                                            ");
                                $select_info->execute();

                                if ($select_info->rowCount() > 0) {
                                    while ($row = $select_info->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td class="pt-4">
                                                <b>
                                                    <?= htmlspecialchars($i++); ?>
                                                </b>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['name']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['email']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['phone']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['address']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['placed_on']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['cancel_date']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['check_date']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['received_date']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['total_products']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['total_price']); ?>$
                                            </td>
                                            <td class="pt-4">
                                                <?= htmlspecialchars($row['method']); ?>
                                            </td>
                                            <td class="pt-4 text-success">
                                                <?= htmlspecialchars($row['payment_status']); ?>
                                            </td>
                                            <td class="pt-4">
                                                <a class="btn btn-primary"
                                                    href="edit_orders.php?update=<?= htmlspecialchars($row['id']); ?>&check_date=<?= date('Y-M-d', strtotime($row['check_date'])); ?>&cancel_date=<?= date('Y-M-d', strtotime($row['cancel_date'])); ?>"
                                                    class="option-btn">edit</a>
                                            </td>
                                            <td class="pt-4">
                                                <a class="btn btn-danger" data-id="<?= htmlspecialchars($row['id']); ?>"
                                                    data-check-date="<?= date('Y-M-d', strtotime($row['check_date'])); ?>"
                                                    data-cancel-date="<?= date('Y-M-d', strtotime($row['cancel_date'])); ?>"
                                                    data-toggle="modal" data-target="#deleteConfirmationModal">delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='12'>Không có dữ liệu.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        
                    </div>
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

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa dòng này?</p>
                    <p><strong>Check Date:</strong> <span id="checkDateInfo"></span></p>
                    <p><strong>Cancel Date:</strong> <span id="cancelDateInfo"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <a id="deleteLink" href="" class="btn btn-danger">Xóa</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var Id = button.data('id');
                var checkDate = button.data('check-date');
                var cancelDate = button.data('cancel-date');

                var deleteLink = 'list_orders.php?delete=' + Id;
                $('#deleteLink').attr('href', deleteLink);

                // Hiển thị thông tin ngày tháng năm trong modal
                $('#checkDateInfo').text(checkDate);
                $('#cancelDateInfo').text(cancelDate);
            });
        });
    </script>

    <?php
    include_once __DIR__ . '../../../partials/admin_footer.php';
    ?>