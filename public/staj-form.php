<?php
require_once __DIR__ . '/../src/layout.php';
require_once __DIR__ . '/../src/hata.php';
require_once __DIR__ . '/../src/staj.php';

// ?id=5 ile açılırsa düzenleme, yoksa yeni kayıt
$id = filter_var($_GET['id'] ?? $_POST['staj_id'] ?? '', FILTER_VALIDATE_INT);
$duzenleme = ($id !== false && $id > 0);

$alanlar = ['firma_id', 'baslik', 'aciklama', 'alan', 'baslangic_tarihi', 'bitis_tarihi', 'durum'];
$degerler = array_fill_keys($alanlar, '');
$degerler['durum'] = 'acik';
$hatalar = [];
$firmalar = [];

try {
    $firmalar = staj_firma_secenekleri();

    if ($duzenleme && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        $kayit = staj_getir($id);
        if ($kayit === null) {
            mesaj_ayarla('hata', 'Staj kaydı bulunamadı.');
            yonlendir('staj.php');
        }
        foreach ($alanlar as $a) {
            $degerler[$a] = (string)($kayit[$a] ?? '');
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($alanlar as $a) {
            $degerler[$a] = trim((string)($_POST[$a] ?? ''));
        }
        [$temiz, $hatalar] = staj_dogrula($_POST);

        if (count($hatalar) === 0) {
            if ($duzenleme) {
                staj_guncelle($id, $temiz);
                mesaj_ayarla('basari', 'Staj güncellendi.');
            } else {
                staj_ekle($temiz);
                mesaj_ayarla('basari', 'Staj eklendi.');
            }
            yonlendir('staj.php');
        }
    }
} catch (PDOException $ex) {
    $hatalar[] = veritabani_hata_mesaji($ex);
}

sayfa_basi($duzenleme ? 'Staj düzenle' : 'Yeni staj');
?>
<h1><?= $duzenleme ? 'Staj düzenle' : 'Yeni staj' ?></h1>

<?php if (count($hatalar) > 0): ?>
    <div class="mesaj hata">
        <?php foreach ($hatalar as $h): ?>
            <div><?= e($h) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (count($firmalar) === 0): ?>
    <div class="mesaj hata">Staj eklemek için önce bir firma eklemelisiniz.
        <a href="firma.php">Firmalar sayfasına git</a></div>
<?php else: ?>
<form method="post" action="staj-form.php<?= $duzenleme ? '?id=' . (int)$id : '' ?>">
    <?php if ($duzenleme): ?>
        <input type="hidden" name="staj_id" value="<?= (int)$id ?>">
    <?php endif; ?>

    <label for="firma_id">Firma *</label>
    <select id="firma_id" name="firma_id">
        <option value="">— Firma seçin —</option>
        <?php foreach ($firmalar as $f): ?>
            <option value="<?= (int)$f['firma_id'] ?>"
                <?= (string)$f['firma_id'] === $degerler['firma_id'] ? 'selected' : '' ?>>
                <?= e($f['ad']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="baslik">Başlık *</label>
    <input type="text" id="baslik" name="baslik" maxlength="150" value="<?= e($degerler['baslik']) ?>">

    <label for="aciklama">Açıklama</label>
    <textarea id="aciklama" name="aciklama" rows="4"><?= e($degerler['aciklama']) ?></textarea>

    <label for="alan">Alan (ör. backend, veri, mobil)</label>
    <input type="text" id="alan" name="alan" maxlength="80" value="<?= e($degerler['alan']) ?>">

    <label for="baslangic_tarihi">Başlangıç tarihi</label>
    <input type="date" id="baslangic_tarihi" name="baslangic_tarihi" value="<?= e($degerler['baslangic_tarihi']) ?>">

    <label for="bitis_tarihi">Bitiş tarihi</label>
    <input type="date" id="bitis_tarihi" name="bitis_tarihi" value="<?= e($degerler['bitis_tarihi']) ?>">

    <label for="durum">Durum *</label>
    <select id="durum" name="durum">
        <?php foreach (STAJ_DURUMLARI as $anahtar => $etiket): ?>
            <option value="<?= e($anahtar) ?>" <?= $degerler['durum'] === $anahtar ? 'selected' : '' ?>>
                <?= e($etiket) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <p>
        <button class="dugme" type="submit">Kaydet</button>
        <a class="dugme ikincil" href="staj.php">İptal</a>
    </p>
</form>
<?php endif; ?>
<?php sayfa_sonu();
