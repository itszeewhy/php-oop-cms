<?php

class PostModel extends Database
{
    protected function fetchAllPosts()
    {

        $sql = "SELECT posts.*, categories.category_name, users.user_name FROM posts, users, categories WHERE posts.post_author_id = users.id AND posts.post_category_id = categories.id";
        $query = $this->connect_db()->query($sql);
        $row = $query->fetchAll();
        return $row;
    }

    protected function fetchPostPerPage()
    {
        if (isset($_GET['page'])) {
            $page = $_GET['page'] - 1;
            $post_per_page = 2;
            $sql = "SELECT posts.*, categories.category_name, users.user_name FROM posts, users, categories WHERE posts.post_author_id = users.id AND posts.post_category_id = categories.id LIMIT $page, $post_per_page";
            $query = $this->connect_db()->query($sql);
            $row = $query->fetchAll();
            return $row;
        } else {
            $sql = "SELECT posts.*, categories.category_name, users.user_name FROM posts, users, categories WHERE posts.post_author_id = users.id AND posts.post_category_id = categories.id LIMIT 0, 2";
            $query = $this->connect_db()->query($sql);
            $row = $query->fetchAll();
            return $row;
        }
    }

    protected function fetchSearchResult()
    {
        if (isset($_POST['search_post_submit'])) {
            $sql = "SELECT posts.*, categories.category_name, users.user_name FROM posts, users, categories WHERE posts.post_tags LIKE ? AND posts.post_author_id = users.id AND posts.post_category_id = categories.id";
            $keyword = htmlspecialchars($_POST['search_post']);
            $stmt = $this->connect_db()->prepare($sql);
            $stmt->execute(["%{$keyword}%"]);
            $row = $stmt->fetchAll();
            return $row;
        }
    }

    protected function fetchPostsFromCate()
    {
        $sql = "SELECT posts.*, categories.category_name, users.user_name FROM posts, categories, users WHERE posts.post_category_id = categories.id AND posts.post_author_id = users.id AND categories.category_name = ?";
        $stmt = $this->connect_db()->prepare($sql);
        if (isset($_GET['cate_name'])) {
            $stmt->execute([$_GET['cate_name']]);
            $row = $stmt->fetchAll();
            return $row;
        }
    }

    protected function fetchPostFromAuthor()
    {
        $sql = "SELECT posts.*, categories.category_name FROM posts, categories WHERE posts.post_category_id = categories.id AND posts.post_author_id = ? ORDER BY posts.id";
        $stmt = $this->connect_db()->prepare($sql);

        if (isset($_GET['user_id'])) {
            $id = $_GET['user_id'];
            $stmt->execute([$id]);
            $row = $stmt->fetchAll();
            return $row;
        }
    }

    protected function fetchPost()
    {
        $sql = "SELECT posts.*, categories.category_name, users.user_name FROM posts, categories, users WHERE posts.post_category_id = categories.id AND posts.post_author_id = users.id AND posts.id = ?";
        $stmt = $this->connect_db()->prepare($sql);
        if (isset($_GET['post_id'])) {
            $stmt->execute([$_GET['post_id']]);
            $row = $stmt->fetch();
            return $row;
        }
    }

    protected function fetchPostCount()
    {
        $sql = "SELECT * FROM posts";
        if ($query = $this->connect_db()->query($sql)) {
            $num_row = $query->rowCount();
            return $num_row;
        }
    }
}
