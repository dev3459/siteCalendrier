<?php

/**
 * Class MeetingManager
 */
class MeetingManager {

    /**
     * Return a list of available meetings as Meeting array.
     * @return array
     */
    public function getMeetings(): array {
        $meetings = [];
        $userManager = new UserManager();
        $stmt = DB::getInstance()->prepare("SELECT * FROM meeting");

        if($stmt->execute()) {
            foreach($stmt->fetchAll() as $data) {
                $meeting = new Meeting($data['id'], $data['location'], new DateTime($data['date']), $data['project']);
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
     */
    public function getMeeting(int $meetingId): Meeting {
        $userManager = new UserManager();
        $meeting = new Meeting();
        $stmt = DB::getInstance()->prepare("SELECT * FROM meeting WHERE id=:i");
        $stmt->bindValue(':i', $meetingId);

        if($stmt->execute()) {
            $data = $stmt->fetch();
            $meeting->setId($data['id']);
            $meeting->setDate(new DateTime($data['date']));
            $meeting->setLocation($data['location']);
            $meeting->setProject($data['project']);
            $meeting->setEmployee($userManager->getUser($data['employee_fk']));
            $meeting->setClient($userManager->getUser($data['client_fk']));
        }
        return $meeting;
    }

    /**
     * Save a role.
     * @param Meeting $meeting
     * @return bool
     */
    public function save(Meeting &$meeting): bool {
        // If id is null, then it does not exits into the database.
        if(is_null($meeting->getId())) {
            // If role name is not null.
            if(!DB::isNull($meeting->getLocation(), $meeting->getDate(), $meeting->getProject(), $meeting->getEmployee()->getId(), $meeting->getClient()->getId())) {
                $stmt = DB::getInstance()->prepare("
                    INSERT INTO meeting (location, date, project, employee_fk, client_fk) 
                    VALUES (:loc, :dat, :proj, :employee, :clien)
                ");

                $stmt->bindValue(':loc', DB::sanitizeString($meeting->getLocation()));
                $stmt->bindValue(':dat', $meeting->getDate()->format('Y-m-d H:i:s'));
                $stmt->bindValue(':proj', DB::sanitizeString($meeting->getProject()));
                $stmt->bindValue(':employee', $meeting->getEmployee()->getId());
                $stmt->bindValue(':clien', $meeting->getClient()->getId());

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
                    client_fk=:clien
                   WHERE id=:i
                ");

                $stmt->bindValue(':loc', DB::sanitizeString($meeting->getLocation()));
                $stmt->bindValue(':dat', $meeting->getDate()->format('Y-m-d H:i:s'));
                $stmt->bindValue(':proj', DB::sanitizeString($meeting->getProject()));
                $stmt->bindValue(':employee', $meeting->getEmployee()->getId());
                $stmt->bindValue(':clien', $meeting->getClient()->getId());
                $stmt->bindValue(':i', $meeting->getId(), PDO::PARAM_INT);

                if ($stmt->execute()) {
                    return true;
                }
            }
        }

        return false;
    }
}
