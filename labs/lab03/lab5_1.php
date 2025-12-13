<?php

function kiemtranguyento($x)
{
    if ($x < 2)
        return false;
    if ($x == 2)
        return true;
    for ($i = 2; $i <= sqrt($x); $i++)
        if ($x % $i == 0)
            return false;
    return true;
}
function xuat_N_NT($n)
{
    $count = 0;
    $num = 2;
    while ($count != $n) {
        if (kiemtranguyento($num)) {
            echo $num . '<br/>';
            $count++;
        }
        $num++;
    }
}
xuat_N_NT(5);
