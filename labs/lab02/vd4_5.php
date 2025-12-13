<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>lab 2_5</title>
</head>

<body>
	<?php
	include("lab2_5a.php");
	include("lab2_5b.php");
	echo "dòng 10 của đoạn mã dùng để chèn nội dung từ file lab2_5a.php vào, trong file có định nghĩa biến x = 10" . "<br/>";
	echo "khi thêm dòng lệnh 11 thì kết quả của x là 20, do trong file lab2_5b thực thi việc tăng giá trị của x thêm 10" . "<br/>";
	if (isset($x))
		echo "Giá trị của x là: $x";
	else
		echo "Biến x không tồn tại";
	?>
</body>

</html>