<?php

namespace Shappy\Models;

use Exception;
use Shappy\Utils\Database;

class Library
{
    public function get_by_user($user_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT l.id as library_id, l.created_at as library_created_at, n.*, r.average_rating, v.total_views 
                    FROM library as l
                    LEFT JOIN novels as n
                    ON n.id = l.novel_id
                    LEFT JOIN (SELECT novel_id, AVG(rating) AS average_rating FROM ratings GROUP BY novel_id) AS r
                    ON r.novel_id= n.id
                    LEFT JOIN (SELECT novel_id, SUM(views) AS total_views FROM views GROUP BY novel_id) AS v
                    ON v.novel_id = n.id
                    WHERE l.user_id = :user_id
                    ORDER BY library_created_at DESC";

            $params = [
                ':user_id' => $user_id
            ];

            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return null;
    }


    public function create($user_id, $novel_id)
    {
        try {
            $db = new Database;
            $sql = "INSERT INTO library (user_id, novel_id) VALUES(:user_id, :novel_id)";

            $params = [
                ':user_id' => $user_id,
                ':novel_id' => $novel_id,
            ];

            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function delete($library_id)
    {
        try {
            $db = new Database;
            $sql = "DELETE FROM library WHERE id = :library_id";

            $db->query($sql, [':library_id' => $library_id]);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }
}
