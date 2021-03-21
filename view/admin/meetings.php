<?php
if(RoleManager::isAdmin($currentUser)) {
    $meetings = MeetingManager::getMeetings();
}
else {
    $meetings = MeetingManager::getMeetings($currentUser);
}

?>

<div class="page-title">
    <h3>Rendez-vous</h3>
</div>
<div class="row box box-primary p-4">
    <!-- Meeting detail -->
    <div class="col-md-12 col-lg-12 hidden" id="meeting-details">
        <div class="card">
            <div class="card-header">Détail du rendez vous</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="nav flex-column nav-pills">
                            <span class="nav-link active" id="pill-informations-tab">Informations</span>
                            <span class="nav-link" id="pill-employee-tab">Employé</span>
                            <span class="nav-link" id="pill-project-tab">Projet</span>
                            <span class="nav-link" id="pill-employee-comment-tab">Commentaire</span>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pill-informations"></div>
                            <div class="tab-pane fade" id="pill-employee"></div>
                            <div class="tab-pane fade" id="pill-project"></div>
                            <div class="tab-pane fade" id="pill-employee-comment">
                                <div>
                                    <!-- meeting_id value is added with JavaScript. -->
                                    <a id="add_comment" class="btn btn-sm btn-outline-primary float-right" href="index.php?page=admin&item=meetings&action=add-comment&meeting_id=">
                                        <i class="fas fa-plus" id="comment-button">Ajouter un commentaire</i>
                                    </a>
                                </div>
                                <div class="mt-2" id="comment-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header flex">
                <div>Cliquez sur le bouton visualiser pour obtenir le détail du rendez-vous</div>
                <div>
                    <a class="btn btn-sm btn-outline-primary float-right" href="index.php?page=admin&item=meetings&action=add">
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
                            <th>Date</th>
                            <th>Client</th>
                            <th class="no-sort"></th>
                            <th class="no-sort"></th>
                            <th class="no-sort"></th>
                        </tr>
                        </thead>
                        <tbody> <?php
                        foreach($meetings as $meeting) {?>
                            <tr>
                                <th scope="row"><?= $meeting->getId() ?></th>
                                <td><?= $meeting->getDate()->format('Y-m-d H:i:s') ?></td>
                                <td><?= $meeting->getClient()->getFirstName() . "  " . $meeting->getClient()->getLastName() ?></td>
                                <td class="show-meeting-details">
                                    <span class="btn btn-outline-warning btn-rounded">
                                        <i class="far fa-eye"></i>
                                    </span>
                                    <!-- Meeting data -->
                                    <div class="hidden" data-name="id"><?= $meeting->getId() ?></div>
                                    <div class="hidden" data-name="location"><?= $meeting->getLocation() ?></div>
                                    <div class="hidden" data-name="date"><?= $meeting->getDate()->format('d-m-Y à H\hi') ?></div>
                                    <div class="hidden" data-name="project"><?= $meeting->getProject() ?></div>
                                    <div class="hidden" data-name="client-first-name"><?= $meeting->getClient()->getFirstName() ?></div>
                                    <div class="hidden" data-name="client-last-name"><?= $meeting->getClient()->getLastName() ?></div>
                                    <div class="hidden" data-name="client-mail"><?= $meeting->getClient()->getMail() ?></div>
                                    <div class="hidden" data-name="client-phone"><?= $meeting->getClient()->getPhone() ?></div>
                                    <div class="hidden" data-name="employee-first-name"><?= $meeting->getEmployee()->getFirstName() ?></div>
                                    <div class="hidden" data-name="employee-last-name"><?= $meeting->getEmployee()->getLastName() ?></div>
                                    <div class="hidden" data-name="employee-mail"><?= $meeting->getEmployee()->getMail() ?></div>
                                    <div class="hidden" data-name="employee-phone"><?= $meeting->getEmployee()->getPhone() ?></div>
                                    <div class="hidden" data-name="employee-comment"><?= $meeting->getComment() ?></div>
                                </td>
                                <td>
                                    <a class="btn btn-outline-info btn-rounded" href="index.php?page=admin&item=meetings&action=edit&meeting_id=<?= $meeting->getId() ?>">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-outline-danger btn-rounded" href="index.php?page=admin&item=meetings&action=delete&meeting_id=<?= $meeting->getId() ?>">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
