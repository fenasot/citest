<?php
$sa = array(
    "s1", "s2", "s3", "s4", "s5", "s6", "s7", "s8", "s9",
);

for ($i = 0; $i < count($sa); $i++) {
    echo $sa[$i];
}

$sb[0] = 10;
$sb[1] = 20;
$sb[2] = 30;
$sb[3] = 40;
$sb[100] = 50;

$sd[] = 20;
$sc[][] = 30;
echo $sc[0];
echo $sd[0][0];
