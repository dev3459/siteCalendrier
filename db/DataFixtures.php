<?php

class DataFixtures {

    /**
     * Load fictive data into the database.
     */
    public function loadRoles() {
        $manager = new RoleManager();
        // Adding admin role.
        $role = new Role(null, 'admin');
        $manager->save($role);

        // Adding employee role.
        $role = new Role(null, 'employee');
        $manager->save($role);

        // Adding client role.
        $role = new Role(null, 'client');
        $manager->save($role);
    }
}

require './DB.php';
require '../entity/Role.php';
require '../manager/RoleManager.php';

$fixtures = new DataFixtures();
$fixtures->loadRoles();