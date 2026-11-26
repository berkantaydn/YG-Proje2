# Staj ve Sektör Yetkinlik Haritası

## P2-02 — Gereksinimler ve Kabul Kriterleri

**Görev:** Issue #2 · **Rol:** Analist · **Hazırlayan:** Hilal Akça  
**Sürüm:** 1.1 — ekip incelemesine sunulan revize taslak

## 1. Amaç ve kapsam

Öğrenci yetkinlikleri ile staj ve sektör beklentilerini karşılaştıran sistemin işlevlerini ve kalite koşullarını tanımlar. CRUD işlemleri ilişkisel veri tabanında kalıcı olarak gerçekleştirilir. US kimlikleri `kullanici-senaryolari.md` belgesine aittir.

**Kimlik biçimi:** `FR-xx` fonksiyonel gereksinim, `NFR-xx` fonksiyonel olmayan gereksinim, `AC-xx.y` ilgili FR'nin y. kabul kriteri. Kabul kriterleri Hafta 4'te gereksinim–test izlenebilirlik tablosuna (P2-16) doğrudan taşınabilsin diye numaralandırılmıştır.

**Kapsam özeti:** 13 FR ve 9 NFR; Issue #2 asgari ölçütleri (en az 10 FR, 4 NFR, her FR için gözlenebilir kabul kriteri) karşılanmaktadır.

## 2. Fonksiyonel gereksinimler (FR)

### FR-01 — Öğrenci profili yönetimi

- **İlgili hikâye:** US-01
- **Gereksinim:** Öğrenci kayıtları oluşturulabilmeli, görüntülenebilmeli, güncellenebilmeli ve silinebilmelidir. Öğrenci numarası, ad, soyad ve e-posta zorunlu alanlardır.
- **Kabul kriterleri:**
  - **AC-01.1** Geçerli sentetik öğrenci kaydı eklenir ve listede görülür.
  - **AC-01.2** Bölüm bilgisi güncellenir ve güncel değer listede görülür.
  - **AC-01.3** Kayıt silindiğinde listeden kalkar.
  - **AC-01.4** Var olan öğrenci numarası veya e-posta ile ikinci kayıt reddedilir.

### FR-02 — Öğrenci yetkinlik yönetimi

- **İlgili hikâye:** US-02
- **Gereksinim:** Öğrenciye sözlükten yetkinlik atanabilmeli, düzeyi 1–5 arasında güncellenebilmeli ve atama kaldırılabilmelidir.
- **Kabul kriterleri:**
  - **AC-02.1** SQL düzeyi 2 olarak eklenip 4 olarak güncellendiğinde profil 4 gösterir.
  - **AC-02.2** Atama kaldırıldığında profilde görünmez.
  - **AC-02.3** Aynı yetkinlik aynı öğrenciye ikinci kez atanmak istendiğinde işlem reddedilir.
  - **AC-02.4** 0 veya 6 düzeyi girildiğinde işlem reddedilir ve kayıt saklanmaz.

### FR-03 — Profil özeti

- **İlgili hikâye:** US-02
- **Gereksinim:** Seçilen öğrencinin yetkinlikleri ve düzeyleri gösterilmelidir.
- **Kabul kriterleri:**
  - **AC-03.1** SQL 4 ve PHP 3 kayıtları olan öğrenci seçildiğinde iki yetkinlik doğru düzeyleriyle görünür.
  - **AC-03.2** Hiç yetkinliği olmayan öğrenci seçildiğinde boş liste yerine "yetkinlik kaydı yok" benzeri açıklayıcı bir mesaj gösterilir.

### FR-04 — Yetkinlik sözlüğü

- **İlgili hikâye:** US-10
- **Gereksinim:** Yetkinlik kayıtları oluşturulabilmeli, listelenebilmeli, güncellenebilmeli ve ilişki kısıtları izin verdiğinde silinebilmelidir.
- **Kabul kriterleri:**
  - **AC-04.1** Yeni SQL kaydı listelenir.
  - **AC-04.2** Kategori güncellemesi listede görünür.
  - **AC-04.3** Bir öğrenciye veya staja bağlı yetkinlik silinmek istendiğinde işlem reddedilir ve açıklayıcı mesaj gösterilir.
  - **AC-04.4** Aynı adlı ikinci yetkinlik eklenemez.

### FR-05 — Sektör yönetimi

