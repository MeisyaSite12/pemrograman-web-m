<?php
declare (strict_types=1);

$huruf = 'B';

$predikat = match ($huruf) {
    'A' => 'Istimewa',
    'B' => 'Sangat Baik',
    'C' => 'Baik',
    'D' => 'Cukup',
    default => 'Kurang',
};
echo " Huruf $huruf -> $predikat\n";

$hari = 'Minggu';
$jenis = match ($hari) {
    'Sabtu', 'Minggu' => 'Hari libur',
    default => 'Hari kerja',
};
echo "$hari adalah $jenis\n";

$kode = 0;
$hasil = match ($kode) {
    0 => 'nol (int)',
    '0' => 'nol (string)',
    default => 'lain',
};
echo "Kode 0 -> $hasil\n";