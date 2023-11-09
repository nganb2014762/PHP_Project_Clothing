<?php

include_once __DIR__ . '../../../partials/boostrap.php';

include_once __DIR__ . '../../../partials/admin_header.php';

require_once __DIR__ . '../../../partials/connect.php';


?>

<section class="my-5 py-5">
    <div class="container title text-center mt-3 pt-5">
        <h2 class="position-relative d-inline-block">My Account</h2>
        <hr class="mx-auto">
    </div>
    
    <div class="mx-auto container mt-3">
        <div class="card mt-5 mb-5 m-auto">
            <div class="card-body fs-4 fw-semibold">
                Basic information
                <hr>
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Profile photo</div>
                <div class="col-md-8 col-10">Your profile photo helps others recognize you</div>
                <div class="col-md-1 col-2"><img class="float-end" src="../img/account/user.jpg" width="70"></div>
                <!-- <hr class="mt-2"> -->
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Name</div>
                <div class="col-md-8 col-10">Nguyen Van A</div>
                <div class="col-md-1 col-2"><i class="fa-solid fa-chevron-right float-end"></i></div>
                <!-- <hr class="mt-2"> -->
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Sex</div>
                <div class="col-md-8 col-10">Male</div>
                <div class="col-md-1 col-2"><i class="fa-solid fa-chevron-right float-end"></i></div>
            </div>
        </div>

        <div class="card mt-5 mb-5 m-auto">
            <div class="card-body fs-4 fw-semibold">
                Contact Info
                <hr>
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Email</div>
                <div class="col-md-8 col-10">A@gmail.com</div>
                <div class="col-md-1 col-2"><i class="fa-solid fa-chevron-right float-end"></i></div>
                <!-- <hr class="mt-2"> -->
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Phone</div>
                <div class="col-md-8 col-10">0944990152</div>
                <div class="col-md-1 col-2"><i class="fa-solid fa-chevron-right float-end"></i></div>
                <!-- <hr class="mt-2"> -->
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Identification card</div>
                <div class="col-md-8 col-10">0123456789</div>
                <div class="col-md-1 col-2"><i class="fa-solid fa-chevron-right float-end"></i></div>
            </div>
        </div>

        <div class="card mt-5 mb-5 m-auto">
            <div class="card-body fs-4 fw-semibold">
                Address
                <hr>
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Home</div>
                <div class="col-md-8 col-10">102 ................</div>
                <div class="col-md-1 col-2"><i class="fa-solid fa-chevron-right float-end"></i></div>
                <!-- <hr class="mt-2"> -->
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Workplace</div>
                <div class="col-md-8 col-10">ĐHCT ..................</div>
                <div class="col-md-1 col-2"><i class="fa-solid fa-chevron-right float-end"></i></div>
                <!-- <hr class="mt-2"> -->
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12">Other address</div>
                <div class="col-md-8 col-10">137/ ..........................</div>
                <div class="col-md-1 col-2"><i class="fa-solid fa-chevron-right float-end"></i></div>
            </div>
        </div>
    </div>
</section>

<?php
include_once __DIR__ . '../../../partials/admin_footer.php';