- **İlgili hikâye:** US-03
- **Gereksinim:** Sektör kayıtları oluşturulabilmeli, listelenebilmeli, güncellenebilmeli ve ilişki kısıtları izin verdiğinde silinebilmelidir.
- **Kabul kriterleri:**
  - **AC-05.1** Yazılım sektörü eklenir ve açıklaması güncellenir.
  - **AC-05.2** Bağlı firma varken sektör silme işlemi reddedilir.
  - **AC-05.3** Bağlı firması olmayan sektör silinebilir.

### FR-06 — Firma yönetimi

- **İlgili hikâye:** US-03
- **Gereksinim:** Firmalar bir sektöre bağlı olarak oluşturulabilmeli, listelenebilmeli, güncellenebilmeli ve silinebilmelidir.
- **Kabul kriterleri:**
  - **AC-06.1** Geçerli sektöre bağlı firma eklenir ve şehir bilgisi güncellenir.
  - **AC-06.2** Olmayan sektör kimliğiyle kayıt reddedilir.
  - **AC-06.3** Stajı olmayan firma silinebilir.
  - **AC-06.4** Stajı olan firma silindiğinde bağlı stajlar ve onların yetkinlik beklentileri de silinir; arayüz, silmeden önce bu sonucu belirten bir onay ister (onay adımı ekip onayına sunulan öneridir, bkz. Bölüm 4).

### FR-07 — Staj yönetimi

- **İlgili hikâye:** US-04
- **Gereksinim:** Firmaya bağlı staj kayıtları oluşturulabilmeli, listelenebilmeli, güncellenebilmeli ve silinebilmelidir.
- **Kabul kriterleri:**
  - **AC-07.1** Geçerli firmaya staj eklenir, durum kapalı olarak güncellenir ve listede görülür.
  - **AC-07.2** Kayıt silindiğinde listeden kalkar.
  - **AC-07.3** Bitiş tarihi başlangıç tarihinden önce olan kayıt reddedilir.
  - **AC-07.4** Durum yalnızca acik veya kapali olabilir; başka değer kabul edilmez.

### FR-08 — Staj yetkinlik yönetimi

- **İlgili hikâye:** US-05
- **Gereksinim:** Staj için gerekli yetkinlikler ve 1–5 arası minimum düzeyler eklenebilmeli, güncellenebilmeli ve kaldırılabilmelidir.
- **Kabul kriterleri:**
  - **AC-08.1** SQL minimum 3 eklenip 4 yapılır ve güncel değer görünür.
  - **AC-08.2** 6 değeri reddedilir.
  - **AC-08.3** Atama kaldırıldığında beklenti listesinde görünmez.
  - **AC-08.4** Aynı yetkinlik aynı staja ikinci kez eklenemez.

### FR-09 — Yetkinlik boşluğu analizi (öğrenci – staj)

- **İlgili hikâye:** US-06
- **Gereksinim:** Seçilen öğrenci ile stajın beklentileri karşılaştırılarak karşılanan, yetersiz ve bulunmayan yetkinlikler gösterilmelidir. Tanımlar:
  - **Karşılanan:** öğrencinin düzeyi stajın minimum düzeyine eşit veya ondan yüksek.
  - **Yetersiz:** öğrencide yetkinlik kaydı var, ancak düzeyi minimum düzeyin altında.
  - **Bulunmayan:** öğrencide o yetkinlik için hiç kayıt yok.
- **Kabul kriterleri:**
  - **AC-09.1** Staj SQL 4, PHP 3, Git 2 beklerken öğrenci SQL 2, PHP 3 ve Git kaydı yoksa sırasıyla yetersiz, karşılanan ve bulunmayan sonuçları gösterilir.
  - **AC-09.2** En az iki gerekli yetkinlik eksikse (yetersiz veya bulunmayan) bunlar ayrı satırlarda listelenir.
  - **AC-09.3** Beklenen yetkinliği tanımlanmamış staj seçildiğinde açıklayıcı mesaj gösterilir.

### FR-10 — Filtreleme

- **İlgili hikâye:** US-07
- **Gereksinim:** Stajlar teknoloji/yetkinlik, alan, firma, sektör ve beklenen minimum düzeye göre filtrelenebilmelidir. Filtreler birlikte uygulandığında yalnızca tüm koşulları karşılayan stajlar listelenir.
- **Kabul kriterleri:**
  - **AC-10.1** SQL, backend alanı, A firması ve minimum düzey 4 seçildiğinde yalnızca tüm seçili koşulları karşılayan stajlar görünür.
  - **AC-10.2** Filtre temizlenince liste eski haline döner.
  - **AC-10.3** Yazılım sektörü seçildiğinde yalnızca o sektördeki firmaların stajları görünür.
  - **AC-10.4** Koşulları sağlayan staj yoksa "sonuç bulunamadı" mesajı gösterilir.

