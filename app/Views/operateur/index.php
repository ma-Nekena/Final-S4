<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Opérateur - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-link text-white navbar-brand fw-bold" href="#">📱 Opérateur Mobile Money</a>
    <div>
        <a href="<?= base_url('/client/login') ?>" class="btn btn-outline-info text-white me-2">Espace Client</a>
        <a href="<?= base_url('/operateur') ?>" class="btn btn-primary">Espace Opérateur</a>
    </div>
  </div>
</nav>

<div class="container my-4">

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Situation Gain (Total des Frais)</h5>
                    <h2 class="fw-bold"><?= number_format($total_gains, 2, ',', ' ') ?> Ar</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Nombre de Comptes Clients</h5>
                    <h2 class="fw-bold"><?= count($clients) ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Configuration des Préfixes</div>
                <div class="card-body">
                    <form action="<?= base_url('/operateur/prefixe/ajouter') ?>" method="post" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="prefixe" class="form-control" placeholder="ex: 033" required>
                            <button class="btn btn-success" type="submit">Ajouter</button>
                        </div>
                    </form>

                    <ul class="list-group">
                        <?php foreach($prefixes as $p): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong><?= esc($p['prefixe']) ?></strong>
                                <a href="<?= base_url('/operateur/prefixe/supprimer/'.$p['id']) ?>" class="btn btn-danger btn-sm">X</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Barème des Frais (Modifiable)</div>
                <div class="card-body">
                    
                    <form action="<?= base_url('/operateur/bareme/ajouter') ?>" method="post" class="row g-2 mb-3">
                        <div class="col-md-3">
                            <select name="type_operation" class="form-select" required>
                                <option value="retrait">Retrait</option>
                                <option value="transfert">Transfert</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="montant_min" class="form-control" placeholder="Montant Min" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="montant_max" class="form-control" placeholder="Montant Max" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="frais" class="form-control" placeholder="Frais (Ar)" required>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success btn-sm">+ Ajouter une tranche</button>
                        </div>
                    </form>

                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Type</th>
                                <th>Tranche de montant (Ar)</th>
                                <th>Frais (Ar)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($baremes as $b): ?>
                                <tr>
                                    <td><span class="badge bg-<?= $b['type_operation'] == 'retrait' ? 'warning' : 'info' ?>"><?= esc(ucfirst($b['type_operation'])) ?></span></td>
                                    <td>De <?= number_format($b['montant_min'], 0, ',', ' ') ?> à <?= number_format($b['montant_max'], 0, ',', ' ') ?></td>
                                    <td><strong><?= number_format($b['frais'], 0, ',', ' ') ?></strong></td>
                                    <td>
                                        <a href="<?= base_url('/operateur/bareme/supprimer/'.$b['id']) ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white fw-bold">Situation des Comptes Clients</div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Numéro de Téléphone</th>
                        <th>Solde Actuel (Ar)</th>
                        <th>Date de création</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($clients)): ?>
                        <tr><td colspan="4" class="text-center">Aucun client inscrit pour le moment.</td></tr>
                    <?php else: ?>
                        <?php foreach($clients as $c): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><strong><?= esc($c['numero_telephone']) ?></strong></td>
                                <td class="text-success fw-bold"><?= number_format($c['solde'], 2, ',', ' ') ?> Ar</td>
                                <td><?= $c['date_creation'] ?></td>
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