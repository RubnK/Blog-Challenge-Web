<?php

namespace App\Models;

use App\Utils\Database;

class Category {
    private $id;
    private $name;
    private $created_at;

    function getCategory($id) {
        $db = new Database();
        $sql = "SELECT * FROM categories WHERE category_id = ?";
        return $db->queryOne($sql, [$id]);
    }

    function getAllCategories() {
        $db = new Database();
        $sql = "SELECT * FROM categories";
        return $db->query($sql);
    }
}