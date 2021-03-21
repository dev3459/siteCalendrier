<?php

/**
 * Class RoleManager
 */
class RoleManager {

    /**
     * Return a list of available roles as Role array.
     * @return array
     */
    public static function getRoles(): array {
        $roles = [];
        $stmt = DB::getInstance()->prepare("SELECT * FROM role");

        if($stmt->execute()) {
            foreach($stmt->fetchAll() as $role_data) {
                $roles[] = new Role($role_data['id'], $role_data['name']);
            }
        }
        return $roles;
    }

    /**
     * Return a Role object based on a given role id.
     * @param int $roleId
     * @return Role
     */
    public static function getRole(int $roleId): Role {
        $role = new Role();
        $stmt = DB::getInstance()->prepare("SELECT * FROM role WHERE id=:i");
        $stmt->bindValue(':i', $roleId);

        if($stmt->execute()) {
            $data = $stmt->fetch();
            // $data is false if request failed.
            if($data !== false) {
                $role->setId($data['id']);
                $role->setName($data['name']);
            }
        }
        return $role;
    }

    /**
     * @param string $roleName
     * @return Role
     */
    public static function getRoleByName(string $roleName): Role {
        $role = new Role();
        $stmt = DB::getInstance()->prepare("SELECT * FROM role WHERE name=:name");
        $stmt->bindValue(':name', $roleName);

        if($stmt->execute()) {
            $data = $stmt->fetch();
            $role->setId($data['id']);
            $role->setName($data['name']);
        }
        return $role;
    }

    /**
     * Return the number users a role has.
     * @param $roleId
     * @return int
     */
    public static function countUsers($roleId): int {
        $stmt = DB::getInstance()->prepare("SELECT count(*) as users_count FROM user WHERE role_fk=:role");
        $stmt->bindValue(':role', $roleId);
        $result = $stmt->execute();
        if($result) {
            return $stmt->fetch()['users_count'];
        }

        return 0;
    }

    /**
     * Save a role if id is not null, add a new one otherwise.
     * @param Role $role
     * @return bool
     */
    public static function save(Role &$role): bool {
        // If id is null, then it does not exits into the database.
        if(is_null($role->getId())) {
            // If role name is not null.
            if(!DB::isNull($role->getName())) {
                $stmt = DB::getInstance()->prepare("INSERT INTO role (name) VALUES (:n)");
                $stmt->bindValue(':n', DB::sanitizeString($role->getName()));
                if ($stmt->execute()) {
                    $role->setId(DB::getInstance()->lastInsertId());
                    return true;
                }
            }
        }
        else {
            // We only can update if role name is not null, database does not accept null values.
            if(!DB::isNull($role->getName())) {
                // If id is not null, then role comes from the database.
                $stmt = DB::getInstance()->prepare("UPDATE role set name=:n WHERE id=:i");
                $stmt->bindValue(':n', DB::sanitizeString($role->getName()));
                $stmt->bindValue(':i', DB::sanitizeInt($role->getId()), PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Delete a role if exists.
     * @param Role $role
     * @return bool
     */
    public static function delete(Role $role): bool {
        if(!DB::isNull($role->getId())) {
            $stmt = DB::getInstance()->prepare("DELETE FROM role WHERE id=:id");
            $stmt->bindValue(':id', $role->getId());
            return $stmt->execute();
        }
        return false;
    }


    /**
     * Return true if the role is deletable ( not the default roles ).
     * @param string $roleName
     * @return bool
     */
    public static function isDeletable(string $roleName): bool {
        return !in_array($roleName, ['admin', 'employee', 'client']);
    }


    /**
     * @param Role $role
     * @return bool
     */
    public static function isEditable(Role $role): bool {
        return self::isDeletable($role->getName());
    }


    /**
     * Return true if the role exists.
     * @param $roleName
     * @return bool
     */
    public static function roleExists($roleName): bool {
        $stmt = DB::getInstance()->prepare("SELECT count(*) as count FROM role WHERE name=:name");
        $stmt->bindValue(':name', trim($roleName));
        if($stmt->execute()) {
            $data = $stmt->fetch();
            if($data) {
                return intval($data['count']) > 0;
            }
        }

        return true;
    }


    /**
     * Return a list of available role users.
     * @param Role $role
     * @return array
     */
    public static function getUsers(Role $role): array {
        $users = [];
        if($role->getId()) {
            $stmt = DB::getInstance()->prepare("SELECT * FROM user WHERE role_fk=:role_id");
            $stmt->bindValue(':role_id', $role->getId());
            if($stmt->execute() && $users_data = $stmt->fetchAll()) {
                foreach($users_data as $data) {
                    $user = new User();
                    $user->setId($data['id']);
                    $user->setMail($data['mail']);
                    $user->setPhone($data['phone']);
                    $user->setRole($role);
                    $user->setFirstName($data['firstName']);
                    $user->setLastName($data['lastName']);
                    $users[] = $user;
                }
            }
        }
        return $users;
    }

    /**
     * Return true if user is allowed to see the admin area.
     * @param User $user
     * @return bool
     */
    public static function isPowerUser(User $user) {
        return $user->getRole()->getId() && in_array($user->getRole()->getName(), ['admin', 'employee']);
    }

    /**
     * Return true if user is admin.
     * @param User $user
     * @return bool
     */
    public static function isAdmin(User $user) {
        return $user->getRole()->getId() && $user->getRole()->getName() === 'admin';
    }
}