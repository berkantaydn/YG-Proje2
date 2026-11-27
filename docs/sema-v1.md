# Veritabanı Şeması v1 (Hafta 2)

Bu belge `sql/schema.sql` dosyasının karar kaydıdır. Tablo ve alan adları Hafta 1 taslağı, veri sözlüğü (`docs/veri-sozlugu.md`) ve ER diyagramı ile aynıdır; yalnızca dosya adı `schema-taslak.sql` → `schema.sql` olmuştur.

Test ortamı: MariaDB 10.11 (XAMPP ile aynı aile). Motor: InnoDB, karakter kümesi `utf8mb4`, sıralama `utf8mb4_unicode_ci`.

## Tablolar (7)
`sektor`, `yetkinlik`, `ogrenci`, `firma`, `staj`, `ogrenci_yetkinlik`, `staj_yetkinlik`

## İlişki kuralları (ON DELETE)
| İlişki | Kural | Neden |
|---|---|---|
| sektor → firma | RESTRICT | Firması olan sektör silinemez; veri kaybı olmasın. |
| firma → staj | CASCADE | Firma silinirse ilanları anlamsız kalır. Arayüzde silme öncesi onay istenir. |
| ogrenci → ogrenci_yetkinlik | CASCADE | Öğrenci silinirse yetkinlik kayıtları da gider. |
| staj → staj_yetkinlik | CASCADE | Staj silinirse beklentileri de gider. |
| yetkinlik → ogrenci_yetkinlik / staj_yetkinlik | RESTRICT | Kullanımdaki yetkinlik silinemez. |

## Kısıtlar
- UNIQUE: `sektor.ad`, `yetkinlik.ad`, `firma.ad`, `ogrenci.ogrenci_no`, `ogrenci.email`
- CHECK: `ogrenci.sinif` 1–6 (veya boş), `staj.durum` ∈ {acik, kapali}, `staj.bitis_tarihi >= baslangic_tarihi`, `ogrenci_yetkinlik.duzey` 1–5, `staj_yetkinlik.min_duzey` 1–5
- Bileşik birincil anahtar: ara tablolarda (aynı çift iki kez eklenemez)

## Kararlar ve bilinen sınırlar
1. **Staj için UNIQUE yok.** `(firma_id, baslik, baslangic_tarihi)` UNIQUE yapılsaydı tarih boşken (NULL) tekrar eden kayıtları engellemezdi; yanıltıcı güvence verirdi. Tekrar denetimi gerekirse uygulama katmanında yapılır.
2. **Firma silme CASCADE.** Bağlı stajlar da silinir; veri sözlüğü değişmesin diye bu korundu, arayüzde onay penceresi var.
3. **Aksan duyarsız karşılaştırma.** `utf8mb4_unicode_ci` ile `ç=c`, `ş=s`, `ö=o` eşit sayılır (ör. "Çağrı" ile "Cagri" aynı kabul edilir). `ı` ile `i` ise farklıdır. Arama/UNIQUE davranışı buna göre yorumlanmalıdır.
4. **Düzey filtresi** (öğrenci düzeyi "eşittir" mi "en az" mı) Hafta 3 sorgu görevinde karara bağlanacak.
5. XAMPP'taki "MySQL" aslında MariaDB'dir; şema her ikisinde de çalışır (CHECK kısıtları MariaDB 10.2+ ve MySQL 8.0.16+ ile uygulanır).

6. **Katı mod.** XAMPP'ın MariaDB 10.4'ünde `sql_mode` katı değildir; bu yüzden hatalı veri (uzun metin, eksik zorunlu alan) reddedilmek yerine sessizce kesilip/doldurularak kaydedilebilir (bkz. `docs/test-plani.md` Bölüm 2). `src/db.php` her bağlantıda `STRICT_ALL_TABLES` oturum modunu açar; böylece XAMPP ile bizim test ortamımız aynı davranır.

## Nasıl kurulur
phpMyAdmin → İçe Aktar → `sql/schema.sql` → Git. Dosya `staj_yetkinlik` veritabanını kendisi oluşturur. Tekrar çalıştırmak tüm verileri siler.
