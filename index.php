<?php

require 'db/DB.php';

require 'entity/Role.php';
require 'entity/User.php';
require 'entity/Meeting.php';

require 'manager/RoleManager.php';
require 'manager/UserManager.php';
require 'manager/MeetingManager.php';

if (isset($_GET['page'])){
    // Admin area.
    if($_GET['page'] === 'admin') {
        require 'view/admin/index.php';
    }
    // Else, then display client area.
    else {
        // TODO.
    }

}
