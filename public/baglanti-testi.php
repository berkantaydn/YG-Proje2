<?php
require_once __DIR__ . '/../src/db.php';

$basarili = false;
$mesaj = '';
$surum = '';
$tablolar = [];

try {
    $pdo = db();
    $surum = $pdo->query('SELECT VERSION()')->fetchColumn();
    $tablolar = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    $basarili = true;
    $mesaj = 'Veritabanı bağlantısı başarılı.';
} catch (PDOException $e) {
    $mesaj = 'Bağlantı hatası: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bağlantı Testi</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 640px; margin: 60px auto; padding: 0 16px; color: #222; }
        .ok  { background: #d1e7dd; padding: 12px 16px; border-radius: 6px; }
        .err { background: #f8d7da; padding: 12px 16px; border-radius: 6px; }
    </style>
</head>
<body>
    <h1>Bağlantı Testi</h1>
    <div class="<?= $basarili ? 'ok' : 'err' ?>">
        <?= htmlspecialchars($mesaj, ENT_QUOTES, 'UTF-8') ?>
    </div>

    <?php if ($basarili): ?>
        <p>Sunucu sürümü: <strong><?= htmlspecialchars($surum, ENT_QUOTES, 'UTF-8') ?></strong></p>
        <h2>Tablolar (<?= count($tablolar) ?>)</h2>
        <?php if (count($tablolar) === 0): ?>
            <p>Henüz tablo yok. <code>sql/schema-taslak.sql</code> dosyasını phpMyAdmin'den içe aktarın.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($tablolar as $t): ?>
                    <li><?= htmlspecialchars($t, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
    <p><a href="index.php">← Ana sayfa</a></p>
</body>
</html>
