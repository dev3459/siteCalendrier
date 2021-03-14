<?php

/**
 * Class Role
 */
class Role {

    private ?int $id;
    private string $name;

    /**
     * Role constructor.
     * @param int|null $id
     * @param string $name
     */
    public function __construct(?int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Return the role id.
     * @return int
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Return the role name.
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the role name.
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }
}