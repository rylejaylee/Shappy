<?php

namespace Shappy\Models;

use Shappy\Utils\Database;
use Exception;

class User
{

    public function get_current_user()
    {
        try {
            $db = new Database;
            $sql = "SELECT * FROM users WHERE id=:user_id";

            $params = [
                ":user_id"  =>      auth()->id
            ];

            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function update($name, $email, $password = null)
    {
        try {
            $db = new Database;
            $sql = "UPDATE users SET name=:name, email=:email ";
            if($password)
                $sql .= ", password=:password ";
            
            $sql.= "WHERE id=:user_id";
            $params = [
                ":user_id"  =>      auth()->id,
                ":name"     =>      $name,
                ":email"    =>      $email,
            ];

            if($password)
                $params['password'] = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->rowCount();
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }
}