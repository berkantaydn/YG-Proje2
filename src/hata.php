<?php
/**
 * Veritabanı hatalarını kullanıcıya anlaşılır bir mesaja çevirir.
 * Teknik ayrıntı kullanıcıya gösterilmez; gerçek hata sunucu günlüğüne yazılır
 * (XAMPP: C:\xampp\apache\logs\error.log).
 *
 * Kullanım:
 *   try { ... } catch (PDOException $e) { $mesaj = veritabani_hata_mesaji($e); }
 */

function veritabani_hata_mesaji(PDOException $e): string
{
    error_log('[DB] ' . $e->getMessage());

    // errorInfo[1] = MySQL/MariaDB hata kodu
    $kod = (int)($e->errorInfo[1] ?? 0);

    return match (true) {
        $kod === 1062                  => 'Bu kayıt zaten var; aynı değer ikinci kez girilemez.',
        $kod === 1451                  => 'Bu kayıt başka kayıtlarla ilişkili olduğu için silinemez. Önce bağlı kayıtları kaldırın.',
        $kod === 1452                  => 'Seçilen bağlı kayıt bulunamadı (geçersiz ilişki).',
        $kod === 1048, $kod === 1364   => 'Zorunlu bir alan boş bırakılamaz.',
        $kod === 1406                  => 'Girilen değer alan için çok uzun.',
        $kod === 3819, $kod === 4025   => 'Girilen değer izin verilen aralığın dışında.',
        default                        => 'Veritabanı işlemi tamamlanamadı. Bilgileri kontrol edip tekrar deneyin.',
    };
}
