<?php
// ------------------- KẾT NỐI CSDL -------------------
require_once __DIR__ . '/../../init.php';
try {
    if (!defined('DB_HOST')) require_once CONFIGS_PATH . '/database.php';
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME_LAB08, DB_CHARSET);
    $pdh = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

// ------------------- LẤY MÃ LOẠI CẦN XÓA -------------------
$book_id = isset($_GET["book_id"]) ? $_GET["book_id"] : "";
// Lấy tham số 'book_id' từ URL, nếu không có thì gán rỗng

// ------------------- CÂU LỆNH SQL XÓA -------------------
$sql = "delete from book where book_id = :book_id";
// Câu lệnh SQL có tham số :book_id
$arr = array(":book_id" => $book_id);
// Mảng ánh xạ tham số với giá trị lấy từ URL

// ------------------- THỰC THI CÂU LỆNH -------------------
$stm = $pdh->prepare($sql); // Chuẩn bị câu lệnh
$stm->execute($arr);        // Thực thi với mảng tham số
$n = $stm->rowCount();      // Số dòng bị ảnh hưởng (số bản ghi xóa được)

// ------------------- THÔNG BÁO KẾT QUẢ -------------------
if ($n > 0)
    $thongbao = "Đã xóa $n quyển sách!"; // Nếu có dòng bị xóa
else
    $thongbao = "Không có dòng nào bị xóa!"; // Nếu không có dòng nào bị xóa
?>

<!-- ------------------- HIỂN THỊ THÔNG BÁO VÀ CHUYỂN TRANG ------------------- -->
<script language="javascript">
    // Hiển thị thông báo bằng hộp thoại alert
    alert("<?php echo $thongbao; ?>");
    // Sau khi bấm OK, chuyển hướng về trang danh sách loại sách
    window.location = "lab8_43.php";
</script>