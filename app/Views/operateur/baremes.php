<?= $this->extend('layout/maino') ?>


<?= $this->section('content') ?>


<h2 class="page-title">
    💰 Gestion du Barème des Frais
</h2>



<div class="dashboard-card">


    <h4>
        Ajouter une tranche de frais
    </h4>



    <form action="<?= base_url('/operateur/bareme/ajouter') ?>" method="post" class="row g-3">


        <div class="col-md-3">

            <select name="type_operation" class="form-control" required>

                <option value="retrait">
                    Retrait
                </option>

                <option value="transfert">
                    Transfert
                </option>

            </select>

        </div>



        <div class="col-md-3">

            <input 
                type="number"
                step="0.01"
                name="montant_min"
                class="form-control"
                placeholder="Montant minimum"
                required
            >

        </div>




        <div class="col-md-3">

            <input 
                type="number"
                step="0.01"
                name="montant_max"
                class="form-control"
                placeholder="Montant maximum"
                required
            >

        </div>




        <div class="col-md-3">

            <input 
                type="number"
                step="0.01"
                name="frais"
                class="form-control"
                placeholder="Frais (Ar)"
                required
            >

        </div>




        <div class="col-12 text-end">

            <button class="btn-gold">

                + Ajouter une tranche

            </button>

        </div>



    </form>


</div>





<div class="dashboard-card">


    <h4>
        Liste des frais configurés
    </h4>



    <div class="table-responsive">


        <table class="modern-table">


            <thead>

                <tr>

                    <th>
                        Type
                    </th>

                    <th>
                        Tranche de montant
                    </th>

                    <th>
                        Frais
                    </th>

                    <th>
                        Action
                    </th>

                </tr>


            </thead>



            <tbody>


            <?php if(empty($baremes)): ?>


                <tr>

                    <td colspan="4" class="text-center">

                        Aucun barème enregistré.

                    </td>

                </tr>



            <?php else: ?>



                <?php foreach($baremes as $b): ?>


                <tr>


                    <td>

                        <?php if($b['type_operation'] == 'retrait'): ?>

                            <span class="badge bg-warning text-dark">
                                Retrait
                            </span>

                        <?php else: ?>

                            <span class="badge bg-info">
                                Transfert
                            </span>

                        <?php endif; ?>


                    </td>




                    <td>

                        De 
                        <?= number_format($b['montant_min'],0,',',' ') ?>

                        à

                        <?= number_format($b['montant_max'],0,',' ,' ') ?>

                        Ar

                    </td>




                    <td class="money">


                        <?= number_format($b['frais'],0,',',' ') ?>

                        Ar


                    </td>




                    <td>


                        <a 
                        href="<?= base_url('/operateur/bareme/supprimer/'.$b['id']) ?>"
                        class="delete-btn"
                        >

                            Supprimer

                        </a>


                    </td>



                </tr>


                <?php endforeach; ?>


            <?php endif; ?>


            </tbody>


        </table>


    </div>


</div>



<?= $this->endSection() ?>