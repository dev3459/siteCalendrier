<?php
// Si le formulaire a été envoyé.
if(isset($_POST['submit'])) {
    // Traitement du formulaire
    if (!DB::isNull($_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['phone'], $_POST['password'], $_POST['roleId'])) {
        $firstName = DB::sanitizeString($_POST['firstname']);
        $lastName = DB::sanitizeString($_POST['lastname']);
        $mail = DB::sanitizeString($_POST['mail']);
        $phone = DB::sanitizeString($_POST['phone']);
        $password = DB::sanitizeString($_POST['password']);
        $roleId = DB::sanitizeInt($_POST['roleId']);

        // Checking mail.
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            header('Location: index.php?page=admin&item=users&action=add&&role_id=' . $roleId . '&err=1');
        }

        // Checking password.
        $regx = "#^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,30}$#";
        if (!preg_match($regx, $password)) {
            header('Location: index.php?page=admin&item=users&action=add&&role_id=' . $roleId . '&err=2');
        }

        // Checking phone number.
        $regx = "#^[0-9\-\(\)\/\+\s]*$#i";
        if(!preg_match($regx, $phone)) {
            header('Location: index.php?page=admin&item=users&action=add&&role_id=' . $roleId . '&err=3');
        }

        // Checking first name, last name length.
        if(strlen($firstName) <= 2 || strlen($lastName) <= 2) {
            header('Location: index.php?page=admin&item=users&action=add&&role_id=' . $roleId . '&err=4');
        }

        $roleManager = new RoleManager();
        $role = $roleManager->getRole($roleId);
        if(!$role->getId()) {
            header('Location: index.php?page=admin&item=users&action=add&&role_id=' . $roleId . '&err=5');
        }

        $userManager = new UserManager();
        $user = new User();
        $user->setRole($role);
        $user->setLastName($lastName);
        $user->setFirstName($firstName);
        $user->setPhone($phone);
        $user->setPassword($password);
        $user->setMail($mail);
        $userManager->save($user);

        if($user->getId()) {
            header('Location: index.php?page=admin&item=users&action=add&&role_id=' . $roleId . '&err=0');
        }
        else {
            header('Location: index.php?page=admin&item=users&action=add&&role_id=' . $roleId . '&err=6');
        }
    }
}

// Errors handling.
if(isset($_GET['err'])) {
    $err = DB::sanitizeInt($_GET['err']);
    switch($err) {
        case 0: ?>
            <div class="alert alert-success">Utilisateur ajouté avec succès</div> <?php
            break;
        case 1: ?>
            <div class="alert alert-danger">L'adresse mail n'est pas valide</div> <?php
            break;
        case 2: ?>
            <div class="alert alert-danger">Le mot de passe n'est pas valide</div> <?php
            break;
        case 3: ?>
            <div class="alert alert-danger">Le numéro de téléphone n'est pas valide</div> <?php
            break;
        case 4: ?>
            <div class="alert alert-danger">Le nom ou le prénom n'est pas assez long</div> <?php
            break;
        case 5: ?>
            <div class="alert alert-danger">Le rôle donné ne semble pas exister</div> <?php
            break;
        case 6: ?>
            <div class="alert alert-danger">Une erreur inconnue est survenue en ajoutant cet utilisateur</div> <?php
            break;
        default:
            break;
    }
}

// If roleId is set, then adding a new user with provided role id.
if(isset($roleId)) {
    $roleManager = new RoleManager();
    $role = $roleManager->getRole($roleId);
}

?>
<div class="page-title">
    <h3>Ajouter un utilisateur</h3>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Détail de l'utilisateur</div>
            <div class="card-body">
                <h5 class="card-title">Rôle: <?= ucfirst($role->getName()) ?></h5>
                <form class="needs-validation" novalidate accept-charset="utf-8" action="#" method="post">

                    <!-- User first and last names. -->
                    <div class="form-group row p-2">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom" required>
                            <div class="invalid-feedback">Veuillez entrer un prénom valide</div>
                        </div>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom" required>
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
                                <input name="mail" type="email" class="form-control" placeholder="Adresse mail" required>
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
                                <input name="phone" type="tel" class="form-control" placeholder="Téléphone" required>
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
                                <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" required>
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
                                <input type="password" class="form-control" name="passwordConfirm" id="passwordConfirm" placeholder="Répétez le mot de passe" required>
                                <div class="invalid-feedback">Les deux mots de passe ne correspondent pas</div>
                                </div>
                        </div>
                    </div>

                    <input type="hidden" name="roleId" value="<?= $role->getId() ?>">

                    <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>