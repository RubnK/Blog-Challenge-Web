<?php

namespace App\Models;

use App\Utils\Database;

class Category {
    private $id;
    private $name;
    private $created_at;

    public function __construct() {
    }

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

    function createCategory($name) {
        $db = new Database();
        $sql = "INSERT INTO categories (name) VALUES (?)";
        return $db->executeSql($sql, [$name]);
    }

    function updateCategory($id, $name) {
        $db = new Database();
        $sql = "UPDATE categories SET name = ? WHERE category_id = ?";
        return $db->executeSql($sql, [$name, $id]);
    }

    function deleteCategory($id) {
        $db = new Database();
        $sql = "DELETE FROM categories WHERE category_id = ?";
        return $db->executeSql($sql, [$id]);
    }
}