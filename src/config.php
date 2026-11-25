<?php
/**
 * Ayarları .env dosyasından okur.
 * .env yoksa XAMPP varsayılan değerleri kullanılır.
 */

function env_yukle(string $dosya): array
{
    $degerler = [];
    if (!is_readable($dosya)) {
        return $degerler;
    }
    foreach (file($dosya, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $satir) {
        $satir = trim($satir);
        if ($satir === '' || $satir[0] === '#' || strpos($satir, '=') === false) {
            continue;
        }
        [$anahtar, $deger] = explode('=', $satir, 2);
        $degerler[trim($anahtar)] = trim($deger);
    }
    return $degerler;
}

$kok = dirname(__DIR__);
$env = env_yukle($kok . '/.env');

return [
    'db_host' => $env['DB_HOST'] ?? '127.0.0.1',
    'db_port' => $env['DB_PORT'] ?? '3306',
    'db_name' => $env['DB_NAME'] ?? 'staj_yetkinlik',
    'db_user' => $env['DB_USER'] ?? 'root',
    'db_pass' => $env['DB_PASS'] ?? '',
];
