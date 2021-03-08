<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="asset/CSS/style.css">
    <title>formulaire réservation</title>
</head>
<body>
    <button id="button" type="button">Prendre un rendez-vous</button>

    <form action="form.php" method="post">
        <label> Nom :
            <input type="text" required>
        </label>
        <label> Prénom :
            <input type="text" required>
        </label>
        <label> Numéro de téléphone :
            <input type="text" required>
        </label>
        <label> Mail :
            <input type="text" required>
        </label>
        <label> Raison/ brève description du projet
            <input type="text" required>
        </label>
        <button type="submit">Valider mon rendez-vous</button>
    <form>

    <script src="asset/JS/app.js"></script>

</body>
</html>

<?php
require_once 'include.php';
