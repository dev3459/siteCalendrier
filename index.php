<?php
    include 'include.php';
    DB::getInstance();
?>

    <!-- modal window-->
    <div id="modal-1" class="modal">
        <p>Le calendrier ici :)</p>
        <div id="container"></div>
    </div>

<!-- Link to open the modal -->
<p><a href="#modal-1" rel="modal:open">Prendre un rendez-vous</a></p>

<!--errors-->
<?php
if(isset($_GET['success']) && intval($_GET['success']) === 1) {
?>
<div class="success">Le rendez-vous est pris ! Merci :) !</div>
<?php
}
if(isset($_GET['success']) && intval($_GET['success']) === 0) {
?>
<div class="error">Une erreur s'est produite ! Le rendez-vous n'est pas pris ! :( </div>
<?php
}
if(isset($_GET['success']) && intval($_GET['success']) === -1) {
?>
<div class="error">Le mot de passe doit contenir au moins une lettre en majuscule,un chiffre et un caractère spéciale ! </div>
<?php
}
?>
<!--le formulaire-->
<div id="modal-2" class="modal">

    <div id="container-form">
        <img src="./asset/img/logo.jpg" alt="logo_site" id="logo">

        <form method="post" action="Utilisateur/register.php">
            <div>
                <label for="username"> Nom :
                    <input type="text" name="username"  id="username" required>
                </label>
            </div>
            <div>
                <label for="firstName"> Prénom :
                    <input type="text" name="firstName" id="firstName" required>
                </label>
            </div>
            <div>
                <label for="password"> Mot de passe :
                    <input type="text" name="password" id="password" required>
                </label>
            </div>
            <div>
                <label for="passwordConfirm"> Vérification du mot de passe :
                    <input type="text" name="passwordConfirm" id="passwordConfirm" required>
                </label>
            </div>

            <div>
                <label for="phone"> Numéro de téléphone :
                    <input type="text" name="phone" id="phone" required>
                </label>
            </div>
            <div>
                <label for="e-mail"> Mail :
                    <input type="email" name="email" id="e-mail"  pattern="^[A-Za-z]+@{1} [A-Za-z] +\.{1} [A-Za-z] {2,}$" required>
                </label>
            </div>
            <div>
                <label for="other"> Raison/ brève description du projet :
                    <input type="text" name="other" id="other" required>
                </label>
            </div>
            <div>
                <button type="submit" value="envoyer">Valider mon rendez-vous</button>
            </div>
        </form>
        <!-- Link to open the modal -->
        <p><a href="#modal-2" rel="modal:open">Prendre un rendez-vous</a></p>
    </div>
</div>

