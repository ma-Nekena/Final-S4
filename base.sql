DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS comptes_clients;
DROP TABLE IF EXISTS baremes_frais;
DROP TABLE IF EXISTS prefixes_operateurs;
DROP TABLE IF EXISTS autres_operateurs;

-- 1. PRÉFIXES NOTRE OPÉRATEUR
CREATE TABLE prefixes_operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe VARCHAR(10) NOT NULL UNIQUE
);

-- 2. AUTRES OPÉRATEURS PARTENAIRES
CREATE TABLE autres_operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_operateur VARCHAR(50) NOT NULL,
    prefixe VARCHAR(10) NOT NULL UNIQUE,
    commission_pourcentage REAL DEFAULT 0.0
);

-- 3. BARÈMES DE FRAIS PAR TRANCHE DE MONTANT
CREATE TABLE baremes_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation VARCHAR(20) NOT NULL, -- 'retrait' ou 'transfert'
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL
);

-- 4. COMPTES CLIENTS
CREATE TABLE comptes_clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone VARCHAR(15) NOT NULL UNIQUE,
    solde REAL DEFAULT 0.0,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 5. TRANSACTIONS
CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_transaction VARCHAR(20) NOT NULL, -- 'depot', 'retrait', 'transfert'
    telephone_expediteur VARCHAR(15) NULL,
    telephone_destinataire VARCHAR(15) NULL,
    montant REAL NOT NULL,
    frais REAL DEFAULT 0.0,
    commission_autre_operateur REAL DEFAULT 0.0, -- Frais % supplémentaire si autre opérateur
    autre_operateur_id INTEGER NULL,
    date_transaction DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(autre_operateur_id) REFERENCES autres_operateurs(id)
);

-- DONNÉES DE DÉPART
INSERT INTO prefixes_operateurs (prefixe) VALUES ('033'), ('037');

-- Exemple d'autres opérateurs (ex: Orange 032, Airtel 033/031)
INSERT INTO autres_operateurs (nom_operateur, prefixe, commission_pourcentage) VALUES 
('Orange', '032', 2.0),
('Airtel', '031', 3.0),
('Telma', '034', 4.0);

INSERT INTO baremes_frais (type_operation, montant_min, montant_max, frais) VALUES
('retrait', 100, 1000, 50),
('retrait', 1001, 5000, 50),
('retrait', 5001, 10000, 100),
('retrait', 10001, 25000, 200),
('retrait', 25001, 50000, 400),
('retrait', 50001, 100000, 800),
('retrait', 100001, 250000, 1500),
('retrait', 250001, 500000, 1500),
('retrait', 500001, 1000000, 2500),
('retrait', 1000001, 2000000, 3000),
('transfert', 100, 1000, 50),
('transfert', 1001, 5000, 50),
('transfert', 5001, 10000, 100),
('transfert', 10001, 25000, 200),
('transfert', 25001, 50000, 400),
('transfert', 50001, 100000, 800),
('transfert', 100001, 250000, 1500),
('transfert', 250001, 500000, 1500),
('transfert', 500001, 1000000, 2500),
('transfert', 1000001, 2000000, 3000);