<?php
namespace App\Models;

use App\Utils\Database;

class Post {
    private $id;
    private $title;
    private $content;
    private $created_at;

    public function __construct() {
    }

    function getArticle($id) {
        $db = new Database();
        $sql = "SELECT * FROM articles WHERE id = ?";
        return $db->queryOne($sql, [$id]);
    }

    function getArticlesByCategorie($id) {
        $db = new Database();
        $sql = "SELECT * FROM articles WHERE categorie_id = ?";
        return $db->query($sql, [$id]);
    }

    function getAllArticles() {
        $db = new Database();
        $sql = "SELECT * FROM articles";
        return $db->query($sql);
    }

    function createArticle($title, $content) {
        $db = new Database();
        $sql = "INSERT INTO articles (title, content) VALUES (?, ?)";
        return $db->executeSql($sql, [$title, $content]);
    }

    function updateArticle($id, $title, $content) {
        $db = new Database();
        $sql = "UPDATE articles SET title = ?, content = ? WHERE id = ?";
        return $db->executeSql($sql, [$title, $content, $id]);
    }

    function deleteArticle($id) {
        $db = new Database();
        $sql = "DELETE FROM articles WHERE id = ?";
        return $db->executeSql($sql, [$id]);
    }

    function getComments($id) {
        $db = new Database();
        $sql = "SELECT * FROM comments WHERE article_id = ?";
        return $db->query($sql, [$id]);
    }

    function createComment($article_id, $author, $content) {
        $db = new Database();
        $sql = "INSERT INTO comments (article_id, author, content) VALUES (?, ?, ?)";
        return $db->executeSql($sql, [$article_id, $author, $content]);
    }

    function updateComment($id, $author, $content) {
        $db = new Database();
        $sql = "UPDATE comments SET author = ?, content = ? WHERE id = ?";
        return $db->executeSql($sql, [$author, $content, $id]);
    }

    function deleteComment($id) {
        $db = new Database();
        $sql = "DELETE FROM comments WHERE id = ?";
        return $db->executeSql($sql, [$id]);
    }

    function getArticleComments($id) {
        $db = new Database();
        $sql = "SELECT * FROM articles JOIN comments ON articles.article_id = comments.article_id WHERE articles.article_id = ?";
        return $db->query($sql, [$id]);
    }

    function getArticleCommentsCount($id) {
        $db = new Database();
        $sql = "SELECT COUNT(*) FROM comments WHERE article_id = ?";
        return $db->queryOne($sql, [$id]);
    }

    function getTopArticles() {
        $db = new Database();
        $sql = "SELECT articles.article_id, articles.title, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.article_id) + (SELECT COUNT(*) FROM likes WHERE likes.article_id = articles.article_id) as interactions_count FROM articles ORDER BY interactions_count DESC LIMIT 6";
        return $db->query($sql);
    }
}