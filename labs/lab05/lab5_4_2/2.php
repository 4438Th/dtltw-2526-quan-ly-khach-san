<?php
function postIndex($index, $value = "")
{
    if (!isset($_POST[$index]))    return $value;
    return $_POST[$index];
}
$ten= postIndex("tenSp");
$cachTim= postIndex("cachTim");
$loai=postIndex("loai");
echo "Tên sản phẩm: ". $ten ."<br>";
echo "Cách tìm: ". $cachTim ."<br>";
echo "Loại sản phẩm: ". $loai ."<br>";
?>