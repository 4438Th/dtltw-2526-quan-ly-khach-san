<?php
$a = array();
$r = array("id" => "sp1", "name " => "Sản phẩm 1 ");
$a[] = $r;
$r = array("id" => "sp2", "name " => "Sản phẩm 2 ");
$a[] = $r;
$r = array("id" => "sp3", "name " => "Sản phẩm 3 ");
$a[] = $r;
function showArray($arr)
{
    echo "<table border=1>";
    echo "<tr><td>STT</td><td>Mã sản phẩm</td><td>Tên sản phẩm</td></tr>";
    $i = 1;
    foreach ($arr as $k => $v) {
        echo "<td>$i</td>";
        foreach ($v as $k1 => $v1) {
            echo "<td>$v1</td>";
        }
        $i++;
        echo "</tr>";
    }
    echo "</table>";
}
showArray($a);
