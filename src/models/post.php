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
        $sql = "SELECT *, articles.created_at AS posted_at, articles.image as post_image FROM articles JOIN users ON articles.user_id = users.user_id WHERE article_id = ?";
        return $db->queryOne($sql, [$id]);
    }

    function getArticlesByCategorie($id) {
        $db = new Database();
        $sql = "SELECT * FROM articles WHERE category_id = ?";
        return $db->query($sql, [$id]);
    }

    function getArticlesByUser($id) {
        $db = new Database();
        $sql = "SELECT * FROM articles WHERE user_id = ?";
        return $db->query($sql, [$id]);
    }

    function getAllArticles() {
        $db = new Database();
        $sql = "SELECT * FROM articles";
        return $db->query($sql);
    }

    function createArticle($title, $content, $author, $image, $category) {
        $db = new Database();
        $sql = "INSERT INTO articles (title, content, user_id, image, category_id) VALUES (?, ?, ?, ?, ?)";
        return $db->executeSql($sql, [$title, $content, $author, $image, $category]);
    }

    function deleteArticle($id) {
        $db = new Database();
        $sql = "DELETE FROM articles WHERE article_id = ?";
        return $db->executeSql($sql, [$id]);
    }

    function getComments($id) {
        $db = new Database();
        $sql = "SELECT * FROM comments JOIN users ON comments.user_id = users.user_id WHERE article_id = ?";
        return $db->query($sql, [$id]);
    }

    function createComment($article_id, $author, $content) {
        $db = new Database();
        $sql = "INSERT INTO comments (article_id, user_id, content) VALUES (?, ?, ?)";
        return $db->executeSql($sql, [$article_id, $author, $content]);
    }

    function deleteComment($id) {
        $db = new Database();
        $sql = "DELETE FROM comments WHERE article_id = ?";
        return $db->executeSql($sql, [$id]);
    }

    function getArticleComments($id) {
        $db = new Database();
        $sql = "SELECT *, comments.created_at as posted_at FROM comments JOIN users ON comments.user_id = users.user_id WHERE article_id = ?";
        return $db->query($sql, [$id]);
    }

    function getTopArticles() {
        $db = new Database();
        $sql = "SELECT articles.article_id, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.article_id) + (SELECT COUNT(*) FROM likes WHERE likes.article_id = articles.article_id) as interactions_count FROM articles ORDER BY interactions_count DESC LIMIT 6";
        return $db->query($sql);
    }

    function likeArticle($user_id, $article_id) {
        $db = new Database();
        $sql = "INSERT INTO likes (user_id, article_id) VALUES (?, ?)";
        return $db->executeSql($sql, [$user_id, $article_id]);
    }

    function unlikeArticle($id) {
        $db = new Database();
        $sql = "DELETE FROM likes WHERE article_id = ?";
        return $db->executeSql($sql, [$id]);
    }

    function getArticleLikesCount($id) {
        $db = new Database();
        $sql = "SELECT COUNT(*) FROM likes WHERE article_id = ?";
        return $db->queryOne($sql, [$id]);
    }

    function getArticleLikes($id) {
        $db = new Database();
        $sql = "SELECT * FROM likes WHERE article_id = ?";
        return $db->query($sql, [$id]);
    }
}