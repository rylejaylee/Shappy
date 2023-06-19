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
}
