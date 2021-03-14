<?php
class DB {
    //Crud is less repetitive and reusable
    private string $server = 'localhost';
    private string $db= 'calendrier';
    private string $user = 'root';
    private string $passwd = '';

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
     * Return only one PDO  instance through the whole project.
     * @return PDO|null (instance) PDO|null
     */
    public static function getInstance(): ?PDO {
        if(null === self::$dbInstance) {
            new self();
        }
        return self::$dbInstance;
    }

    /**
     * Return sanitized string to have secure data to insert into the database.
     * @param $data
     * @return string
     */
    public static function sanitizeString($data): string {
        $data = strip_tags($data);
        $data = addslashes($data);
        return trim($data);
    }

    /**
     * Return sanitized int to have secure data to insert into the database.
     * @param $data
     * @return int
     */
    public static function sanitizeInt($data): int {
        return intval($data);
    }


    /**
     * Return true if at least one parameter is null !
     * @param mixed ...$data
     * @return bool
     */
    public static function isNull(...$data): bool {
        foreach($data as $param) {
            if(is_null($param)) {
                return true;
            }
        }
        return false;
    }


    /**
     * Encode a given plain password
     * @param $plainPassword
     * @return string
     */
    public static function encodePassword($plainPassword): string {
        // Encoding password.
        $password = self::sanitizeString($plainPassword);
        return password_hash($password, PASSWORD_BCRYPT);
    }


    /**
     * we prevent letting other developers clone the object
     */
    public function __clone(){}
}