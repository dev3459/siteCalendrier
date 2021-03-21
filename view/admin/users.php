<div class="page-title">
    <h3>Utilisateurs</h3>
</div>
<div class="row box box-primary"> <?php
    foreach(UserManager::getUsersByRole() as $role => $usersByGroup) { ?>
        <div class="col-md-12 col-lg-12 mt-4">
            <div class="card">
                <div class="card-header flex">
                    <div><?= ucfirst($role) ?></div>
                    <?php
                        if(RoleManager::isAdmin($currentUser)) {                    ?>
                            <div>
                                <a class="btn btn-sm btn-outline-primary float-right" href="index.php?page=admin&item=users&action=add&&role_id=<?= RoleManager::getRoleByName($role)->getId() ?>">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div> <?php
                        } ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="sortable table dataTables">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Mail</th>
                                    <th class="no-sort">Téléphone</th>
                                    <th class="no-sort">&nbsp;</th>
                                    <th class="no-sort"> </th>
                                    <th class="no-sort"> </th>
                                    <?php
                                        if(RoleManager::isAdmin($currentUser)) { ?>
                                        <th class="no-sort"> </th>
                                        <th class="no-sort"> </th><?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($usersByGroup as $user) {
                                /* @var User $user */ ?>
                                <tr>
                                    <th scope="row" class="text-center"><?php echo $user->getId() ?></th>
                                    <td><?= $user->getLastName() ?></td>
                                    <td><?= $user->getFirstName() ?></td>
                                    <td><?= $user->getMail() ?></td>
                                    <td><?= $user->getPhone() ?></td>
                                    <td><a class="btn btn-outline-primary btn-rounded" href="mailto:<?= $user->getMail() ?>"><i class="far fa-envelope"></i></a></td>
                                    <td><a class="btn btn-outline-primary btn-rounded" href="tel:<?= $user->getPhone() ?>"><i class="fas fa-phone-square-alt"></i></a></td>
                                    <td><a class="btn btn-outline-primary btn-rounded" href="sms://<?= $user->getPhone() ?>"><i class="fas fa-sms"></i></a></td>
                                    <?php
                                    if(RoleManager::isAdmin($currentUser)) { ?>
                                        <td>
                                            <a class="btn btn-outline-info btn-rounded" href="index.php?page=admin&item=users&action=edit&user_id=<?= $user->getId() ?>">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-outline-danger btn-rounded" href="index.php?page=admin&item=users&action=delete&user_id=<?= $user->getId() ?>">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td><?php
                                    }
                                    ?>
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