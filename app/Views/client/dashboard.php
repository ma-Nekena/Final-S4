<?= $this->extend('layout/main') ?>


<?= $this->section('content') ?>


<div class="client-dashboard">


    <!-- Barre utilisateur -->
    <div class="client-topbar">

        <div>
            📱 Client :
            <strong><?= esc($client['numero_telephone']) ?></strong>
        </div>

        <a href="<?= base_url('/client/logout') ?>" class="logout-btn">
            Déconnexion
        </a>

    </div>



    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>

    <?php endif; ?>




    <!-- Solde -->

    <div class="balance-card">

        <h5>
            Votre Solde Actuel
        </h5>

        <h1>
            <?= number_format($client['solde'], 2, ',', ' ') ?> Ar
        </h1>

    </div>




    <!-- Actions -->

    <div class="row action-section">



        <!-- Dépôt -->

        <div class="col-md-4">

            <div class="action-card">

                <div class="action-title">
                    💰 Dépôt
                </div>


                <form action="<?= base_url('/client/depot') ?>" method="post">

                    <input 
                        type="number"
                        step="0.01"
                        name="montant"
                        class="custom-input"
                        placeholder="Montant (Ar)"
                        required
                    >


                    <button class="deposit-btn">
                        Faire un dépôt
                    </button>

                </form>

            </div>

        </div>





        <!-- Retrait -->

        <div class="col-md-4">

            <div class="action-card">

                <div class="action-title">
                    💸 Retrait
                </div>


                <form action="<?= base_url('/client/retrait') ?>" method="post">


                    <input 
                        type="number"
                        step="0.01"
                        name="montant"
                        class="custom-input"
                        placeholder="Montant (Ar)"
                        required
                    >


                    <button class="withdraw-btn">
                        Faire un retrait
                    </button>


                </form>

            </div>

        </div>





        <!-- Transfert -->

        <div class="col-md-4">


            <div class="action-card">

                <div class="action-title">
                    📤 Transfert
                </div>



                <form action="<?= base_url('/client/transfert') ?>" method="post">


                    <input 
                        type="text"
                        name="telephone_destinataire"
                        class="custom-input"
                        placeholder="N° Destinataire"
                        required
                    >


                    <input 
                        type="number"
                        step="0.01"
                        name="montant"
                        class="custom-input"
                        placeholder="Montant (Ar)"
                        required
                    >


                    <button class="transfer-btn">
                        Faire un transfert
                    </button>


                </form>


            </div>


        </div>



    </div>





    <!-- Historique -->


    <div class="history-card">


        <div class="history-title">
            Historique de vos Transactions
        </div>



        <div class="table-responsive">


            <table class="transaction-table">


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


                    <tr>

                        <td colspan="6">
                            Aucune transaction enregistrée.
                        </td>

                    </tr>


                <?php else: ?>



                    <?php foreach ($history as $h): ?>


                    <tr>


                        <td>

                            <span class="badge">

                                <?= esc(ucfirst($h['type_transaction'])) ?>

                            </span>

                        </td>


                        <td>
                            <?= esc($h['telephone_expediteur'] ?? '-') ?>
                        </td>


                        <td>
                            <?= esc($h['telephone_destinataire'] ?? '-') ?>
                        </td>


                        <td>
                            <strong>
                                <?= number_format($h['montant'],2,',',' ') ?> Ar
                            </strong>
                        </td>


                        <td>
                            <?= number_format($h['frais'],2,',',' ') ?> Ar
                        </td>


                        <td>
                            <?= $h['date_transaction'] ?>
                        </td>



                    </tr>


                    <?php endforeach; ?>


                <?php endif; ?>


                </tbody>


            </table>


        </div>



    </div>

</div>


<?= $this->endSection() ?>