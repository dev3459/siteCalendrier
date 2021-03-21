<?php
/************************************************/
/*  Traitement du formulaire s'il a été envoyé  */
/************************************************/
if(isset($_POST['submit'])) {
    if (!DB::isNull($_POST['location'], $_POST['project'], $_POST['employee'], $_POST['client'])) {

        $employee = DB::sanitizeInt($_POST['employee']);
        $client = DB::sanitizeInt($_POST['client']);

        $employee = UserManager::getUser($employee);
        if(!$employee->getId()) {
            DB::setMessage("L'employé choisi n'existe pas !", 'error');
        }

        $client = UserManager::getUser($client);
        if(!$client->getId()) {
            DB::setMessage("Le client sélectionné ne semble pas exister !", 'error');
        }

        if(!DB::hasError()) {
            $meeting->setEmployee($employee);
            $meeting->setClient($client);
            if(isset($_POST['form-date'])) {
                $meeting->setDate(DB::sanitizeString($_POST['form-date']));
            }
            $meeting->setLocation(DB::sanitizeString($_POST['location']));
            $meeting->setProject(DB::sanitizeString($_POST['project']));
            // Saving comment
            if($_POST['comment']) {
                $meeting->setComment(DB::sanitizeString($_POST['comment']));
            }
            MeetingManager::save($meeting);
        }

        if($meeting->getId()) {
            DB::setMessage("Le rendez-vous a bien été ajouté", 'success');
        }
        else {
            DB::setMessage("Une erreur est survenur en ajoutant ce rendez-vous !", 'error');
        }
    }
}

/**************************************************************/
/*   If $meeting object was provided, then drawing the form.  */
/**************************************************************/
if(isset($meeting)) { ?>
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
                        <!-- Meeting location -->
                        <div class="form-group row p-2">
                            <div class="col-md-12">
                                <input class="form-control" type="text" name="location" placeholder="Lieu" value="<?= $meeting->getLocation() ?? '' ?>" required>
                                <div class="invalid-feedback">Veuillez entrer un lieu valide</div>
                            </div>
                        </div>

                        <!-- Meeting project -->
                        <div class="form-group row p-2">
                            <div class="col-md-12">
                                <textarea class="form-control" name="project" placeholder="Projet" required><?= $meeting->getProject() ?? '' ?></textarea>
                                <div class="invalid-feedback">Veuillez entrer un détail de projet valide</div>
                            </div>
                        </div>

                        <!-- Meeting comment -->
                        <div class="form-group row p-2">
                            <div class="col-md-12">
                                <textarea class="form-control" name="comment" placeholder="Commentaire"><?= $meeting->getComment() ?? '' ?></textarea>
                            </div>
                        </div>

                        <!-- Meeting employee -->
                        <div class="form-group row p-2">
                            <div class="col-md-12">
                                <label for="employee">Choisissez un employé / admin</label> <?php
                                $roles = [
                                    RoleManager::getRoleByName('admin'),
                                    RoleManager::getRoleByName('employee'),
                                ];
                                ?>
                                <select class="form-control" name="employee" id="employee"> <?php
                                    foreach($roles as $role) {
                                        /* @var Role $role */
                                        $users = RoleManager::getUsers($role);
                                        foreach ($users as $user) {
                                            $selected = '';
                                            if($meeting->getId()) {
                                                $selected = $meeting->getEmployee()->getId() === $user->getId() ? 'selected' : '';
                                            }

                                            /* @var User $user */ ?>
                                            <option value="<?= $user->getId() ?>" <?= $selected ?>><?= $user->getFirstName() . "  " . $user->getLastName() ?></option> <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Meeting client -->
                        <div class="form-group row p-2">
                            <div class="col-md-12">
                                <label for="client">Choisissez un client</label> <?php
                                $role = RoleManager::getRoleByName('client'); ?>
                                <select class="form-control" name="client" id="employee"> <?php

                                    $users = RoleManager::getUsers($role);
                                    foreach ($users as $user) {
                                        $selected = '';
                                        if($meeting->getId()) {
                                            $selected = $meeting->getClient()->getId() === $user->getId() ? 'selected' : '';
                                        }
                                        /* @var User $user */ ?>
                                        <option value="<?= $user->getId() ?>" <?= $selected ?>><?= $user->getFirstName() . "  " . $user->getLastName() ?></option> <?php
                                    } ?>
                                </select>
                            </div>
                        </div>


                        <!-- Date selection -->
                        <div class="form-group row p-2">
                            <div class="col-md-12 p-5">
                                <!-- Will create an hidden input. -->
                                <div id="calendar"></div>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div> <?php
}
