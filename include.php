<?php
require_once './db/DB.php';
$db = DB::getInstance();

// Include entities.
require_once 'entity/Role.php';
require_once 'entity/User.php';

// Include managers.
require_once 'manager/RoleManager.php';
require_once 'manager/UserManager.php';


$roleManager = new RoleManager();
$userManager = new UserManager();
