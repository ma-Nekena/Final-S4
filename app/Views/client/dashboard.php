<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Client - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
  <div class="container">
    <span class="navbar-brand fw-bold">📱 Client : <?= esc($client['numero_telephone']) ?></span>
    <a href="<?= base_url('/client/logout') ?>" class="btn btn-outline-light btn-sm">Déconnexion</a>
  </div>
</nav>

<div class="container my-4">

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card bg-success text-white mb-4 shadow-sm">
        <div class="card-body text-center">
            <h5>Votre Solde Actuel</h5>
            <h1 class="display-4 fw-bold"><?= number_format($client['solde'], 2, ',', ' ') ?> Ar</h1>
        </div>
    </div>

    <div class="row mb-4">
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Dépôt (Automatique)</div>
                <div class="card-body">
                    <form action="<?= base_url('/client/depot') ?>" method="post">
                        <div class="mb-3">
                            <input type="number" step="0.01" name="montant" class="form-control" placeholder="Montant (Ar)" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Faire un Dépôt</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Retrait (Automatique)</div>
                <div class="card-body">
                    <form action="<?= base_url('/client/retrait') ?>" method="post">
                        <div class="mb-3">
                            <input type="number" step="0.01" name="montant" class="form-control" placeholder="Montant (Ar)" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 text-white">Faire un Retrait</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Transfert d'argent</div>
                <div class="card-body">
                    <form action="<?= base_url('/client/transfert') ?>" method="post">
                        <div class="mb-2">
                            <input type="text" name="telephone_destinataire" class="form-control" placeholder="N° Destinataire" required>
                        </div>
                        <div class="mb-3">
                            <input type="number" step="0.01" name="montant" class="form-control" placeholder="Montant (Ar)" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Faire un Transfert</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">Historique de vos Transactions</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Expéditeur</th>
                        <th>Destinataire</th>
                        <th>Montant</th>
                        <th>Frais</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($history)): ?>
                        <tr><td colspan="6" class="text-center">Aucune transaction enregistrée.</td></tr>
                    <?php else: ?>
                        <?php foreach ($history as $h): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-<?= $h['type_transaction'] == 'depot' ? 'success' : ($h['type_transaction'] == 'retrait' ? 'warning' : 'info') ?>">
                                        <?= esc(ucfirst($h['type_transaction'])) ?>
                                    </span>
                                </td>
                                <td><?= esc($h['telephone_expediteur'] ?? '-') ?></td>
                                <td><?= esc($h['telephone_destinataire'] ?? '-') ?></td>
                                <td><strong><?= number_format($h['montant'], 2, ',', ' ') ?> Ar</strong></td>
                                <td><?= number_format($h['frais'], 2, ',', ' ') ?> Ar</td>
                                <td><?= $h['date_transaction'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>