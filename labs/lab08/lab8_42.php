<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Lab8_42 - PDO - MySQL - select - insert - parameter</title>
</head>

<body>
    <form id="form_timKiem" action="lab8_42.php" method="$_GET">
        <tr>
            <td><label for="book_name">Tên sách: </label></td>
            <td><input type="text" name="book_name"></td>
        </tr>
    </form>
    <button type="submit">Tìm</button>
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
    // ------------------- LẤY DỮ LIỆU TỪ REQUEST -------------------s
    function postIndex($index, $value = "")
    {
        if (!isset($_GET[$index]))    return $value;
        return trim($_GET[$index]);
    }
    // ------------------- TRUY VẤN SELECT -------------------
    $search = postIndex("book_name"); // từ khóa tìm kiếm
    $sql = "select * from publisher where pub_name like :ten"; // câu lệnh SQL có tham số
    $stm = $pdh->prepare($sql); // chuẩn bị câu lệnh
    $stm->bindValue(":ten", "%$search%"); // gán giá trị cho tham số :ten
    $stm->execute(); // thực thi câu lệnh
    $rows = $stm->fetchAll(PDO::FETCH_ASSOC); // lấy tất cả kết quả dưới dạng mảng kết hợp

    // In kết quả ra màn hình
    echo "<pre>";
    print_r($rows); // hiển thị mảng kết quả
    echo "</pre>";
    echo "<hr>";
    ?>
</body>

</html>