# Staj ve Sektör Yetkinlik Haritası

## Test Planı — İskelet ve İlk Negatif Test Fikirleri

**Görev:** Issue #1 · **Rol:** Test/Kalite · **Hazırlayan:** Selin Özbay  
**Sürüm:** 1.0 — iskelet (Hafta 1)

## 1. Amaç ve kapsam

Bu belge, sistemin veri bütünlüğünü, CRUD işlevlerini, raporlarını ve güvenli sorgu kullanımını nasıl test edeceğimizi tanımlar. Hafta 1'de iskelet ve ilk negatif test fikirleri hazırlanmıştır; testler henüz çalıştırılmamıştır.

Belge ileride şu görevlerin temelini oluşturur:

| Görev | Hafta | Bu belgedeki karşılığı |
|---|---|---|
| P2-13 Veri doğrulama ve referans bütünlüğü | 3 | Bölüm 6'daki DB testlerinin çalıştırılıp sonuçlarının yazılması |
| P2-14 Güvenli sorgu ve hassas veri | 3 | Bölüm 6.6 güvenlik testleri |
| P2-15 Entegrasyon ve hata düzeltme | 3 | En az 5 işlevsel testin çalıştırılması, hataların issue olarak açılması |
| P2-16 Gereksinim–test izlenebilirliği | 4 | Bölüm 8'deki matrisin tamamlanması |

**Kapsam dışı:** Yük testi, tarayıcı uyumluluğu, kullanıcı hesabı / yetkilendirme (sistemde giriş ekranı yoktur).

## 2. Test ortamı

