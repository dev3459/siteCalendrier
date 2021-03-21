<?php
// Including admin partials.
require '_partials/header.php';

if (isset($_GET['item'])) {
    // Admin actions such as get users list and so on.
    switch ($_GET['item']) { // no need to test values as no echo and strict check.

        /***********************/
        /** Users management **/
        /**********************/
        case 'users':
            if(isset($_GET['action']) && in_array($_GET['action'], ['add', 'delete', 'edit'])) {
                // User addition.
                if(RoleManager::isAdmin($currentUser)) {
                    if ($_GET['action'] === 'add' && isset($_GET['role_id'])) {
                        addUser();
                    } // User edition.
                    elseif ($_GET['action'] === 'edit' && isset($_GET['user_id'])) {
                        editUser();
                    } // User deletion.
                    elseif ($_GET['action'] === 'delete' && isset($_GET['user_id'])) {
                        deleteUser();
                    }
                    else {
                        require 'users.php';
                    }
                }
                else {
                    require 'users.php';
                }
            }
            else {
                // No action = Default action = display the users list.
                require 'users.php';
            }
            break;

        /***********************/
        /** Roles management **/
        /**********************/
        case 'roles':
            if(RoleManager::isAdmin($currentUser)) {
                if (isset($_GET['action']) && in_array($_GET['action'], ['add', 'delete', 'edit'])) {
                    // Role addition.
                    if ($_GET['action'] === 'add') {
                        addRole();
                    } // Role edition.
                    elseif ($_GET['action'] === 'edit' && isset($_GET['role_id'])) {
                        editRole();
                    } // Role deletion.
                    elseif ($_GET['action'] === 'delete' && isset($_GET['role_id'])) {
                        deleteRole();
                    }
                }
                else {
                    // No action = Default action = display the roles list.
                    require 'roles.php';
                }
            }
            else {
                header('Location: index.php?page=admin');
            }
            break;

        /*************************/
        /** Meetings management **/
        /*************************/
        case 'meetings':
            if(isset($_GET['action']) && in_array($_GET['action'], ['add', 'delete', 'edit', 'add-comment', 'edit-comment'])) {
                // Meeting addition.
                if($_GET['action'] === 'add') {
                    addMeeting();
                }
                // Meeting edition.
                elseif($_GET['action'] === 'edit' && isset($_GET['meeting_id'])) {
                    editMeeting();
                }
                // Meeting deletion.
                elseif($_GET['action'] === 'delete' && isset($_GET['meeting_id'])) {
                    deleteMeeting();
                }
                // Meeting add comment.
                elseif(in_array($_GET['action'], ['add-comment', 'edit-comment']) && isset($_GET['meeting_id'])) {
                    $meetingId = intval($_GET['meeting_id']);
                    $meeting = MeetingManager::getMeeting($meetingId);

                    if($meeting->getId()) {
                        // Comments addition / edition only available for meeting assigned employee and admin.
                        if(RoleManager::isAdmin($currentUser) || $meeting->getEmployee()->getId() === $currentUser->getId()) {
                            require 'forms/comment.php';
                        }
                    }
                }
            }
            require 'meetings.php';
            break;
        default:
            // If user enter something else then display the default entry page.
            require 'dashboard.php';
    }
}
else {
    // The default page for admin and employees.
    require 'dashboard.php';
}

require '_partials/footer.php';


/**
 * Add a new user.
 */
function addUser() {
    // $_GET['role_id'] contains the role ID to use to add new user.
    $roleId = intval($_GET['role_id']);
    $role = RoleManager::getRole($roleId);
    $user = new User();
    if($role->getId()) {
        $user->setRole($role);
        require 'forms/user.php';
    }
    else {
        DB::setMessage("Le rôle choisi n'existe pas !", 'error');
        require 'users.php';
    }
}

/**
 * Add a new rôle.
 */
function addRole() {
    // $_GET['role_id'] contains the role ID to use to add new user.
    $role = new Role();
    require 'forms/role.php';
}

/**
 * Add a new meeting.
 */
function addMeeting() {
    // $_GET['meeting_id'] contains the role ID to use to add new user.
    $meeting = new Meeting();
    require 'forms/meeting.php';
}

/**
 * Edit a user.
 */
function editUser() {
    $userId = intval($_GET['user_id']);
    $user = UserManager::getUser($userId);
    // If $user exists then display the user edit form.
    if($user->getId()) {
        require 'forms/user.php';
    }
    // Else display the users listing.
    else {
        DB::setMessage("Cet utilisateur n'existe pas !", 'error');
        require 'users.php';
    }
}

/**
 * Edit a rôle.
 */
function editRole() {
    $roleId = intval($_GET['role_id']);
    $role = RoleManager::getRole($roleId);
    if($role->getId() && RoleManager::isEditable($role)) {
        require 'forms/role.php';
    }
    else {
        DB::setMessage("Le rôle spécifié n'existe pas !", 'error');
        require 'roles.php';
    }
}

/**
 * Edit a meeting.
 */
function editMeeting() {
    $meetingId = intval($_GET['meeting_id']);
    $meeting = MeetingManager::getMeeting($meetingId);
    if($meeting->getId()) {
        require 'forms/meeting.php';
    }
    else {
        DB::setMessage("Le meeting sélectionné ne semble pas exister", 'error');
        require 'meetings.php';
    }
}

/**
 * Delete a user.
 */
function deleteUser() {
    $userId = intval($_GET['user_id']);
    $user = UserManager::getUser($userId);
    // if user exists, id is !== null.
    if($user->getId()) {
        $result = UserManager::delete($user);
        if($result) {
            DB::setMessage("Utilisateur supprimé", 'success');
        }
        else {
            DB::setMessage("Une erreur est survenue en supprimant l'utilisateur", 'error');
        }
    }
    require 'users.php';
}

/**
 * Delete a rôle
 */
function deleteRole() {
    $roleId = intval($_GET['role_id']);
    $role = RoleManager::getRole($roleId);
    // if role exists, id is !== null.
    if($role->getId() && RoleManager::isDeletable($role->getName())) {
        $result = RoleManager::delete($role);
        if($result) {
            DB::setMessage("Rôle supprimé", 'success');
        }
        else {
            DB::setMessage("Le rôle spécifié n'a pas pu être supprimé !", 'error');
        }
    }
    require 'roles.php';
}

/**
 * Delete a meeting.
 */
function deleteMeeting() {
    $meetingId = intval($_GET['meeting_id']);
    $meeting = MeetingManager::getMeeting($meetingId);
    // if meeting exists, id is !== null.
    if($meeting->getId()) {
        $result = MeetingManager::delete($meeting);
        DB::setMessage('Meeting supprimé', 'success');
    }
    else {
        DB::setMessage("Le meeting que vous tentez de supprimer n'existe pas !", 'error');
    }
    require 'meetings.php';
}

