<?php

/**
 * Class RoleManager
 */
class RoleManager {

    /**
     * Return a list of available roles as Role array.
     * @return array
     */
    public function getRoles(): array {
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
    public function getRole(int $roleId): Role {
        $role = new Role();
        $stmt = DB::getInstance()->prepare("SELECT * FROM role WHERE id=:i");
        $stmt->bindValue(':i', $roleId);

        if($stmt->execute()) {
            $data = $stmt->fetch();
            $role->setId($data['id']);
            $role->setName($data['name']);
        }
        return $role;
    }

    /**
     * Save a role.
     * @param Role $role
     * @return bool
     */
    public function save(Role $role): bool {
        // If id is null, then it does not exits into the database.
        if(is_null($role->getId())) {
            // If role name is not null.
            if(!DB::isNull($role->getName())) {
                $stmt = DB::getInstance()->prepare("INSERT INTO role (name) VALUES (:n)");
                $stmt->bindValue(':n', DB::sanitizeString($role->getName()));
                if ($stmt->execute()) {
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
}