-- path: database/schema.sql
-- MySQL 8.x
-- Gebruik eerst:
-- USE examen_dag1;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS afspraak_behandeling;
DROP TABLE IF EXISTS behandeling_product;
DROP TABLE IF EXISTS klant_kenmerken;
DROP TABLE IF EXISTS afspraken;
DROP TABLE IF EXISTS behandelingen;
DROP TABLE IF EXISTS producten;
DROP TABLE IF EXISTS klanten;
DROP TABLE IF EXISTS medewerkers;
DROP TABLE IF EXISTS medewerker_behandeling;
DROP TABLE IF EXISTS gebruikers;
DROP TABLE IF EXISTS rollen;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE rollen (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    naam VARCHAR(50) NOT NULL,
    omschrijving VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_rollen_naam (naam)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE gebruikers (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    rol_id BIGINT UNSIGNED NOT NULL,
    voornaam VARCHAR(100) NOT NULL,
    achternaam VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefoon VARCHAR(30) NULL,
    wachtwoord VARCHAR(255) NOT NULL,
    actief TINYINT(1) NOT NULL DEFAULT 1,
    laatste_login DATETIME NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_gebruikers_email (email),
    KEY idx_gebruikers_rol_id (rol_id),
    CONSTRAINT fk_gebruikers_rol
        FOREIGN KEY (rol_id) REFERENCES rollen(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE medewerkers (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    gebruiker_id BIGINT UNSIGNED NOT NULL,
    personeelsnummer VARCHAR(50) NOT NULL,
    functie VARCHAR(100) NULL,
    in_dienst_sinds DATE NULL,
    werkdagen VARCHAR(120) NOT NULL DEFAULT 'Maandag t/m vrijdag',
    werktijden VARCHAR(40) NOT NULL DEFAULT '09:00 - 17:00',
    notities TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_medewerkers_gebruiker_id (gebruiker_id),
    UNIQUE KEY uk_medewerkers_personeelsnummer (personeelsnummer),
    CONSTRAINT fk_medewerkers_gebruiker
        FOREIGN KEY (gebruiker_id) REFERENCES gebruikers(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE klanten (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    gebruiker_id BIGINT UNSIGNED NOT NULL,
    geboortedatum DATE NULL,
    adresregel1 VARCHAR(255) NULL,
    adresregel2 VARCHAR(255) NULL,
    postcode VARCHAR(20) NULL,
    plaats VARCHAR(100) NULL,
    land VARCHAR(100) NULL,
    algemene_notities TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_klanten_gebruiker_id (gebruiker_id),
    KEY idx_klanten_plaats (plaats),
    CONSTRAINT fk_klanten_gebruiker
        FOREIGN KEY (gebruiker_id) REFERENCES gebruikers(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE klant_kenmerken (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    klant_id BIGINT UNSIGNED NOT NULL,
    type ENUM('voorkeur', 'allergie', 'wens', 'medisch') NOT NULL,
    titel VARCHAR(150) NOT NULL,
    beschrijving TEXT NULL,
    actief TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_klant_kenmerken_klant_id (klant_id),
    KEY idx_klant_kenmerken_type (type),
    CONSTRAINT fk_klant_kenmerken_klant
        FOREIGN KEY (klant_id) REFERENCES klanten(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE producten (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    naam VARCHAR(150) NOT NULL,
    sku VARCHAR(100) NULL,
    beschrijving TEXT NULL,
    voorraad_aantal INT NOT NULL DEFAULT 0,
    eenheid VARCHAR(30) NULL,
    kostprijs DECIMAL(10,2) NULL,
    verkoopprijs DECIMAL(10,2) NULL,
    actief TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_producten_naam (naam),
    UNIQUE KEY uk_producten_sku (sku)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE behandelingen (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    naam VARCHAR(150) NOT NULL,
    type VARCHAR(100) NOT NULL,
    beschrijving TEXT NULL,
    duur_minuten INT NOT NULL,
    prijs DECIMAL(10,2) NOT NULL,
    actief TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_behandelingen_type (type),
    KEY idx_behandelingen_naam (naam),
    FULLTEXT KEY ftx_behandelingen (naam, beschrijving)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE behandeling_product (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    behandeling_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    hoeveelheid DECIMAL(10,2) NOT NULL DEFAULT 1.00,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_behandeling_product (behandeling_id, product_id),
    KEY idx_behandeling_product_product_id (product_id),
    CONSTRAINT fk_behandeling_product_behandeling
        FOREIGN KEY (behandeling_id) REFERENCES behandelingen(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_behandeling_product_product
        FOREIGN KEY (product_id) REFERENCES producten(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE medewerker_behandeling (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    medewerker_id BIGINT UNSIGNED NOT NULL,
    behandeling_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uk_medewerker_behandeling (medewerker_id, behandeling_id),
    KEY idx_medewerker_behandeling_behandeling_id (behandeling_id),
    CONSTRAINT fk_medewerker_behandeling_medewerker
        FOREIGN KEY (medewerker_id) REFERENCES medewerkers(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_medewerker_behandeling_behandeling
        FOREIGN KEY (behandeling_id) REFERENCES behandelingen(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE afspraken (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    klant_id BIGINT UNSIGNED NOT NULL,
    medewerker_id BIGINT UNSIGNED NULL,
    start_datumtijd DATETIME NOT NULL,
    eind_datumtijd DATETIME NOT NULL,
    status ENUM('gepland', 'bevestigd', 'uitgevoerd', 'geannuleerd', 'no_show') NOT NULL DEFAULT 'gepland',
    opmerking_klant TEXT NULL,
    interne_notitie TEXT NULL,
    totaalprijs DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    aangemaakt_door_gebruiker_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_afspraken_klant_id (klant_id),
    KEY idx_afspraken_medewerker_id (medewerker_id),
    KEY idx_afspraken_start (start_datumtijd),
    KEY idx_afspraken_status (status),
    KEY idx_afspraken_aangemaakt_door (aangemaakt_door_gebruiker_id),
    CONSTRAINT fk_afspraken_klant
        FOREIGN KEY (klant_id) REFERENCES klanten(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_afspraken_medewerker
        FOREIGN KEY (medewerker_id) REFERENCES medewerkers(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT fk_afspraken_aangemaakt_door
        FOREIGN KEY (aangemaakt_door_gebruiker_id) REFERENCES gebruikers(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT chk_afspraken_tijd CHECK (eind_datumtijd > start_datumtijd)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE afspraak_behandeling (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    afspraak_id BIGINT UNSIGNED NOT NULL,
    behandeling_id BIGINT UNSIGNED NOT NULL,
    prijs_op_moment DECIMAL(10,2) NOT NULL,
    duur_minuten_op_moment INT NOT NULL,
    notitie TEXT NULL,
    uitgevoerd TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_afspraak_behandeling (afspraak_id, behandeling_id),
    KEY idx_afspraak_behandeling_behandeling_id (behandeling_id),
    CONSTRAINT fk_afspraak_behandeling_afspraak
        FOREIGN KEY (afspraak_id) REFERENCES afspraken(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_afspraak_behandeling_behandeling
        FOREIGN KEY (behandeling_id) REFERENCES behandelingen(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO rollen (naam, omschrijving) VALUES
('eigenaar', 'Kan medewerkers beheren'),
('medewerker', 'Kan klanten, afspraken en behandelingen beheren'),
('klant', 'Kan afspraken bekijken en beheren'),
('planner', 'Kan afspraken plannen en wijzigen'),
('beheerder', 'Kan technische instellingen beheren');

INSERT INTO gebruikers (
    rol_id, voornaam, achternaam, email, telefoon, wachtwoord, actief
) VALUES
(1, 'Lisa', 'Jansen', 'lisa@kniplokettiko.nl', '06 12345678', '$2y$12$voorbeeldhashhier', 1),
(2, 'Laura', 'Jansen', 'laura@kniplokettiko.nl', '06 23456789', '$2y$12$voorbeeldhashhier', 1),
(2, 'Mark', 'van Dijk', 'mark@kniplokettiko.nl', '06 34567890', '$2y$12$voorbeeldhashhier', 1),
(2, 'Emma', 'Bakker', 'emma@kniplokettiko.nl', '06 45678901', '$2y$12$voorbeeldhashhier', 1),
(2, 'Tom', 'Meijer', 'tom@kniplokettiko.nl', '06 56789012', '$2y$12$voorbeeldhashhier', 1),
(3, 'Sanne', 'de Vries', 'sanne@example.test', '06 67890123', '$2y$12$voorbeeldhashhier', 1),
(3, 'Nora', 'Peters', 'nora@example.test', '06 78901234', '$2y$12$voorbeeldhashhier', 1),
(3, 'Mila', 'Vos', 'mila@example.test', '06 89012345', '$2y$12$voorbeeldhashhier', 1),
(3, 'Daan', 'Smit', 'daan@example.test', '06 90123456', '$2y$12$voorbeeldhashhier', 1),
(3, 'Yara', 'Mulder', 'yara@example.test', '06 01234567', '$2y$12$voorbeeldhashhier', 1);

INSERT INTO medewerkers (
    gebruiker_id, personeelsnummer, functie, in_dienst_sinds, werkdagen, werktijden
) VALUES
(1, 'MW-001', 'Manager', '2021-01-10', 'Maandag t/m vrijdag', '09:00 - 17:00'),
(2, 'MW-002', 'Kapster', '2022-03-01', 'Maandag t/m donderdag', '09:00 - 17:00'),
(3, 'MW-003', 'Colorist', '2023-04-15', 'Dinsdag t/m zaterdag', '10:00 - 18:00'),
(4, 'MW-004', 'Stylist', '2024-02-20', 'Maandag, woensdag, vrijdag', '09:00 - 16:00'),
(5, 'MW-005', 'Extensions specialist', '2024-09-01', 'Woensdag t/m zaterdag', '10:00 - 18:00');

INSERT INTO klanten (
    gebruiker_id, geboortedatum, adresregel1, postcode, plaats, land, algemene_notities
) VALUES
(6, '1998-06-15', 'Voorbeeldstraat 1', '1234AB', 'Utrecht', 'Nederland', 'Parfumvrij werken'),
(7, '1989-11-03', 'Kapsalonlaan 7', '3521CD', 'Utrecht', 'Nederland', 'Komt graag in de ochtend'),
(8, '2001-02-21', 'Knipstraat 12', '3512EF', 'Nieuwegein', 'Nederland', 'Studentenkorting'),
(9, '1977-08-09', 'Kleurplein 4', '3581GH', 'Zeist', 'Nederland', 'Gevoelige hoofdhuid'),
(10, '1995-12-30', 'Stylinghof 22', '3701JK', 'Houten', 'Nederland', 'Wil vaste stylist');

INSERT INTO producten (
    naam, sku, beschrijving, voorraad_aantal, eenheid, kostprijs, verkoopprijs, actief
) VALUES
('Shampoo Hydrate', 'PRD-001', 'Hydraterende shampoo', 25, 'fles', 4.50, 9.95, 1),
('Kleurcreme Bruin', 'PRD-002', 'Professionele kleurcreme', 40, 'tube', 5.75, 14.95, 1),
('Styling Mousse', 'PRD-003', 'Mousse voor volume', 18, 'bus', 3.20, 8.95, 1),
('Extensions Tape', 'PRD-004', 'Tape voor extensions', 12, 'set', 9.50, 19.95, 1),
('Heat Protect Spray', 'PRD-005', 'Bescherming bij styling', 30, 'fles', 4.10, 10.95, 1);

INSERT INTO behandelingen (
    naam, type, beschrijving, duur_minuten, prijs, actief
) VALUES
('Knippen', 'Haar', 'Knippen en afwerken', 45, 32.50, 1),
('Kleuren', 'Haar', 'Volledige kleurbehandeling', 90, 68.00, 1),
('Styling', 'Haar', 'Stylen en fohnen', 40, 29.95, 1),
('Extensions', 'Haar', 'Extensions plaatsen', 120, 110.00, 1),
('Basic Gezichtsbehandeling', 'Gezicht', 'Basis gezichtsbehandeling', 45, 45.00, 1);

INSERT INTO medewerker_behandeling (
    medewerker_id,
    behandeling_id
) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 2),
(4, 3),
(5, 4);

INSERT INTO behandeling_product (
    behandeling_id, product_id, hoeveelheid
) VALUES
(1, 1, 1.00),
(2, 2, 1.50),
(3, 3, 1.00),
(4, 4, 2.00),
(5, 5, 1.00);

INSERT INTO klant_kenmerken (
    klant_id, type, titel, beschrijving, actief
) VALUES
(1, 'allergie', 'Parfum', 'Klant reageert op sterk geparfumeerde producten', 1),
(2, 'voorkeur', 'Ochtend', 'Boekt graag voor 11:00', 1),
(3, 'wens', 'Rustige plek', 'Wil rustige behandelplek', 1),
(4, 'medisch', 'Gevoelige huid', 'Voorzichtig met kleurproducten', 1),
(5, 'voorkeur', 'Vaste stylist', 'Boekt het liefst bij Emma', 1);

INSERT INTO afspraken (
    klant_id,
    medewerker_id,
    start_datumtijd,
    eind_datumtijd,
    status,
    opmerking_klant,
    interne_notitie,
    totaalprijs,
    aangemaakt_door_gebruiker_id
) VALUES
(1, 1, '2026-07-08 10:00:00', '2026-07-08 11:00:00', 'gepland', 'Eerste afspraak', 'Gebruik parfumvrije producten', 32.50, 6),
(2, 2, '2026-07-09 09:30:00', '2026-07-09 10:15:00', 'bevestigd', 'Punten knippen', NULL, 32.50, 7),
(3, 3, '2026-07-10 13:00:00', '2026-07-10 14:30:00', 'gepland', 'Uitgroei bijwerken', NULL, 68.00, 8),
(4, 4, '2026-07-11 15:00:00', '2026-07-11 15:45:00', 'gepland', 'Styling voor feest', NULL, 29.95, 9),
(5, 5, '2026-07-12 12:00:00', '2026-07-12 14:00:00', 'gepland', 'Extensions intake', NULL, 110.00, 10);

INSERT INTO afspraak_behandeling (
    afspraak_id,
    behandeling_id,
    prijs_op_moment,
    duur_minuten_op_moment,
    notitie,
    uitgevoerd
) VALUES
(1, 1, 32.50, 45, 'Knippen basis', 0),
(2, 1, 32.50, 45, 'Punten knippen', 0),
(3, 2, 68.00, 90, 'Uitgroei bijwerken', 0),
(4, 3, 29.95, 40, 'Styling feest', 0),
(5, 4, 110.00, 120, 'Extensions intake', 0);
