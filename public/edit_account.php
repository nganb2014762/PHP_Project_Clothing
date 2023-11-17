<?php
include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}
;

if (isset($_POST['update_profile'])) {
    // Kiểm tra các trường không được để trống
    if (empty($_POST['name']) || empty($_POST['sex']) || empty($_POST['born']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address'])) {
        $message[] = 'All fields are required.';
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $sex = $_POST['sex'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $born = $_POST['born'];

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'admin/uploaded_img/user/' . $image;
        $old_image = $_POST['old_image'];

        $update_profile = $pdo->prepare("UPDATE user SET name = ?, sex = ?, email = ?, phone = ?, address = ?, born = ? WHERE id = ?");
        $update_success = $update_profile->execute([$name, $sex, $email, $phone, $address, $born, $user_id]);

        $message[] = 'updated successfully!';

        if (!empty($image)) {
            if ($image_size > 2000000) {
                $message[] = 'image size is too large!';
            } else {
                $update_image = $pdo->prepare("UPDATE `user` SET image = ? WHERE id = ?");
                $update_image->execute([$image, $id]);

                if ($update_image) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    unlink('admin/uploaded_img/user/' . $old_image);
                    // $message[] = 'image updated successfully!';
                }
            }
        }
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
        <div class="card mt-5 mb-5">
            <form action="user_edit_account.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input class="form-control w-100" type="hidden" name="old_image"
                        value="<?= htmlspecialchars($fetch_profile['image']); ?>">
                </div>

                <div class="form-group">
                    <input class="form-control" type="hidden" name="id"
                        value="<?= htmlspecialchars($fetch_profile['id']); ?>">
                </div>
                <div class="card-body row">
                    <div class="col-md-3 col-12">Profile photo </div>
                    <div class="col-md-8 col-10">
                        <div class="col-md-8 col-10">
                            <?php
                            if ((htmlspecialchars($fetch_profile['image'])) != '') { ?>
                                <img src="admin/uploaded_img/user/<?= htmlspecialchars($fetch_profile['image']); ?>"
                                    width="70">
                                <?php
                            } else {
                                echo htmlspecialchars('<img src="img/account/user0.png" width="70">');
                            }
                            ;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-md-3 col-12">Update profile photo</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="file" name="image"
                            value="<?= htmlspecialchars($fetch_profile['image']); ?>"
                            accept="image/jpg, image/jpeg, image/png" placeholder="update image" width="70">
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-md-3 col-12">Name</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="text" name="name"
                            value="<?= htmlspecialchars($fetch_profile['name']); ?>" placeholder="update username">
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-md-3 col-12">Sex</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="text" name="sex" value="<?php
                        // Lấy giá trị sex từ $fetch_profile
                        $sex = htmlspecialchars($fetch_profile['sex']);

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
                        ?>" placeholder="update my sex">
                    </div>

                </div>
                <div class="card-body row">
                    <div class="col-md-3 col-12">Birthday</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="text" name="born"
                            value="<?= htmlspecialchars($fetch_profile['born']); ?>" placeholder="update my birthday">
                    </div>
                </div>

                <div class="card-body row">
                    <div class="col-md-3 col-12">Email</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="text" name="email"
                            value="<?= htmlspecialchars($fetch_profile['email']); ?>" placeholder="update my email">
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-md-3 col-12">Phone</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="text" name="phone"
                            value="<?= htmlspecialchars($fetch_profile['phone']); ?>" placeholder="update my phone">
                    </div>
                </div>

                <div class="card-body row">
                    <div class="col-md-3 col-12">Address</div>
                    <div class="col-md-8 col-10">
                        <input class="form-control" type="text" name="address"
                            value="<?= htmlspecialchars($fetch_profile['address']); ?>" placeholder="update address">
                    </div>
                </div>
                <div class="p-3">
                    <input type="submit" class="btn w-100" value="Update" name="update_profile">
                </div>
                <div class="px-3 pb-3">
                    <a class="btn w-100" href="user_account.php">View Profile</a>
                </div>
            </form>    
        </div>
    </div>
    
</section>

<?php
include_once __DIR__ . '../../partials/footer.php';