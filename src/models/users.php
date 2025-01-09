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

    function createUser($username, $email, $password) {
        $db = new Database();
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        return $db->executeSql($sql, [$username, $email, $password]);
    }

    function updateUser($id, $username, $email, $password) {
        $db = new Database();
        $sql = "UPDATE users SET username = ?; email = ?, password = ? WHERE id = ?";
        return $db->executeSql($sql, [$username, $email, $password, $id]);
    }

    function deleteUser($id) {
        $db = new Database();
        $sql = "DELETE FROM users WHERE id = ?";
        return $db->executeSql($sql, [$id]);
    }

    function login($identifier, $password) {
        $db = new Database();
        $sql = "SELECT * FROM users WHERE email = :identifier AND password = :password OR username = :identifier AND password = :password";
        return $db->queryOne($sql, ['identifier' => $identifier, 'password' => $password]);
    }
}