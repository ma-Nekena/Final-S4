-- Nettoyage de la base
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS comptes_clients;
DROP TABLE IF EXISTS baremes_frais;
DROP TABLE IF EXISTS prefixes_operateurs;

-- 1. PRÉFIXES AUTORISÉS (ex: 033, 037)
CREATE TABLE prefixes_operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe VARCHAR(10) NOT NULL UNIQUE
);

-- 2. BARÈMES DE FRAIS PAR TRANCHE DE MONTANT
CREATE TABLE baremes_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation VARCHAR(20) NOT NULL, -- 'retrait' ou 'transfert'
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL
);

-- 3. COMPTES CLIENTS
CREATE TABLE comptes_clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone VARCHAR(15) NOT NULL UNIQUE,
    solde REAL DEFAULT 0.0,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 4. HISTORIQUE DES TRANSACTIONS
CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_transaction VARCHAR(20) NOT NULL, -- 'depot', 'retrait', 'transfert'
    telephone_expediteur VARCHAR(15) NULL,
    telephone_destinataire VARCHAR(15) NULL,
    montant REAL NOT NULL,
    frais REAL DEFAULT 0.0,
    date_transaction DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- =========================================================
-- DONNÉES INITIALES (Exemple de l'énoncé)
-- =========================================================

-- Préfixes autorisés
INSERT INTO prefixes_operateurs (prefixe) VALUES ('033'), ('037');

-- Barème pour Retrait
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
('retrait', 1000001, 2000000, 3000);

-- Barème pour Transfert (identique par défaut)
INSERT INTO baremes_frais (type_operation, montant_min, montant_max, frais) VALUES
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