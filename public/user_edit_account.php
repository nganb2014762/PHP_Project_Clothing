<?php
include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';

echo 'Debugging output here';

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}
;
$message = [];
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
            $message[] = 'Profile updated successfully!';
            // echo 'Redirecting...'; // Add this line for debugging
            // header('location:user_account.php');
            // exit(); // Make sure to exit after the header redirection
        } else {
            $message[] = 'Profile update failed: ' . $pdo->errorInfo()[2]; // In ra thông báo lỗi của PDO
        }
    }
};

if (isset($message)) {
    foreach ($message as $message) {
        // echo '<script>alert(" ' . $message . ' ");</script>';
        echo '<div class="alert alert-warning alert-dismissible fade show col-4 offset-4" role="alert" tabindex="-1">
                ' . htmlspecialchars($message) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}
;
?>

<title>Update Account</title>
</head>
<section class="my-5 py-5">
    <div class="container title text-center mt-3 pt-5">
        <h2 class="position-relative d-inline-block">Update Account</h2>
        <hr class="mx-auto">
    </div>

    <div class="d-flex justify-content-center">
        <div class="card mt-5 mb-5 w-50">

            <form action="user_edit_account.php" method="post">
                <div class="card-body row">
                    <div class="col-md-3 col-12">Profile photo</div>
                    <div class="col-md-8 col-10">Your profile photo helps others recognize you</div>
                    <div class="col-md-1 col-2"><img class="float-end" src="../img/account/user.jpg" width="70"></div>
                    <!-- <hr class="mt-2"> -->
                </div>
                <div class="card-body row">
                    <div class="col-md-3 col-12">Name</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="text" name="name" value="<?= $fetch_profile['name']; ?>"
                            placeholder="update username">

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
                        <input class="form-control" type="text" name="born" value="<?= $fetch_profile['born']; ?>"
                            placeholder="update my birthday">

                    </div>

                    <!-- <hr class="mt-2"> -->
                </div>

                <div class="card-body row">
                    <div class="col-md-3 col-12">Email</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="text" name="email" value="<?= $fetch_profile['email']; ?>"
                            placeholder="update my email">
                    </div>

                    <!-- <hr class="mt-2"> -->
                </div>
                <div class="card-body row">
                    <div class="col-md-3 col-12">Phone</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="text" name="phone" value="<?= $fetch_profile['phone']; ?>"
                            placeholder="update my phone">
                    </div>

                    <!-- <hr class="mt-2"> -->
                </div>

                <div class="card-body row">
                    <div class="col-md-3 col-12">Address</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="text" name="address" value="<?= $fetch_profile['address']; ?>"
                            placeholder="update address">
                    </div>

                    <!-- <hr class="mt-2"> -->
                </div>
                <div class="p-3">
                    <input type="submit" class="btn w-100" value="Update" name="update_profile">

                </div>
        </div>
    </div>
    </form>
</section>

<?php
include_once __DIR__ . '../../partials/footer.php';