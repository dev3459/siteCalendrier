<?php
DB::getInstance();

/**
 * @param string $params
 * @param string $param1
 * @param string $param2
 * @param string $param3
 * @param string $param4
 * @param string $param5
 * @param string $param6
 * @return bool
 */
function issetPostParams(string $params, string $param1, string $param2, string $param3, string $param4, string $param5, string $param6) : bool {
    foreach ($params as $param) {
       if(!isset($_POST[$param])) {
          return false;
       }
    }
   return true;
}

if(issetPostParams('username', 'firstName', 'password', 'passwordConfirm','phone', 'e-mail', 'other')) {
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

        $username = secure($_POST['nom']);
        $firstName = secure($_POST['firstName']);
        $password = secure($_POST['password']);
        $passwordConfirm = secure($_POST['passwordConfirm']);
        $phone = secure($_POST['phone']);
        $email = secure($_POST['e-mail']);
        $other = secure($_POST['other']);

        //check email
        $email2 = "bubulle";

        $email = "tarzan@gmail.com";
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // echo "L'adresse email" . $email . "est valide .";
        }
        else if (filter_var($email2, FILTER_VALIDATE_EMAIL)) {
            // echo "L'adresse n'est pas valide.";

        }

        //$sql = "INSERT INTO  (nom, prenom, phone, mail, raison)
        //      VALUES  ($name, $firstName, $phone, $login, $other)";

        //echo $sql . '<br>';
        //$db->exec($sql);

    }
    catch (PDOException $exception) {
        echo $exception->getMessage();
    }
}
else {
    header("Location: index.php");
}

/**
 * @param $data
 * @return string
 */
function cleanup($data) :string {
    $data = trim($data);
    $data = strip_tags($data);
    return $data;
}

/**
 * @param $password
 * @return bool
 */
function ValidatePassword($password) : bool {
    $uppercase = preg_match('@[A-Z]@', $password);
    $number = preg_match('@[0-9]',$password);
    $specialChars = preg_match('@[^\W]@', $password);
    $lenghtPw = strlen($password) >= 6 && strlen($password) <= 24;
    if($uppercase && $number && $specialChars && $lenghtPw) {
        return true;
    }
    return false;
}