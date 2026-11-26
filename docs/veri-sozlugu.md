# Staj ve Sektör Yetkinlik Haritası

## P2-03 — Varlıklar ve Veri Sözlüğü

**Görev:** Issue #2 · **Rol:** Analist · **Hazırlayan:** Hilal Akça  
**Sürüm:** 1.1 — ekip incelemesine sunulan revize taslak

## 1. Amaç ve kapsam

Hafta 1 `sql/schema-taslak.sql` dosyasındaki yedi tablo ve 33 alan belgelenmiştir. Veri tabanı: `staj_yetkinlik`; motor: InnoDB; varsayılan karakter grubu: utf8mb4; karşılaştırma: utf8mb4_unicode_ci. Bu belge kesin şema değil, mevcut taslağın açıklamasıdır.

**Gösterim:** PK = birincil anahtar; FK = yabancı anahtar; UNIQUE = benzersizlik kısıtı; Evet = NOT NULL; Hayır = NULL kabul edilir. AUTO_INCREMENT alanları zorunludur ancak kullanıcı tarafından girilmesi gerekmez. "Örnek" sütunundaki değerler tamamen sentetiktir; gerçek kişi veya firma verisi değildir.

## 2. Varlık özeti

| Tablo             | Varlık türü | Amaç                                   | İlgili FR                     |
|-------------------|-------------|----------------------------------------|-------------------------------|
| `sektor`          | Ana         | Firmaların bağlı olduğu sektörler      | FR-05, FR-10, FR-13           |
| `yetkinlik`       | Ana         | Ortak teknoloji ve yetkinlik sözlüğü   | FR-04, FR-11                  |
| `ogrenci`         | Ana         | Sentetik/anonim öğrenci profilleri     | FR-01, FR-03                  |
| `firma`           | Ana         | Staj veren firmalar                    | FR-06, FR-10                  |
| `staj`            | Ana         | Firmaya bağlı staj fırsatları          | FR-07, FR-09, FR-10           |
| `ogrenci_yetkinlik` | İlişki (N:M) | Öğrenci–yetkinlik ve düzey           | FR-02, FR-03, FR-09, FR-12, FR-13 |
| `staj_yetkinlik`  | İlişki (N:M) | Staj–beklenen yetkinlik ve minimum düzey | FR-08, FR-09, FR-11, FR-12, FR-13 |

## 3. Varlıklar ve alanlar

### 3.1. `sektor`

Firmaların bağlı olduğu sektörler.

| Alan      | Veri tipi    | Zorunlu mu? | Anahtar | Açıklama / kısıt     | Örnek                         |
|-----------|--------------|-------------|---------|----------------------|-------------------------------|
| sektor_id | INT UNSIGNED | Evet        | PK      | AUTO_INCREMENT       | 1                             |
| ad        | VARCHAR(100) | Evet        | UNIQUE  | Benzersiz sektör adı | Yazılım                       |
| aciklama  | VARCHAR(255) | Hayır       | —       | Sektör açıklaması    | Yazılım ve bilişim hizmetleri |

### 3.2. `yetkinlik`

Ortak teknoloji ve yetkinlik sözlüğü.

| Alan         | Veri tipi    | Zorunlu mu? | Anahtar | Açıklama / kısıt        | Örnek                           |
|--------------|--------------|-------------|---------|-------------------------|---------------------------------|
| yetkinlik_id | INT UNSIGNED | Evet        | PK      | AUTO_INCREMENT          | 1                               |
| ad           | VARCHAR(100) | Evet        | UNIQUE  | Benzersiz yetkinlik adı | SQL                             |
| kategori     | VARCHAR(50)  | Hayır       | —       | Yetkinlik kategorisi    | Veri tabanı                     |
| aciklama     | VARCHAR(255) | Hayır       | —       | Yetkinlik açıklaması    | İlişkisel veri tabanı sorgulama |

### 3.3. `ogrenci`

Sentetik veya anonim öğrenci profilleri.

