<?php
    $message = "";
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Récupérer les informations des formulaires
        // On clean les données htmlspecialschars et trim
        $firstname = htmlspecialchars(trim($_POST['firstname']));
        $lastname = htmlspecialchars(trim($_POST['lastname']));
        $email = htmlspecialchars(trim($_POST['email']));
        $pass = htmlspecialchars(trim($_POST['pass']));
        // On fait les contrôles sur les données
        $isFormOk = true; // Est-ce que le formulaire est correctement rempli
        // On vérifie que les champs ne sont pas vides
        if(empty($firstname) || empty($lastname) || empty($email) || empty($pass)){
            $message = "Tous les champs doivent être renseignés";
            $isFormOk = false;
        }

        // On vérifie si le mail est bien un mail
        if($isFormOk && !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $message = "Le mail n'est pas valide";
            $isFormOk = false;
        }

        // On hash le mot de passe
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        
        // Faire en sorte que prénom et nom → 1ère lettre en maj
        $firstname = ucfirst($firstname);
        $lastname = ucfirst($lastname);

        // Si aucun message d'erreur
        if($isFormOk){
            require_once "./config/connect.php";
            
            // Faire une comparaison dans la BDD pour voir si mail unique
            $sql = "SELECT COUNT(email_user) AS nbEmail FROM users WHERE email_user = :email";

            $data = $db->prepare($sql);

            $data->execute([
                'email' => $email
            ]);

            // Si mail déjà présent bdd → afficher un message
            $nbEmail = $data->fetch();

            if($nbEmail[0] == 1){
                $message = "Vous ne pouvez pas vous inscrire avec cette adresse mail";
                $isFormOk = false;
            }

            // Si on arrive ici, tout est au vert, on peut inscrire l'utilisateur
            if($isFormOk){
                // Insérer les données dans la BDD
                $sql = "INSERT INTO users(firstname_user, lastname_user, email_user, pass_user, fk_id_role) VALUES(:firstname, :lastname, :email, :pass, :id_role)";

                $req = $db->prepare($sql);

                $success = $req->execute([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'pass' => $hash,
                    'id_role' => 1
                ]);

                // rowCount → compte le nombre de lignes affectées
                if($success && $req->rowCount() > 0){
                    // Redirection sur page de connexion
                    header('Location: signin.php');
                    exit;
                }

                if(!$success){
                    $message = "Quelque chose s'est mal passé.";
                }
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