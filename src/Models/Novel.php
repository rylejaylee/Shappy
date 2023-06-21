<?php

namespace Shappy\Models;

use Exception;
use Shappy\Utils\Database;

class Novel
{
    public function create($title, $user_id, $desc, $category_id, $img = null,)
    {
        try {
            $db = new Database;
            $sql = "INSERT INTO novels (title, slug, user_id, description, category_id, img) VALUES (:title, :slug, :user_id, :desc, :category_id, :img)";

            $params = [
                ":title"        =>      $title,
                ":slug"         =>      $this->title_to_slug($title),
                ":user_id"      =>      $user_id,
                ":desc"         =>      $desc,
                ":category_id"  =>      $category_id,
                ":img"          =>      $img,
            ];

            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function update($title, $desc, $category_id, $nove_id)
    {
        try {
            $db = new Database;
            $sql = "UPDATE novels 
                    SET title=:title, slug=:slug, category_id=:category_id, description=:desc 
                    WHERE id=:novel_id";

            $params = [
                ":title"        =>      $title,
                ":slug"         =>      $this->title_to_slug($title),
                ":desc"         =>      $desc,
                ":category_id"  =>      $category_id,
                ":novel_id"     =>      $nove_id
            ];

            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function fetch_all($limit = 0, $offset = 0)
    {
        try {
            $db = new Database;
            $sql = "SELECT n.*, category , r.average_rating
                    FROM novels AS n 
                    JOIN categories AS c
                    ON n.category_id = c.id 
                    LEFT JOIN (SELECT novel_id, AVG(rating) AS average_rating FROM ratings GROUP BY novel_id) AS r
                    ON r.novel_id= n.id
                    ORDER BY updated_at DESC ";

            if ($limit)
                $sql .= "LIMIT $limit ";

            if ($offset)
                $sql .=  "OFFSET $offset";

            $stmt = $db->query($sql);

            $novels = $stmt->fetchAll();

            $db->close();
            return $novels;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return [];
    }

    public function get_by_slug($slug)
    {
        try {
            $db = new Database;
            $sql = "SELECT * FROM novels WHERE slug=:slug";

            $stmt = $db->query($sql, [':slug' => $slug]);

            $novel = $stmt->fetch();

            $db->close();
            return $novel;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
    }

    public function get_by_id($id)
    {
        try {
            $db = new Database;
            $sql = "SELECT * FROM novels WHERE id=:id";

            $stmt = $db->query($sql, [':id' => $id]);

            $novel = $stmt->fetch();

            $db->close();

            return $novel;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
    }

    public function get_by_slug_with_user($slug)
    {
        try {
            $db = new Database;
            $sql = "SELECT n.id, user_id, title, description, img, slug, n.created_at, n.updated_at, n.status, u.name, u.email, category
                    FROM novels as n
                    INNER JOIN users as u
                    ON n.user_id = u.id
                    INNER JOIN categories as c
                    on n.category_id = c.id
                    WHERE slug=:slug";

            $stmt = $db->query($sql, [':slug' => $slug]);

            $novel = $stmt->fetch();

            $db->close();

            return $novel;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $db = new Database;
            $sql = "DELETE FROM novels WHERE id=:id";
            $db->query($sql, [':id' => $id]);
            $db->close();

            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
    }

    public function update_img($new_img, $id)
    {
        try {
            $db = new Database;
            $sql = "UPDATE novels SET img=:new_img WHERE id=:id";
            $db->query($sql, [':id' => $id, ':new_img' => $new_img]);
            $db->close();

            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
    }

    public function count()
    {
        try {
            $db = new Database;
            $sql = "SELECT COUNT(*) as count FROM novels";
            $stmt = $db->query($sql);
            $db->close();

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
    }

    public function title_to_slug($title, $separator = '-')
    {
        $title = preg_replace('/[^a-zA-Z0-9]+/', ' ', $title); // Replace special characters with a space
        $title = strtolower(trim($title)); // Convert to lowercase and remove leading/trailing spaces
        $title = preg_replace('/\s+/', $separator, $title); // Replace consecutive spaces with the separator

        return $title;
    }
}