### FR-11 — Talep edilen yetkinlikler raporu

- **İlgili hikâye:** US-08
- **Gereksinim:** Yetkinlikler, talep eden farklı staj sayısına göre azalan sırada özetlenmelidir.
- **Kabul kriterleri:**
  - **AC-11.1** İki staj SQL, bir staj PHP istiyorsa rapor SQL 2 ve PHP 1 gösterir; SQL önce gelir.
  - **AC-11.2** Talep sayısı eşit olan yetkinlikler ad sırasına göre listelenir (sıralama her çalıştırmada aynıdır).

### FR-12 — Öğrenci-yetkinlik boşlukları raporu

- **İlgili hikâye:** US-09
- **Gereksinim:** Seçilen staj için öğrencilerin karşılamadığı yetkinlikler toplu gösterilmelidir; her eksik yetkinlik için eksiği olan öğrenci sayısı ve listesi görülebilmelidir.
- **Kabul kriterleri:**
  - **AC-12.1** SQL 4 isteyen staj için SQL 2 olan öğrenci ve SQL kaydı olmayan öğrenci eksik olarak görünür.
  - **AC-12.2** SQL 4 olan öğrenci SQL eksiği olarak görünmez.

### FR-13 — Sektör bazlı yetkinlik karşılaştırması *(yeni, ekip onayına sunulan öneri)*

- **İlgili hikâye:** US-06 (`kullanici-senaryolari.md` ile eşleşmesi doğrulanmalı)
- **Gereksinim:** Seçilen öğrencinin yetkinlikleri, seçilen sektördeki firmaların stajlarının talep ettiği yetkinliklerle karşılaştırılmalıdır. Her yetkinlik için sektörde talep eden staj sayısı, sektör beklentisi (o yetkinlik için sektördeki en yüksek minimum düzey), öğrencinin düzeyi ve durumu (karşılanan / yetersiz / bulunmayan) gösterilir. Durum tanımları FR-09 ile aynıdır.
- **Gerekçe:** Teknik dokümanda zorunlu işlev "öğrenci yetkinlikleri ile **sektör** beklentilerinin karşılaştırılması"dır; eylem planındaki P2-12 çıktısı da "yetkinlik–sektör karşılaştırması"dır. FR-09 yalnızca tek staj düzeyinde karşılaştırma yaptığı için sektör düzeyi ayrı bir gereksinim olarak eklenmiştir.
- **Kabul kriterleri:**
  - **AC-13.1** Yazılım sektöründe bir staj SQL 3, başka bir staj SQL 4 ve PHP 3 istiyorsa sektör beklentisi SQL 4 ve PHP 3 olur; SQL 4 olup PHP kaydı olmayan öğrenci için SQL karşılanan, PHP bulunmayan görünür.
  - **AC-13.2** Sektörde hiç staj veya beklenen yetkinlik yoksa açıklayıcı mesaj gösterilir.

## 3. Fonksiyonel olmayan gereksinimler (NFR)

### NFR-01 — Veri bütünlüğü

- **Gereksinim:** Birincil/yabancı anahtarlar, benzersizlik ve düzey kısıtları korunmalıdır.
- **Kabul kriteri:** Tekrarlanan öğrenci numarası, geçersiz yabancı anahtar, 0/6 düzeyi, geçersiz sınıf değeri (0 veya 7) ve geçersiz staj durumu veri tabanında reddedilir.

### NFR-02 — İlişkisel silme/güncelleme

- **Gereksinim:** Silme ve güncelleme davranışları şema kurallarına uygun olmalıdır.
- **Kabul kriteri:** Bağlı firma varken sektör silinemez; bağlı kaydı olan yetkinlik silinemez; test ortamında öğrenci silindiğinde öğrenci-yetkinlik kayıtları, firma silindiğinde bağlı staj ve staj-yetkinlik kayıtları da silinir.

### NFR-03 — Performans ve doğruluk

