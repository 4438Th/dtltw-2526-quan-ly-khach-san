<?php
function postIndex($index, $value = "")
{
    if (!isset($_GET[$index]))    return $value;
    return $_GET[$index];
}
$id = postIndex("id");
echo "ID nhận được: " . $id;
?>