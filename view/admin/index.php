<?php
// Including admin partials.
require '_partials/header.php';

if (isset($_GET['item'])) {
    // Admin actions such as get users list and so on.
    switch ($_GET['item']) { // no need to test values as no echo and strict check.
        case 'users':
            if(isset($_GET['action']) && in_array($_GET['action'], ['add', 'delete', 'edit'])) {
                if($_GET['action'] === 'add' && isset($_GET['role_id'])) {
                    // $_GET['role_id'] contains the role ID to use to add new user.
                    $roleId = intval($_GET['role_id']);
                    require 'forms/user.php';
                }
                elseif($_GET['action'] === 'edit' && isset($_GET['user_id'])) {
                    $userId = intval($_GET['user_id']);
                    require 'forms/user.php';
                }
            }
            else {
                // No action = Default action = display the users list.
                require 'users.php';
            }
            break;
        case 'roles':
            //require './roles.php';
            break;
        case 'meetings':
            //require './meetings.php';
            break;
        default:
            // If user enter something else then display the default entry page.
            require 'dashboard.php';
    }
}
else {
    // The default page for admin and employees.
    //require 'dashboard.php';
}

require '_partials/footer.php';