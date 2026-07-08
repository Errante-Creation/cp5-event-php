<?php

require_once __DIR__ . '/Database.php';

class UserManager
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function emailExists(string $email): bool
    {
        // statement
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users WHERE email_user = :email');
        $stmt->execute(['email' => $email]);
        // Si une ligne est trouvée, l'email existe → on retourne true, sinon false
        return $stmt->fetchColumn() > 0;
    }

    public function login(string $email, string $pass): ?array
    {
        // Si l'email n'est pas trouvé dans la BDD
        if (!$this->emailExists($email)){
            return null;
        }

        $stmt = $this->db->prepare("SELECT pass_user AS pass, firstname_user, lastname_user FROM users WHERE email_user = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($pass, $user['pass'])) {
            return $user;
        }
        return null;
    }

    public function register(string $firstname, string $lastname, string $email, string $pass): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users(firstname_user, lastname_user, email_user, pass_user, fk_id_role) VALUES(:firstname, :lastname, :email, :pass, :id_role)");
        return $stmt->execute([
            'firstname' => ucfirst($firstname),
            'lastname' => ucfirst($lastname),
            'email' => $email,
            'pass' => password_hash($pass, PASSWORD_DEFAULT),
            'id_role' => 1
        ]) && $stmt->rowCount() > 0;
    }
}