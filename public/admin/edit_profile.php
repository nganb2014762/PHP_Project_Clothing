<?php
include_once __DIR__ . "../../../partials/admin_boostrap.php";
session_start();
require_once __DIR__ . '../../../partials/connect.php';

$user_id = $_SESSION['admin_id'];
$message = [];
if (!isset($user_id)) {
    header('location:login.php');
}
;

if (isset($_POST['update_profile'])) {
    // Kiểm tra các trường không được để trống
    if (empty($_POST['name']) || empty($_POST['sex']) || empty($_POST['born']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address'])) {
        $message[] = 'All fields are required.';
    } else {
        $name = $_POST['name'];
        $sex = $_POST['sex'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $born = $_POST['born'];

        $update_profile = $pdo->prepare("UPDATE user SET name = ?, sex = ?, email = ?, phone = ?, address = ?, born = ? WHERE id = ?");
        $update_success = $update_profile->execute([$name, $sex, $email, $phone, $address, $born, $user_id]);

        if ($update_success) {
            // Nếu thành công, thêm thông báo vào mảng $message
            $message[] = 'Profile updated successfully!';
        } else {
            $message[] = 'Profile update failed: ' . $pdo->errorInfo()[2]; // In ra thông báo lỗi của PDO
        }
    }
}
?>

<title>Edit Profile</title>
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
                    <?php
                    if (isset($message) && !empty($message)) {
                        foreach ($message as $message) {
                            echo '<div class="message">' . $message . '</div>';
                        }
                    }
                    ?>

                    <div class="d-flex justify-content-center  vh-100">
                        <div class="card mt-5 mb-5 w-50">

                            <form action="edit_profile.php" method="post">
                                <div class="card-body row">
                                    <div class="col-md-3 col-12">Profile photo</div>
                                    <div class="col-md-8 col-10">Your profile photo helps others recognize you</div>
                                    <div class="col-md-1 col-2"><img class="float-end" src="../img/account/user.jpg"
                                            width="70"></div>
                                    <!-- <hr class="mt-2"> -->
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-3 col-12">Name</div>
                                    <div class="col-md-8 col-10">
                                        <input class="form-control" type="text" name="name"
                                            value="<?= $fetch_profile['name']; ?>" placeholder="update username">

                                    </div>

                                    <!-- <hr class="mt-2"> -->
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-3 col-12">Sex</div>
                                    <div class="col-md-8 col-10">
                                        <input class="form-control" type="text" name="sex" value="<?php
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
                                        echo $sex_string;
                                        ?>" placeholder="update my sex">
                                    </div>

                                </div>
                                <div class="card-body row">
                                    <div class="col-md-3 col-12">Birthday</div>
                                    <div class="col-md-8 col-10">
                                        <input class="form-control" type="text" name="born"
                                            value="<?= $fetch_profile['born']; ?>" placeholder="update my birthday">

                                    </div>

                                    <!-- <hr class="mt-2"> -->
                                </div>

                                <div class="card-body row">
                                    <div class="col-md-3 col-12">Email</div>
                                    <div class="col-md-8 col-10">
                                        <input class="form-control" type="text" name="email"
                                            value="<?= $fetch_profile['email']; ?>" placeholder="update my email">
                                    </div>

                                    <!-- <hr class="mt-2"> -->
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-3 col-12">Phone</div>
                                    <div class="col-md-8 col-10">
                                        <input class="form-control" type="text" name="phone"
                                            value="<?= $fetch_profile['phone']; ?>" placeholder="update my phone">
                                    </div>

                                    <!-- <hr class="mt-2"> -->
                                </div>

                                <div class="card-body row">
                                    <div class="col-md-3 col-12">Address</div>
                                    <div class="col-md-8 col-10">
                                        <input class="form-control" type="text" name="address"
                                            value="<?= $fetch_profile['address']; ?>" placeholder="update address">
                                    </div>

                                    <!-- <hr class="mt-2"> -->
                                </div>
                                <div class="d-grid gap-2 col-3 mx-auto">
                                    <button type="submit" class="btn btn-primary" value="Update" name="update_profile">
                                        Update
                                    </button>
                                </div>

                        </div>



                    </div>

                </div>


                </form>

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
