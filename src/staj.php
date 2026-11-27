<?php
/**
 * Staj kayıtları için veri erişim katmanı (CRUD) — P2-09.
 * Tüm sorgular PDO hazırlanmış sorgudur; kullanıcı verisi SQL metnine eklenmez.
 */

require_once __DIR__ . '/db.php';

const STAJ_DURUMLARI = ['acik' => 'Açık', 'kapali' => 'Kapalı'];

/** Tüm stajlar, firma adıyla birlikte (en yeni üstte). */
function staj_listele(): array
{
    $sql = 'SELECT s.staj_id, s.baslik, s.alan, s.baslangic_tarihi, s.bitis_tarihi,
                   s.durum, f.ad AS firma_ad
            FROM staj s
            JOIN firma f ON f.firma_id = s.firma_id
            ORDER BY s.staj_id DESC';
    return db()->query($sql)->fetchAll();
}

/** Tek staj kaydı; yoksa null. */
function staj_getir(int $id): ?array
{
    $st = db()->prepare('SELECT * FROM staj WHERE staj_id = :id');
    $st->execute([':id' => $id]);
    $satir = $st->fetch();
    return $satir ?: null;
}

/** Açılır liste için firmalar. */
function staj_firma_secenekleri(): array
{
    return db()->query('SELECT firma_id, ad FROM firma ORDER BY ad')->fetchAll();
}

/** Yeni staj ekler; yeni kaydın kimliğini döndürür. */
function staj_ekle(array $v): int
{
    $st = db()->prepare(
        'INSERT INTO staj (firma_id, baslik, aciklama, alan, baslangic_tarihi, bitis_tarihi, durum)
         VALUES (:firma_id, :baslik, :aciklama, :alan, :baslangic, :bitis, :durum)'
    );
    $st->execute([
        ':firma_id'  => $v['firma_id'],
        ':baslik'    => $v['baslik'],
        ':aciklama'  => $v['aciklama'],
        ':alan'      => $v['alan'],
        ':baslangic' => $v['baslangic_tarihi'],
        ':bitis'     => $v['bitis_tarihi'],
        ':durum'     => $v['durum'],
    ]);
    return (int)db()->lastInsertId();
}

/** Var olan stajı günceller. */
function staj_guncelle(int $id, array $v): void
{
    $st = db()->prepare(
        'UPDATE staj
         SET firma_id = :firma_id, baslik = :baslik, aciklama = :aciklama, alan = :alan,
             baslangic_tarihi = :baslangic, bitis_tarihi = :bitis, durum = :durum
         WHERE staj_id = :id'
    );
    $st->execute([
        ':firma_id'  => $v['firma_id'],
        ':baslik'    => $v['baslik'],
        ':aciklama'  => $v['aciklama'],
        ':alan'      => $v['alan'],
        ':baslangic' => $v['baslangic_tarihi'],
        ':bitis'     => $v['bitis_tarihi'],
        ':durum'     => $v['durum'],
        ':id'        => $id,
    ]);
}

/** Stajı siler (bağlı staj_yetkinlik kayıtları CASCADE ile silinir). Silindiyse true. */
function staj_sil(int $id): bool
{
    $st = db()->prepare('DELETE FROM staj WHERE staj_id = :id');
    $st->execute([':id' => $id]);
    return $st->rowCount() > 0;
}

/**
 * Form girdisini denetler.
 * @return array{0: array, 1: string[]}  [temiz değerler, hata mesajları]
 */
function staj_dogrula(array $girdi): array
{
    $hatalar = [];

    $firma_id  = filter_var($girdi['firma_id'] ?? '', FILTER_VALIDATE_INT);
    $baslik    = trim((string)($girdi['baslik'] ?? ''));
    $aciklama  = trim((string)($girdi['aciklama'] ?? ''));
    $alan      = trim((string)($girdi['alan'] ?? ''));
    $baslangic = trim((string)($girdi['baslangic_tarihi'] ?? ''));
    $bitis     = trim((string)($girdi['bitis_tarihi'] ?? ''));
    $durum     = trim((string)($girdi['durum'] ?? ''));

    if ($firma_id === false || $firma_id < 1) {
        $hatalar[] = 'Firma seçmelisiniz.';
        $firma_id = 0;
    }
    if ($baslik === '') {
        $hatalar[] = 'Başlık boş bırakılamaz.';
    } elseif (mb_strlen($baslik) > 150) {
        $hatalar[] = 'Başlık en fazla 150 karakter olabilir.';
    }
    if (mb_strlen($alan) > 80) {
        $hatalar[] = 'Alan en fazla 80 karakter olabilir.';
    }

    $baslangic = staj_tarih_denetle($baslangic, 'Başlangıç tarihi', $hatalar);
    $bitis     = staj_tarih_denetle($bitis, 'Bitiş tarihi', $hatalar);
    if ($baslangic !== null && $bitis !== null && $bitis < $baslangic) {
        $hatalar[] = 'Bitiş tarihi başlangıç tarihinden önce olamaz.';
    }

    if (!array_key_exists($durum, STAJ_DURUMLARI)) {
        $hatalar[] = 'Durum açık veya kapalı olmalıdır.';
    }

    $temiz = [
        'firma_id'         => $firma_id,
        'baslik'           => $baslik,
        'aciklama'         => $aciklama === '' ? null : $aciklama,
        'alan'             => $alan === '' ? null : $alan,
        'baslangic_tarihi' => $baslangic,
        'bitis_tarihi'     => $bitis,
        'durum'            => $durum,
    ];
    return [$temiz, $hatalar];
}

/** Boşsa null; YYYY-AA-GG biçiminde geçerli tarihse kendisini döndürür. */
function staj_tarih_denetle(string $deger, string $etiket, array &$hatalar): ?string
{
    if ($deger === '') {
        return null;
    }
    $tarih = DateTime::createFromFormat('Y-m-d', $deger);
    if (!$tarih || $tarih->format('Y-m-d') !== $deger) {
        $hatalar[] = $etiket . ' geçerli bir tarih olmalıdır.';
        return null;
    }
    return $deger;
}
