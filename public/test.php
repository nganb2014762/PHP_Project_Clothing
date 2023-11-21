
<?php
// Trong phần xử lý khi người dùng gửi đánh giá
if (isset($_POST['send'])) {
   if (isset($_SESSION['user_id'])) {
      // Lấy thông tin người dùng đăng nhập
      $user_id = $_SESSION['user_id'];

      // Lấy thông tin về đánh giá từ form
      $comment = $_POST['comment'];

      // Lấy ID của sản phẩm mà người dùng đang xem
      $pid = $_GET['pid']; // Chú ý rằng cần kiểm tra và xử lý dữ liệu này để tránh tấn công SQL Injection

      if (isset($_GET['pid'])) {
         $pid = $_GET['pid']; // Gán giá trị từ URL vào biến $pid
         try {
            // Kiểm tra xem người dùng đã tải lên hình ảnh hay chưa
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
               $image_name = $_FILES['image']['name'];
               $temp_image_path = $_FILES['image']['tmp_name'];
               $uploads_directory = 'upload_directory/';

               // Di chuyển hình ảnh tải lên vào thư mục lưu trữ
               move_uploaded_file($temp_image_path, $uploads_directory . $image_name);

               // Thêm đánh giá vào cơ sở dữ liệu với hình ảnh
               $insert_comment = $pdo->prepare("INSERT INTO `reviews` (user_id, pid, comment, image) VALUES (?, ?, ?, ?)");
               $insert_comment->execute([$user_id, $pid, $comment, $image_name]);
            } else {
               // Người dùng không tải lên hình ảnh, thêm đánh giá với image=NULL hoặc giá trị mặc định
               $insert_comment = $pdo->prepare("INSERT INTO `reviews` (user_id, pid, comment, image) VALUES (?, ?, ?, NULL)");
               $insert_comment->execute([$user_id, $pid, $comment]);
            }

            // Đánh dấu thông báo bình luận đã được thêm thành công
            header('Location:view_page.php?pid=' . $pid);
            exit();
         } catch (PDOException $e) {
            // Xử lý lỗi nếu có ngoại lệ xảy ra trong quá trình thêm vào cơ sở dữ liệu
            $message[] = "Lỗi khi thực hiện truy vấn: " . $e->getMessage();
         }
      } else {
         // Xử lý khi không tìm thấy giá trị pid trong URL
         $message[] = "Không tìm thấy sản phẩm!";
      }
   } else {
      // Nếu người dùng chưa đăng nhập, hiển thị thông báo
      $_SESSION['comment'] = 'Bạn cần đăng nhập để đánh giá sản phẩm.';
   }
}
;
?>