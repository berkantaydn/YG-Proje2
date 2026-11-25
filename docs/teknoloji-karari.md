# Teknoloji Kararı

**Proje:** Staj ve Sektör Yetkinlik Haritası (Proje 2 – Grup 1)
**Karar veren:** Berkant Aydın (Lider)
**İlgili issue:** P2-05

## Seçilen teknolojiler

| Katman | Teknoloji |
|---|---|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP |
| Veritabanı | MySQL 8 |
| Veritabanı bağlantısı | PHP PDO |
| Yerel geliştirme | XAMPP |
| Veritabanı yönetimi | phpMyAdmin |

## Gerekçe

- Ekibin ana hedefi arayüz değil **veri modeli, CRUD, JOIN sorguları ve raporlardır**; bu yığın bunları sade biçimde yapmaya izin verir.
- XAMPP ile tek kurulumda Apache, PHP, veritabanı ve phpMyAdmin hazır gelir; kurulum zahmeti azdır.
- PDO, hazırlanmış sorgularla (prepared statements) güvenli SQL erişimi sağlar. Bu, proje şartlarından biridir.

## Önemli not: XAMPP ve MySQL 8

XAMPP'ın içindeki "MySQL" aslında **MariaDB**'dir. Bu yüzden:
- SQL dosyaları hem MySQL 8 hem MariaDB ile uyumlu yazılır.
- Yalnızca MySQL 8'e özgü özellikler kullanılmaz (ör. `utf8mb4_0900_ai_ci` collation).
- Karakter kümesi: `utf8mb4`, collation: `utf8mb4_unicode_ci`.

## Klasör yapısı

```
.
├── docs/        Belgeler (gereksinim, veri sözlüğü, ER, test planı...)
├── sql/         schema ve seed SQL dosyaları
├── src/         PHP kodları (config.php, db.php ...)
├── public/      Tarayıcıdan erişilen sayfalar (index.php ...)
├── data/        Örnek veri taslakları
├── .env.example Ayar şablonu (gerçek .env GitHub'a gönderilmez)
└── .gitignore
```

## Adlandırma kuralı

- Tablo ve sütun adları: küçük harf, `snake_case`, Türkçe karakter yok (ör. `ogrenci_yetkinlik`).
- Birincil anahtarlar: `tabloadi_id`.

## Çalışma kuralları

1. Her commit mesajında issue numarası olur. Örnek: `P2-03: veri sözlüğü eklendi (#2)`
2. `.env` dosyası asla commit'lenmez. Şablon `.env.example`'dır.
3. Gerçek kişi verisi kullanılmaz; tüm örnek veriler sentetik/anonimdir.
4. Kullanıcıdan gelen veri SQL metnine doğrudan eklenmez; PDO `prepare()` + `execute()` kullanılır.
5. Herkes kendi dalında (`feature/...`) çalışır ve Pull Request ile `main`'e birleştirir.
