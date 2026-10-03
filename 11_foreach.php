<?php
declare (strict_types=1);

$buah = ["Apel", "Jeruk", "Mangga"];
foreach ($buah as $b) {
    echo "- $b\n";
}

$ipk = ["Andi" => 3.8, "Budi" => 3.2, "Citra" => 2.9];
foreach ($ipk as $nama => $nilai) {
    echo "$nama: $nilai\n";
}

$total = 0;
foreach ($ipk as $nilai) {
    $total += $nilai;
}
echo "Rata-rata IPK: " . number_format($total / count($ipk), 2) . "\n"; 