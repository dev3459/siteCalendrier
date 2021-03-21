<?php

/**
 * Class MeetingManager
 */
class MeetingManager {

    /**
     * Return a list of available meetings as Meeting array.
     * @param User|null $user
     * @param string $criteria
     * @return array
     * @throws Exception
     */
    public static function getMeetings(User $user = null, string $criteria = ''): array {
        $meetings = [];
        $userManager = new UserManager();

        // Bulding criteria.
        if(strlen($criteria) > 0 && $user === null) {
            $criteria = " WHERE " . $criteria;
        }
        elseif(strlen($criteria) && $user !== null) {
            $criteria = " WHERE " . $criteria . " AND employee_fk = :id OR client_fk = :id";
        }

        if(is_null($user)) {
            $stmt = DB::getInstance()->prepare("SELECT * FROM meeting $criteria ORDER BY date DESC");
        }
        else {
            $stmt = DB::getInstance()->prepare("SELECT * FROM meeting $criteria ORDER BY date DESC");
            $stmt->bindValue(':id', $user->getId());
        }
        if($stmt->execute()) {
            foreach($stmt->fetchAll() as $data) {
                $meeting = new Meeting($data['id'], $data['location'], $data['date'], $data['project'], $data['commentaire']);
                $meeting->setEmployee($userManager->getUser($data['employee_fk']));
                $meeting->setClient($userManager->getUser($data['client_fk']));
                $meetings[] = $meeting;
            }
        }
        return $meetings;
    }

    /**
     * Return a Meeting object based on a given meeting id.
     * @param int $meetingId
     * @return Meeting
     * @throws Exception
     */
    public static function getMeeting(int $meetingId): Meeting {
        $userManager = new UserManager();
        $meeting = new Meeting();
        $stmt = DB::getInstance()->prepare("SELECT * FROM meeting WHERE id=:i");
        $stmt->bindValue(':i', $meetingId);

        if($stmt->execute()) {
            $data = $stmt->fetch();
            $meeting->setId($data['id']);
            $meeting->setDate($data['date']);
            $meeting->setLocation($data['location']);
            $meeting->setProject($data['project']);
            $meeting->setEmployee($userManager->getUser($data['employee_fk']));
            $meeting->setClient($userManager->getUser($data['client_fk']));
            $meeting->setComment($data['commentaire']);
        }
        return $meeting;
    }

    /**
     * Save a role.
     * @param Meeting $meeting
     * @return bool
     */
    public static function save(Meeting &$meeting): bool {
        // If id is null, then it does not exits into the database.
        if(is_null($meeting->getId())) {
            // If role name is not null.
            if(!DB::isNull($meeting->getLocation(), $meeting->getDate(), $meeting->getProject(), $meeting->getEmployee()->getId(), $meeting->getClient()->getId())) {
                $stmt = DB::getInstance()->prepare("
                    INSERT INTO meeting (location, date, project, employee_fk, client_fk, commentaire) 
                    VALUES (:loc, :dat, :proj, :employee, :clien, :comment)
                ");

                $stmt->bindValue(':loc', DB::sanitizeString($meeting->getLocation()));
                $stmt->bindValue(':dat', $meeting->getDate()->format('Y-m-d H:i:s'));
                $stmt->bindValue(':proj', DB::sanitizeString($meeting->getProject()));
                $stmt->bindValue(':employee', $meeting->getEmployee()->getId());
                $stmt->bindValue(':clien', $meeting->getClient()->getId());
                $stmt->bindValue(':comment', $meeting->getComment() ?? '');

                if ($stmt->execute()) {
                    $meeting->setId(DB::getInstance()->lastInsertId());
                    return true;
                }
            }
        }
        else {
            // We only can update if role name is not null, database does not accept null values.
            if(!DB::isNull($meeting->getLocation(), $meeting->getDate(), $meeting->getProject(), $meeting->getEmployee()->getId(), $meeting->getClient()->getId())) {
                // If id is not null, then role comes from the database.
                $stmt = DB::getInstance()->prepare("UPDATE meeting set 
                    location=:loc,
                    date=:dat,
                    project=:proj,
                    employee_fk=:employee,
                    client_fk=:clien,
                    commentaire=:comment
                   WHERE id=:i
                ");

                $stmt->bindValue(':loc', DB::sanitizeString($meeting->getLocation()));
                $stmt->bindValue(':dat', $meeting->getDate()->format('Y-m-d H:i:s'));
                $stmt->bindValue(':proj', DB::sanitizeString($meeting->getProject()));
                $stmt->bindValue(':employee', $meeting->getEmployee()->getId());
                $stmt->bindValue(':clien', $meeting->getClient()->getId());
                $stmt->bindValue(':i', $meeting->getId(), PDO::PARAM_INT);
                $stmt->bindValue(':comment', $meeting->getComment(), is_null($meeting->getComment()) ? PDO::PARAM_NULL : PDO::PARAM_STR);

                if ($stmt->execute()) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Delete a meeting if exists.
     * @param Meeting $meeting
     * @return bool
     */
    public static function delete(Meeting $meeting) {
        if(!DB::isNull($meeting->getId())) {
            $stmt = DB::getInstance()->prepare("DELETE FROM meeting WHERE id=:id");
            $stmt->bindValue(':id', $meeting->getId());
            return $stmt->execute();
        }
        return false;
    }

    /**
     * Return meetings as json.
     * @return string
     * @throws Exception
     */
    public static function getMeetingsAsJson(): string
    {
        $user = null;
        if(isset($_SESSION['current_user'])) {
            $user = unserialize($_SESSION['current_user']);
        }

        if(isset($_GET['start']) && isset($_GET['end'])) {
            $from = str_replace('T', ' ', DB::sanitizeString($_GET['start']));
            $from = substr($from, 0, strrpos($from, '+'));
            $to = str_replace('T', ' ', DB::sanitizeString($_GET['end']));
            $to = substr($to, 0, strrpos($to, '+'));
            if(RoleManager::isAdmin($user)) {
                $meetings = self::getMeetings();
            }
            else {
                $meetings = self::getMeetings($user, "date BETWEEN '$from' AND '$to'");
            }
        }
        else {
            $meetings = self::getMeetings($user);
        }


        $str = '[';
        foreach($meetings as $meeting) {
            /* @var Meeting $meeting */
            $start = $meeting->getDate()->format('Y-m-d\TH:i:s');
            $date = $meeting->getDate();
            $end = $date->modify('+30 minutes')->format('Y-m-d H:i:s');
            $str .= '{';
            $str .= '"title": "réservé", "start": " ' . $start . '", "end": "' . $end . '", "allDay": 0';
            $str .= '},';
        }

        $str = rtrim($str, ',');
        $str .= ']';
        return $str;
    }
}
