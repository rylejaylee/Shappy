<?php

namespace Shappy\Models;

use Exception;
use Shappy\Utils\Database;

class Review
{

    public function create($comment, $user_id, $novel_id)
    {
        try {
            $db = new Database;
            $sql = "INSERT INTO reviews (comment, user_id, novel_id) VALUES (:comment, :user_id, :novel_id)";

            $params = [
                ":comment"    =>      $comment,
                ":user_id"  =>      $user_id,
                ":novel_id"  =>      $novel_id,
            ];

            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function get_all_by_novel_id($novel_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT r.id, comment, name, r.created_at, r.updated_at, r.user_id, r.novel_id 
                    FROM reviews as r
                    JOIN users as u
                    ON r.user_id = u.id
                    WHERE novel_id = :novel_id
                    ORDER BY updated_at DESC";

            $params = [
                ':novel_id' => $novel_id,
            ];

            $stmt = $db->query($sql, $params);
            $reviews = $stmt->fetchAll();
            $db->close();
            return $reviews;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }
}
