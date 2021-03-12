<?php
DB::getInstance();
include 'include.php';


/**  1=>Utilisateur 2=>employée  3=>Administrateur
 * @return bool
 */
function is_utilisateur(): bool {
    return !empty($_SESSION['role'] && $_SESSION['role'] === 1);
}

/**
 * @return bool
 */
function is_employe(): bool {
    return !empty($_SESSION['role'] && $_SESSION['role'] === 2);
}

/**
 * @return bool
 */
function is_admin(): bool{
    return !empty($_SESSION['role'] && $_SESSION['role'] === 3);
}
if(!is_admin()) {
    ?>
    <?php
      header('403 Forbidden', true, 403);
      exit();
}
