<?php
declare (strict_types=1);

for ($i = 1; $i <= 5; $i++) {
    echo "Iterasi ke-$i\n";
}

$total = 0;
for ($i = 1; $i <= 100; $i++) {
    $total += $i;
}

$faktorial = 1;
for ($i = 1; $i <= 5; $i++) {
    $faktorial *= $i;
}
echo "5! = $faktorial\n";