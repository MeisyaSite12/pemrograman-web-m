<?php
declare (strict_types=1);

$a = 10;
$b = 20;
$maks = ($a > $b) ? $a : $b;
echo "Maksimum: $maks \n";

$nilai = 80;
$status = $nilai >= 75 ? "LULUS" : "TIDAK LULUS";
echo "Status: $status \n";

$input = "0";
echo "Elvis ?: " . ($input ?: "default") . "\n";
echo "Null ??: " . ($input ?? "default") . "\n";

$umur = $_GET['umur'] ?? 0;
echo "Umur: $umur \n";