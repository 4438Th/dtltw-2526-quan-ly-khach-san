<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Quản lý loại sách</title>
    <style>
        /* Khung chứa nội dung chính */
        #container {
            width: 600px;
            margin: 0 auto;
            /* căn giữa trang */
        }
    </style>
</head>

<body>
    <div id="container">

        <!-- Form nhập dữ liệu loại sách -->
        <form action="lab8_43.php" method="post">
            <table>
                <tr>
                    <td>Mã sách:</td>
                    <td><input type="text" name="book_id" /></td>
                </tr>
                <tr>
                    <td>Tên sách:</td>
                    <td><input type="text" name="book_name" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="sm" value="Insert" />
                    </td>
                </tr>
            </table>
        </form>

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

        // ------------------- XỬ LÝ THÊM LOẠI SÁCH -------------------
        if (isset($_POST["sm"])) { // kiểm tra nếu người dùng bấm nút Insert
            // Câu lệnh SQL thêm loại sách mới với tham số
            $sql = "insert into book(book_id, book_name) values(:book_id, :book_name)";
            // Mảng ánh xạ tham số với dữ liệu nhập từ form
            $arr = array(":book_id" => $_POST["book_id"], ":book_name" => $_POST["book_name"]);
            // Chuẩn bị và thực thi câu lệnh
            $stm = $pdh->prepare($sql);
            $stm->execute($arr);
            $n = $stm->rowCount(); // số dòng bị ảnh hưởng

            // Thông báo kết quả
            if ($n > 0) echo "Đã thêm $n loại ";
            else echo "Lỗi thêm ";
        }
        // ------------------- LẤY DANH SÁCH LOẠI SÁCH -------------------
        $stm = $pdh->prepare("select * from book");
        $stm->execute();
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC); // lấy tất cả kết quả dưới dạng mảng kết hợp


        // Hiển thị danh sách loại sách
        echo "
        <table border=1>
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </thead>
            <tbody>";
        foreach ($rows as $row) {
            echo "
                <tr>
                    <td>
                        " . $row["book_id"] . "
                    </td>
                    <td>
                        " . $row["book_name"] . "
                    </td>
                    <td>
                    <a href='lab8_43_del.php?book_id=" . $row["book_id"] . "'>Xóa</a>
                    </td>
                </tr>";
        }
        echo "
            </tbody>
        </table>
        ";
        ?>