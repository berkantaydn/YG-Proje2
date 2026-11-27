<?php
/**
 * Veritabanı bağlantısı (PHP PDO).
 *
 * Kullanım:
 *   require_once __DIR__ . '/db.php';
 *   $pdo = db();
 *   $stmt = $pdo->prepare('SELECT * FROM ogrenci WHERE ogrenci_id = :id');
 *   $stmt->execute([':id' => $id]);
 *
 * KURAL: Kullanıcıdan gelen veri asla SQL metnine doğrudan eklenmez,
 * her zaman prepare() + execute() ile parametre olarak gönderilir.
 */

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $ayar = require __DIR__ . '/config.php';

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $ayar['db_host'],
        $ayar['db_port'],
        $ayar['db_name']
    );

    $pdo = new PDO($dsn, $ayar['db_user'], $ayar['db_pass'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    // XAMPP'ın varsayılanında katı mod kapalıdır; bu durumda MariaDB hatalı veriyi
    // reddetmek yerine sessizce değiştirip kaydedebilir. Oturum için katı modu açıyoruz.
    $pdo->exec("SET SESSION sql_mode = 'STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION'");

    return $pdo;
}
