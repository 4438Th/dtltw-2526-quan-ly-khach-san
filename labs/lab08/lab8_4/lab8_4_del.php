<?php
// Nạp các file cấu hình và hàm cần thiết cho ứng dụng
include "config/config.php";              // File cấu hình (ví dụ: thông tin kết nối CSDL)
include ROOT . "/include/function.php";   // File chứa các hàm tiện ích dùng chung

// Đăng ký hàm tự động nạp class (autoload)
// Khi khởi tạo một đối tượng, PHP sẽ tự động tìm và load file class tương ứng
spl_autoload_register("loadClass");

$book = new Book();
$book_id = isset($_GET["book_id"]) ? $_GET["book_id"] : ""; 
$n=$book->deleteById($book_id);
// ------------------- THÔNG BÁO KẾT QUẢ -------------------
if ($n > 0) 
    $thongbao = "Đã xóa $n loại sách!"; // Nếu có dòng bị xóa
else 
    $thongbao = "Lỗi xóa!";             // Nếu không có dòng nào bị xóa
?>
<script language="javascript">
    // Hiển thị thông báo bằng hộp thoại alert
    alert("<?php echo $thongbao; ?>");
    // Sau khi bấm OK, chuyển hướng về trang danh sách loại sách
    window.location = "index.php";
</script>