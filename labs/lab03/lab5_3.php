<?php
function tongChuSoTrongChuoi($str)
{
    $sum = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        if (is_numeric($str[$i])) {
            echo $str[$i] . ' la so <br/>';
            $sum += $str[$i];
        }
    }
    return $sum;
}
$str = 'ngay29thang10nam2025';
echo 'chuoi = ' . $str . '<br/>';
echo 'tong = ' . tongChuSoTrongChuoi($str);
