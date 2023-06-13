<?php

namespace Shappy\Utils;

class Auth
{
    public function login($email, $password)
    {
        $db = new Database;
        $sql = "SELECT * FROM users WHERE email = :email";
        $result = $db->query($sql, [':email' => $email]);

        if ($result->rowCount()) {
            $user = $result->fetch();

            if (password_verify($password, $user->password)) {
                $db->close();
                $this->set_auth($user);
                return 1;
            }
            FlashMessage::set('warning', "Wrong Username/ Password.");
            return 0;
        }
        FlashMessage::set('warning', "Account does not exist");
        return 0;
    }

    public function register($name, $email, $password)
    {
        $db = new Database;
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

        $params = [
            ":name"     => $name,
            ":email"    => $email,
            ":password" => password_hash($password, PASSWORD_DEFAULT),
        ];

        $result = $db->query($sql, $params);
        $db->close();
        return $result;
    }

    public function logout()
    {
        $_SESSION = array();

        // Destroy the session
        session_destroy();
    }

    private function set_auth($auth)
    {
        $_SESSION['is_logged_in'] = 1;
        $_SESSION['auth'] = $auth;
    }

    public function email_exist($email)
    {
        $db = new Database;
        $sql = "SELECT * FROM users WHERE email = :email";
        $result = $db->query($sql, [':email' => $email]);
        $db->close();
        return $result->rowCount();
    }
}
