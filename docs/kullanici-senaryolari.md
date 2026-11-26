# Staj ve Sektör Yetkinlik Haritası
## P2-01 — Paydaşlar ve Kullanıcı Senaryoları

**Görev:** Issue #2 · **Rol:** Analist · **Hazırlayan:** Hilal Akça  
**Sürüm:** 1.1 — inceleme notları uygulanmış taslak

## 1. Amaç ve kapsam

Sistem, öğrencilerin yetkinliklerini staj pozisyonlarının ve sektörlerin beklentileriyle karşılaştırmayı, eksik yetkinlikleri belirlemeyi ve anlamlı raporlar üretmeyi amaçlar. Bu belge, kullanıcı ihtiyaçlarını ve bunlara karşılık gelen sistem işlevlerini tanımlar.

## 2. Personalar

Aşağıdaki profiller ihtiyaç analizini somutlaştırmak için oluşturulmuş kurgusal örneklerdir; gerçek kullanıcı görüşmesi sonuçları değildir.

| Kimlik | Persona | Amaç | Sorun / ihtiyaç |
|---|---|---|---|
| P-01 | Deniz — Yazılım geliştirme öğrencisi | Yetkinliklerini görmek ve staj beklentileriyle karşılaştırmak | Hangi teknolojilerde yeterli olduğunu ve hangilerini geliştirmesi gerektiğini belirleyemiyor. |
| P-02 | Ece — Firma / sektör temsilcisi (senaryo paydaşı) | Staj pozisyonları için gerekli yetkinlikleri ve minimum düzeyleri tanımlamak | Pozisyon beklentilerini düzenli ve karşılaştırılabilir biçimde ifade etmeye ihtiyaç duyuyor. |
| P-03 | Mert — Staj koordinatörü / akademik danışman | Öğrencilerin güçlü ve eksik yetkinliklerini toplu olarak değerlendirmek | Sektör taleplerini ve öğrenci yetkinlik boşluklarını tek bir görünümde incelemek istiyor. |

## 3. Kullanıcı hikâyeleri ve ilgili işlevler

| Kimlik | Persona | Kullanıcı hikâyesi | İlgili sistem işlevi |
|---|---|---|---|
| US-01 | P-01 | Bir öğrenci olarak profil bilgilerimi oluşturmak ve güncellemek istiyorum; böylece yetkinliklerim doğru öğrenci profiliyle ilişkilendirilsin. | Öğrenci profili yönetimi |
| US-02 | P-01 | Bir öğrenci olarak yetkinliklerimi ve 1–5 arasındaki düzeylerimi kaydetmek ve güncellemek istiyorum; böylece mevcut yetkinlik profilimi görebileyim. | Öğrenci yetkinlik yönetimi ve profil özeti |
| US-03 | P-02 | Bir firma temsilcisi olarak firma ve sektör bilgilerini kaydetmek istiyorum; böylece staj fırsatları ilgili firma ve sektörle ilişkilendirilebilsin. | Firma ve sektör profili yönetimi |
| US-04 | P-02 | Bir firma temsilcisi olarak staj pozisyonlarını tanımlamak istiyorum; böylece öğrenciler mevcut fırsatları inceleyebilsin. | Staj/pozisyon yönetimi |
| US-05 | P-02 | Bir firma temsilcisi olarak pozisyon için gerekli yetkinlikleri ve minimum düzeyleri tanımlamak istiyorum; böylece beklentiler ölçülebilir olsun. | Pozisyon yetkinlik yönetimi |
| US-06 | P-01 | Bir öğrenci olarak yetkinliklerimi seçtiğim staj pozisyonunun beklentileriyle karşılaştırmak istiyorum; böylece yeterli ve eksik olduğum alanları belirleyebileyim. | Yetkinlik boşluğu analizi |
| US-07 | P-01 | Bir öğrenci olarak fırsatları teknoloji, alan, firma, yetkinlik ve düzeye göre filtrelemek istiyorum; böylece ilgilendiğim fırsatları daha kolay bulabileyim. | Arama ve filtreleme |
| US-08 | P-03 | Bir staj koordinatörü olarak en çok talep edilen yetkinlikleri raporda görmek istiyorum; böylece öğrencileri sektör beklentilerine göre yönlendirebileyim. | Talep edilen yetkinlikler raporu |
| US-09 | P-03 | Bir staj koordinatörü olarak seçtiğim sektör veya pozisyon için öğrencilerin yetkinlik boşluklarını toplu olarak görmek istiyorum; böylece geliştirilmesi gereken alanları belirleyebileyim. | Öğrenci-yetkinlik boşlukları raporu |
| US-10 | P-03 | Bir staj koordinatörü olarak yetkinlik ve teknoloji sözlüğünün güncel ve tutarlı tutulmasını istiyorum; böylece öğrenci ve pozisyon kayıtları ortak yetkinlik tanımlarıyla karşılaştırılabilsin. | Yetkinlik/teknoloji sözlüğü yönetimi |

## 4. Temel kullanım senaryoları

### KS-01 — Öğrenci yetkinlik profili (US-01, US-02)

1. Öğrenci profili oluşturulur veya mevcut profil seçilir.
2. Yetkinlik sözlüğünden bir yetkinlik seçilir.
3. Yetkinlik düzeyi 1–5 arasında girilir ve kayıt saklanır veya güncellenir.
4. Sistem güncel yetkinlik profilini gösterir.

