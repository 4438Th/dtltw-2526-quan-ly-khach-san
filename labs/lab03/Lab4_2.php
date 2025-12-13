<?php
$n = 0;
$s = 0;
while ($s < 1000) {
    $n++;
    $s += $n;
}
echo $n . "<br/>";
echo $s . "<br/>";

$n1 = 0;
$s1 = 0;
do {
    $n1++;
    $s1 += $n1;
} while ($s1 < 1000);
echo $n1 . "<br/>";
echo $s1 . "<br/>";
