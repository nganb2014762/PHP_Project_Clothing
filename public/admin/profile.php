<?php
include_once __DIR__ . "../../../partials/admin_boostrap.php";
session_start();
require_once __DIR__ . '../../../partials/connect.php';

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}
;

$message = [];
if (isset($_POST['update_profile'])) {

    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $born = $_POST['born'];
    $update_profile = $pdo->prepare("UPDATE `user` SET name = ?, email = ? WHERE id = ?");
    $update_profile->execute([$name, $sex, $phone, $address, $born, $email, $user_id]);

}
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

<title>Profile</title>
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

                    <div class="container title text-center ">
                        <h2 class="position-relative d-inline-block">My Account</h2>

                    </div>

                    <div class="d-flex justify-content-center vh-100">
                        <div class="card mt-5 mb-5 w-50 p-2">
                            <div class="card-body row">
                                <div class="col-md-3 col-12">Profile photo</div>
                                <div class="col-md-8 col-10">Your profile photo</div>
                                <div class="col-md-1 col-2"><img class="float-end img-fuild"
                                        src="../img/account/user0.png" width="70"></div>
                                <!-- <hr class="mt-2"> -->
                            </div>
                            <div class="card-body row">
                                <div class="col-md-3 col-12">Name</div>
                                <div class="col-md-8 col-10">
                                    <?= $fetch_profile['name']; ?>

                                </div>

                                <!-- <hr class="mt-2"> -->
                            </div>
                            <div class="card-body row">
                                <div class="col-md-3 col-12">Sex</div>
                                <div class="col-md-8 col-10">
                                    <?php
                                    // Lấy giá trị sex từ $fetch_profile
                                    $sex = $fetch_profile['sex'];

                                    // Chuyển đổi giá trị sex thành chuỗi "male" hoặc "female"
                                    if ($sex == 1) {
                                        $sex_string = 'male';
                                    } elseif ($sex == 0) {
                                        $sex_string = 'female';
                                    } else {
                                        $sex_string = 'unknown';
                                    }

                                    // In ra kết quả
                                    echo htmlspecialchars($sex_string);
                                    ?>
                                </div>

                            </div>
                            <div class="card-body row">
                                <div class="col-md-3 col-12">Birthday</div>
                                <div class="col-md-8 col-10">
                                    <?= htmlspecialchars($fetch_profile['born']); ?>

                                </div>

                                <!-- <hr class="mt-2"> -->
                            </div>

                            <div class="card-body row">
                                <div class="col-md-3 col-12">Email</div>
                                <div class="col-md-8 col-10">
                                    <?= htmlspecialchars($fetch_profile['email']); ?>
                                </div>

                                <!-- <hr class="mt-2"> -->
                            </div>
                            <div class="card-body row">
                                <div class="col-md-3 col-12">Phone</div>
                                <div class="col-md-8 col-10">
                                    <?= htmlspecialchars($fetch_profile['phone']); ?>
                                </div>

                                <!-- <hr class="mt-2"> -->
                            </div>

                            <div class="card-body row">
                                <div class="col-md-3 col-12">Address</div>
                                <div class="col-md-8 col-10">
                                    <?= htmlspecialchars($fetch_profile['address']); ?>
                                </div>

                                <!-- <hr class="mt-2"> -->
                            </div>
                            <div class="d-grid">
                                <a href="edit_profile.php" class="btn btn-primary w-100">Change Information</a>
                            </div>

                        </div>
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
    </div>
    <!-- End of Content Wrapper -->

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
                    Bạn có chắc chắn muốn xóa dòng này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <a id="deleteLink" href="" class="btn btn-danger">Xóa</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <?php

    include_once __DIR__ . '../../../partials/admin_footer.php';
