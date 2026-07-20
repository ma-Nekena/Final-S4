<?= $this->extend('layout/main') ?>


<?= $this->section('content') ?>

<div class="login-container">

    <div class="login-card">

        <div class="login-header">
            📱 Connexion Client Mobile Money
        </div>

        <div class="login-body">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>


            <form action="<?= base_url('/client/login') ?>" method="post">

                <div class="form-group">

                    <label>
                        Numéro de téléphone :
                    </label>

                    <input 
                        type="text" 
                        name="phone_number" 
                        class="custom-input" 
                        placeholder="ex: 0331234567" 
                        required
                    >

                    <small>
                        Mettre un numéro commençant par un préfixe valide (ex: 033, 037).
                    </small>

                </div>


                <button type="submit" class="login-button">
                    Se connecter / Accéder
                </button>

            </form>


            <hr>


            <div class="operator-link">
                <a href="<?= base_url('/operateur') ?>">
                    Accéder à l'Espace Opérateur
                </a>
            </div>


        </div>

    </div>

</div>


<?= $this->endSection() ?>