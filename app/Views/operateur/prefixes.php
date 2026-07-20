<?= $this->extend('layout/maino') ?>


<?= $this->section('content') ?>


<div class="page-header">

    <h2>
        ⚙ Gestion des préfixes
    </h2>

    <p>
        Configurez les préfixes téléphoniques autorisés pour Mobile Money.
    </p>

</div>



<div class="dashboard-card prefix-card">


    <div class="card-title">
        Ajouter un nouveau préfixe
    </div>



<form action="<?= base_url('/operateur/prefixe/ajouter') ?>" method="post">

    <div class="prefix-form">

        <input 
            type="text"
            name="prefixe"
            class="prefix-input"
            placeholder="Ex : 033"
            required
        >

        <button class="btn-gold">
            + Ajouter
        </button>

    </div>

</form>




    <div class="table-container">


        <table class="modern-table">


            <thead>

                <tr>

                    <th>
                        Préfixe
                    </th>


                    <th>
                        Action
                    </th>


                </tr>


            </thead>



            <tbody>


            <?php if(empty($prefixes)): ?>


                <tr>

                    <td colspan="2" class="empty">

                        Aucun préfixe enregistré.

                    </td>

                </tr>



            <?php else: ?>



                <?php foreach($prefixes as $p): ?>


                <tr>


                    <td>

                        <span class="prefix-badge">
                            <?= esc($p['prefixe']) ?>
                        </span>

                    </td>



                    <td>

                        <a 
                        href="<?= base_url('/operateur/prefixe/supprimer/'.$p['id']) ?>"
                        class="delete-button"
                        >

                            🗑 Supprimer

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