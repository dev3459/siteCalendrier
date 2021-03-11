<?php
    include 'include.php';
    DB::getInstance();
?>

    <!-- modal window-->
    <div id="modal-1" class="modal">
        <div id="container">Le calendrier ici :)</div>
        <a href="#modal-2" rel="modal:open">Continuer vers mon rendez-vous</a>

    </div>

<!-- Link to open the modal -->
<button type="submit" id="btnOpen"><a href="#modal-1" rel="modal:open">Prendre un rendez-vous</a></button>

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
                <label for="username">
                    <input type="text" name="username"  id="username" required placeholder="Nom :">
                </label>
            </div>
            <div>
                <label for="firstName">
                    <input type="text" name="firstName" id="firstName" required placeholder="Prénom :">
                </label>
            </div>
            <div>
                <label for="password">
                    <input type="text" name="password" id="password" required placeholder="Mot de passe :">
                </label>
            </div>
            <div>
                <label for="passwordConfirm">
                    <input type="text" name="passwordConfirm" id="passwordConfirm" required placeholder="Vérification du mot de passe :">
                </label>
            </div>

            <div>
                <label for="phone">
                    <input type="text" name="phone" id="phone" required placeholder="Numéro de téléphone :">
                </label>
            </div>
            <div>
                <label for="e-mail">
                    <input type="email" name="email" id="e-mail" pattern="^[A-Za-z]+@{1} [A-Za-z] +\.{1} [A-Za-z] {2,}$" required placeholder="Mail :">
                </label>
            </div>
            <div> Raisons :
                <label for="other">
                    <select name="other" id="other-choice">
                        <option value="1"> réparation pc</option>
                        <option value="2"> réparation tablette</option>
                        <option value="3">projet de site internet</option>
                        <option value="4">e-commerce</option>
                        <option value="5">autre</option>
                    </select>
                </label>
            </div>
            <div>
                <button type="submit" value="envoyer">Confirmer mon rendez-vous</button>
            </div>
        </form>

    </div>
</div>

