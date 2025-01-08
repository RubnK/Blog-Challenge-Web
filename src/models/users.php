<?php

namespace App\Models;

use App\Utils\Database;

class Users {
    private $id;
    private $email;
    private $password;
    private $role;
    private $created_at;

    public function __construct() {
    }

    function getUser($id) {
        $db = new Database();
        $sql = "SELECT * FROM users WHERE id = ?";
        return $db->queryOne($sql, [$id]);
    }

    function getAllUsers() {
        $db = new Database();
        $sql = "SELECT * FROM users";
        return $db->query($sql);
    }

    function createUser($email, $password, $role) {
        $db = new Database();
        $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
        return $db->executeSql($sql, [$email, $password, $role]);
    }

    function updateUser($id, $email, $password, $role) {
        $db = new Database();
        $sql = "UPDATE users SET email = ?, password = ?, role = ? WHERE id = ?";
        return $db->executeSql($sql, [$email, $password, $role, $id]);
    }

    function deleteUser($id) {
        $db = new Database();
        $sql = "DELETE FROM users WHERE id = ?";
        return $db->executeSql($sql, [$id]);
    }
}