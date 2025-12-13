<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab5_4_2</title>
</head>
<body>
    <form action="2.php" method="POST">    
    <label for="tenSp">Tên sản phẩm:</label><br>
    <input type="text" name="tenSp"><br>
        <input type="radio" name="cachTim" value="Chính xác" checked="checked"> Chính xác <br>
        <input type="radio" name="cachTim" value="Gần đúng"> Gần đúng <br>
        <select name="loai" id="dsLoai">
            <option value="all">Tất cả</option>
            <option value="1">Loại 1</option>
            <option value="2">Loại 2</option>
            <option value="3">Loại 3</option>
        </select>
        <button type="submit">Tìm</button>
    </form>
</body>
</html>