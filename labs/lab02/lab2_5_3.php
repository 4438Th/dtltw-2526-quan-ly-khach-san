<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>lab 2_5</title>
</head>

<body>
    <?php
    $a = 5;
    $b = 6;
    $c = 1;
    $delta = pow($b, 2) - (4 * $a * $c);
    echo "biến a = " . $a . "<br/>";
    echo "biến b = " . $b . "<br/>";
    echo "biến c = " . $c . "<br/>";
    echo "delta = " . $delta . "<br/>";
    if ($delta < 0)
        echo "phương trình vô nghiệm" . "<br/>";
    else if ($delta == 0)
        echo "phương trình có nghiệm kép x1 = x2 = " . - ($b / 2 * $a) . "<br/>";
    else {
        echo "phương trình có 2 nghiệm" . "<br/>";
        echo "x1 = " . (-$b - sqrt($delta)) / (2 * $a) . "<br/>";
        echo "x2 = " . (-$b + sqrt($delta)) / (2 * $a) . "<br/>";
    }
    ?>
</body>

</html>