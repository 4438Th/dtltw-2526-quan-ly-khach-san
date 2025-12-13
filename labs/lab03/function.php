<?php
function BCC(
    $n,
    $colorHead = "red",
    $color1 = "yellow",
    $color2 = "green"
) {
    $result = '';
    $result .= '<table>';
    $result .=  '<tr style="background-color: ' . $colorHead . ';">
                    <td colspan="3">Bảng cửu chương ' . $n . '</td>
                </tr>';

    for ($i = 1; $i <= 10; $i++) {
        $result .= '
            <tr style="background-color: ' . (($i % 2 != 0) ? $color1 : $color2) . ';">
                <td>' . $n . '</td>
                <td>' . $i . '</td>
                <td>' . $n * $i . '</td>
            </tr>';
    }
    $result .= '</table>';
    return $result;
}
function BanCo($size = 8)
{
    $result = '';
    $result .= '<div id="banco">';
    for ($i = 1; $i <= $size; $i++) {
        for ($j = 1; $j <= $size; $j++) {
            $classCss = ((($i + $j) % 2) == 0 ? 'cellWhite' : 'cellBlack');
            $result .= '<div class="' . $classCss . '">' . ($i - $j) . '</div>';
        }
        $result .= '<div class="clear"/>';
    }
    return $result;
}