**Beklenen sonuç:** Öğrencinin yetkinlikleri ve düzeyleri görüntülenebilir.

### KS-02 — Staj beklentilerinin tanımlanması (US-03, US-04, US-05)

1. İlgili sektör ve firma kaydı oluşturulur veya mevcut kayıt seçilir.
2. Firmaya bağlı staj pozisyonu tanımlanır.
3. Pozisyonun gerekli yetkinlikleri sözlükten seçilir ve minimum düzeyleri 1–5 arasında belirlenir.
4. Kayıtlar veri tabanında saklanır.

**Beklenen sonuç:** Pozisyon beklentileri karşılaştırmaya hazır hale gelir.

### KS-03 — Fırsat arama ve yetkinlik boşluğu analizi (US-04, US-06, US-07)

1. Öğrenci seçilir.
2. Öğrenci, mevcut staj fırsatlarını teknoloji, alan, firma, yetkinlik ve düzeye göre filtreleyerek listeler ve ilgilendiği pozisyonu seçer.
3. Sistem öğrencinin yetkinlik düzeylerini pozisyonun minimum düzeyleriyle karşılaştırır.
4. Yetkinlikler üç grupta listelenir: minimum düzeyi karşılayanlar, düzeyi yetersiz olanlar ve öğrenci profilinde bulunmayanlar (eksik).
5. Sonuçlar duruma göre (karşılanan / yetersiz / eksik) filtrelenerek incelenebilir.

**Örnek:** Pozisyon SQL için minimum 4, PHP için minimum 3 ve Docker için minimum 2 bekliyor. Öğrencinin SQL düzeyi 2, PHP düzeyi 3 ve profilinde Docker yok. Bu durumda SQL geliştirilmesi gereken (yetersiz), PHP karşılanan, Docker ise eksik yetkinlik olarak gösterilir.

**Beklenen sonuç:** Öğrenci, seçtiği pozisyon için hangi yetkinliklerde yeterli, hangilerinde yetersiz olduğunu ve hangilerinin hiç profilinde bulunmadığını görür.

### KS-04 — Raporlama (US-08, US-09)

1. Kullanıcı talep edilen yetkinlikler veya öğrenci-yetkinlik boşlukları raporunu seçer.
2. Öğrenci-yetkinlik boşlukları raporu için sektör veya pozisyon seçilir.
3. Sistem veri tabanındaki kayıtları sorgular ve özetler:
   - **Talep edilen yetkinlikler raporu:** her yetkinlik için kaç pozisyonun istediği ve beklenen ortalama minimum düzey; yetkinlikler talep sayısına göre sıralanır.
   - **Öğrenci-yetkinlik boşlukları raporu:** her öğrenci için yetkinlik, beklenen düzey, mevcut düzey ve fark; yetersiz düzeydeki yetkinlikler ile profilde hiç bulunmayan (eksik) yetkinlikler ayrı listelenir.
4. Kullanıcı sonuçları inceleyerek gelişim alanlarını belirler.

**Beklenen sonuç:** En az iki anlamlı rapor görünümü elde edilir.

### KS-05 — Yetkinlik/teknoloji sözlüğü yönetimi (US-10)

1. Koordinatör yetkinlik/teknoloji sözlüğünü açar.
2. Yeni bir yetkinlik ekler veya mevcut bir yetkinliğin adını ve alanını günceller.
3. Sistem aynı adla ikinci bir kaydın oluşturulmasını engeller ve hatalı ya da eksik girişte açıklayıcı bir mesaj gösterir.
4. Güncel sözlük, öğrenci yetkinlik ve pozisyon yetkinlik seçimlerinde kullanılır (KS-01, KS-02).

**Beklenen sonuç:** Öğrenci ve pozisyon kayıtları aynı, tutarlı yetkinlik tanımlarıyla karşılaştırılabilir.

## 5. Kapsam notları ve izlenebilirlik

- Persona tanımları ayrı kullanıcı hesapları, giriş ekranları veya yetkilendirme rolleri gerektirdiği anlamına gelmez. Firma temsilcisi senaryo paydaşıdır; işlemleri kimin gerçekleştireceği ekipçe netleştirilecektir.
- 1–5 düzey ölçeği mevcut `sql/schema-taslak.sql` dosyasıyla uyumludur.
- Kabul kriterleri P2-02 gereksinim belgesinde FR kimlikleriyle birlikte tanımlanacaktır.
- US kimlikleri P2-02 gereksinim belgesinde ilgili FR kimlikleriyle eşleştirilecektir. FR kimlikleri henüz kesinleştirilmemiştir.
- Örnek veriler sentetiktir; gerçek kişilere ait veri kullanılmayacaktır.
- Kullanıcı hikâyeleri ve senaryolar ekip incelemesinden sonra güncellenebilir.

### Hikâye–senaryo eşleşmesi

| Kullanıcı hikâyesi | Senaryo |
|---|---|
| US-01, US-02 | KS-01 |
| US-03, US-04, US-05 | KS-02 |
| US-04, US-06, US-07 | KS-03 |
| US-08, US-09 | KS-04 |
| US-10 | KS-05 |

## 6. Kaynaklar

- Proje 2 Teknik Proje Dokümanı, bölüm 3, 4, 6 ve 7.
- Proje 2 Dört Haftalık Eylem Planı, P2-01.
- GitHub Issue #2 ve `sql/schema-taslak.sql` (Hafta 1 taslağı).
