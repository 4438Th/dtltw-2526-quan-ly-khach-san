<?php
function postIndex($index, $value = "")
{
    if (!isset($_POST[$index]))    return $value;
    return $_POST[$index];
}
function showImage()
{
    echo "<br>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];

        $upload_dir = './';

        $destination = $upload_dir . $file_name;

        // Di chuyển file
        if (move_uploaded_file($file_tmp, $destination)) {
            echo '<p style="color: blue">Upload thành công! Tên mới: ' . $file_name . '</p>';
            echo '<br><image src="' . $destination . '" alt="Uploaded Image" style="max-width:300px;">';
        } else {
            echo '<p style="color: red">Lỗi lưu file!</p>';
        }
    }
}
$username = postIndex("username");
$password = postIndex("password");
$confirm_password = postIndex("confirm_password");
$gender = postIndex("gender");
$hobbies = postIndex("hobbies");
$province = postIndex("province");

echo "Tên đăng nhập: " . $username . "<br>";
echo "Mật khẩu: " . $password . "<br>";
echo "Nhập lại mật khẩu: " . $confirm_password . "<br>";
echo "Giới tính: " . $gender . "<br>";
echo "Sở thích: " . $hobbies . "<br>";
echo "Hình ảnh:" . "<br>";
showImage();
echo "<br>Tỉnh: " . $province . "<br>";
