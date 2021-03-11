<?php
DB::getInstance();
include 'include.php';
$users = $bd->query("SELECT * FROM Utilisateur ORDER BY id DESC LIMIT 0,5");

	if(isset($_GET['role']) AND $_GET['role'] === 'Utilisateurs') {
	   if(isset($_GET['confirme']) AND !empty($_GET['confirme'])) {
	      $confirme = (int) $_GET['confirme'];
	      $req = $bd->prepare('UPDATE `rendez-vous` SET user_fk WHERE id = ?');
	      $req->execute(array($confirme));
	   }
	   if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
	      $supprime = (int) $_GET['supprime'];
	      $req = $bd->prepare('DELETE FROM utilisateur WHERE id = ?');
	      $req->execute(array($supprime));
	   }

	}
	$users = $bd->query('SELECT * FROM utilisateur ORDER BY id DESC LIMIT 0,5');
	?>

   <!--<title>Administration</title>-->
	   <ul>
	      <?php while($m = $users->fetch()) { ?>
	      <li><?= $m['id'] ?> : <?= $m['pseudo'] ?><?php if($m['confirme'] == 0) { ?>
                  - <a href="../index.php?type=membre&confirme=<?= $m['id'] ?>">Confirmer</a><?php } ?>
                  - <a href="../index.php?type=membre&supprime=<?= $m['id'] ?>">Supprimer</a></li>
	      <?php } ?>
	   </ul>

<?php

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
if(!is_admin()){
    ?>
    <?php
      header('403 Forbidden', true, 403);
      exit();
}
