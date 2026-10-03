<?php
declare (strict_types=1);

echo "Tabel Perkalian \n";
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 10; $j++) {
        printf("%4d", $i * $j);
    }
    echo "\n";
}

// Faktorial berulang
echo "\nFaktorial berulang \n";
for ($n = 1; $n <= 6; $n++) {
    $f = 1;
    for ($k = 1; $k <= $n; $k++) {
        $f *= $k;
    }
    echo "$n! = $f\n";
}