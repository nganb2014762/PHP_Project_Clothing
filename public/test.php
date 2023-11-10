<?php

include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';


// $user_id = $_SESSION['user_id'];

// if (!isset($user_id)) {
//    header('location:login.php');
// };


if (isset($_POST['add_to_wishlist'])) {
	$pid = $_POST['pid'];
	$pid = filter_var($pid, FILTER_SANITIZE_STRING);
	$p_name = $_POST['p_name'];
	$p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
	$p_price = $_POST['p_price'];
	$p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
	$p_image = $_POST['p_image'];
	$p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

	$check_wishlist_numbers = $pdo->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
	$check_wishlist_numbers->execute([$p_name, $user_id]);

	$check_cart_numbers = $pdo->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
	$check_cart_numbers->execute([$p_name, $user_id]);

	if ($check_wishlist_numbers->rowCount() > 0) {
		$message[] = 'already added to wishlist!';
	} elseif ($check_cart_numbers->rowCount() > 0) {
		$message[] = 'already added to cart!';
	} else {
		$insert_wishlist = $pdo->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
		$insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
		$message[] = 'added to wishlist!';
	}
}

if (isset($_POST['add_to_cart'])) {
	$pid = $_POST['pid'];
	$pid = filter_var($pid, FILTER_SANITIZE_STRING);
	$p_name = $_POST['p_name'];
	$p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
	$p_price = $_POST['p_price'];
	$p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
	$p_image = $_POST['p_image'];
	$p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
	$p_qty = $_POST['p_qty'];
	$p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

	$check_cart_numbers = $pdo->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
	$check_cart_numbers->execute([$p_name, $user_id]);

	if ($check_cart_numbers->rowCount() > 0) {
		// Sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
		$update_qty = $pdo->prepare("UPDATE `cart` SET quantity = quantity + ? WHERE name = ? AND user_id = ?");
		$update_qty->execute([$p_qty, $p_name, $user_id]);
		$message[] = 'Quantity updated in cart!';
	} else {
		// Sản phẩm chưa có trong giỏ hàng, thêm mới
		$insert_cart = $pdo->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
		$insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
		$message[] = 'added to cart!';
	}
}


?>

<title>Details Product</title>
<style>
	/* .main_image {
		display: flex;
		justify-content: center;
		align-items: center;
		height: 300px;
		width: 100%;
		overflow: hidden;
	} */

	/* .heart {
		height: 29px;
		width: 29px;
		display: flex;
		justify-content: center;
		align-items: center
	} */
</style>
</head>

<body>
	
	<section class="bg-light mt-5 pt-5">
		<div class="container pb-5">
			<div class="row">
				<div class="col-lg-4 mt-5">
					<div class="card mb-3">
						<img class="card-img img-fluid" src="img/shop/dress/1.jpg" alt="Card image cap"
							id="product-detail">
					</div>
					<div class="row">
						<!--Start Controls-->
						<div class="col-1 align-self-center">
							<a href="#multi-item-example" role="button" data-bs-slide="prev">
								<i class="text-dark fas fa-chevron-left"></i>
								<span class="sr-only">Previous</span>
							</a>
						</div>
						<!--End Controls-->
						<!--Start Carousel Wrapper-->
						<div id="multi-item-example" class="col-10 carousel slide carousel-multi-item pointer-event"
							data-bs-ride="carousel">
							<!--Start Slides-->
							<div class="carousel-inner product-links-wap" role="listbox">

								<!--First slide-->
								<div class="carousel-item active">
									<div class="row">
										<div class="col-4">
											<a href="#">
												<img class="card-img img-fluid" src="img/shop/dress/1.jpg"
													alt="Product Image 1">
											</a>
										</div>
										<div class="col-4">
											<a href="#">
												<img class="card-img img-fluid" src="img/shop/dress/1.jpg"
													alt="Product Image 2">
											</a>
										</div>
										<div class="col-4">
											<a href="#">
												<img class="card-img img-fluid" src="img/shop/dress/1.jpg"
													alt="Product Image 3">
											</a>
										</div>
									</div>
								</div>
								<!--/.First slide-->

								<!--Second slide-->
								<div class="carousel-item">
									<div class="row">
										<div class="col-4">
											<a href="#">
												<img class="card-img img-fluid" src="img/shop/dress/1.jpg"
													alt="Product Image 4">
											</a>
										</div>
										<div class="col-4">
											<a href="#">
												<img class="card-img img-fluid" src="img/shop/dress/1.jpg"
													alt="Product Image 5">
											</a>
										</div>
										<div class="col-4">
											<a href="#">
												<img class="card-img img-fluid" src="img/shop/dress/1.jpg"
													alt="Product Image 6">
											</a>
										</div>
									</div>
								</div>
								<!--/.Second slide-->
							</div>
							<!--End Slides-->
						</div>
						<!--End Carousel Wrapper-->
						<!--Start Controls-->
						<div class="col-1 align-self-center">
							<a href="#multi-item-example" role="button" data-bs-slide="next">
								<i class="text-dark fas fa-chevron-right"></i>
								<span class="sr-only">Next</span>
							</a>
						</div>
						<!--End Controls-->
					</div>
				</div>
				<!-- col end -->
				<div class="col-lg-8 mt-5">
					<div class="card">
						<div class="card-body">
							<h1 class="h2">Active Wear</h1>
							<p class="h3 py-2">$25.00</p>
							<p class="py-2">
								<i class="fa fa-star text-warning"></i>
								<i class="fa fa-star text-warning"></i>
								<i class="fa fa-star text-warning"></i>
								<i class="fa fa-star text-warning"></i>
								<i class="fa fa-star text-secondary"></i>
								<span class="list-inline-item text-dark">Rating 4.8 | 36 Comments</span>
							</p>
							<ul class="list-inline">
								<li class="list-inline-item">
									<h6>Category:</h6>
								</li>
								<li class="list-inline-item">
									<p class="text-muted"><strong></strong></p>
								</li>
							</ul>
							<h6>Description:</h6>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temp incididunt
								ut labore et dolore magna aliqua. Quis ipsum suspendisse. Donec condimentum elementum
								convallis. Nunc sed orci a diam ultrices aliquet interdum quis nulla.</p>

							<h6>Specification:</h6>
							<ul class="list-unstyled pb-3">
								<li>Lorem ipsum dolor sit</li>
								<li>Amet, consectetur</li>
								<li>Adipiscing elit,set</li>
								<li>Duis aute irure</li>
								<li>Ut enim ad minim</li>
								<li>Dolore magna aliqua</li>
								<li>Excepteur sint</li>
							</ul>

							<form action="" method="GET">
								<input type="hidden" name="product-title" value="Activewear">
								<div class="row">
									<div class="col-auto">
										<ul class="list-inline pb-3">
											<li class="list-inline-item text-right">
												Quantity
												<input type="hidden" name="product-quanity" id="product-quanity"
													value="1">
											</li>
											<li class="list-inline-item"><span class="" id="btn-minus">-</span></li>
											<li class="list-inline-item"><span class="" id="var-value">1</span></li>
											<li class="list-inline-item"><span class="" id="btn-plus">+</span></li>
										</ul>
									</div>
								</div>

								<div class="row pb-3">
									<div class="col d-grid">
										<button type="submit" class="btn btn-success btn-lg" name="add_to_cart"
											value="add_to_cart">Add To Cart</button>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	include_once __DIR__ . '../../partials/footer.php';
