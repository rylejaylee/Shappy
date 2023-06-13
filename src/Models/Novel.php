<?php

namespace Shappy\Models;

use Exception;
use Shappy\Utils\Database;

class Novel
{
    public function create($title, $user_id, $desc, $img = null)
    {
        try {
            $db = new Database;
            $sql = "INSERT INTO novels (title, slug, user_id, description, img) VALUES (:title, :slug, :user_id, :desc, :img)";

            $params = [
                ":title"    =>      $title,
                ":slug"     =>      $this->title_to_slug($title),
                ":user_id"  =>      $user_id,
                ":desc"     =>      $desc,
                ":img"      =>      $img,
            ];

            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function update($title, $desc, $nove_id)
    {
        try {
            $db = new Database;
            $sql = "UPDATE novels SET title=:title, slug=:slug, description=:desc WHERE id=:novel_id";

            $params = [
                ":title"        =>      $title,
                ":slug"         =>      $this->title_to_slug($title),
                ":desc"         =>      $desc,
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

    public function fetch_all()
    {
        try {
            $db = new Database;
            $sql = "SELECT * FROM novels ORDER BY updated_at DESC";

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
            $sql = "SELECT n.id, user_id, title, description, img, n.created_at, n.updated_at, u.name, u.email
                    FROM novels as n
                    JOIN users as u
                    ON n.user_id = u.id
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

    public function title_to_slug($title, $separator = '-')
    {
        $title = preg_replace('/[^a-zA-Z0-9]+/', ' ', $title); // Replace special characters with a space
        $title = strtolower(trim($title)); // Convert to lowercase and remove leading/trailing spaces
        $title = preg_replace('/\s+/', $separator, $title); // Replace consecutive spaces with the separator

        return $title;
    }
}