| Alan       | Veri tipi        | Zorunlu mu? | Anahtar | Açıklama / kısıt           | Örnek                   |
|------------|------------------|-------------|---------|----------------------------|-------------------------|
| ogrenci_id | INT UNSIGNED     | Evet        | PK      | AUTO_INCREMENT             | 1                       |
| ogrenci_no | VARCHAR(20)      | Evet        | UNIQUE  | Benzersiz öğrenci numarası | S0001                   |
| ad         | VARCHAR(50)      | Evet        | —       | Öğrenci adı                | Ada                     |
| soyad      | VARCHAR(50)      | Evet        | —       | Öğrenci soyadı             | Örnek                   |
| email      | VARCHAR(100)     | Evet        | UNIQUE  | Benzersiz e-posta          | ada.ornek@example.com   |
| bolum      | VARCHAR(100)     | Hayır       | —       | Bölüm adı                  | Bilgisayar Mühendisliği |
| sinif      | TINYINT UNSIGNED | Hayır       | —       | NULL veya 1–6              | 3                       |

### 3.4. `firma`

Staj veren firmalar.

| Alan       | Veri tipi    | Zorunlu mu? | Anahtar | Açıklama / kısıt    | Örnek                              |
|------------|--------------|-------------|---------|---------------------|------------------------------------|
| firma_id   | INT UNSIGNED | Evet        | PK      | AUTO_INCREMENT      | 1                                  |
| ad         | VARCHAR(150) | Evet        | UNIQUE  | Benzersiz firma adı | Örnek Yazılım A.Ş.                 |
| sektor_id  | INT UNSIGNED | Evet        | FK      | sektor.sektor_id    | 1                                  |
| sehir      | VARCHAR(80)  | Hayır       | —       | Firma şehri         | Ankara                             |
| web_sitesi | VARCHAR(200) | Hayır       | —       | Web sitesi adresi   | https://www.ornek-yazilim.example  |

### 3.5. `staj`

Firmaya bağlı staj fırsatları.

| Alan             | Veri tipi    | Zorunlu mu? | Anahtar | Açıklama / kısıt                                                | Örnek                        |
|------------------|--------------|-------------|---------|-----------------------------------------------------------------|------------------------------|
| staj_id          | INT UNSIGNED | Evet        | PK      | AUTO_INCREMENT                                                  | 1                            |
| firma_id         | INT UNSIGNED | Evet        | FK      | firma.firma_id                                                  | 1                            |
| baslik           | VARCHAR(150) | Evet        | —       | Pozisyon başlığı                                                | Backend Stajyeri             |
| aciklama         | TEXT         | Hayır       | —       | Pozisyon açıklaması                                             | Web servisleri geliştirme    |
| alan             | VARCHAR(80)  | Hayır       | —       | Çalışma alanı (serbest metin)                                   | backend                      |
| baslangic_tarihi | DATE         | Hayır       | —       | Başlangıç tarihi                                                | 2027-06-15                   |
| bitis_tarihi     | DATE         | Hayır       | —       | Bitiş tarihi; iki tarih de varsa başlangıçtan önce olamaz       | 2027-08-15                   |
| durum            | VARCHAR(10)  | Evet        | —       | acik veya kapali; varsayılan acik (değerler Türkçe karaktersiz saklanır) | acik                |

### 3.6. `ogrenci_yetkinlik`

Öğrenci ile yetkinlik arasındaki çoktan çoğa ilişki.

| Alan         | Veri tipi        | Zorunlu mu? | Anahtar          | Açıklama / kısıt         | Örnek |
|--------------|------------------|-------------|------------------|--------------------------|-------|
| ogrenci_id   | INT UNSIGNED     | Evet        | PK (bileşik), FK | ogrenci.ogrenci_id       | 1     |
| yetkinlik_id | INT UNSIGNED     | Evet        | PK (bileşik), FK | yetkinlik.yetkinlik_id   | 1     |
| duzey        | TINYINT UNSIGNED | Evet        | —                | 1–5 arası öğrenci düzeyi | 4     |

### 3.7. `staj_yetkinlik`

Staj ile beklenen yetkinlik arasındaki çoktan çoğa ilişki.

