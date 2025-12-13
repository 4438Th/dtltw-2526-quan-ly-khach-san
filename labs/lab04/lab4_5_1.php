<!-- <br />Hiển thị nội dung mảng b ra dạng bảng:
<table border=1>
	<tr><td>STT</td><td>Key</td><td>Value</td></tr>
    <?php
    $i = 0;
    foreach ($b as $k => $v) {
        $i++;
        echo "<tr><td>$i</td>";
        echo "<td>$k</td>";
        echo "<td>$v</td></tr>";
    }
    ?>
</table> -->
<?php
$a = array(1, -3, 5);
function showArray($arr)
{
    echo "<table border=1>";
    echo "<tr><td>Key</td><td>Value</td></tr>";
    foreach ($arr as $k => $v) {
        echo "<td>$k</td>";
        echo "<td>$v</td></tr>";
    }
}
showArray($a);
