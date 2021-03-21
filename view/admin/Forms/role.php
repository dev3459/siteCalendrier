<?php

/************************************************/
/*  Traitement du formulaire s'il a été envoyé  */
/************************************************/
if(isset($_POST['submit'])) {
    if (!DB::isNull($_POST['name'])) {
        $name = DB::sanitizeString($_POST['name']);
        $role->setName($name);

        if(!RoleManager::roleExists($name)) {
            // Checking if role already exists.
            RoleManager::save($role);
        }

        // Role id is not null in case of success.
        if($role->getId()) {
            DB::setMessage("Rôle ajouté avec succès", 'success');
        }
        else {
            DB::setMessage("Une erreur est survenue, le rôle existe peut être déjà", 'error');
        }
    }
}

/***********************************************************/
/*   If $role object was provided, then drawing the form.  */
/***********************************************************/
if(isset($role)) { ?>
    <div class="page-title">
        <h3 class="d-flex justify-content-between align-items-center">
            <?= is_null($role->getId()) ? "Ajouter un rôle" : "Editer un rôle" ?>
            <a href="index.php?page=admin&item=roles" class="btn btn-sm btn-outline-info float-right mr-1">
                <i class="fas fa-angle-left"></i> <span class="btn-header"> Retour</span>
            </a>
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Détail du rôle</div>
                <div class="card-body">
                    <h5 class="card-title">Rôle: <?= ucfirst($role->getName()) ?></h5>
                    <form class="needs-validation" novalidate accept-charset="utf-8" action="#" method="post">

                        <!-- User first and last names. -->
                        <div class="form-group row p-2">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nom du rôle" value="<?= $role->getName() ?? '' ?>" required>
                                <div class="invalid-feedback">Veuillez entrer un nom de rôle valide</div>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div> <?php
}