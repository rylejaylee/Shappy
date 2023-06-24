<?php

namespace Shappy\Models;

use Exception;
use Shappy\Utils\Database;

class Category
{
    public function get_all()
    {
        try {
            $db = new Database;
            $sql = "SELECT * FROM categories ORDER BY category";

            $stmt = $db->query($sql);
            $categories = $stmt->fetchAll();
            $db->close();
            return $categories;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function get_by_novel($novel_id)
    {
        try {
            $db = new Database;
            $sql = "SELECT c.id, category 
                    FROM categories_novels as cn 
                    JOIN  categories as c
                    ON c.id = cn.category_id 
                    WHERE cn.novel_id = :novel_id
                    ORDER BY c.category";

            $stmt = $db->query($sql, [":novel_id" => $novel_id]);
            $categories = $stmt->fetchAll();

            $db->close();
            return $categories;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function create($categories, $novel_id)
    {
        try {
            $db = new Database;
            $sql = "INSERT INTO categories_novels (category_id, novel_id) VALUES";

            foreach ($categories as $category_id) {
                $sql .= "($category_id, $novel_id), ";
            }

            $sql = rtrim($sql, ", ");

            $stmt = $db->query($sql);
            $categories = $stmt->fetchAll();
            $db->close();
            return $categories;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }

    public function delete($novel_id)
    {
        try {
            $db = new Database;
            $sql = "DELETE FROM categories_novels WHERE novel_id = :novel_id";

            $stmt = $db->query($sql, [':novel_id' => $novel_id]);
          
            $db->close();
            return $stmt;
        } catch (Exception $e) {
            echo "ERROR 500 : " . $e->getMessage();
        }
        return 0;
    }
}
