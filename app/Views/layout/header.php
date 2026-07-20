<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Mobile Money' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>

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
<main class="container content">