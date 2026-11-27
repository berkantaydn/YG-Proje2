# Örnek Veri Taslağı (Sentetik)

**Görev:** Issue #3 · **Hazırlayan:** Çağrı Aydemir (Dokümantasyon/Sunum)
**Dayanak:** `sql/schema-taslak.sql`, [`docs/veri-sozlugu.md`](../../docs/veri-sozlugu.md) (sürüm 1.1)

Bu klasördeki **tüm kayıtlar kurgusaldır.** Öğrenci adları "Örnek, Deneme, Kurgu..." gibi açıkça sentetik soyadlarla, e-postalar `@example.com`, firma siteleri `.example` uzantısıyla yazılmıştır. Gerçek kişi, öğrenci numarası veya firma verisi yoktur (NFR-05, GV-05).

Bu dosyalar **taslaktır.** Kesin `seed.sql` dosyası P2-08 kapsamında bu verilerden üretilecektir.

## Dosyalar ve yükleme sırası

Her tablo için ayrı bir CSV vardır. Dosya adlarındaki numara, yükleme sırasıdır. Yabancı anahtarlar nedeniyle üst tablolar önce yüklenmelidir.

| Sıra | Dosya | Tablo | Kayıt |
|---|---|---|---|
| 1 | `1_sektor.csv` | `sektor` | 4 |
| 2 | `2_yetkinlik.csv` | `yetkinlik` | 12 |
| 3 | `3_ogrenci.csv` | `ogrenci` | 9 |
| 4 | `4_firma.csv` | `firma` | 6 |
| 5 | `5_staj.csv` | `staj` | 8 |
| 6 | `6_ogrenci_yetkinlik.csv` | `ogrenci_yetkinlik` | 31 |
| 7 | `7_staj_yetkinlik.csv` | `staj_yetkinlik` | 27 |

Biçim: UTF-8, virgülle ayrılmış, ilk satır sütun adları. Sütun sırası tablolardaki sütun sırasıyla aynıdır. Boş (NULL) alan yoktur.

## phpMyAdmin ile yükleme

1. Önce ana README'deki kurulum adımlarıyla şemayı kurun (`sql/schema-taslak.sql`).
2. Sol menüden `staj_yetkinlik` veritabanını açın ve yükleyeceğiniz tabloya tıklayın (ör. `sektor`).
3. **İçe Aktar** sekmesinde dosyayı seçin. Biçim olarak **CSV** seçili olsun.
4. **Kısmi içe aktarma** bölümündeki "Şu kadar sorguyu/satırı atla" alanına **1** yazın (başlık satırı atlanır).
5. Sütun ayırıcı `,` ve sütun çevreleyici `"` olarak kalsın. **İçe Aktar**'a basın.
6. Aynı işlemi tablodaki sırayla diğer altı dosya için tekrarlayın.

## Verinin test ettiği durumlar

Veri, gereksinim ve test belgelerindeki senaryolar çalıştırılabilsin diye tasarlanmıştır:

| Durum | Veride nerede? |
|---|---|
| **KS-03 örneği (yetkinlik boşluğu):** pozisyon SQL ≥ 4, PHP ≥ 3, Docker ≥ 2 bekler; öğrencide SQL 2, PHP 3 var, Docker yok | Öğrenci S0001 (Deniz Örnek) ↔ Staj 1 (Backend Stajyeri). Beklenen sonuç: SQL **yetersiz**, PHP **karşılanan**, Docker **eksik** |
| Pozisyonun tüm beklentilerini karşılayan öğrenci | S0002 ↔ Staj 2, S0003 ↔ Staj 4, S0004 ↔ Staj 6, S0008 ↔ Staj 1 ve 5 |
| Kısmen karşılayan öğrenci | S0005 ↔ Staj 3 (Docker yetersiz), S0006 ↔ Staj 7 |
| Neredeyse hiç yetkinliği olmayan öğrenci | S0007 (yalnızca HTML/CSS 2) |
| **Hiç yetkinliği olmayan öğrenci** (0..N katılım) | S0009 (Arda Demo) |
| **Talep edilen yetkinlikler raporu** için farklı talep sayıları | SQL 5 pozisyon, PHP ve Git 4'er, HTML/CSS 3, Docker/JavaScript/Python 2'şer, diğerleri 1'er |
| Durum filtresi (`acik` / `kapali`) | Staj 8 kapalı (geçmiş dönem), diğerleri açık |
| Sektör filtresi (`staj → firma → sektor` zinciri) | 4 sektör; Yazılım sektöründe 3 firma |
| Alan filtresi | backend (3), frontend, devops, veri, oyun, fullstack |
| Türkçe karakterler (NFR-09) | Yazılım, İstanbul, İzmir, Örnek, Ödeme, İngilizce, Takım Çalışması |

## Doğrulama

Dosyalar MariaDB 10.11 üzerinde `schema-taslak.sql` kurulduktan sonra katı modda (`STRICT_ALL_TABLES`) yüklenmiş; uyarı veya kısıt ihlali oluşmamıştır. Yükleme sonrası KS-03 karşılaştırma sorgusu beklenen sonucu (yetersiz / karşılanan / eksik) vermiştir.
