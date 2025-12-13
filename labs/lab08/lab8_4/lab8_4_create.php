<?php
// Nạp các file cấu hình và hàm cần thiết cho ứng dụng
include "config/config.php";              // File cấu hình (ví dụ: thông tin kết nối CSDL)
include ROOT . "/include/function.php";   // File chứa các hàm tiện ích dùng chung

// Đăng ký hàm tự động nạp class (autoload)
// Khi khởi tạo một đối tượng, PHP sẽ tự động tìm và load file class tương ứng
spl_autoload_register("loadClass");

$book = new Book();
if (isset($_POST["sm"])) { // kiểm tra nếu người dùng bấm nút Inserts 
    $n = $book->create($_POST["book_id"], $_POST["book_name"]); // số dòng bị ảnh hưởngs
    // Thông báo kết quả
    if ($n > 0) $thongbao = "Đã thêm $n loại ";
    else $thongbao = "Lỗi thêm ";
}
?>
<script language="javascript">
    // Hiển thị thông báo bằng hộp thoại alert
    alert("<?php echo $thongbao; ?>");
    // Sau khi bấm OK, chuyển hướng về trang danh sách loại sách
    window.location = "index.php";
</script>