<?php

class DataFixtures {

    private bool $status;

    /**
     * DataFixtures constructor.
     */
    public function __construct() {
        $stmt_roles = DB::getInstance()->prepare('DELETE FROM role WHERE 1');
        $stmt_users = DB::getInstance()->prepare('DELETE FROM user WHERE 1');
        $this->status = $stmt_roles->execute() && $stmt_users->execute();
    }

    /**
     * Load fictive roles data into the database.
     */
    public function loadRoles(): array {
        $roles = [];
        if($this->status) {
            echo "Table des roles vidée" . PHP_EOL;
            $manager = new RoleManager();

            // Adding admin role.
            $role = new Role(null, 'admin');
            $manager->save($role);
            $role->setId(DB::getInstance()->lastInsertId());
            $roles['admin'] = $role;
            echo "  --> Role ajouté: admin" . PHP_EOL;

            // Adding employee role.
            $role = new Role(null, 'employee');
            $manager->save($role);
            $role->setId(DB::getInstance()->lastInsertId());
            $roles['employee'] = $role;
            echo "  --> Role ajouté: employee" . PHP_EOL;

            // Adding client role.
            $role = new Role(null, 'client');
            $manager->save($role);
            $role->setId(DB::getInstance()->lastInsertId());
            $roles['client'] = $role;
            echo "  --> Role ajouté: client" . PHP_EOL;
        }
        else {
            echo "  --> Impossible de supprimer les données de la table ROLE" . PHP_EOL;
        }

        return $roles;
    }


    /**
     * Load fictive users data into the database.
     * @param array $roles
     * @param int $countAdmins
     * @param int $countEmployees
     * @param int $countClients
     * @return array
     */
    public function loadUsers(array $roles, int $countAdmins, int $countEmployees, int $countClients): array {
        $users = [
            "admins" => [],
            "employees" => [],
            "clients" => [],
        ];

        if($this->status) {
            $userManager = new UserManager();
            echo "Table des utilisateurs vidée" . PHP_EOL;
            // Admins
            for($i = 0; $i < $countAdmins; $i++) {
                $admin = new User();
                $admin->setMail('admin-'. ($i + 1) .'@gmail.com');
                $admin->setPassword('azerty');
                $admin->setPhone('+3200000' . ($i + 1));
                $admin->setFirstName('FirstName-' . ($i + 1));
                $admin->setLastName('LastName-' . ($i + 1));
                $admin->setRole($roles['admin']);

                // Sauvegarde.
                if($userManager->save($admin)) {
                    echo "  --> Admin ajouté: " . $admin->getMail() . PHP_EOL;
                    $users['admins'][] = $admin;
                }
            }

            // Employees
            for($i = 0; $i < $countEmployees; $i++) {
                $employee = new User();
                $employee->setMail('employee-'. ($i + 1) .'@gmail.com');
                $employee->setPassword('azerty');
                $employee->setPhone('+3200000' . ($i + 1));
                $employee->setFirstName('FirstName-' . ($i + 1));
                $employee->setLastName('LastName-' . ($i + 1));
                $employee->setRole($roles['employee']);

                // Sauvegarde.
                if($userManager->save($employee)) {
                    echo "  --> Employé ajouté: " . $employee->getMail() . PHP_EOL;
                    $users['employees'][] = $employee;
                }
            }

            // Clients
            for($i = 0; $i < $countClients; $i++) {
                $client = new User();
                $client->setMail('client-'. ($i + 1) .'@gmail.com');
                $client->setPassword('azerty');
                $client->setPhone('+3200000' . ($i + 1));
                $client->setFirstName('FirstName-' . ($i + 1));
                $client->setLastName('LastName-' . ($i + 1));
                $client->setRole($roles['client']);

                // Sauvegarde.
                if($userManager->save($client)) {
                    echo "  --> Client ajouté: " . $client->getMail() . PHP_EOL;
                    $users['clients'][] = $client;
                }
            }
        }
        else {
            echo "  --> Impossible de supprimer les données de la table USER" . PHP_EOL;
        }

        return $users;
    }
}

require './DB.php';
require '../entity/Role.php';
require '../entity/User.php';
require '../manager/RoleManager.php';
require '../manager/UserManager.php';

$fixtures = new DataFixtures();
$roles = $fixtures->loadRoles();
$users = $fixtures->loadUsers($roles, 1, 2, 5);