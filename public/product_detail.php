<body>
    <!-- header #2b80dd -->
    <?php include '../partials/heading.php' ?>
    <!-- end-header -->
    <!-- detail -->
    <?php
    include '../partials/connect.php';

    $product = null;
    $images = [];

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        // echo "ID của sản phẩm: " . $id;

        // Lấy thông tin sản phẩm từ ID
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch();

        if (!$product) {
            die("Sản phẩm không tồn tại.");
        }

        // Lấy danh sách hình ảnh từ ID sản phẩm
        $stmt_images = $pdo->prepare('SELECT * FROM product_images WHERE product_id = :product_id');
        $stmt_images->bindParam(':product_id', $id);
        $stmt_images->execute();
        $images = $stmt_images->fetchAll();

        if (!$images) {
            die("Không tìm thấy hình ảnh nào cho sản phẩm có ID đã cung cấp");
        }
    }

    // Đánh giá
    // Check if the form is submitted for review
    if (isset($_POST['evaluate'])) {
        // Check if the user is logged in
        if (isset($_SESSION['id'])) {
            $user_id = $_SESSION['id'];
            // echo $user_id;
            $message = $_POST['message'];
            // Insert the review into the message table
            $insert_message = $pdo->prepare("INSERT INTO `evaluate` ( user_id, message, product_id) VALUES (?, ?, ?)");
            $insert_message->execute([$user_id, $message, $id]);

            $_SESSION['message'] = 'Đánh giá thành công!';
        } else {
            echo "<script>alert('Bạn chưa đăng nhập!')</script>";
        }
    }

    // Hiển thị đánh giá
    $show_user = $pdo->prepare("SELECT * FROM `user` , `evaluate` WHERE user.id=evaluate.user_id AND evaluate.product_id = ?");
    $show_user->execute([$id]);

    $auth = false;
    if (isset($_SESSION['id'])) {
        $auth = true;
    }

    ?>

    <div class="container-fluid ">
        <div class="container">
            <div class="row mb-5">
                <div class="col-sm-6 ms-sm-auto">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                        <div class="carousel-inner">
                            <?php if ($images) {
                                foreach ($images as $image) { ?>
                                    <div class="carousel-item active">
                                        <?php echo "<img src='../admin/upload/product_detail/" . $image['images'] . "' alt='' class=' d-block w-100 mt-2'>"; ?>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <?php if ($product) {
                            echo "<h3 class='mt-2'>" . $product['name'] . "</h3>";
                        } ?>
                    </div>
                    <div class="row">
                        <?php
                        $current_price = $product['price'] - ($product['price'] * $product['discount'] / 100);
                        if ($product) {
                        ?>
                            <p id="product-price" class='fs-5 text-danger'> Giá: <?php echo number_format($current_price, 0, ',', '.') ?></p>
                            <!-- echo "<p class='fs-5 text-danger-emphasis'>Giá: " . $current_price . "</p>"; -->
                        <?php } ?>
                    </div>
                    <div class="row li-describe">
                        <h5>Mô tả chi tiết</h5>
                        <div>
                            <?php
                            $text = $product['describe'];
                            $specs = explode(" \ ", $text);
                            echo "<ul>";

                            foreach ($specs as $spec) {
                                echo "<li>{$spec}</li>";
                            }
                            echo "</ul>";
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            Chọn loại:
                            <select class="mx-3" onchange="updatePrice(this.value)">
                                <option value="1">8GB - 256GB</option>
                                <option value="2">16GB - 256GB</option>
                                <option value="3">16GB - 512GB</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4">
                        <div class="row">
                            <div class="col-lg-4 pb-3">
                                <a href="#" class="btn btn-warning w-100" id="addToCart" data-toggle="modal" data-target="#buyModal" onclick="addToCart()">
                                    Thêm vào giỏ
                                </a>
                            </div>
                            <div class="col-lg-4 pb-3">
                                <a href="/public/cart.php" class="btn btn-success w-100" onclick="addToCart()">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mô tả-->
            <div class="tablist mt-5">
                <div class="nav nav-tabs" role="tablist">
                    <a class="nav-item nav-link active col-sm-6 text-center text-black fs-4" id="tab1" data-toggle="tab" href="#content1" role="tab" aria-controls="content1" aria-selected="true">Mô tả</a>
                    <a class="nav-item nav-link col-sm-6 text-center text-black fs-4" id="tab2" data-toggle="tab" href="#content2" role="tab" aria-controls="content2" aria-selected="false">Đánh giá</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="content1" role="tabpanel" aria-labelledby="tab1">
                        <p>
                        <h4>Thiết kế</h4>
                        <figure class=" text-center">
                            <img alt='design' class='w-50' src='../admin/upload/product_detail/<?= $images[0]['images'] ?>' />
                            <figcaption class="figure-caption">Thiết kế của laptop</figcaption>
                        </figure>
                        <p>
                            Bộ vi xử lý Intel Core i5 11400H kết hợp cùng card đồ họa NVIDIA GeForce GTX 1650 Max-Q Design, 4 GB
                            cho phép bạn chiến các tựa game đình đám như Liên Minh Huyền Thoại, CS:GO, PUBG,... ở mức cấu hình
                            cao, đồng thời có khả năng xử lý đồ họa với hiệu suất cao
                        </p>
                        <p>
                            RAM 8 GB với khả năng nâng cấp lên đến tối đa 64 GB cho khả năng xử lý đa nhiệm tốt, chạy nhiều ứng
                            dụng cùng một lúc mà không gặp phải giật lag gây khó chịu. Ổ SSD 512 GB NVMe PCIe có thể lưu trữ
                            nhiều tệp tin lớn, cải thiện hiệu suất khi chơi game và xử lý đồ họa.
                        </p>
                        <p>
                            Màn hình 15.6 inch rộng rãi phù hợp để chơi game, làm việc văn phòng, tấm nền IPS hỗ trợ độ phân
                            giải Full HD có khả năng tái tạo hình ảnh với góc nhìn rộng, có độ chi tiết cao, mang đến cho bạn
                            trải nghiệm khung hình sắc nét và sống động hơn.
                        </p>
                        <p>
                            Màn hình 144 Hz của laptop MSI Gaming GF giúp giảm thiểu độ trễ hình ảnh và hạn chế tình trạng nhấp
                            nháy gây khó chịu, tăng trải nghiệm chơi game và xem video, mọi thao tác trong ứng dụng đều sẽ trở
                            nên trơn tru, mượt mà hơn bao giờ hết.
                        </p>
                        <h4>Cấu tạo</h4>
                        <figure class=" text-center">
                            <img alt='design' class='w-50' src='../admin/upload/product_detail/<?= $images[1]['images'] ?>' />
                            <figcaption class="figure-caption">Thiết kế của laptop</figcaption>
                        </figure>
                        <p>
                            Công nghệ âm thanh Realtek High Definition Audio cho phép người dùng tùy chỉnh âm lượng, cân bằng âm
                            để bạn có những giây phút giải trí tuyệt vời.
                        </p>
                        <p>
                            Laptop MSI sở hữu lớp vỏ ngoài được hoàn thiện từ chất liệu kim loại vừa đảm bảo độ bền bỉ vừa tạo
                            cảm giác sang trọng, khối lượng 1.86 kg không quá nặng đối với một chiếc laptop gaming.
                        </p>
                        <h4>Bàn phím</h4>
                        <figure class=" text-center">
                            <img alt='design' class='w-50' src='../admin/upload/product_detail/<?= $images[2]['images'] ?>' />
                            <figcaption class="figure-caption">Thiết kế của laptop</figcaption>
                        </figure>
                        <p>
                            Đèn bàn phím màu đỏ hỗ trợ bạn điều khiển nhân vật trong game dễ dàng hơn về đêm. Laptop còn được
                            trang bị nhiều cổng kết nối như: HDMI, USB 3.2, USB Type-C, LAN.
                        </p>
                        </p>
                    </div>

                    <!--  Đánh giá -->
                    <div class="tab-pane fade" id="content2" role="tabpanel" aria-labelledby="tab2">
                        <div class="row">
                            <form action="" method="POST">
                                <div class="col-sm-12 form-group my-2">
                                    <?php if (isset($_SESSION['message'])) :  ?>
                                        <div class="text-success mt-3">
                                            <?= $_SESSION['message'] ?>
                                        </div>
                                        <?php unset($_SESSION['message']) ?>
                                    <?php endif; ?>
                                    <label class="fs-4 my-3" for=""><b>Viết đánh giá</b></label>
                                    <textarea class="form-control" name="message" id="" rows="3" placeholder="Viết đánh giá tại đây..."></textarea>
                                    <button value="evaluate" name="evaluate" type="submit" class="btn btn-primary my-2">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">

                                <?php
                                if ($show_user->rowCount() > 0) {
                                    while ($fetch_user = $show_user->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <div class="card my-1">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-2 text-center">
                                                        <h6 class="text-center"><?= $fetch_user['name'] ?></h6>
                                                        <img src="../admin/upload/user_profile/<?= $fetch_user['image']  ?>" width="100px" height="100px" alt="">

                                                    </div>
                                                    <div class="col-sm-10">
                                                        <div class="card d-flex h-100">
                                                            <div class="card-body">
                                                                <?= $fetch_user['message'] ?>
                                                            </div>
                                                            <div class="d-flex justify-content-end m-4">
                                                                <i class="fa fa-thumbs-up fs-4 mx-2"></i>
                                                                <i class="fa fa-thumbs-down fs-4"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '<p class="empty">Chưa có đánh giá nào!</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Thêm nội dung cho các tab khác nếu cần -->
            </div>
        </div>
        <!--End Mô tả & Đánh giá  -->
    </div>
    </div>
    <!--End-detail -->
    <?php include  '../partials/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>

    <script>
        $(document).ready(function() {
            $('.nav-tabs a').click(function() {
                $(this).tab('show');
            });
        });
    </script>
    <script>
        var currentPrice = <?php echo $product['price']; ?>;
        var discount = <?php echo $product['discount']; ?>;
        var originalPrice = currentPrice; // Lưu giá gốc
        var price = currentPrice;

        function formatPrice(price) {
            var formattedPrice = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return formattedPrice.replace(/\.00/g, ''); // Loại bỏ 2 số 0 ở cuối
        }

        function updatePrice(selectedOption) {
            var updatedPrice = originalPrice; // Sử dụng giá gốc mặc định

            // Thay đổi giá dựa trên tùy chọn được chọn
            switch (selectedOption) {
                case "1":
                    updatedPrice = currentPrice - (currentPrice * discount / 100); //Giá mặc định
                    break;
                case "2":
                    updatedPrice = currentPrice - (currentPrice * (discount) / 100) + 1100000; // Áp dụng cho value =2
                    break;
                case "3":
                    updatedPrice = currentPrice - (currentPrice * (discount) / 100) + 1700000; //  Áp dụng cho value =2
                    break;
                default:
                    break;
            }


            // Cập nhật giá
            document.getElementById('product-price').innerHTML = 'Giá: ' + formatPrice(updatedPrice);
            price = updatedPrice;
        }

        var auth = `<?= $auth ?>`;
        addToCart = () => {
            if (auth) {
                var name = `<?= $_SESSION['id']; ?>`;
                const Items = {
                    "img": `<?= $images[0]['images']; ?>`,
                    "pid": `<?= $id; ?>`,
                    "price": price,
                    "quanlity": 1
                }

                var items_arr = [];
                var same = false;
                if (localStorage.getItem(name)) {
                    const pd = JSON.parse(localStorage.getItem(name));
                    if (pd.length > 0) {
                        pd.forEach(e => {
                            if (e.pid === Items.pid && e.price === Items.price) {
                                e.quanlity = parseInt(e.quanlity) + 1;
                                same = true;
                            }
                            items_arr.push(e);
                        });
                    }
                }

                if (!same) {
                    items_arr.push(Items);
                }
                Items_str = JSON.stringify(items_arr);
                localStorage.setItem(name, Items_str);
                // alert('Đã thêm vào giỏ hàng!');
                document.location.reload();
            } else {
                alert("Bạn chưa đăng nhập!");
            }
        }
    </script>

</body>