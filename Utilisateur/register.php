<?php
DB::getInstance();

//check the data
if(isset($_POST['username']) && isset($_POST['firstName']) && isset($_POST['password']) && isset($_POST['passwordConfirm'])
    && isset($_POST['phone']) && isset($_POST['e-mail']) && isset($_POST['other'])) {

    $username = cleanup($_POST['username']);
    $firstName = cleanup($_POST['firstName']);
    $password = cleanup($_POST['password']);
    $passwordConfirm = cleanup($_POST['passwordConfirm']);
    $phone = cleanup($_POST['phone']);
    $email = cleanup($_POST['e-mail']);
    $other = cleanup($_POST['other']);

    if($password === $passwordConfirm) {
        echo "Nom :" . $_POST['username'];
        echo "Prénom :" . $_POST['firstName'];
        echo "password :" . $_POST['password'];
        echo "passwordConfirm" . $_POST['passwordConfirm'];
        echo "phone :" . $_POST['phone'];
        echo "email :" . $_POST['e-mail'];
        echo "other : " . $_POST['other'];

        header('Location: ../index.php?success= 1');
    }

    else {
        header('Location: ../index.php?error= 0');
    }

    //check e-mail in PHP
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === $passwordConfirm || ValidatePassword($password)) {
        header('Location: ../index.php?error=0');
    }

    //validate password
    $uppercase = preg_match('@[A-Z]@', $password);
    $number = preg_match('@[0-9]',$password);
    $specialChars = preg_match('@[^\W]@', $password);
    if($uppercase || $number || $specialChars) {
        header('Location: success= -1');
    }
}