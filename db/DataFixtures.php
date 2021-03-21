<?php

class DataFixtures {

    private bool $status;

    /**
     * DataFixtures constructor.
     */
    public function __construct() {
        $stmt_roles = DB::getInstance()->prepare('DELETE FROM role WHERE 1');
        $stmt_users = DB::getInstance()->prepare('DELETE FROM user WHERE 1');
        $stmt_meets = DB::getInstance()->prepare('DELETE FROM meeting WHERE 1');

        $this->status = $stmt_roles->execute() && $stmt_users->execute() && $stmt_meets;
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
            $roles['admin'] = $role;
            echo "  --> Role ajouté: admin" . PHP_EOL;

            // Adding employee role.
            $role = new Role(null, 'employee');
            $manager->save($role);
            $roles['employee'] = $role;
            echo "  --> Role ajouté: employee" . PHP_EOL;

            // Adding client role.
            $role = new Role(null, 'client');
            $manager->save($role);
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
                $admin->setPassword('Azerty00!');
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
                $employee->setPassword('Azerty00!');
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
                $client->setPassword('Azerty00!');
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


    /**
     * Load fake meetings for dev purpose.
     * @param array $users
     * @param int $count
     */
    public function loadMeetings(array $users): array {
        $meetings = [];
        $meetingManager = new MeetingManager();
        echo "Table des meetings vidée" . PHP_EOL;

        foreach($users['clients'] as $client) {
            $meeting = new Meeting();
            $meeting->setClient($client);
            $meeting->setEmployee($users['employees'][rand(0, count($users['employees']) -1)]);
            $meeting->setProject('Super projet numéro ' . $client->getId());
            $meeting->setLocation('Un endroit au top ' . $client->getId());
            $meeting->setDate((new DateTime())->modify('+2 days')->format('Y-m-d H:i:s'));

            // Sauvegarde.
            if($meetingManager->save($meeting)) {
                echo "  --> Meeting ajouté: Entre le client " . $client->getMail() . " ET l'employé " . $meeting->getEmployee()->getMail() . PHP_EOL;
            }
        }

        return $meetings;
    }
}

require './DB.php';

require '../entity/Role.php';
require '../entity/User.php';
require '../entity/Meeting.php';

require '../manager/RoleManager.php';
require '../manager/UserManager.php';
require '../manager/MeetingManager.php';

$fixtures = new DataFixtures();
$roles = $fixtures->loadRoles();
$users = $fixtures->loadUsers($roles, 1, 2, 5);
$fixtures->loadMeetings($users);