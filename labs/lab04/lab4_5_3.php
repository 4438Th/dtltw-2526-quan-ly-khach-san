<?php
$ds_cauhoi = array();
$ch_1 = array("ch" => "1+1=?", "da" => 2);
$ch_2 = array("ch" => "1+2=?", "da" => 3);
$ch_3 = array("ch" => "1+3=?", "da" => 4);
$ch_4 = array("ch" => "1+4=?", "da" => 5);
$ds_cauhoi[] = $ch_1;
$ds_cauhoi[] = $ch_2;
$ds_cauhoi[] = $ch_3;
$ds_cauhoi[] = $ch_4;
function showArray($arr)
{
    echo "Siêu trí tuệ!<br>";

}
showArray($ds_cauhoi);
