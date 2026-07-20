# VERSION 1
## database
    [OK] creation de database
        [OK] table prefies_operateurs
        [OK] table baremes_frais
        [OK] table comptes_clients
        [OK] table transactions
    [OK] insertion des donnees

## models
    [OK] BaremeModel
    [OK] ClientModel
    [OK] PrefixeModel
    [OK] TransactionModel

## controllers
    [OK] operateurCOntroller 
    [OK] clientController

# VERSION2
    [OK] ajout de table operateur
    [OK] Configuration des préfixes valable pour les autres opérateurs (ex: 032 et 031, …)
    [OK] Configuration % en plus de commissions pour les transferts vers les autres opérateurs 
    [OK] Sur la page “Situation gain via les différents frais” , séparer opérateur et autres opérateurs
    [OK] Situation des montants à envoyer à chaque opérateur

    [OK] Option inclure frais de retrait lors de l’envoi
    [OK] Envoi multiple vers plusieurs numéros ( divisé le montant pour chaque numéro)
    même opérateur uniquement

