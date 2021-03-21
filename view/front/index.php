<?php
require '_partials/header.php'; ?>

<div class="container-fluid">


    <div class="container">
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#loginModal" id="loginModalButton">
            Login
        </button>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0"></div>
                <div class="modal-body">
                    <div class="form-title text-center">
                        <h4>Connexion</h4>
                    </div>
                    <div class="d-flex flex-column text-center">
                        <form class="needs-validation" novalidate accept-charset="utf-8" method="post" action="index.php?page=login">
                            <div class="form-group mt-4">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Votre adresse e-mail" required="required">
                                <div class="invalid-feedback">Veuillez entrer une adresse mail valide</div>
                            </div>
                            <div class="form-group mt-4">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe" required="required">
                                <div class="invalid-feedback">Veuillez entrer un mot de passe valide</div>
                            </div>
                            <button type="submit" class="btn btn-secondary btn-block mt-4">Connexion</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div class="signup-section">Pas encore de compte ? <a href="#" class="text-info"> Créez en un</a>.</div>
                </div>
            </div>
        </div>



</div>
<?php

require '_partials/footer.php';