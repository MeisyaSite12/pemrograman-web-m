<?php
declare (strict_types=1);

$i = 1;
do {
    echo "i = $i\n";
    $i++;
} while ($i <= 5);

$percobaan = 0;
do {
    $percobaan++;
    $nilai = 30 + $percobaan * 20;
} while ($percobaan < 5);
echo "Diperoleh nilai $nilai setelah $percobaan percobaan\n";