| Bileşen | Sürüm / değer |
|---|---|
| Sunucu paketi | XAMPP |
| Veri tabanı | MariaDB 10.4.32 (XAMPP'ın "MySQL"i) |
| PHP | 8.2.12 |
| Veri tabanı adı | `staj_yetkinlik` |
| Şema | `sql/schema-taslak.sql` (Hafta 2'de `schema.sql` ile değiştirilecek) |
| Araç | phpMyAdmin → SQL sekmesi (DB testleri), tarayıcı (uygulama testleri) |

**Önemli gözlem — `sql_mode`:** XAMPP'ın `my.ini` dosyasında `sql_mode=NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION` yazılıdır; yani **katı mod (`STRICT_TRANS_TABLES`) kapalıdır**. Katı mod kapalıyken MariaDB bazı hatalı girişleri reddetmek yerine **uyarı verip veriyi değiştirerek kaydedebilir**:

- `INSERT` içinde hiç yazılmayan NOT NULL bir metin alanı boş metin (`''`) ile kaydedilebilir.
- Sütundan uzun metin kesilerek kaydedilebilir.
- Aralık dışı sayı en yakın sınıra çekilebilir (ör. `-1` → `0`).

Bu davranışlar Bölüm 6'daki ilgili testlerle (DB-02, DB-23, DB-24) doğrulanacaktır. Doğrulanırsa ekibe önerimiz: `src/db.php` içinde bağlantı açılırken oturum için katı mod açılsın (ör. `SET SESSION sql_mode = 'STRICT_ALL_TABLES,...'`). Karar Lider ve geliştiricilerle birlikte verilecektir.

**CHECK kısıtları:** MariaDB 10.2.1 ve sonrası `CHECK` kısıtlarını uygular. Kullandığımız 10.4.32 sürümünde düzey, sınıf, durum ve tarih kısıtlarının çalışması beklenir; DB-17 – DB-22 bunu doğrular.

## 3. Test türleri

| Tür | Kimlik öneki | Nasıl çalıştırılır | Ne zaman |
|---|---|---|---|
| Veri tabanı kısıt testleri | `DB-xx` | phpMyAdmin SQL sekmesinde doğrudan SQL | Şema v1 hazır olunca (Hafta 2–3) |
| Uygulama / form testleri | `UY-xx` | Tarayıcıdan ekran üzerinden | CRUD ekranları yazıldıkça (Hafta 2–3) |
| Güvenlik testleri | `GV-xx` | Form girdisi + kod incelemesi | Hafta 3 (P2-14) |
| Rapor ve karşılaştırma doğruluğu | `RP-xx` | Bilinen veriyle ekran sonucu ↔ kontrol sorgusu | Hafta 3 (P2-12 sonrası) |
| Kurulum testi | `KR-xx` | Temiz bilgisayarda README adımları | Hafta 4 (P2-17) |

Her FR'ye bağlanan testler P2-16'da ayrıca `TC-xx.y` biçiminde (eylem planındaki örnekteki gibi; `xx` = FR numarası) numaralandırılacaktır.

## 4. Giriş ve çıkış ölçütleri

**Teste başlamak için:**

- Şema boş veri tabanına hatasız kuruluyor.
- Bölüm 5'teki test ön verisi eklenmiş.
- Test edilecek ekran veya sorgu `main` dalına birleştirilmiş.

**Testi tamamlanmış saymak için:**

- Bölüm 6'daki tüm DB testleri en az bir kez çalıştırılmış ve sonucu (Geçti / Kaldı + hata kodu) yazılmış.
- Kalan her test için GitHub'da issue açılmış.
- Kritik hata (veri kaybı, bütünlüğü bozan kayıt, SQL enjeksiyonu) açık kalmamış.

## 5. Test ön verisi

Tüm değerler sentetiktir. Şema yeni kurulmuş boş veri tabanında çalıştırıldığında kimlikler 1'den başlar; Bölüm 6'daki testler bu kimliklere göre yazılmıştır.

```sql
USE staj_yetkinlik;

INSERT INTO sektor (ad) VALUES ('Yazılım');                                   -- sektor_id = 1
INSERT INTO yetkinlik (ad, kategori) VALUES ('SQL', 'Veri tabanı'),
                                            ('PHP', 'Backend');               -- yetkinlik_id = 1, 2
INSERT INTO ogrenci (ogrenci_no, ad, soyad, email)
    VALUES ('T0001', 'Ada', 'Örnek', 't1@example.com');                       -- ogrenci_id = 1
INSERT INTO firma (ad, sektor_id) VALUES ('Örnek Yazılım A.Ş.', 1);           -- firma_id = 1
INSERT INTO staj (firma_id, baslik) VALUES (1, 'Backend Stajyeri');           -- staj_id = 1
INSERT INTO ogrenci_yetkinlik (ogrenci_id, yetkinlik_id, duzey) VALUES (1, 1, 3);
INSERT INTO staj_yetkinlik (staj_id, yetkinlik_id, min_duzey) VALUES (1, 1, 4);
```

Silme testleri (Bölüm 6.5) veriyi değiştirdiği için en son çalıştırılır. Testler arasında temiz başlangıç gerekirse şema yeniden içe aktarılıp ön veri tekrar eklenir.

## 6. İlk negatif test fikirleri

**Durum** sütunu testler çalıştırıldıkça doldurulacaktır. Beklenen hata kodları MariaDB kodlarıdır:

| Kod | Anlamı |
|---|---|
| 1048 | Sütun NULL olamaz |
| 1062 | Tekrarlanan değer (UNIQUE / PK) |
| 1451 | Bağlı kayıt varken üst kayıt silinemez (FK) |
| 1452 | Var olmayan üst kayda referans (FK) |
| 4025 | CHECK kısıtı ihlali |

İlgili gereksinim kimlikleri [`gereksinimler.md`](gereksinimler.md) sürüm 1.1'e göredir.

### 6.1 Boş zorunlu alan

| Kimlik | Test | SQL / girdi | Beklenen sonuç | İlgili | Durum |
|---|---|---|---|---|---|
| DB-01 | Öğrenci adı NULL | `INSERT INTO ogrenci (ogrenci_no, ad, soyad, email) VALUES ('T0002', NULL, 'Test', 't2@example.com');` | Reddedilir (1048) | FR-01, NFR-01 | Çalıştırılmadı |
| DB-02 | Öğrenci soyadı hiç yazılmamış | `INSERT INTO ogrenci (ogrenci_no, ad, email) VALUES ('T0003', 'Ada', 't3@example.com');` | Reddedilmeli. **Risk:** katı mod kapalıysa `soyad = ''` ile kaydedilip yalnızca uyarı verebilir (Bölüm 2). | FR-01, NFR-01 | Çalıştırılmadı |
| DB-03 | Öğrenci adı boş metin | `INSERT INTO ogrenci (ogrenci_no, ad, soyad, email) VALUES ('T0004', '', 'Test', 't4@example.com');` | Veri tabanı kabul eder (NOT NULL boş metni engellemez). Uygulama katmanında reddedilmeli → UY-01 | NFR-04 | Çalıştırılmadı |
| DB-04 | Firmanın sektörü NULL | `INSERT INTO firma (ad, sektor_id) VALUES ('Deneme Ltd.', NULL);` | Reddedilir (1048) | FR-06 | Çalıştırılmadı |
| DB-05 | Staj başlığı NULL | `INSERT INTO staj (firma_id, baslik) VALUES (1, NULL);` | Reddedilir (1048) | FR-07 | Çalıştırılmadı |

### 6.2 Geçersiz yabancı anahtar

| Kimlik | Test | SQL / girdi | Beklenen sonuç | İlgili | Durum |
|---|---|---|---|---|---|
| DB-06 | Olmayan sektöre firma | `INSERT INTO firma (ad, sektor_id) VALUES ('Hayalet A.Ş.', 999);` | Reddedilir (1452) | AC-06.2 | Çalıştırılmadı |
| DB-07 | Olmayan firmaya staj | `INSERT INTO staj (firma_id, baslik) VALUES (999, 'Frontend Stajyeri');` | Reddedilir (1452) | FR-07 | Çalıştırılmadı |
| DB-08 | Olmayan öğrenciye yetkinlik | `INSERT INTO ogrenci_yetkinlik VALUES (999, 1, 3);` | Reddedilir (1452) | FR-02 | Çalıştırılmadı |
| DB-09 | Staja olmayan yetkinlik | `INSERT INTO staj_yetkinlik VALUES (1, 999, 3);` | Reddedilir (1452) | FR-08 | Çalıştırılmadı |

### 6.3 Tekrar eden kayıt

| Kimlik | Test | SQL / girdi | Beklenen sonuç | İlgili | Durum |
|---|---|---|---|---|---|
| DB-10 | Aynı öğrenci numarası | `INSERT INTO ogrenci (ogrenci_no, ad, soyad, email) VALUES ('T0001', 'Can', 'Deneme', 't9@example.com');` | Reddedilir (1062) | AC-01.4 | Çalıştırılmadı |
| DB-11 | Aynı e-posta, farklı büyük/küçük harf | `INSERT INTO ogrenci (ogrenci_no, ad, soyad, email) VALUES ('T0009', 'Can', 'Deneme', 'T1@EXAMPLE.COM');` | Reddedilir (1062); karşılaştırma büyük/küçük harf duyarsızdır | AC-01.4 | Çalıştırılmadı |
| DB-12 | Aynı yetkinlik adı, küçük harf | `INSERT INTO yetkinlik (ad) VALUES ('sql');` | Reddedilir (1062) | AC-04.4 | Çalıştırılmadı |
| DB-13 | Aynı firma adı | `INSERT INTO firma (ad, sektor_id) VALUES ('Örnek Yazılım A.Ş.', 1);` | Reddedilir (1062) | FR-06 | Çalıştırılmadı |
| DB-14 | Türkçe büyük harfle aynı sektör | `INSERT INTO sektor (ad) VALUES ('YAZILIM');` | İş kuralına göre reddedilmeli. **Risk:** `utf8mb4_unicode_ci` "ı" ile "I" harfini aynı saymayabilir; kayıt yeni sektör olarak kabul edilirse ekibe bildirilecek. | FR-05, NFR-09 | Çalıştırılmadı |
| DB-15 | Aynı öğrenci–yetkinlik çifti | `INSERT INTO ogrenci_yetkinlik VALUES (1, 1, 5);` | Reddedilir (1062) | AC-02.3 | Çalıştırılmadı |
| DB-16 | Aynı staj–yetkinlik çifti | `INSERT INTO staj_yetkinlik VALUES (1, 1, 2);` | Reddedilir (1062) | AC-08.4 | Çalıştırılmadı |

### 6.4 Değer aralığı ve iş kuralları (CHECK)

| Kimlik | Test | SQL / girdi | Beklenen sonuç | İlgili | Durum |
|---|---|---|---|---|---|
| DB-17 | Öğrenci düzeyi 0 ve 6 | `INSERT INTO ogrenci_yetkinlik VALUES (1, 2, 0);` ve aynısı `6` ile | İkisi de reddedilir (4025) | AC-02.4 | Çalıştırılmadı |
| DB-18 | Düzey güncellemesi 9 | `UPDATE ogrenci_yetkinlik SET duzey = 9 WHERE ogrenci_id = 1 AND yetkinlik_id = 1;` | Reddedilir (4025); kayıt 3 olarak kalır | AC-02.4 | Çalıştırılmadı |
| DB-19 | Minimum düzey 6 | `INSERT INTO staj_yetkinlik VALUES (1, 2, 6);` | Reddedilir (4025) | AC-08.2 | Çalıştırılmadı |
| DB-20 | Sınıf 0 ve 7 | `INSERT INTO ogrenci (ogrenci_no, ad, soyad, email, sinif) VALUES ('T0005', 'Ali', 'Test', 't5@example.com', 7);` ve aynısı `0` ile | İkisi de reddedilir (4025) | NFR-01 | Çalıştırılmadı |
| DB-21 | Geçersiz staj durumu | `INSERT INTO staj (firma_id, baslik, durum) VALUES (1, 'Test Stajı', 'beklemede');` | Reddedilir (4025) | AC-07.4 | Çalıştırılmadı |
| DB-22 | Ters tarih aralığı | `INSERT INTO staj (firma_id, baslik, baslangic_tarihi, bitis_tarihi) VALUES (1, 'Yaz Stajı', '2027-08-15', '2027-06-15');` | Reddedilir (4025) | AC-07.3 | Çalıştırılmadı |
| DB-23 | Negatif düzey | `INSERT INTO ogrenci_yetkinlik VALUES (1, 2, -1);` | Reddedilmeli. Katı mod kapalıysa `-1` önce `0`'a çekilir, ardından CHECK yakalar; hata kodu 1264 veya 4025 olabilir. Kayıt saklanmamalı. | AC-02.4 | Çalıştırılmadı |
| DB-24 | Sütundan uzun öğrenci no | `INSERT INTO ogrenci (ogrenci_no, ad, soyad, email) VALUES ('T00000000000000000001', 'Uzun', 'Test', 't6@example.com');` (21 karakter, sınır 20) | Reddedilmeli. **Risk:** katı mod kapalıysa 20 karaktere kesilip kaydedilebilir. | NFR-01 | Çalıştırılmadı |

### 6.5 Silme davranışı (en son çalıştırılır)

| Kimlik | Test | SQL / girdi | Beklenen sonuç | İlgili | Durum |
|---|---|---|---|---|---|
| DB-25 | Firması olan sektörü silme | `DELETE FROM sektor WHERE sektor_id = 1;` | Reddedilir (1451) | AC-05.2, NFR-02 | Çalıştırılmadı |
| DB-26 | Kullanımdaki yetkinliği silme | `DELETE FROM yetkinlik WHERE yetkinlik_id = 1;` | Reddedilir (1451) | AC-04.3, NFR-02 | Çalıştırılmadı |
| DB-27 | Öğrenci silinince yetkinlikleri | `DELETE FROM ogrenci WHERE ogrenci_id = 1;` → `SELECT COUNT(*) FROM ogrenci_yetkinlik WHERE ogrenci_id = 1;` | Silme başarılı, sayım 0 (CASCADE) | NFR-02 | Çalıştırılmadı |
| DB-28 | Firma silinince staj ve beklentileri | `DELETE FROM firma WHERE firma_id = 1;` → `SELECT COUNT(*) FROM staj WHERE firma_id = 1;` ve `SELECT COUNT(*) FROM staj_yetkinlik WHERE staj_id = 1;` | Silme başarılı, iki sayım da 0 (CASCADE) | AC-06.4, NFR-02 | Çalıştırılmadı |

### 6.6 Uygulama ve güvenlik testleri (ekranlar hazır olunca)

| Kimlik | Test | Girdi | Beklenen sonuç | İlgili | Durum |
|---|---|---|---|---|---|
| UY-01 | Boş zorunlu alan | Öğrenci formunda ad alanı boş veya yalnızca boşluk | Kayıt yapılmaz; hangi alanın eksik olduğu anlaşılır biçimde yazılır | NFR-04 | Ekran yok |
| UY-02 | Hatalı e-posta | `ada.example.com` | Kayıt yapılmaz; e-posta biçim hatası gösterilir | NFR-04 | Ekran yok |
| UY-03 | Formdan geçersiz düzey | Düzey alanına 6 (veya tarayıcı aracıyla gönderilen 6) | Kayıt yapılmaz; 1–5 aralığı hatırlatılır | AC-02.4, NFR-04 | Ekran yok |
| UY-04 | Formdan ters tarih | Bitiş tarihi başlangıçtan önce | Kayıt yapılmaz; açıklayıcı mesaj gösterilir | AC-07.3, NFR-04 | Ekran yok |
| UY-05 | Tekrar kayıt mesajı | Var olan öğrenci numarasıyla kayıt | Teknik hata (SQLSTATE, tablo adı) yerine kullanıcı dostu mesaj | AC-01.4, NFR-04 | Ekran yok |
| UY-06 | Bağlı kaydı silme mesajı | Firması olan sektörü ekrandan silme | Silinmez; neden silinemediği açıklanır | AC-05.2 | Ekran yok |
| GV-01 | SQL enjeksiyonu (arama/filtre) | `' OR '1'='1` | Tüm kayıtlar dönmez; sorgu yapısı bozulmaz | NFR-06 | Ekran yok |
| GV-02 | SQL enjeksiyonu (form) | `'; DROP TABLE ogrenci; --` | Metin olduğu gibi saklanır veya reddedilir; tablo silinmez | NFR-06 | Ekran yok |
| GV-03 | HTML/JS girdisi | Firma adı: `<script>alert(1)</script>` | Listede metin olarak görünür, betik çalışmaz (`htmlspecialchars`) | NFR-06 | Ekran yok |
| GV-04 | Kod incelemesi | `src/` ve `public/` altındaki tüm SQL'ler | Kullanıcı girdisi SQL metnine birleştirilmemiş; `prepare()` + `execute()` kullanılmış | NFR-06 | Çalıştırılmadı |
| GV-05 | Veri gizliliği | Seed ve demo verileri | Gerçek ad, öğrenci no veya kişisel e-posta yok | NFR-05 | Çalıştırılmadı |
| TR-01 | Türkçe karakter | `Işık Ölçüm Çözümleri` ekle, listele, güncelle, ara | Karakterler bozulmaz; aramada bulunur | NFR-09 | Ekran yok |

## 7. Hata kaydı

Kalan her test için GitHub'da issue açılır. Başlık biçimi: `[Hata] DB-xx: kısa açıklama`. Issue gövdesinde test kimliği, adımlar, beklenen ve gerçekleşen sonuç, hata kodu veya ekran görüntüsü yer alır. Düzeltme PR'ı ilgili issue'ya bağlanır ve test yeniden çalıştırılır.

## 8. İzlenebilirlik matrisi (P2-16'da tamamlanacak)

| FR / NFR | Testler | Sonuç |
|---|---|---|
| FR-01 Öğrenci profili | DB-01, DB-02, DB-10, DB-11, UY-01, UY-02, UY-05 | — |
| FR-02 Öğrenci yetkinlik | DB-08, DB-15, DB-17, DB-18, DB-23, UY-03 | — |
| FR-03 Profil özeti | (RP testleri eklenecek) | — |
| FR-04 Yetkinlik sözlüğü | DB-12, DB-26 | — |
| FR-05 Sektör | DB-14, DB-25, UY-06 | — |
| FR-06 Firma | DB-04, DB-06, DB-13, DB-28 | — |
| FR-07 Staj | DB-05, DB-07, DB-21, DB-22, UY-04 | — |
| FR-08 Staj yetkinlik | DB-09, DB-16, DB-19 | — |
| FR-09 – FR-13 Karşılaştırma, filtre, raporlar | (RP testleri P2-11 / P2-12 sonrası eklenecek) | — |
| NFR-01 Veri bütünlüğü | DB-01 – DB-24 | — |
| NFR-02 İlişkisel silme | DB-25 – DB-28 | — |
| NFR-04 Girdi doğrulama | DB-03, UY-01 – UY-05 | — |
| NFR-05 Gizlilik | GV-05 | — |
| NFR-06 Güvenli sorgu | GV-01 – GV-04 | — |
| NFR-09 Karakter kodlaması | DB-14, TR-01 | — |

## 9. Açık noktalar

- XAMPP'ta katı mod kapalı olduğu için DB-02, DB-23 ve DB-24 beklenenden farklı sonuç verebilir. Sonuca göre `src/db.php`'de oturum `sql_mode` ayarı ekibe önerilecektir.
- DB-14'teki Türkçe "ı/I" karşılaştırması gerçek bir veri tutarlılığı riski olabilir; sonuç ekiple paylaşılacaktır.
- Boş metin ve e-posta biçimi veri tabanında yakalanmadığı için uygulama katmanı doğrulaması (UY-01, UY-02) zorunludur.
- Testler `schema-taslak.sql` üzerine yazılmıştır; P2-06 / P2-08'de kesin şema gelince kimlikler ve SQL'ler gözden geçirilecektir.

## 10. Kaynaklar

- Proje 2 Teknik Proje Dokümanı, bölüm 5, 8, 12.
- Dört Haftalık Eylem Planı, P2-13, P2-14, P2-15, P2-16 ve Bölüm 5 (izlenebilirlik örneği).
- `sql/schema-taslak.sql`, [`gereksinimler.md`](gereksinimler.md) ve [`veri-sozlugu.md`](veri-sozlugu.md) (sürüm 1.1), GitHub Issue #1.

## 11. Sürüm geçmişi

| Sürüm | Değişiklik |
|---|---|
| 1.0 | İlk iskelet: test ortamı, test türleri, giriş/çıkış ölçütleri, ön veri, 28 DB testi ve 12 uygulama/güvenlik test fikri, izlenebilirlik matrisi taslağı. |