| Alan         | Veri tipi        | Zorunlu mu? | Anahtar          | Açıklama / kısıt        | Örnek |
|--------------|------------------|-------------|------------------|-------------------------|-------|
| staj_id      | INT UNSIGNED     | Evet        | PK (bileşik), FK | staj.staj_id            | 1     |
| yetkinlik_id | INT UNSIGNED     | Evet        | PK (bileşik), FK | yetkinlik.yetkinlik_id  | 1     |
| min_duzey    | TINYINT UNSIGNED | Evet        | —                | 1–5 arası minimum düzey | 3     |

**Alan sayısı kontrolü:** 3 + 4 + 7 + 5 + 8 + 3 + 3 = 33.

## 4. İlişkiler ve referans bütünlüğü

| Üst tablo | Bağlı tablo / FK               | Kardinalite | ON DELETE | ON UPDATE |
|-----------|--------------------------------|-------------|-----------|-----------|
| sektor    | firma.sektor_id                | 1 : 0..N    | RESTRICT  | CASCADE   |
| firma     | staj.firma_id                  | 1 : 0..N    | CASCADE   | CASCADE   |
| ogrenci   | ogrenci_yetkinlik.ogrenci_id   | 1 : 0..N    | CASCADE   | CASCADE   |
| yetkinlik | ogrenci_yetkinlik.yetkinlik_id | 1 : 0..N    | RESTRICT  | CASCADE   |
| staj      | staj_yetkinlik.staj_id         | 1 : 0..N    | CASCADE   | CASCADE   |
| yetkinlik | staj_yetkinlik.yetkinlik_id    | 1 : 0..N    | RESTRICT  | CASCADE   |

Her bağlı kayıt tam bir üst kayda referans verir. Öğrenci–Yetkinlik ve Staj–Yetkinlik ilişkileri ara tablolarla çoktan çoğa modellenir. Ara tablolardaki iki kimlik birlikte birincil anahtardır; aynı çift tekrar eklenemez.

**Çoktan çoğa ilişkiler (özet):**

- Öğrenci (N) — (M) Yetkinlik: `ogrenci_yetkinlik`, ilişki özelliği `duzey`.
- Staj (N) — (M) Yetkinlik: `staj_yetkinlik`, ilişki özelliği `min_duzey`.

**Sektör bağlantısı:** Sektör ile staj arasında doğrudan alan yoktur; ilişki `staj → firma → sektor` zinciriyle kurulur. Sektör bazlı filtre ve karşılaştırma (FR-10, FR-13) bu üç tablonun JOIN'i ile yapılır.

## 5. Kısıt özeti

| Kısıt türü           | Tablo.alan                                                                                         |
|----------------------|----------------------------------------------------------------------------------------------------|
| UNIQUE               | sektor.ad, yetkinlik.ad, ogrenci.ogrenci_no, ogrenci.email, firma.ad                               |
| Bileşik PK           | ogrenci_yetkinlik (ogrenci_id, yetkinlik_id); staj_yetkinlik (staj_id, yetkinlik_id)               |
| Değer aralığı        | ogrenci.sinif: NULL veya 1–6; ogrenci_yetkinlik.duzey: 1–5; staj_yetkinlik.min_duzey: 1–5          |
| Değer kümesi         | staj.durum: acik veya kapali                                                                       |
| Alanlar arası kural  | staj: bitis_tarihi, baslangic_tarihi'nden önce olamaz (iki tarih de doluysa)                       |
| Varsayılan değer     | staj.durum = acik                                                                                  |

## 6. İş kuralları ve açık noktalar

