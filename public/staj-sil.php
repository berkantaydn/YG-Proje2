<?php
require_once __DIR__ . '/../src/layout.php';
require_once __DIR__ . '/../src/hata.php';
require_once __DIR__ . '/../src/staj.php';

// Silme yalnızca POST ile yapılır (adres çubuğuna yazılarak silinemez).
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    yonlendir('staj.php');
}

$id = filter_var($_POST['staj_id'] ?? '', FILTER_VALIDATE_INT);
if ($id === false || $id < 1) {
    mesaj_ayarla('hata', 'Geçersiz kayıt.');
    yonlendir('staj.php');
}

try {
    if (staj_sil($id)) {
        mesaj_ayarla('basari', 'Staj silindi.');
    } else {
        mesaj_ayarla('hata', 'Silinecek kayıt bulunamadı.');
    }
} catch (PDOException $ex) {
    mesaj_ayarla('hata', veritabani_hata_mesaji($ex));
}
yonlendir('staj.php');
