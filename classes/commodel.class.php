<?php

class ComModel extends Database
{
    protected function fetchComment()
    {
        $sql = "SELECT * FROM comments WHERE id = ?";
        try {
            if (isset($_GET['comment_id'])) {
                $id = $_GET['comment_id'];
                $stmt = $this->connect_db()->prepare($sql);
                $stmt->execute([$id]);
                $result = $stmt->fetch();
                return $result;
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    protected function fetchAllComments()
    {
        $sql = "SELECT comments.*, users.user_name, posts.post_title FROM comments, users, posts WHERE comments.comment_author_id = users.id AND comments.comment_post_id = posts.id ORDER BY comments.id";
        $query = $this->connect_db()->query($sql);
        $result = $query->fetchAll();
        return $result;
    }

    protected function fetchPostCommentCount()
    {
        $sql = "SELECT * FROM comments WHERE comment_post_id = ?";
        $post_id = $_GET['post_id'];
        $stmt = $this->connect_db()->prepare($sql);
        $stmt->execute([$post_id]);
        $stmt->fetch();
        $comment_count = $stmt->rowCount();
        return $comment_count;
    }

    protected function fetchPostComments()
    {
        $sql = "SELECT comments.*, users.user_name FROM comments, users WHERE comments.comment_author_id = users.id AND comments.comment_post_id = ?";
        $stmt = $this->connect_db()->prepare($sql);
        if (isset($_GET['post_id'])) {
            $stmt->execute([$_GET['post_id']]);
            $row = $stmt->fetchAll();
            return $row;
        }
    }
}
