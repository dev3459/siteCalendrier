<?php
class DB {
    //Crud is less repetitive and reusable
    private string $server = 'localhost';
    private string $db= '';
    private string $user = 'root';
    private string $passwd = 'dev';

    private static ?PDO $dbInstance = null;

    /*
     * Static construct
     */
    public function __construct(){
        try {
            self::$dbInstance = new PDO("mysql:host=$this->server;dbname=$this->db;charset=utf8", $this->user, $this->passwd);
            self::$dbInstance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            self::$dbInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch(PDOException $exeption) {
            echo $exeption->getMessage();
        }
    }

    /**
     * @return (instance) PDO|null
     */
    public static function getInstance(): ?PDO {
        if(null === self::$dbInstance) {
            new self();
        }
        return self::$dbInstance;
    }

    /**
     * we prevent letting other developers clone the object
     */
    public function __clone(){}
}