- **Gereksinim:** Filtreleme ve raporlama makul veri hacminde hızlı ve doğru sonuç vermelidir.
- **Kabul kriteri:** Önerilen hedef: 100 öğrenci, 50 staj, 30 yetkinlik ve 1000 ilişki kaydıyla her temel filtre/rapor 5 denemenin her birinde 2 saniye içinde sonuç verir; sonuçlar kontrol sorgusuyla eşleşir.

### NFR-04 — Girdi doğrulama ve geri bildirim

- **Gereksinim:** Eksik veya hatalı girişlerde açıklayıcı geri bildirim verilmelidir. Boş metin ve hatalı e-posta biçimi veri tabanı kısıtlarıyla yakalanmadığı için uygulama katmanında doğrulanır.
- **Kabul kriteri:** Boş zorunlu alan, geçersiz e-posta biçimi, geçersiz düzey ve ters tarih aralığı ayrı ayrı denenir; anlaşılır hata gösterilir ve geçersiz kayıt saklanmaz.

### NFR-05 — Veri gizliliği

- **Gereksinim:** Demo ve test verileri sentetik veya anonim olmalıdır.
- **Kabul kriteri:** Örnek veri dosyaları ve demo kayıtları incelendiğinde gerçek öğrenci numarası, isim veya kişisel e-posta içeren tanımlanabilir kayıt bulunmaz.

### NFR-06 — Güvenli sorgu erişimi *(yeni, ekip onayına sunulan öneri)*

- **Gereksinim:** Kullanıcıdan gelen veri SQL metnine doğrudan birleştirilmemeli; parametreli (hazırlanmış) sorgular kullanılmalıdır.
- **Kabul kriteri:** Formlara `' OR '1'='1` ve `'; DROP TABLE ogrenci; --` gibi girdiler girildiğinde veriler değişmez, sorgu yapısı bozulmaz ve hata kullanıcıya teknik ayrıntı sızdırmadan gösterilir; kod incelemesinde kullanıcı girdisinin sorgu metnine birleştirilmediği doğrulanır.
- **Dayanak:** Eylem planı P2-14 ve değerlendirme rubriğindeki "veri bütünlüğü, güvenli sorgu ve testler" kalemi.

### NFR-07 — Kurulabilirlik ve tekrarlanabilirlik *(yeni, ekip onayına sunulan öneri)*

- **Gereksinim:** Veri tabanı, boş bir sunucuda şema ve örnek veri betikleriyle hatasız kurulabilmelidir.
- **Kabul kriteri:** Boş veri tabanında `schema.sql` ve ardından `seed.sql` çalıştırıldığında hata oluşmaz, örnek veriler ilişki kısıtlarını bozmaz; README'deki XAMPP/MySQL adımlarını izleyen bir ekip üyesi uygulamayı temiz bilgisayarda çalıştırabilir.
- **Dayanak:** Eylem planı P2-08 ve P2-17.

### NFR-08 — Normalizasyon *(yeni, ekip onayına sunulan öneri)*

- **Gereksinim:** Şema en az üçüncü normal forma (3NF) uygun olmalıdır.
- **Kabul kriteri:** Normalizasyon gerekçe tablosunda (P2-07) her tablo için 1NF–3NF değerlendirmesi, tekrar eden gruplar ve işlevsel bağımlılıklar açıklanmıştır; kalan istisnalar gerekçesiyle belirtilmiştir.
- **Dayanak:** Eylem planı, Bölüm 2 (asgari kabul koşulları).

### NFR-09 — Karakter kodlaması *(yeni, ekip onayına sunulan öneri)*

- **Gereksinim:** Türkçe karakterler kayıt ve listelemede bozulmadan saklanmalı ve görüntülenmelidir.
- **Kabul kriteri:** ç, ğ, ı, İ, ö, ş, ü içeren sentetik bir ad (örn. "Işık Ölçüm Çözümleri") eklenir, listelenir, güncellenir ve arama/filtrede doğru bulunur; ekranda bozuk karakter görünmez.

## 4. Tasarım kararları ve açık noktalar

