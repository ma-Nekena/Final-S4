<?= $this->extend('layout/maino') ?>

<?= $this->section('content') ?>

<h2> Autres Opérateurs & Reversements</h2>

<div class="row mt-4">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white fw-bold">
                Ajouter un Opérateur
            </div>
            <div class="card-body">
                <form action="<?= base_url('/operateur/autres-operateurs/ajouter') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom de l'opérateur</label>
                        <input type="text" name="nom_operateur" class="form-control" placeholder="ex: Orange, Telma" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Préfixe</label>
                        <input type="text" name="prefixe" class="form-control" placeholder="ex: 032, 034" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Commission (%)</label>
                        <input type="number" step="0.01" name="commission_pourcentage" class="form-control" placeholder="ex: 2.5" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-dark text-white fw-bold">
                 Montants Cumulés à Reverser
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Opérateur</th>
                            <th>Préfixe</th>
                            <th>Commission</th>
                            <th>Montant Brut à Reverser</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($operateurs_avec_montants)): ?>
                            <?php foreach ($operateurs_avec_montants as $op): ?>
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
                                        <?= number_format($op['montant_a_envoyer'] ?? 0, 2, ',', ' ') ?> Ar
                                    </td>
                                    <td>
                                        <a href="<?= base_url('/operateur/autres-operateurs/supprimer/' . $op['id']) ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet opérateur ?')">
                                            ✕
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    Aucun autre opérateur configuré pour le moment.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>