<?php

/**
 * Class Role
 */
class Role {

    private ?int $id;
    private ?string $name;

    /**
     * Role constructor.
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(?int $id = null, ?string $name = null) {
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
     * Set the role id if role id was not already set.
     * @param int $id
     * @return void
     */
    public function setId(int $id): void {
        if(is_null($this->getId())) {
            $this->id = $id;
        }
    }

    /**
     * Return the role name.
     * @return string
     */
    public function getName(): ?string {
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