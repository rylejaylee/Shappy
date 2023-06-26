<?php

namespace Shappy\Models;

use Exception;
use Shappy\Utils\Database;

class Novel
{
    public const DATE = 1;
    public const NAME  = 2;
    public const RATING = 3;
    public const VIEWS = 4;

    public function create($title, $user_id, $desc, $img = null,)
    {
        try {
            $db = new Database;
            $sql = "INSERT INTO novels (title, slug, user_id, description, img) VALUES (:title, :slug, :user_id, :desc, :img)";

            $params = [
                ":title"        =>      $title,
                ":slug"         =>      $this->title_to_slug($title),
                ":user_id"      =>      $user_id,
                ":desc"         =>      $desc,
                ":img"          =>      $img,
            ];

            $db->query($sql, $params);
            $last_id = $db->get_last_inserted_id();
            $db->close();
            return $last_id;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function search($searchText)
    {
        try {
            $db = new Database;
            $sql = "SELECT * FROM novels WHERE title LIKE :search";

            $params = [
                ":search"        =>     "%$searchText%",
            ];

            $stmt = $db->query($sql, $params);
            $db->close();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function update($title, $desc, $novel_id)
    {
        try {
            $db = new Database;
            $sql = "UPDATE novels 
                    SET title=:title, slug=:slug, description=:desc 
                    WHERE id=:novel_id";

            $params = [
                ":title"        =>      $title,
                ":slug"         =>      $this->title_to_slug($title),
                ":desc"         =>      $desc,
                ":novel_id"     =>      $novel_id
            ];

            $db->query($sql, $params);
            $db->close();
            return 1;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function fetch_all($limit = 0, $offset = 0, $filter = Novel::DATE, $arrangement = "desc", $status = 'all')
    {
        // 1 - new 2 - pop
        try {
            $db = new Database;
            $sql = "SELECT n.*, r.average_rating, v.total_views, c.categories, ch.chapters_count
                    FROM novels AS n 
                    LEFT JOIN (SELECT novel_id, AVG(rating) AS average_rating FROM ratings GROUP BY novel_id) AS r
                    ON r.novel_id= n.id
                    LEFT JOIN (SELECT novel_id, SUM(views) AS total_views FROM views GROUP BY novel_id) AS v
                    ON v.novel_id = n.id
                    LEFT JOIN (SELECT JSON_ARRAYAGG(category) AS categories, cn.novel_id  FROM categories_novels AS cn INNER JOIN categories AS c ON c.id = cn.category_id GROUP BY cn.novel_id) AS c
					ON c.novel_id = n.id
                    LEFT JOIN (SELECT novel_id, COUNT(id) as chapters_count FROM chapters GROUP BY novel_id) as ch
                    ON ch.novel_id = n.id ";

            if ($status != 'all')
                $sql .= "WHERE status = '$status' ";

            if ($filter == Novel::DATE)
                $sql .= "ORDER BY n.updated_at ";
            elseif ($filter == Novel::NAME)
                $sql .= "ORDER BY LOWER(n.title) ";
            elseif ($filter == Novel::VIEWS)
                $sql .= "ORDER BY v.total_views ";
            elseif ($filter == Novel::RATING)
                $sql .= "ORDER BY r.average_rating ";

            if ($arrangement == 'desc')
                $sql .= "DESC ";
            elseif ($arrangement == 'asc')
                $sql .= "ASC ";

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
            $sql = "SELECT n.id, user_id, title, description, img, slug, n.created_at, n.updated_at, n.status, u.name, u.email
                    FROM novels as n
                    INNER JOIN users as u
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
