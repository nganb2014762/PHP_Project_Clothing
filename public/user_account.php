<?php

include_once __DIR__ . '/../partials/boostrap.php';

include_once __DIR__ . '/../partials/header.php';

require_once __DIR__ . '/../partials/connect.php';
$message = [];
if (isset($_POST['update_profile'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $sex = $_POST['sex'];
    $sex = filter_var($sex, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $phone = $_POST['phone'];
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);
    $address = $_POST['address'];
    $address = filter_var($born, FILTER_SANITIZE_STRING);
    $born = $_POST['address'];
    $born = filter_var($born, FILTER_SANITIZE_STRING);

    $update_profile = $pdo->prepare("UPDATE `user` SET name = ?, email = ? WHERE id = ?");
    $update_profile->execute([$name, $sex, $phone, $address, $born, $email, $user_id]);



}

?>
<section class="my-5 py-5">
    <div class="container title text-center mt-3 pt-5">
        <h2 class="position-relative d-inline-block">My Account</h2>
        <hr class="mx-auto">

    </div>

    <div class="d-flex justify-content-center  vh-100">
        <div class="card mt-5 mb-5 w-50">

            <div class="card-body row">
                <div class="col-md-3 col-12">Profile photo</div>
                <div class="col-md-8 col-10">Your profile photo helps others recognize you</div>
                <div class="col-md-1 col-2"><img class="float-end" src="../img/account/user.jpg" width="70"></div>
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
                    echo $sex_string;
                    ?>
                </div>

            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Birthday</div>
                <div class="col-md-8 col-10">
                    <?= $fetch_profile['born']; ?>

                </div>

                <!-- <hr class="mt-2"> -->
            </div>

            <div class="card-body row">
                <div class="col-md-3 col-12">Email</div>
                <div class="col-md-8 col-10">
                    <?= $fetch_profile['email']; ?>
                </div>

                <!-- <hr class="mt-2"> -->
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Phone</div>
                <div class="col-md-8 col-10">
                    <?= $fetch_profile['phone']; ?>
                </div>

                <!-- <hr class="mt-2"> -->
            </div>

            <div class="card-body row">
                <div class="col-md-3 col-12">Address</div>
                <div class="col-md-8 col-10">
                    <?= $fetch_profile['address']; ?>
                </div>

                <!-- <hr class="mt-2"> -->
            </div>

        </div>


    </div>

    </div>

    <div class="d-grid gap-2 col-3 mx-auto">
        <a href="user_edit_account.php" class="btn btn-primary">Change Information</a>
        
    </div>


    
</section>



<?php
include_once __DIR__ . '/../partials/footer.php';