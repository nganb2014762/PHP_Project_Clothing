<?php

include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';

$message = [];

if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="alert alert-warning alert-dismissible fade show col-4 offset-4" role="alert" tabindex="-1">
                ' . htmlspecialchars($message) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}
;
?>

<title>My Account</title>
</head>

<section class="my-5 py-5">
    <div class="container title text-center mt-3 pt-5">
        <h2 class="position-relative d-inline-block">My Account</h2>
        <hr class="mx-auto">

    </div>
    <div class="mx-auto container my-5">
        <div class="card col-md-10 offset-1 shadow-sm rounded-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <input class="form-control" type="hidden" name="id"
                                value="<?= htmlspecialchars($fetch_profile['id']); ?>">
                        </div>

                        <div class="form-group text-center">
                            <?php if ($fetch_profile['image'] == '') {
                                echo '<img class="img-fluid" src="../img/account/user0.png" alt="" width="315px" height="315px" />';
                            } else {
                                ?>
                                <img class="img-fluid"
                                    src="admin/uploaded_img/user/<?= htmlspecialchars($fetch_profile['image']); ?>" alt=""
                                    width="315px" height="315px" />
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-md-7 mt-3">
                        <div class="form-group d-flex p-2">
                            <div class="col-md-3 col-12 p-2 fw-bold">Name</div>
                            <div class="col-md-9 col-10">
                                <input type="text" class="form-control" name="name" disabled
                                    value="<?= htmlspecialchars($fetch_profile['name']); ?>">
                            </div>
                        </div>
                        <div class="form-group d-flex p-2">
                            <div class="col-md-3 col-12 p-2 fw-bold">Sex</div>
                            <div class="col-md-9 col-10">
                                <input type="text" class="form-control" name="sex" disabled
                                    value="<?= htmlspecialchars($fetch_profile['sex']) == '0' ? 'Female' : 'Male' ?>">
                            </div>
                        </div>
                        <div class="form-group d-flex p-2">
                            <div class="col-md-3 col-12 p-2 fw-bold">Born</div>
                            <div class="col-md-9 col-10">
                                <input class="form-control" type="text" name="born" disabled
                                    value="<?= htmlspecialchars($fetch_profile['born']); ?>">
                            </div>
                        </div>
                        <div class="form-group d-flex p-2">
                            <div class="col-md-3 col-12 p-2 fw-bold">Address</div>
                            <div class="col-md-9 col-10">
                                <textarea class="form-control" name="address" disabled cols="30"
                                    rows="1"><?= htmlspecialchars($fetch_profile['address']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group d-flex p-2">
                            <div class="col-md-3 col-12 p-2 fw-bold">Phone</div>
                            <div class="col-md-9 col-10">
                                <input class="form-control" type="tel" name="phone" disabled
                                    value="<?= htmlspecialchars($fetch_profile['phone']); ?>">
                            </div>
                        </div>
                        <div class="form-group d-flex p-2">
                            <div class="col-md-3 col-12 p-2 fw-bold">Email</div>
                            <div class="col-md-9 col-10">
                                <input class="form-control" type="email" name="email" disabled
                                    value="<?= htmlspecialchars($fetch_profile['email']); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group p-2">
                        <div class="flex-btn">
                            <a href="edit_profile.php" class="btn btn-primary shadow-sm w-100">Change Information</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="card mt-5 mb-5 w-50">
            <div class="card-body row">
                <div class="col-md-3 col-12">Profile photo</div>
                <div class="col-md-8 col-10">
                    <?php
                    if ((htmlspecialchars($fetch_profile['image'])) != '') { ?>
                        <img src="admin/uploaded_img/user/<?= htmlspecialchars($fetch_profile['image']); ?>" width="70">
                        <?php
                    } else {
                        echo htmlspecialchars('<img src="img/account/user0.png" width="70">');
                    }
                    ;
                    ?>
                </div>
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Name</div>
                <div class="col-md-8 col-10">
                    <?= htmlspecialchars($fetch_profile['name']); ?>
                </div>
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
            <div class="p-3">
                <a href="user_edit_account.php" class="btn btn-primary w-100">Change Information</a>

            </div>
        </div>


    </div>
</section>



<?php
include_once __DIR__ . '/../partials/footer.php';