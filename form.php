<?php
DB::getInstance();

//I check the data
if(isset($_POST['name']) && isset($_POST['firstName']) && isset($_POST['phone']) && isset($_POST['mail']) && isset($_POST['other'])) {};

/**
 * @param string $params
 * @param string $string
 * @param string $string1
 * @param string $string2
 * @param string $string3
 * @return bool
 */
function issetPostParams(string $params, string $param1, string $param2, string $param3, string $param4) : bool {
    foreach ($params as $param) {
        if(!isset($_POST[$param])) {
            return false;
        }
    }
    return true;
}

if(issetPostParams('name', 'firstName', 'phone', 'login', 'other')) {
    try {
        /** secure the data
         * @param $data
         * @return string
         */
        function secure($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = addslashes($data);
            return $data;
        }

        $name = secure($_POST['nom']);
        $firstName = secure($_POST['prenom']);
        $phone = secure($_POST['numero de telephone']);
        $login = secure($_POST['mail']);
        $other = secure($_POST['raison']);

        //check email
        $email2 = "bubulle";

        $email = "tarzan@gmail.com";
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Echo "L'adresse email" . $email . "est valide .";
        }
        else if(filter_var($email2, FILTER_VALIDATE_EMAIL)) {
            echo "L'adresse n'est pas valide.";

        }

        $sql = "INSERT INTO  (nom, prenom, phone, mail, raison)
                VALUES  ($name, $firstName, $phone, $login, $other)";

        echo $sql . '<br>';
        $db->exec($sql);
        echo "Le rendez-vous est pris ! :)";
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }
}
else {
    header("Location: index.php");
}