<?= $this->extend('layout/maino') ?>


<?= $this->section('content') ?>


<h2 class="page-title">
    👥 Gestion des Comptes Clients
</h2>




<div class="dashboard-card">


    <h4>
        Liste des clients
    </h4>



    <div class="table-responsive">


        <table class="modern-table">


            <thead>
                <tr>
                    <th>
                        #
                    </th>


                    <th>
                        Numéro téléphone
                    </th>


                    <th>
                        Solde actuel
                    </th>


                    <th>
                        Date de création
                    </th>


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

                        <?= number_format($c['solde'],2,',',' ') ?>

                        Ar

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



</div>



<?= $this->endSection() ?>