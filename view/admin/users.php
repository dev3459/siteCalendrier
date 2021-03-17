<?php
    $userManager = new UserManager();
    $roleManager = new RoleManager();
    $users = $userManager->getUsersByRole();
?>
<div class="page-title">
    <h3>Utilisateurs</h3>
</div>
<div class="row"> <?php
    foreach($users as $role => $usersByGroup) { ?>
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header flex">
                    <div><?= ucfirst($role) ?></div>
                    <div>
                        <a href="index.php?page=admin&item=users&action=add&&role_id=<?= $roleManager->getRoleByName($role)->getId() ?>">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Mail</th>
                                    <th>Téléphone</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($usersByGroup as $user) {
                                /* @var User $user */ ?>
                                <tr>
                                    <th scope="row"><?php echo $user->getId() ?></th>
                                    <td><?= $user->getLastName() ?></td>
                                    <td><?= $user->getFirstName() ?></td>
                                    <td><?= $user->getMail() ?></td>
                                    <td><?= $user->getPhone() ?></td>
                                    <td><i class="fas fa-trash"></i></td>
                                </tr><?php
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <?php
    } ?>
</div>