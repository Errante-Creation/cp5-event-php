<?php
require_once __DIR__ . '/classes/UserManager.php';

$message = "";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $firstname  = htmlspecialchars(trim($_POST['firstname']));
    $lastname   = htmlspecialchars(trim($_POST['lastname']));
    $email      = htmlspecialchars(trim($_POST['email']));
    $pass       = htmlspecialchars(trim($_POST['pass']));

    if(empty($firstname) || empty($lastname) || empty($email) || empty($pass)){
        $message = "Tous les champs doivent être renseignés";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $message = "Le mail n'est pas valide";
    } else {
        $userManager = new UserManager();

        if($userManager->emailExists($email)){
            $message = "Vous ne pouvez pas vous inscrire avec cette adresse email";
        } elseif($userManager->register($firstname, $lastname, $email, $pass)){
            header('location: signin.php');
            exit;
        } else {
            $message = "Quelque chose s'est mal passé.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <?= $message; ?>
    <form action="#" method="post">
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" required>
        <br />
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname">
        <br />
        <label for="email">Email :</label>
        <input type="email" id="email" name="email">
        <br />
        <label for="pass">Mot de passe :</label>
        <input type="password" id="pass" name="pass">
        <br />
        <button>S'inscrire !</button>
    </form>
    <a href="signin.php">Déjà inscrit ?</a>

</body>
</html>