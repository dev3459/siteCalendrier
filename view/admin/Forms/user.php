<?php

/************************************************/
/*  Traitement du formulaire s'il a été envoyé  */
/************************************************/
$error = false;
if(isset($_POST['submit'])) {
    // firstname, lastname, mail et phone sont obligatoires. Password ne l'est pas dans le cas d'une édition utilisateur.
    if (!DB::isNull($_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['phone'])) {
        $firstName = DB::sanitizeString($_POST['firstname']);
        $lastName = DB::sanitizeString($_POST['lastname']);
        $mail = DB::sanitizeString($_POST['mail']);
        $phone = DB::sanitizeString($_POST['phone']);

        // Mail validation.
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            DB::setMessage("L'adresse mail n'est pas valide", 'error');
        }

        // Password validation if provided ( no need of password in user edition ).
        if(isset($_POST['password']) && strlen($_POST['password']) > 0) {
            $password = DB::sanitizeString($_POST['password']);
            $regx = "#^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,30}$#";
            if (!preg_match($regx, $password)) {
                DB::setMessage("Le mot de passe n'est pas valide", 'error');
            }
        }

        // Phone number validation.
        $regx = "#^[0-9\-\(\)\/\+\s]*$#i";
        if(!preg_match($regx, $phone)) {
            DB::setMessage("Le numéro de téléphone n'est pas valide", 'error');
        }

        // First name, last name length validation.
        if(strlen($firstName) <= 2 || strlen($lastName) <= 2) {
            DB::setMessage("Le nom ou le prénom n'est pas assez long", 'error');
        }

        // If no error stored in error handler, then storing the user data.
        if(!DB::hasError()) {
            $user->setLastName($lastName);
            $user->setFirstName($firstName);
            $user->setPhone($phone);
            $user->setMail($mail);
            // id is null in case of new user, then apssword is required.
            if (is_null($user->getId())) {
                if (isset($password) && strlen($password) > 0) {
                    $user->setPassword($password);
                } else {
                    DB::setMessage("Le mot de passe n'est pas valide", 'error');
                }
            } else {
                if (isset($password)) {
                    // Else, user exists, updating password.
                    UserManager::updatePassword($password, $user);
                }
            }

            // Apply role if role was changed.
            if (isset($_POST['role'])) {
                $role = DB::sanitizeInt($_POST['role']);
                $role = RoleManager::getRole($role);
                $user->setRole($role);
            }

            // Saving user.
            UserManager::save($user);

            // User id is not null in case of success.
            if ($user->getId()) {
                DB::setMessage("Utilisateur ajouté/modifié avec succès", 'success');
            } else {
                DB::setMessage("Une erreur inconnue est survenue en ajoutant/modifiant cet utilisateur", 'error');
            }
        }
    }
}

/***********************************************************/
/*   If $user object was provided, then drawing the form.  */
/***********************************************************/
if(isset($user)) { ?>
    <div class="page-title">
        <h3 class="d-flex justify-content-between align-items-center">
            <?= is_null($user->getId()) ? "Ajouter un utilisateur" : "Editer un utilisateur" ?>
            <a href="index.php?page=admin&item=users" class="btn btn-sm btn-outline-info float-right mr-1">
                <i class="fas fa-angle-left"></i> <span class="btn-header"> Retour</span>
            </a>
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Détail de l'utilisateur</div>
                <div class="card-body">
                    <h5 class="card-title">Rôle: <?= ucfirst($user->getRole()->getName()) ?></h5>
                    <?php
                    if(!is_null($user->getId())) { ?>
                        <small class="m-2">Si vous ne souhaitez pas metre à jour le mot de passe, laissez les champs vides.</small> <?php
                    } ?>
                    <form class="needs-validation" novalidate accept-charset="utf-8" action="#" method="post">

                        <!-- User first and last names. -->
                        <div class="form-group row p-2">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom" value="<?= $user->getFirstName() ?? '' ?>" required>
                                <div class="invalid-feedback">Veuillez entrer un prénom valide</div>
                            </div>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom" value="<?= $user->getLastName() ?? '' ?>" required>
                                <div class="invalid-feedback">Veuillez entrer un nom valide</div>
                            </div>
                        </div>


                        <!-- User mail and phone. -->
                        <div class="form-group row p-2">
                            <div class="col-sm-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-at prepend-fa"></i>
                                        </div>
                                    </div>
                                    <input name="mail" type="email" class="form-control" placeholder="Adresse mail" value="<?= $user->getMail() ?? '' ?>" required>
                                    <div class="invalid-feedback">Veuillez entrer une adresse mail valide</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-mobile-alt prepend-fa"></i>
                                        </div>
                                    </div>
                                    <input name="phone" type="tel" class="form-control" placeholder="Téléphone" value="<?= $user->getPhone() ?? '' ?>" required>
                                    <div class="invalid-feedback">Veuillez entrer un numéro de téléphone valide au format: +33...</div>
                                </div>
                            </div>

                        </div>

                        <!-- User password. -->
                        <div class="form-group row p-2">
                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-key prepend-fa"></i>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" >
                                    <small class="form-text text-muted">Le mot de passe doit avoir de 8 à 20 caractères, doit contenir que des lettres et des chiffres, dont une majuscule</small>
                                    <div class="invalid-feedback">Veuillez entrer un mot de passe valide</div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-redo prepend-fa"></i>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control" name="passwordConfirm" id="passwordConfirm" placeholder="Répétez le mot de passe" >
                                    <div class="invalid-feedback">Les deux mots de passe ne correspondent pas</div>
                                </div>
                            </div>
                        </div>
                        <?php
                        // Allow to change role only for existing users.
                        if($user->getId()) {
                            $roles = RoleManager::getRoles(); ?>
                            <!-- User password. -->
                            <div class="form-group row p-2">
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-question-circle"></i>
                                            </div>
                                        </div>
                                        <select name="role" id="role"> <?php
                                            foreach($roles as $availableRole) {
                                                $selected = $availableRole->getId() === $user->getRole()->getId() ? "selected" : '';
                                                echo "<option value='".$availableRole->getId()."' ".$selected.">".ucfirst($availableRole->getName())."</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div> <?php
                        } ?>
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div> <?php
}