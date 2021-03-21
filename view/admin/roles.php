<?php
$roles = RoleManager::getRoles(); ?>

<div class="page-title">
    <h3>Rôles</h3>
</div>
<div class="row box box-primary">
    <div class="col-md-12 col-lg-12 mt-4">
        <div class="card">
            <div class="card-header flex">
                <div>Rôles disponibles</div>
                <div>
                    <a class="btn btn-sm btn-outline-primary float-right" href="index.php?page=admin&item=roles&action=add">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table dataTables">
                        <thead>
                            <tr role="row">
                                <th>ID</th>
                                <th class="sorting">Role</th>
                                <th class="sorting text-center">Utilisateurs</th>
                                <?php
                                if(RoleManager::isAdmin($currentUser)) { ?>
                                    <th class="no-sort"> </th>
                                    <th class="no-sort"> </th> <?php
                                } ?>
                            </tr>
                        </thead>
                        <tbody> <?php
                        foreach($roles as $role) {
                            /* @var Role $role */ ?>
                            <tr>
                                <th scope="row"><?php echo $role->getId() ?></th>
                                <td><?= $role->getName() ?></td>
                                <td class="text-center"><?= RoleManager::countUsers($role->getId()) ?></td>
                                <?php
                                if(RoleManager::isAdmin($currentUser)) { ?>
                                    <td> <?php
                                        if(RoleManager::isEditable($role)) { ?>
                                            <a class="btn btn-outline-info btn-rounded" href="index.php?page=admin&item=roles&action=edit&role_id=<?= $role->getId() ?>">
                                                <i class="fas fa-pen"></i>
                                            </a> <?php
                                        }
                                        ?>
                                    </td>
                                    <td> <?php
                                        if(RoleManager::isDeletable($role->getName())) { ?>
                                            <a class="btn btn-outline-danger btn-rounded" href="index.php?page=admin&item=roles&action=delete&role_id=<?= $role->getId() ?>">
                                                <i class="fas fa-trash"></i>
                                            </a> <?php
                                        } ?>
                                    </td><?php
                                } ?>
                            </tr><?php
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>