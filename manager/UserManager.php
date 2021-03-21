<?php

/**
 * Class UserManager
 */
class UserManager {
    /**
     * Return a list of available users as User array.
     * @return array
     */
    public static function getUsers(): array {
        $users = [];
        $stmt = DB::getInstance()->prepare("SELECT * FROM user");

        if($stmt->execute()) {
            $roleManager = new RoleManager();
            foreach($stmt->fetchAll() as $user_data) {
                $role = $roleManager->getRole($user_data['role_fk']);
                // If id is a number and nut null, then create user object.
                if($role->getId()) {
                    $users[] = new User(
                        $user_data['id'],
                        $user_data['mail'],
                        $user_data['password'],
                        $user_data['phone'],
                        $user_data['firstName'],
                        $user_data['lastName'],
                        $role,
                    );
                }
            }
        }
        return $users;
    }

    /**
     * Return a list of users based on roles.
     * @return array
     */
    public static function getUsersByRole(): array {
        $users = self::getUsers();
        $roles = (new RoleManager())->getRoles();

        $byRole = [];
        foreach($roles as $role) {
            $byRole[$role->getName()] = [];
        }

        // Filtering users by roles.
        foreach($users as $user) {
            $byRole[$user->getRole()->getName()][] = $user;
        }
        return $byRole;
    }

    /**
     * Return a User object based on a given user id.
     * @param int $userId
     * @return User
     */
    public static function getUser(int $userId): User {
        $user = new User();
        $stmt = DB::getInstance()->prepare("SELECT * FROM user WHERE id=:i");
        $stmt->bindValue(':i', $userId);

        if($stmt->execute()) {
            $roleManager = new RoleManager();
            $data = $stmt->fetch();
            if($data !== false) {
                $user->setId($data['id']);
                $user->setMail($data['mail']);
                $user->setPassword($data['password']);
                $user->setPhone($data['phone']);
                $user->setFirstName($data['firstName']);
                $user->setLastName($data['lastName']);
                $role = $roleManager->getRole($data['role_fk']);
                // Adding rôle only if it exists ( role id is null if nothing matches in database )
                if($role->getId()) {
                    $user->setRole($role);
                }
            }
        }
        return $user;
    }

    /**
     * Save a User.
     * @param User $user
     * @return bool
     */
    public static function save(User &$user): bool {
        // If id is null, then it does not exits into the database.
        if(is_null($user->getId())) {
            if(!DB::isNull($user->getMail(), $user->getPassword(), $user->getPhone(), $user->getFirstName(), $user->getLastName(), $user->getRole()->getId())) {
                // Setting up prepared statement.
                $stmt = DB::getInstance()->prepare("
                    INSERT INTO user (mail, password, phone, firstName, lastName, role_fk) 
                    VALUES (:m, :p, :phone, :fname, :lname, :r)
                ");

                // Binding user values.
                $stmt->bindValue(':m', DB::sanitizeString($user->getMail()));
                $stmt->bindValue(':p', DB::encodePassword($user->getPassword()));
                $stmt->bindValue(':phone', DB::sanitizeString($user->getPhone()));
                $stmt->bindValue(':fname', DB::sanitizeString($user->getFirstName()));
                $stmt->bindValue(':lname', DB::sanitizeString($user->getLastName()));
                $stmt->bindValue(':r', DB::sanitizeInt($user->getRole()->getId()), PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $user->setId(DB::getInstance()->lastInsertId());
                    return true;
                }
            }
        }
        else {
            if(!DB::isNull($user->getMail(), $user->getPhone(), $user->getFirstName(), $user->getLastName(), $user->getRole()->getId())) {
                // Setting up prepared statement.
                $stmt = DB::getInstance()->prepare("
                    UPDATE user SET 
                        mail=:m, 
                        phone=:phone, 
                        firstName=:fname, 
                        lastName=:lname, 
                        role_fk=:r
                    WHERE id=:i
                ");

                // Binding user values.
                $stmt->bindValue(':m', DB::sanitizeString($user->getMail()));
                $stmt->bindValue(':phone', DB::sanitizeString($user->getPhone()));
                $stmt->bindValue(':fname', DB::sanitizeString($user->getFirstName()));
                $stmt->bindValue(':lname', DB::sanitizeString($user->getLastName()));
                $stmt->bindValue(':r', DB::sanitizeInt($user->getRole()->getId()), PDO::PARAM_INT);
                $stmt->bindValue(':i', DB::sanitizeInt($user->getId()), PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Update user specific password.
     * @param String $clearPassord
     * @param User $user
     */
    public static function updatePassword(String $clearPassord, User $user): bool {
        if(!DB::isNull($user->getId(), $clearPassord)) {
            // Setting up prepared statement.
            $stmt = DB::getInstance()->prepare("UPDATE user SET password=:p WHERE id=:i");

            // Binding user values.
            $stmt->bindValue(':p', DB::encodePassword($clearPassord));
            $stmt->bindValue(':i', DB::sanitizeInt($user->getId()), PDO::PARAM_INT);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }


    /**
     * Delete a user from database.
     * @param User $user
     * @return bool
     */
    public static function delete(User $user): bool {
        if(!DB::isNull($user->getId())) {
            $stmt = DB::getInstance()->prepare("DELETE FROM user WHERE id=:id");
            $stmt->bindValue(':id', $user->getId());
            return $stmt->execute();
        }
        return false;
    }

    /**
     * Return an array containing user meetings.
     * @param User $user
     * @return array
     */
    public static function getMeetings(User $user): array {
        if(!DB::isNull($user->getId())) {
            return (new MeetingManager())->getMeetings($user);
        }
        return [];
    }

    /**
     * Get a user from iuts email.
     * @param string $mail
     * @return User
     */
    public static function getUserByMail(string $mail): User {
        $user = new User();
        $stmt = DB::getInstance()->prepare("SELECT * FROM user WHERE mail=:mail");
        $stmt->bindValue(':mail', $mail);

        if($stmt->execute()) {
            $roleManager = new RoleManager();
            $data = $stmt->fetch();
            if($data !== false) {
                $user->setId($data['id']);
                $user->setMail($data['mail']);
                $user->setPassword($data['password']);
                $user->setPhone($data['phone']);
                $user->setFirstName($data['firstName']);
                $user->setLastName($data['lastName']);
                $role = $roleManager->getRole($data['role_fk']);
                if($role->getId()) {
                    $user->setRole($role);
                }
            }
        }
        return $user;
    }
}