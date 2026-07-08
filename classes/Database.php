<?php

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if(self::$instance === null){
            try {
                self::$instance = new PDO(
                    'mysql:host=localhost;dbname=events;charset=utf8',
                    'root', // utilisateur
                    '', // motdepasse 
                    [
                        PDO::ATTR_ERRMODE =>  PDO::ERRMODE_EXCEPTION // Active gestion erreur
                    ]
                );
            } catch (Exception $e) {
                die("Connexion à la BDD impossible");
            }
        }
        return self::$instance;
    }
}