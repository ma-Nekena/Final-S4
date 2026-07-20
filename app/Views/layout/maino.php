<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<title>
<?= $title ?? 'Mobile Money' ?>
</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

</head>


<body>

<?= view('layout/header') ?>

<div class="operator-layout">


    <?= $this->include('layout/sidebar') ?>


    <main class="operator-content">

        <?= $this->renderSection('content') ?>

    </main>


</div>

<?= view('layout/footer') ?>
</body>

</html>