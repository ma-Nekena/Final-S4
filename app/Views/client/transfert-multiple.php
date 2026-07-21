<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Transfert Multiple - Mobile Money</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

<header class="header">

    <div class="container header-container">

        <a href="<?= base_url('/') ?>" class="brand">
            📱 Mobile Money
        </a>

        <div class="menu">

            <a href="<?= base_url('/client/login') ?>" class="btn-client">
                Client
            </a>

            <a href="<?= base_url('/operateur') ?>" class="btn-operateur">
                Opérateur
            </a>

        </div>

    </div>

</header>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0">

                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">
                        🚀 Transfert Multiple
                    </h4>
                </div>



                <div class="card-body">

                    <form action="<?= base_url('/client/transfert-multiple/envoyer') ?>" method="post">


                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Numéros des destinataires

                            </label>
                        <button
                            type="button"
                            class="btn btn-warning fw-bold"
                            onclick="ajouterChampNumero()">

                            <i class="bi bi-plus-circle"></i>

                            Ajouter un numéro

                        </button>
                        <div id="liste-numeros">
                            <div class="numero-row">
                                <span class="phone-icon">📱</span>
                                <input
                                    type="text"
                                    name="destinataires[]"
                                    class="numero-input"
                                    placeholder="Ex : 0331122233"
                                    required
                                >
                                <button type="button" class="delete-number" onclick="supprimerChampNumero(this)">
                                    ✕
                                </button>
                            </div>
                        </div>
                            <div class="form-text">

                                Le montant total sera réparti automatiquement entre tous les destinataires.

                            </div>

                        </div>




                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Montant total (Ar)

                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="montant_total"
                                class="form-control"
                                placeholder="Ex : 50000"
                                required
                            >

                        </div>




                        <div class="form-check mb-4">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="fraisCheck"
                                name="inclure_frais_retrait"
                                value="1"
                            >

                            <label class="form-check-label" for="fraisCheck">

                                Inclure les frais de retrait pour les destinataires

                            </label>

                        </div>




                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-success btn-lg fw-bold">

                                <i class="bi bi-send-fill"></i>

                                Envoyer le transfert multiple

                            </button>

                        </div>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>



<script src="<?= base_url('js/client.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<footer class="footer">

    <div class="container">

        <p class="copyright">
            © <?= date('Y') ?>Projet-Final - Mobile Money 
        </p>

        <div class="footer-links">
            <a href="#">ETU004193</a>
            <a href="#">ETU004115</a>
        </div>

    </div>

</footer>
</body>

</html>