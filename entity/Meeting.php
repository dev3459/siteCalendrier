<?php

/**
 * Class Meeting
 */
class Meeting {

    private ?int $id;
    private ?string $location;
    private ?Datetime $date;
    private ?string $project;
    private ?User $employee;
    private ?User $client;
    private ?string $commentaire;

    /**
     * Meeting constructor.
     * @param int|null $id
     * @param string|null $location
     * @param String|null $date
     * @param string|null $project
     * @param string|null $comment
     * @throws Exception
     */
    public function __construct(int $id = null, string $location = null, String $date = null, string $project = null, string $comment = null) {
        $this->id = $id;
        $this->location = $location;
        $this->date = new DateTime($date);
        $this->project = $project;
        $this->commentaire = $comment;
    }

    /**
     * Return the meeting id.
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Set the meeting id.
     * @param int|null $id
     */
    public function setId(?int $id): void {
        if(is_null($this->getId())) {
            $this->id = $id;
        }
    }

    /**
     * Return the meeting location.
     * @return string|null
     */
    public function getLocation(): ?string {
        return $this->location;
    }

    /**
     * Set the meeting location.
     * @param string|null $location
     */
    public function setLocation(?string $location): void {
        $this->location = $location;
    }

    /**
     * Return the meeting datetime.
     * @return Datetime|null
     */
    public function getDate(): ?Datetime {
        return $this->date;
    }

    /**
     * Set the meeting datetime.
     * @param String|null $date
     * @throws Exception
     */
    public function setDate(?String $date): void {
        $this->date = new DateTime($date);
    }

    /**
     * Return the meeting project.
     * @return string|null
     */
    public function getProject(): ?string {
        return $this->project;
    }

    /**
     * Set the meeting project.
     * @param string|null $project
     */
    public function setProject(?string $project): void {
        $this->project = $project;
    }

    /**
     * Return the meeting employee.
     * @return User|null
     */
    public function getEmployee(): ?User {
        return $this->employee;
    }

    /**
     * Set the meeting employee.
     * @param User|null $employee
     */
    public function setEmployee(?User $employee): void {
        $this->employee = $employee;
    }

    /**
     * Return the meeting client.
     * @return User|null
     */
    public function getClient(): ?User {
        return $this->client;
    }

    /**
     * Set the meeting client.
     * @param User|null $client
     */
    public function setClient(?User $client): void {
        $this->client = $client;
    }

    /**
     * Return comment or null if none.
     * @return string|null
     */
    public function getComment(): ?string {
        return $this->commentaire;
    }

    /**
     * Set a new comment for meeting.
     * @param String|null $comment
     */
    public function setComment(?String $comment): void {
        $this->commentaire = $comment;
    }

}