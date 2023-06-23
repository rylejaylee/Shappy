<?php

namespace Shappy\Models;

use Shappy\Utils\Database;
use Exception;

class Chapter
{

    public function create($title, $content, $user_id, $novel_id)
    {
        try {
            $db = new Database;
            $sql = "INSERT 
                    INTO chapters (title, content, user_id, novel_id) 
                    VALUES (:title, :content, :user_id, :novel_id)";

            $params = [
                ':title' => $title,
                ':content' => $content,
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

    public function update($title, $content, $chapter_id)
    {
        try {
            $db = new Database;
            $sql = "UPDATE chapters
                    SET title=:title, content=:content 
                    WHERE id=:id";

            $params = [
                ':title'    =>  $title,
                ':content'  =>  $content,
                ':id'       =>  $chapter_id
            ];

            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
    }

    public function delete($chapter_id)
    {
        try {
            $db = new Database;
            $sql = "DELETE 
                    FROM chapters
                    WHERE id=:chapter_id";

            $params = [
                ':chapter_id'  =>  $chapter_id
            ];

            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
    }

    public function get_by_id($chapter_id, $novel_id = 0, $counter = '')
    {
        try {
            $db = new Database;
            $operation = '=';

            if ($counter == 'next') $operation = '>';
            elseif ($counter == 'prev') $operation = '<';

            $sql = "SELECT c.id, novel_id, c.title, n.title as novel_title, content, c.created_at, c.updated_at, slug as novel_slug, n.user_id
                    FROM chapters as c
                    JOIN novels as n
                    on c.novel_id = n.id
                    WHERE c.id $operation :chapter_id ";
            if ($novel_id)
                $sql .= "AND c.novel_id = :novel_id ";
            if ($counter == 'next')
                $sql .= "LIMIT 1 ";
            if ($counter == 'prev')
                $sql .= "ORDER BY c.id DESC LIMIT 1 ";

            $params = [
                ':chapter_id' => $chapter_id,
            ];

            if($novel_id)
                $params['novel_id'] = $novel_id;

            // dd($sql);

            $stmt = $db->query($sql, $params);
            $chapter = $stmt->fetch();
            $db->close();
            return $chapter;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }


    public function count_by_novel_id($novel_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT * 
                    FROM chapters 
                    WHERE novel_id = :novel_id";

            $params = [
                ':novel_id' => $novel_id,
            ];

            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->rowCount();
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function get_all_by_novel_id($novel_id, $limit = 0, $offset = 0)
    {
        try {
            $db = new Database;
            $sql = "SELECT * 
                    FROM chapters 
                    WHERE novel_id = :novel_id
                    ORDER BY created_at DESC ";

            if ($limit)
                $sql .= "LIMIT $limit ";
            if ($offset)
                $sql .= "OFFSET $offset";

            $params = [
                ':novel_id' => $novel_id,
            ];

            $stmt = $db->query($sql, $params);
            $chapters = $stmt->fetchAll();
            $db->close();
            return $chapters;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function get_all_ids($novel_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT id 
                    FROM chapters 
                    WHERE novel_id = :novel_id ";

            $params = [
                ':novel_id' => $novel_id,
            ];

            $stmt = $db->query($sql, $params);
            $chapters = $stmt->fetchAll();
            $db->close();
            return $chapters;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }
}
