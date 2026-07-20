<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Client - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center fw-bold">
                    📱 Connexion Client Mobile Money
                </div>
                <div class="card-body p-4">
                    
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('/client/login') ?>" method="post">
                        <div class="mb-3">
                            <label class="form-label">Numéro de téléphone :</label>
                            <input type="text" name="phone_number" class="form-control form-control-lg" placeholder="ex: 0331234567" required>
                            <div class="form-text">Mettre un numéro commençant par un préfixe valide (ex: 033, 037).</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg">Se connecter / Accéder</button>
                    </form>
                    
                    <hr>
                    <div class="text-center">
                        <a href="<?= base_url('/operateur') ?>" class="text-decoration-none text-muted">Accéder à l'Espace Opérateur</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>