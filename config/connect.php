<?php
try {
    // La connexion fais appel à une INSTANCE de la classe PDO
    // On peut ensuite manipuler cette connexion pour le CRUD
    $db = new PDO(
        'mysql:host=localhost;dbname=events;charset=utf8',
        'root', // utilisateur
        '', // motdepasse 
        [
            PDO::ATTR_ERRMODE =>  PDO::ERRMODE_EXCEPTION // Active gestion erreur
        ]
    );
} catch (Exception $e){
    // echo "Connexion refusée à la base de données";
    echo "Error: ".$e->getMessage();
    exit();
    // On peut écrire la vraie erreur dans un log (a faire avant exit)
}