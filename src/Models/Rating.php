<?php

namespace Shappy\Models;

use Exception;
use Shappy\Utils\Database;

class Rating
{

    public function create($rating, $user_id, $novel_id)
    {
        try {
            $db = new Database;
            $sql = "INSERT INTO ratings (rating, user_id, novel_id) VALUES (:rating, :user_id, :novel_id)";

            $params = [
                ":rating"    =>      $rating,
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

    public function update($rating, $rating_id)
    {
        try {
            $db = new Database;
            $sql = "UPDATE ratings SET rating = :rating WHERE id=:rating_id";

            $params = [
                ":rating"    =>      $rating,
                ":rating_id"  =>      $rating_id,
            ];

            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function get_average($novel_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT AVG(rating) as novel_rating FROM ratings WHERE novel_id = :novel_id";

            $params = [
                ":novel_id"  =>      $novel_id,
            ];

            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->fetch()->novel_rating;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function get_rating_count($novel_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT COUNT(rating) as total_rating FROM ratings WHERE novel_id = :novel_id";

            $params = [
                ":novel_id"  =>      $novel_id,
            ];

            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->fetch()->total_rating;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }


    public function user_has_rating($user_id, $novel_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT * FROM ratings WHERE user_id = :user_id AND novel_id = :novel_id";

            $params = [
                ":user_id"  =>      $user_id,
                ":novel_id"  =>      $novel_id,
            ];

            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->rowCount();
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function get_user_rating($user_id, $novel_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT * FROM ratings WHERE user_id = :user_id AND novel_id = :novel_id";

            $params = [
                ":user_id"  =>      $user_id,
                ":novel_id"  =>      $novel_id,
            ];

            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function get_ratings($novel_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT rating, COUNT(rating) AS rating_count 
                    FROM ratings 
                    WHERE novel_id=:novel_id 
                    GROUP BY rating
                    ORDER BY rating";

            $params = [
                ":novel_id"  =>     $novel_id,
            ];

            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }
}
