<?php
require_once __DIR__ . '/../src/layout.php';
require_once __DIR__ . '/../src/hata.php';
require_once __DIR__ . '/../src/staj.php';

$liste = [];
$hata = null;
try {
    $liste = staj_listele();
} catch (PDOException $ex) {
    $hata = veritabani_hata_mesaji($ex);
}

sayfa_basi('Stajlar');
?>
<h1>Stajlar</h1>
<p><a class="dugme" href="staj-form.php">+ Yeni staj</a></p>

<?php if ($hata): ?>
    <div class="mesaj hata"><?= e($hata) ?></div>
<?php elseif (count($liste) === 0): ?>
    <p>Henüz staj kaydı yok.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Başlık</th><th>Firma</th><th>Alan</th><th>Tarih aralığı</th><th>Durum</th><th>İşlem</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($liste as $s): ?>
            <tr>
                <td><?= e($s['baslik']) ?></td>
                <td><?= e($s['firma_ad']) ?></td>
                <td><?= e($s['alan']) ?></td>
                <td><?= e($s['baslangic_tarihi'] ?? '—') ?> / <?= e($s['bitis_tarihi'] ?? '—') ?></td>
                <td><?= e(STAJ_DURUMLARI[$s['durum']] ?? $s['durum']) ?></td>
                <td>
                    <a class="dugme ikincil" href="staj-form.php?id=<?= (int)$s['staj_id'] ?>">Düzenle</a>
                    <form class="satir" method="post" action="staj-sil.php"
                          onsubmit="return confirm('Bu staj kaydı ve bağlı yetkinlik beklentileri silinecek. Emin misiniz?');">
                        <input type="hidden" name="staj_id" value="<?= (int)$s['staj_id'] ?>">
                        <button class="dugme tehlike" type="submit">Sil</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php sayfa_sonu();
