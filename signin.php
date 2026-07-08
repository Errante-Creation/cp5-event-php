<?php
require_once __DIR__ . '/classes/UserManager.php';

$message = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = htmlspecialchars(trim($_POST['email']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    
    if(empty($email) || empty($pass)){
        $message = "Tous les champs doivent être renseignés";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $message = "Le mail n'est pas valide";
    } else {
        $userManager = new UserManager();
        $user = $userManager->login($email, $pass);

        if ($user){
            session_start();
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['firstname'] = $user['firstname_user'];
            $_SESSION['lastname'] = $user['lastname_user'];
            $_SESSION['email'] = $email;
            header('location: profile.php');
            exit;
        } else {
            $message = "Mail ou mot de passe invalide";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <?= $message; ?>
    <form action="#" method="post">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email">
        <br />

        <label for="pass">Mot de passe :</label>
        <input type="password" id="pass" name="pass">
        <br />

        <button>Se connecter !</button>
    </form>
    <a href="register.php">Pas encore inscrit ?</a>
</body>
</html>