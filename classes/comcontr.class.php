<?php

class ComContr extends ComModel
{
    public function insertComment()
    {
        $sql_add_comment = "INSERT INTO comments (comment_content, comment_post_id, comment_author_id, comment_date, comment_status) VALUES (?, ?, ?, ?, ?)";

        try {
            if (isset($_POST['post_comment_submit'], $_GET['post_id'])) {
                // insert comment
                $comment = htmlspecialchars($_POST['post_comment']);
                $post = $_GET['post_id'];
                $author = $_SESSION['user_info']['id'];
                $date = date('Y-m-d');
                $is_admin = $_SESSION['user_info']['user_isadmin'];
                if ($is_admin == 1) {
                    $status = 1;
                } else {
                    $status = 0;
                }
                $stmt_insert_comment = $this->connect_db()->prepare($sql_add_comment);

                if ($stmt_insert_comment->execute([$comment, $post, $author, $date, $status])) {
                    $this->updateCommentCount();
                    header('Location: ' . $_SERVER['PHP_SELF'] . "?post_id=" . $post);
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function updateCommentCount()
    {
        $sql = "UPDATE posts SET post_comments_count = :post_comments_count WHERE id = :id";
        $comment_count = $this->fetchPostCommentCount();
        $post_id = $_GET['post_id'];
        $stmt = $this->connect_db()->prepare($sql);
        $stmt->execute(['post_comments_count' => $comment_count, 'id' => $post_id]);
    }

    public function deleteComment()
    {
        $sql = "DELETE FROM comments WHERE id = ?";
        $sql_reset_ai = "ALTER TABLE comments AUTO_INCREMENT = 1";

        try {
            if (isset($_GET['comment_id'])) {
                $id = $_GET['comment_id'];
                $stmt = $this->connect_db()->prepare($sql);
                if ($stmt->execute([$id])) {
                    $this->connect_db()->query($sql_reset_ai);
                    header('Location: ' . $_SERVER['PHP_SELF'] . "?admin_page=comments");
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function approveComment()
    {
        $sql = "UPDATE comments SET comment_status = :comment_status WHERE id = :id";
        try {
            if (isset($_GET['status'], $_GET['comment_id'])) {
                $id = $_GET['comment_id'];
                $status = $_GET['status'];
                $stmt = $this->connect_db()->prepare($sql);
                if ($stmt->execute(['comment_status' => $status, 'id' => $id])) {
                    header('Location: ' . $_SERVER['PHP_SELF'] . "?admin_page=comments");
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function updateComment()
    {
        $sql = "UPDATE comments SET comment_content = :comment_content WHERE id = :id";

        try {
            if (isset($_POST['edit_comment_submit'])) {
                if (!empty($_POST['comment_content'])) {
                    $content = htmlspecialchars($_POST['comment_content']);
                    $id = $_GET['comment_id'];
                    $stmt = $this->connect_db()->prepare($sql);

                    if ($stmt->execute(['comment_content' => $content, 'id' => $id])) {
                        header('Location: ' . $_SERVER['PHP_SELF'] . "?admin_page=comments");
                    }
                } else {
                    echo "This field cannot be blank";
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }
}
