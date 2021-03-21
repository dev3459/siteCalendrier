<?php
session_start();

require 'db/DB.php';

require 'entity/Role.php';
require 'entity/User.php';
require 'entity/Meeting.php';

require 'manager/RoleManager.php';
require 'manager/UserManager.php';
require 'manager/MeetingManager.php';

// Getting current user if any.
if(isset($_SESSION['current_user'])) {
    $currentUser = unserialize($_SESSION['current_user']);
    if(RoleManager::isPowerUser($currentUser)) {
        // Display the admin area link.
    }
}
else {
    $currentUser = new User();
}

if (isset($_GET['page'])){
    // Admin area.
    if($_GET['page'] === 'admin') {
        // Si l'utilisateur est connecté et qu'il est admin ou employé alors on peut afficher l'espace d'amdministration.
        if($currentUser->getId() && RoleManager::isPowerUser($currentUser)) {
            require 'view/admin/index.php';
        }
        else {
            // Redirect to the home page if user is not admin or employee.
            header('Location: index.php');
        }
    }

    // Load meetings for calendar.
    elseif($_GET['page'] === 'events') {
        echo MeetingManager::getMeetingsAsJson();
    }
    // Login process, after having provided login informations.
    elseif($_GET['page'] === 'login') {
        if(isset($_POST['email']) && isset($_POST['password'])) {
            $email = DB::sanitizeString($_POST['email']);
            $password = DB::sanitizeString($_POST['password']);

            $user = UserManager::getUserByMail($email);
            if(!$user->getId()) {
                DB::setMessage("Nous n'avons aucun utilisateur avec cet email", 'error');
            }
            else {
                if(password_verify($password, $user->getPassword())) {
                    // Do something with logged in user.
                    $_SESSION['current_user'] = serialize($user);
                    if(RoleManager::isPowerUser($user)) {
                        echo "Redirect to admin area";
                        header('Location: index.php?page=admin');
                    }
                }
                else {
                    DB::setMessage("Le mot de passe entré n'est pas correct", 'error');
                }
            }

            require 'view/front/index.php';
        }
    }
    // Disconnect process.
    elseif($_GET['page'] === 'logout') {
        $currentUser = null;
        $_SESSION = [];
        session_destroy();
        header('Location: index.php');
    }
}
// Else, then display client area.
else {
    require 'view/front/index.php';
}
