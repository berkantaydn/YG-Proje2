-- =====================================================================
-- Staj ve Sektör Yetkinlik Haritası — ŞEMA TASLAĞI (Hafta 1)
-- MySQL 8 ve XAMPP (MariaDB) ile uyumludur.
-- Bu dosya TASLAKTIR: ER diyagramı v1 ve veri sözlüğü netleşince
-- Hafta 2'de (P2-06, P2-08) kesin sürüm yazılacaktır.
-- Tekrar tekrar çalıştırılabilir (DROP TABLE IF EXISTS kullanır).
-- =====================================================================

CREATE DATABASE IF NOT EXISTS staj_yetkinlik
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE staj_yetkinlik;

DROP TABLE IF EXISTS staj_yetkinlik;
DROP TABLE IF EXISTS ogrenci_yetkinlik;
DROP TABLE IF EXISTS staj;
DROP TABLE IF EXISTS firma;
DROP TABLE IF EXISTS ogrenci;
DROP TABLE IF EXISTS yetkinlik;
DROP TABLE IF EXISTS sektor;

-- SEKTOR: Firmaların ait olduğu sektörler (ör. Yazılım, Finans)
CREATE TABLE sektor (
    sektor_id  INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    ad         VARCHAR(100)  NOT NULL,
    aciklama   VARCHAR(255)  NULL,
    PRIMARY KEY (sektor_id),
    UNIQUE KEY uq_sektor_ad (ad)
) ENGINE=InnoDB;

-- YETKINLIK: Yetkinlik / teknoloji sözlüğü (ör. SQL, PHP, Takım Çalışması)
CREATE TABLE yetkinlik (
    yetkinlik_id INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    ad           VARCHAR(100)  NOT NULL,
    kategori     VARCHAR(50)   NULL,
    aciklama     VARCHAR(255)  NULL,
    PRIMARY KEY (yetkinlik_id),
    UNIQUE KEY uq_yetkinlik_ad (ad)
) ENGINE=InnoDB;

-- OGRENCI: Öğrenci profili (veriler sentetik/anonim olmalıdır)
CREATE TABLE ogrenci (
    ogrenci_id  INT UNSIGNED     NOT NULL AUTO_INCREMENT,
    ogrenci_no  VARCHAR(20)      NOT NULL,
    ad          VARCHAR(50)      NOT NULL,
    soyad       VARCHAR(50)      NOT NULL,
    email       VARCHAR(100)     NOT NULL,
    bolum       VARCHAR(100)     NULL,
    sinif       TINYINT UNSIGNED NULL,
    PRIMARY KEY (ogrenci_id),
    UNIQUE KEY uq_ogrenci_no (ogrenci_no),
    UNIQUE KEY uq_ogrenci_email (email),
    CONSTRAINT ck_ogrenci_sinif CHECK (sinif IS NULL OR sinif BETWEEN 1 AND 6)
) ENGINE=InnoDB;

-- FIRMA: Staj veren firmalar; her firma bir sektöre bağlıdır
CREATE TABLE firma (
    firma_id   INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    ad         VARCHAR(150)  NOT NULL,
    sektor_id  INT UNSIGNED  NOT NULL,
    sehir      VARCHAR(80)   NULL,
    web_sitesi VARCHAR(200)  NULL,
    PRIMARY KEY (firma_id),
    UNIQUE KEY uq_firma_ad (ad),
    CONSTRAINT fk_firma_sektor FOREIGN KEY (sektor_id)
        REFERENCES sektor (sektor_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- STAJ: Firmanın açtığı staj fırsatı / pozisyon
CREATE TABLE staj (
    staj_id          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    firma_id         INT UNSIGNED  NOT NULL,
    baslik           VARCHAR(150)  NOT NULL,
    aciklama         TEXT          NULL,
    alan             VARCHAR(80)   NULL,
    baslangic_tarihi DATE          NULL,
    bitis_tarihi     DATE          NULL,
    durum            VARCHAR(10)   NOT NULL DEFAULT 'acik',
    PRIMARY KEY (staj_id),
    CONSTRAINT fk_staj_firma FOREIGN KEY (firma_id)
        REFERENCES firma (firma_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT ck_staj_durum CHECK (durum IN ('acik', 'kapali')),
    CONSTRAINT ck_staj_tarih CHECK (
        baslangic_tarihi IS NULL OR bitis_tarihi IS NULL
        OR bitis_tarihi >= baslangic_tarihi)
) ENGINE=InnoDB;

-- OGRENCI_YETKINLIK: Öğrenci <-> Yetkinlik (çoktan çoğa), düzey 1-5
CREATE TABLE ogrenci_yetkinlik (
    ogrenci_id   INT UNSIGNED     NOT NULL,
    yetkinlik_id INT UNSIGNED     NOT NULL,
    duzey        TINYINT UNSIGNED NOT NULL,
    PRIMARY KEY (ogrenci_id, yetkinlik_id),
    CONSTRAINT fk_oy_ogrenci FOREIGN KEY (ogrenci_id)
        REFERENCES ogrenci (ogrenci_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_oy_yetkinlik FOREIGN KEY (yetkinlik_id)
        REFERENCES yetkinlik (yetkinlik_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT ck_oy_duzey CHECK (duzey BETWEEN 1 AND 5)
) ENGINE=InnoDB;

-- STAJ_YETKINLIK: Staj <-> Yetkinlik (çoktan çoğa), beklenen minimum düzey 1-5
CREATE TABLE staj_yetkinlik (
    staj_id      INT UNSIGNED     NOT NULL,
    yetkinlik_id INT UNSIGNED     NOT NULL,
    min_duzey    TINYINT UNSIGNED NOT NULL,
    PRIMARY KEY (staj_id, yetkinlik_id),
    CONSTRAINT fk_sy_staj FOREIGN KEY (staj_id)
        REFERENCES staj (staj_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_sy_yetkinlik FOREIGN KEY (yetkinlik_id)
        REFERENCES yetkinlik (yetkinlik_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT ck_sy_min_duzey CHECK (min_duzey BETWEEN 1 AND 5)
) ENGINE=InnoDB;
