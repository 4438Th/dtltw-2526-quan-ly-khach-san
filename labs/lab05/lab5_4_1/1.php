<?php
$arr = array();
$r = array("id" => 1, "name" => "Product1");
$arr[] = $r;
$r = array("id" => 2, "name" => "Product2");
$arr[] = $r;
$r = array("id" => 3, "name" => "Product3");
$arr[] = $r;
$r = array("id" => 4, "name" => "Product4");
$arr[] = $r;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab6_4_1</title>
</head>

<body>
    <?php
    foreach($arr as $k=>$v){
        echo "<a href="."2.php?id=".$arr[$k]['id'].">".$arr[$k]['name']."</a><br>";
    }
    ?>
</body>

</html>