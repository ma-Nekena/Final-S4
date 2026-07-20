<?= $this->extend('layout/maino') ?>

<?= $this->section('content') ?>

<h2>Tableau de bord</h2>

<!-- 1. Situation Gain via les Différents Frais -->
<h4 class="mt-4 mb-3">📊 Situation gain via les différents frais</h4>

<div class="row mb-4">
    <!-- Gains de notre Opérateur -->
    <div class="col-md-4">
        <div class="stat-card gain">
            <h5>Gains de notre Opérateur</h5>
            <small class="text-muted d-block mb-2">(Frais sur dépôts, retraits, transferts internes)</small>
            <h2><?= number_format($gains_internes ?? 0, 2, ',', ' ') ?> Ar</h2>
        </div>
    </div>

    <!-- Gains via Autres Opérateurs -->
    <div class="col-md-4">
        <div class="stat-card commission">
            <h5>Gains Autres Opérateurs</h5>
            <small class="text-muted d-block mb-2">(Commissions prélevées sur les interconnexions)</small>
            <h2><?= number_format($gains_commissions ?? 0, 2, ',', ' ') ?> Ar</h2>
        </div>
    </div>

    <!-- Total Général -->
    <div class="col-md-4">
        <div class="stat-card total-gain">
            <h5>Total Général des Gains</h5>
            <small class="text-muted d-block mb-2">(Cumul total des revenus de la plateforme)</small>
            <h2><?= number_format($total_gains ?? 0, 2, ',', ' ') ?> Ar</h2>
        </div>
    </div>
</div>

<!-- 2. Situation des Montants à Envoyer à Chaque Opérateur -->
<h4 class="mt-4 mb-3">💸 Situation des montants à envoyer à chaque opérateur</h4>

<div class="table-responsive mb-4">
    <table class="modern-table">
        <thead>
            <tr>
                <th>Opérateur Destinataire</th>
                <th>Préfixe</th>
                <th>Commission (%)</th>
                <th>Montant Brut Cumulé à Reverser</th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($operateurs_avec_montants)): ?>
            <tr>
                <td colspan="4" class="text-center">
                    Aucun transfert vers d'autres opérateurs enregistré.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach($operateurs_avec_montants as $op): ?>
            <tr>
                <td>
                    <strong><?= esc($op['nom_operateur'] ?? $op['nom'] ?? 'N/A') ?></strong>
                </td>
                <td>
                    <span class="badge bg-secondary"><?= esc($op['prefixe']) ?></span>
                </td>
                <td>
                    <?= esc($op['commission_pourcentage']) ?> %
                </td>
                <td class="money">
                    <strong><?= number_format($op['montant_a_envoyer'] ?? 0, 2, ',', ' ') ?> Ar</strong>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- 3. Liste des Clients -->
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h4 class="mb-0">Liste des clients</h4>
    <div class="stat-card client py-2 px-3 m-0 d-inline-block">
        <span class="fw-bold">Total Clients : <?= count($clients ?? []) ?></span>
    </div>
</div>

<div class="table-responsive">
    <table class="modern-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Numéro téléphone</th>
                <th>Solde actuel</th>
                <th>Date de création</th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($clients)): ?>
            <tr>
                <td colspan="4" class="text-center">
                    Aucun client inscrit pour le moment.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach($clients as $c): ?>
            <tr>
                <td>
                    <?= $c['id'] ?>
                </td>
                <td>
                    <strong>
                        <?= esc($c['numero_telephone']) ?>
                    </strong>
                </td>
                <td class="money">
                    <?= number_format($c['solde'], 2, ',', ' ') ?> Ar
                </td>
                <td>
                    <?= $c['date_creation'] ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>