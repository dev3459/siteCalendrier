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
     * Save a role.
     * @param Role $role
     * @return bool
     */
    public function save(Role $role): bool {
        // If id is null, then it does not exits into the database.
        if(is_null($role->getId())) {
            $stmt = DB::getInstance()->prepare("INSERT INTO role (name) VALUES (:n)");
            $stmt->bindValue(':n', $role->getName());
            if($stmt->execute()) {
                return true;
            }
        }
        else {
            // If id is not null, then role comes from the database.
            $stmt = DB::getInstance()->prepare("UPDATE role set name=:n WHERE id=:i");
            $stmt->bindValue(':n', $role->getName());
            $stmt->bindValue(':i', $role->getId());
            if($stmt->execute()) {
                return true;
            }
        }

        return false;
    }

}