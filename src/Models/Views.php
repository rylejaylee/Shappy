<?php

namespace Shappy\Models;

use Exception;
use Shappy\Utils\Database;

class Views
{
    public function create($novel_id, $chapter_id)
    {
        try {
            $db = new Database;
            $sql = "INSERT INTO views (novel_id, chapter_id) VALUES(:novel_id, :chapter_id)";
            $params = [
                ':novel_id' => $novel_id,
                ':chapter_id' => $chapter_id,
            ];
            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function increment($chapter_id)
    {
        try {
            $db = new Database;
            $sql = "UPDATE views SET views = views + 1 WHERE chapter_id = :chapter_id";
            $params = [
                ':chapter_id' => $chapter_id,
            ];
            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function get_by_novel($novel_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT SUM(views) as total_views FROM views WHERE novel_id=:novel_id";
            $params = [
                ':novel_id' => $novel_id,
            ];
            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }
}