- Öğrenci numarası, öğrenci e-postası, sektör adı, firma adı ve yetkinlik adı kendi tablolarında benzersizdir. Karşılaştırma kuralı utf8mb4_unicode_ci (büyük/küçük harf duyarsız) olduğundan "SQL" ve "sql" aynı değer sayılır.
- Öğrenci sınıfı boş olabilir; girilirse 1–6 arasındadır. Yetkinlik düzeyleri 1–5 arasındadır. Staj durumu acik/kapali değerlerinden biridir. İki staj tarihi de girilirse bitiş başlangıçtan önce olamaz.
- NOT NULL tek başına boş metni veya hatalı e-posta biçimini engellemez; uygulama doğrulaması P2-02 kapsamında (NFR-04) gereklidir.
- Firma silinirse bağlı stajlar ve onların yetkinlik ilişkileri de silinir. Bu mevcut taslak davranışıdır; kesin şema öncesinde ekipçe değerlendirilmelidir.
- Bir yetkinlik herhangi bir öğrenciye veya staja bağlıysa silinemez (RESTRICT); önce ilgili atamalar kaldırılmalıdır.
- `staj.alan`, `yetkinlik.kategori`, `ogrenci.bolum` ve `firma.sehir` serbest metindir; aynı değer farklı yazımlarla girilirse filtreler (FR-10) tutarsız sonuç verebilir. Kontrollü değer listesi veya ayrı tablo kullanımı ekipçe değerlendirilmelidir.
- Sayısal aralık ve değer kümesi kısıtlarının kullanılan XAMPP/MySQL/MariaDB sürümünde gerçekten uygulandığı NFR-01 testiyle doğrulanmalıdır.
- Filtreleme performansı için birincil/yabancı anahtar ve UNIQUE alanlar zaten indekslidir; `staj.alan` ve `staj.durum` için ek indeks ancak NFR-03 ölçümü gerektirirse düşünülmelidir.
- Issue #2 altı varlığı asgari olarak saymaktadır; mevcut SQL ve pozisyon beklentisi gereksinimi nedeniyle staj_yetkinlik de dahil edilmiştir.
- Şema, P2-04 ER diyagramı v1 ve P2-06 şema v1 netleşince güncellenecektir. Bu belge SQL dosyasını değiştirmez.

## 7. Normalizasyon ön notu

Kesin normalizasyon analizi P2-07 kapsamındadır; aşağıdakiler ön gözlemdir.

- **1NF:** Tüm alanlar tek değerlidir; tekrar eden grup yoktur. Çoktan çoğa ilişkiler ara tablolarla çözülmüştür.
- **2NF:** Bileşik anahtarlı iki tabloda (`ogrenci_yetkinlik.duzey`, `staj_yetkinlik.min_duzey`) alan anahtarın tamamına bağlıdır; kısmi bağımlılık görülmemiştir.
- **3NF:** Sektör bilgisi yalnızca `sektor` tablosunda tutulur, `firma` yalnızca `sektor_id` taşır; geçişli bağımlılık görülmemiştir.
- **Dikkat edilecek nokta:** Serbest metin alanlar (Bölüm 6) 3NF'yi bozmaz, ancak veri tutarlılığı riski taşır.

## 8. SQL ile karşılaştırma kontrol listesi

Belge `sql/schema-taslak.sql` ile aşağıdaki maddeler üzerinden doğrulanmalıdır:

- [ ] Yedi tablo adı ve alan sayıları (33) eşleşiyor.
- [ ] Veri tipleri ve uzunlukları eşleşiyor (özellikle VARCHAR uzunlukları, UNSIGNED işaretleri).
- [ ] NOT NULL / NULL durumları eşleşiyor.
- [ ] UNIQUE ve bileşik PK tanımları eşleşiyor.
- [ ] Altı yabancı anahtarın ON DELETE / ON UPDATE kuralları Bölüm 4 ile eşleşiyor.
- [ ] Sınıf, düzey, minimum düzey, durum ve tarih sırası kısıtları SQL'de tanımlı.
- [ ] `staj.durum` varsayılanı `acik`.

## 9. Kaynaklar

- `sql/schema-taslak.sql` (Hafta 1, paylaşılan SQL içeriği).
- Proje 2 Teknik Proje Dokümanı, bölümler 4–6 ve 8.
- Dört Haftalık Eylem Planı, P2-03, P2-04, P2-06, P2-07; GitHub Issue #2.
- `gereksinimler.md` ve `kullanici-senaryolari.md`.

## 10. Sürüm geçmişi

| Sürüm | Değişiklik |
|-------|-----------|
| 1.0 | İlk taslak: yedi tablo, 33 alan, ilişkiler ve iş kuralları. |
| 1.1 | Varlık özeti ve FR eşleşmesi; örnek sentetik değerler; kısıt özeti; sektör bağlantısı açıklaması; normalizasyon ön notu; SQL kontrol listesi; "Hafta 2 ER diyagramı" ifadesi eylem planına uygun düzeltildi (ER v1 = P2-04, şema v1 = P2-06); serbest metin alan riski ve CHECK sürüm notu eklendi. |
