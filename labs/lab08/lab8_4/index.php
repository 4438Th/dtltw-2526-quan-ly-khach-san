<?php
// Nạp các file cấu hình và hàm cần thiết cho ứng dụng
include "config/config.php";              // File cấu hình (ví dụ: thông tin kết nối CSDL)
include ROOT . "/include/function.php";   // File chứa các hàm tiện ích dùng chung

// Đăng ký hàm tự động nạp class (autoload)
// Khi khởi tạo một đối tượng, PHP sẽ tự động tìm và load file class tương ứng
spl_autoload_register("loadClass");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Database!</title>
    <style>
        /* CSS định dạng cho khối hiển thị sách */
        .book {
            width: 250px;
            height: 300px;
            margin: 3px;
            background: #FCC; 
            float: left;    
        }

        /* CSS cho hình ảnh bên trong khối sách */
        div.book img {
            height: 200px;
            margin: 0 10px;
        }
    </style>
</head>

<body>
    <!-- Form nhập dữ liệu loại sách -->
    <form action="lab8_4_create.php" method="post">
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
    // Tạo đối tượng kết nối CSDL (class Db sẽ được tự động load từ file Db.class.php)
    $obj = new Db();

    // Thực hiện truy vấn lấy tất cả các dòng trong bảng category
    $rows = $obj->select("select * from category ");

    // Duyệt qua từng dòng kết quả và in ra ID + tên danh mục
    foreach ($rows as $row) {
        echo "<br>" . $row["cat_id"] . "-" . $row["cat_name"];
    }
    echo "<hr>"; 


    //---------------- BOOK ---------------
    // Tạo đối tượng Book (class Book sẽ được load từ file Book.class.php)
    $book = new Book();

    // Lấy tất cả từ CSDL
    $rows = $book->getAll();

    // Duyệt qua từng quyển sách và hiển thị thông tin
    // Hiển thị danh sách
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
                <a href='lab8_4_del.php?book_id=" . $row["book_id"] . "'>Xóa</a>
                </td>
            </tr>";
    }
    echo "
        </tbody>
    </table>
    ";
    ?>
</body>

</html>
