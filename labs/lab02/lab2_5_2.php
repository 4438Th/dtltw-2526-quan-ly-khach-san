<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>lab 2_5</title>
</head>

<body>
    <?php
    $a = 5.0;
    echo "biến a = " . $a . "<br/>";
    if (is_int($a))
        echo "biến a là số nguyên" . "<br/>";
    else if (is_float($a))
        echo "biến a là số thực" . "<br/>";
    ?>
</body>

</html>