- Performans eşiği ve test veri hacmi ekip onayına sunulan önerilerdir; ölçüm yapılmamıştır.
- Raporların kapsamı tüm kayıtlı stajlardır; açık/kapalı kapsamı ekipçe kesinleştirilmelidir. Teknoloji ve yetkinlik ortak sözlük üzerinden ele alınır.
- Düzey filtresi (FR-10), beklenen minimum düzeyin seçilen değerle **eşitliği** olarak önerilmiştir. Alternatif: "seçilen düzey ve üzeri" (≥). Hangisinin kullanılacağı ekipçe seçilmelidir.
- FR-09/FR-13'teki "karşılanan" tanımı (öğrenci düzeyi ≥ minimum düzey) ve FR-13'teki sektör beklentisi hesabı (sektördeki en yüksek minimum düzey) ekip onayına sunulan önerilerdir.
- Personalar ayrı hesap veya yetkilendirme mekanizması zorunluluğu doğurmaz.
- Kabul kriterleri test hedefleridir; uygulamanın bunları sağladığı henüz doğrulanmamıştır.
- Şemaya göre firma silme işlemi bağlı stajları ve staj yetkinliklerini de siler; ekip bu davranışı kesin şema öncesi değerlendirmelidir. AC-06.4'teki silme öncesi onay adımı bu riski azaltmak için önerilmiştir.
- Şemadaki sayısal sınırlar (sınıf 1–6, düzey 1–5) ve staj durumu kısıtları veri tabanı sürümüne bağlı olarak uygulanır. Kullanılan XAMPP/MySQL/MariaDB sürümünde bu kısıtların gerçekten reddettiği NFR-01 testiyle doğrulanmalıdır; bazı eski MySQL sürümleri CHECK kısıtını yazım olarak kabul eder ancak uygulamaz.
- Bu revizyonda eklenenler: AC kimlikleri, FR-13, NFR-06 – NFR-09 ve mevcut kabul kriterlerindeki bazı ek senaryolar (yinelenen atama, boş durum mesajları vb.). Ekip kabul etmezse ilgili maddeler çıkarılabilir; Issue #2 asgari ölçütleri (10 FR, 4 NFR) bunlar olmadan da karşılanır.

## 5. İzlenebilirlik özeti

| FR | İlgili hikâye | Kabul kriterleri | Test (P2-16'da eşleştirilecek) |
|----|---------------|------------------|--------------------------------|
| FR-01 | US-01 | AC-01.1 – AC-01.4 | Test/Kalite rolü dolduracak |
| FR-02 | US-02 | AC-02.1 – AC-02.4 | Test/Kalite rolü dolduracak |
| FR-03 | US-02 | AC-03.1 – AC-03.2 | Test/Kalite rolü dolduracak |
| FR-04 | US-10 | AC-04.1 – AC-04.4 | Test/Kalite rolü dolduracak |
| FR-05 | US-03 | AC-05.1 – AC-05.3 | Test/Kalite rolü dolduracak |
| FR-06 | US-03 | AC-06.1 – AC-06.4 | Test/Kalite rolü dolduracak |
| FR-07 | US-04 | AC-07.1 – AC-07.4 | Test/Kalite rolü dolduracak |
| FR-08 | US-05 | AC-08.1 – AC-08.4 | Test/Kalite rolü dolduracak |
| FR-09 | US-06 | AC-09.1 – AC-09.3 | Test/Kalite rolü dolduracak |
| FR-10 | US-07 | AC-10.1 – AC-10.4 | Test/Kalite rolü dolduracak |
| FR-11 | US-08 | AC-11.1 – AC-11.2 | Test/Kalite rolü dolduracak |
| FR-12 | US-09 | AC-12.1 – AC-12.2 | Test/Kalite rolü dolduracak |
| FR-13 | US-06 (doğrulanacak) | AC-13.1 – AC-13.2 | Test/Kalite rolü dolduracak |

## 6. Kanıt (Issue #2)

- Issue: #2 (YG-Proje2 Görev Panosu)
- Commit/PR bağlantısı: *(commit ve PR açıldıktan sonra eklenecek)*

## 7. Kaynaklar

- Proje 2 Teknik Proje Dokümanı, bölümler 3, 4, 6, 7, 8, 12.
- Dört Haftalık Eylem Planı, P2-02, P2-08, P2-12, P2-14, P2-17 ve Bölüm 2, 5.
- GitHub Issue #2, `kullanici-senaryolari.md`, `sql/schema-taslak.sql`.

## 8. Sürüm geçmişi

| Sürüm | Değişiklik |
|-------|-----------|
| 1.0 | İlk taslak: 12 FR, 5 NFR. |
| 1.1 | AC kimlikleri ve ek kabul kriterleri; FR-09 tanımları; FR-10'a sektör filtresi; FR-13 ve NFR-06 – NFR-09 eklendi; açık noktalar ve izlenebilirlik özeti güncellendi. |
