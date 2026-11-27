<?php
/**
 * Ortak sayfa şablonu ve yardımcı fonksiyonlar.
 * Her sayfanın başında:   require_once __DIR__ . '/../src/layout.php';
 * Sayfa içeriği:          sayfa_basi('Başlık');  ... HTML ...  sayfa_sonu();
 *
 * Çıktı HTML'e yazılan her kullanıcı verisi e() ile kaçışlanmalıdır (XSS önlemi).
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** HTML çıktısı için güvenli metin. */
function e(mixed $deger): string
{
    return htmlspecialchars((string)($deger ?? ''), ENT_QUOTES, 'UTF-8');
}

/** Bir sonraki sayfada gösterilecek mesajı kaydeder. $tur: 'basari' veya 'hata' */
function mesaj_ayarla(string $tur, string $metin): void
{
    $_SESSION['mesaj'] = ['tur' => $tur, 'metin' => $metin];
}

/** Başka sayfaya yönlendirir ve çalışmayı bitirir. */
function yonlendir(string $sayfa): void
{
    header('Location: ' . $sayfa);
    exit;
}

/** Sayfanın üst kısmını (başlık, menü, varsa mesaj) yazar. */
function sayfa_basi(string $baslik): void
{
    header('Content-Type: text/html; charset=UTF-8');

    $menu = [
        'index.php'     => 'Ana sayfa',
        'ogrenci.php'   => 'Öğrenciler',
        'yetkinlik.php' => 'Yetkinlikler',
        'sektor.php'    => 'Sektörler',
        'firma.php'     => 'Firmalar',
        'staj.php'      => 'Stajlar',
    ];
    $aktif = basename($_SERVER['SCRIPT_NAME'] ?? '');

    $mesaj = $_SESSION['mesaj'] ?? null;
    unset($_SESSION['mesaj']);
    ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($baslik) ?> — Staj ve Sektör Yetkinlik Haritası</title>
    <style>
        /* Geçici temel stil; Dokümantasyon/Sunum görevi bunu css/stil.css ile değiştirebilir. */
        body { font-family: Arial, sans-serif; margin: 0; color: #222; background: #f6f7f9; }
        nav { background: #1f3a5f; padding: 10px 24px; }
        nav a { color: #fff; text-decoration: none; margin-right: 18px; }
        nav a.aktif { font-weight: bold; text-decoration: underline; }
        main { max-width: 960px; margin: 24px auto; padding: 0 16px; }
        table { border-collapse: collapse; width: 100%; background: #fff; }
        th, td { border: 1px solid #d5d9e0; padding: 8px 10px; text-align: left; }
        th { background: #e8ecf2; }
        .dugme { display: inline-block; background: #0b5ed7; color: #fff; padding: 7px 14px;
                 border: 0; border-radius: 4px; text-decoration: none; cursor: pointer; font-size: 14px; }
        .dugme.ikincil { background: #6c757d; }
        .dugme.tehlike { background: #c82333; }
        .mesaj { padding: 10px 14px; border-radius: 4px; margin: 12px 0; }
        .mesaj.basari { background: #d1e7dd; }
        .mesaj.hata { background: #f8d7da; }
        form.satir { display: inline; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input[type=text], input[type=date], input[type=email], input[type=number], select, textarea {
            width: 100%; max-width: 480px; padding: 7px; box-sizing: border-box; }
    </style>
</head>
<body>
<nav>
    <?php foreach ($menu as $dosya => $etiket): ?>
        <a href="<?= e($dosya) ?>"<?= $aktif === $dosya ? ' class="aktif"' : '' ?>><?= e($etiket) ?></a>
    <?php endforeach; ?>
</nav>
<main>
    <?php if ($mesaj): ?>
        <div class="mesaj <?= e($mesaj['tur']) ?>"><?= e($mesaj['metin']) ?></div>
    <?php endif; ?>
<?php
}

/** Sayfanın alt kısmını yazar. */
function sayfa_sonu(): void
{
    echo "</main>\n</body>\n</html>\n";
}
