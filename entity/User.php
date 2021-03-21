<?php

/**
 * Class User
 */
class User {

    private ?int $id;
    private ?string $mail;
    private ?string $password;
    private ?string $phone;
    private ?string $firstName;
    private ?string $lastName;
    private ?Role $role;

    /**
     * User constructor.
     * @param int|null $id
     * @param string|null $m
     * @param string|null $pswd
     * @param string|null $phone
     * @param string|null $fName
     * @param string|null $lName
     * @param Role|null $r
     */
    public function __construct(?int $id=null, string $m=null, string $pswd=null, string $phone=null, string $fName=null, string $lName=null, Role $r=null) {
        $this->id = $id;
        $this->mail = $m;
        $this->password = $pswd;
        $this->phone = $phone;
        $this->firstName = $fName;
        $this->lastName = $lName;
        $this->role = $r;
    }

    /**
     * Return the user id.
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Set the user id if user id was not already set.
     * @param int $id
     * @return void
     */
    public function setId(int $id): void {
        if(is_null($this->getId())) {
            $this->id = $id;
        }
    }

    /**
     * Return the user mail.
     * @return string
     */
    public function getMail(): ?string {
        return $this->mail;
    }

    /**
     * Set the user mail.
     * @param string $mail
     */
    public function setMail(string $mail): void {
        $this->mail = $mail;
    }

    /**
     * Return the user password ( encrypted ).
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * Set the user password.
     * @param string $password
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * Return the user phone number.
     * @return string
     */
    public function getPhone(): ?string {
        return $this->phone;
    }

    /**
     * Set the user phone number.
     * @param string $phone
     */
    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    /**
     * Return the user first name.
     * @return string
     */
    public function getFirstName(): ?string {
        return $this->firstName;
    }

    /**
     * Set the user first name.
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    /**
     * Return the user last name.
     * @return string
     */
    public function getLastName(): ?string {
        return $this->lastName;
    }

    /**
     * Set the user last name.
     * @param string $lastName
     */
    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    /**
     * Return the user Role.
     * @return Role
     */
    public function getRole(): Role {
        return $this->role;
    }

    /**
     * Set the user role.
     * @param Role $role
     */
    public function setRole(Role $role): void {
        $this->role = $role;
    }
}