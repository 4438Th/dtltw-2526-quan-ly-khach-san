<?php
function kt_DoiXung($str)
{
    return strcmp($str, strrev($str));
}
if (kt_DoiXung('abba')==0) echo 'ok';
else echo "no";
