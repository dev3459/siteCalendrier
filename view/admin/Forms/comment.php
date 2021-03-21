<?php

/************************************************/
/*  Traitement du formulaire s'il a été envoyé  */
/************************************************/
if(isset($_POST['submit'])) {
    if (!DB::isNull($_POST['comment'])) {
        $comment = DB::sanitizeString($_POST['comment']);
        $meeting->setComment($comment);
        // Saving comment
        $result = MeetingManager::save($meeting);
        if($result) {
            DB::setMessage("Commentaire ajouté / modifié avec succès", 'success');
        }
        else {
            DB::setMessage("Une erreur est survenue en ajoutant / modifiant le commentaire", 'error');
        }
    }
}

/**************************************************************/
/*   If $meeting object was provided, then drawing the form.  */
/**************************************************************/
if(isset($meeting) && $currentUser->getId() === $meeting->getEmployee()->getId() || RoleManager::isAdmin($currentUser)) { ?>
    <div class="page-title">
        <h3 class="d-flex justify-content-between align-items-center">
            <?= strlen($meeting->getComment()) === 0 ? "Ajouter un commentaire" : "Editer un commentaire" ?>
            <a href="index.php?page=admin&item=meetings" class="btn btn-sm btn-outline-info float-right mr-1">
                <i class="fas fa-angle-left"></i> <span class="btn-header"> Retour</span>
            </a>
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate accept-charset="utf-8" action="#" method="post">
                        <!-- User first and last names. -->
                        <div class="form-group row p-2">
                            <div class="col-md-12">
                                <textarea class="form-control" name="comment" id="comment" placeholder="Votre commentaire" required><?= $meeting->getComment() ?></textarea>
                                <div class="invalid-feedback">Veuillez entrer un commentaire valide</div>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div> <?php
}
else {
    header('Location: index.php?page=admin&item=meetings');
}