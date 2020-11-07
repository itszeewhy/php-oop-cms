<?php

class PostContr extends PostModel
{
    public function addPost()
    {
        $sql = "INSERT INTO posts (post_title, post_author_id, post_category_id, post_tags, post_content, post_date, post_image, post_status) VALUES (:post_title, :post_author_id, :post_category_id, :post_tags, :post_content, :post_date, :post_image, :post_status)";

        try {
            if (isset($_POST['add_post_submit'])) {

                if (!in_array("", $_POST['add_post'])) {
                    $upload_ok = $this->postImageHandler();
                    if ($upload_ok['ok'] == 1) {
                        $fields = $_POST['add_post'];
                        $title = htmlspecialchars($fields['post_title']);
                        $author = $_SESSION['user_info']['id'];
                        $cate = htmlspecialchars($fields['post_cate']);
                        $tags = htmlspecialchars($fields['post_tags']);
                        $content = htmlspecialchars($fields['post_content']);
                        $date = date('Y-m-d');
                        $image = $_FILES['post_image']['name'];
                        $image_tmp = $_FILES['post_image']['tmp_name'];

                        if ($_SESSION['user_info']['user_isadmin'] == 1) {
                            $status = 1;
                        } else {
                            if ($_SESSION['user_info']['user_isadmin'] == 0) {
                                $status = 0;
                            }
                        }

                        $stmt = $this->connect_db()->prepare($sql);
                        $stmt->execute([
                            'post_title' => $title,
                            'post_author_id' => $author,
                            'post_category_id' => $cate,
                            'post_tags' => $tags,
                            'post_content' => $content,
                            'post_date' => $date,
                            'post_image' => $image,
                            'post_status' => $status
                        ]);

                        move_uploaded_file($image_tmp, 'img/' . basename($image));

                        switch ($_SERVER['PHP_SELF']) {
                            case '/oop-cms/index.php':
                                header('Location: ' . $_SERVER['PHP_SELF']);
                                break;
                            case '/oop-cms/admin.php':
                                header('Location: ' . $_SERVER['PHP_SELF'] . "?admin_page=posts");
                                break;
                        }
                    } else {
                        echo $upload_ok['msg'];
                    }
                } else {
                    echo "All the fields are required";
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function postUpdate()
    {
        $sql = "UPDATE posts SET post_title = :post_title, post_category_id = :post_category_id, post_tags = :post_tags, post_content = :post_content, post_image = :post_image WHERE id = :id";

        try {
            if (isset($_POST['edit_post_submit'])) {
                if (!in_array("", $_POST['edit_post'])) {
                    $upload_ok = $this->postImageHandler();
                    $fields = $_POST['edit_post'];
                    $title = htmlspecialchars($fields['post_title']);
                    $cate = htmlspecialchars($fields['post_cate']);
                    $tags = htmlspecialchars($fields['post_tags']);
                    $content = htmlspecialchars($fields['post_content']);
                    $image = $_FILES['post_image']['name'];
                    $image_tmp = $_FILES['post_image']['tmp_name'];
                    $id = $_GET['post_id'];
                    $stmt = $this->connect_db()->prepare($sql);


                    switch ($upload_ok['ok']) {
                        case 1:
                            $stmt->execute([
                                'post_title' => $title,
                                'post_category_id' => $cate,
                                'post_tags' => $tags,
                                'post_content' => $content,
                                'post_image' => $image,
                                'id' => $id
                            ]);
                            move_uploaded_file($image_tmp, 'img/' . basename($image));
                            header('Location: ' . $_SERVER['PHP_SELF'] . "?admin_page=posts");
                            break;
                        case 2:
                            $image = $this->fetchPost()['post_image'];
                            $stmt->execute([
                                'post_title' => $title,
                                'post_category_id' => $cate,
                                'post_tags' => $tags,
                                'post_content' => $content,
                                'post_image' => $image,
                                'id' => $id
                            ]);
                            header('Location: ' . $_SERVER['PHP_SELF'] . "?admin_page=posts");
                            break;
                        case 0:
                            echo $upload_ok['msg'];
                            break;
                    }
                } else {
                    echo "All the fields are required";
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function postViewsUpdate()
    {
        $sql = "UPDATE posts SET post_views = post_views + 1 WHERE id = ?";

        if (isset($_GET['post_id'])) {
            $id = $_GET['post_id'];
            $stmt = $this->connect_db()->prepare($sql);
            $stmt->execute([$id]);
        }
    }

    public function postDelete()
    {
        $sql = "DELETE FROM posts WHERE id = ?";
        $sql_reset_ai = "ALTER TABLE posts AUTO_INCREMENT = 1";

        try {
            if (isset($_GET['post_id'])) {
                $post_id = $_GET['post_id'];
                $fetch_post = $this->fetchPost();
                // Delete correspond image
                unlink("img/" . $fetch_post['post_image']);

                $stmt = $this->connect_db()->prepare($sql);
                if ($stmt->execute([$post_id])) {
                    $this->connect_db()->query($sql_reset_ai);
                    header('Location: ' . $_SERVER['PHP_SELF'] . "?admin_page=posts");
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function postApproval()
    {
        $sql = "UPDATE posts SET post_status = :post_status WHERE id = :id";

        try {
            if (isset($_GET['action']) && $_GET['action'] == 'approve') {
                if (isset($_GET['status'], $_GET['post_id'])) {
                    $status = $_GET['status'];
                    $id = $_GET['post_id'];

                    $stmt = $this->connect_db()->prepare($sql);
                    $stmt->execute([
                        'post_status' => $status,
                        'id' => $id
                    ]);

                    header('Location: ' . $_SERVER['PHP_SELF'] . "?admin_page=posts");
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function postBulkAction()
    {
        $sql_delete = "DELETE FROM posts WHERE id = ?";
        $sql_approve = "UPDATE posts SET post_status = :post_status WHERE id = :id";
        $sql_reset_ai = "ALTER TABLE posts AUTO_INCREMENT = 1";
        $sql_fetch_img = "SELECT post_image FROM posts WHERE id = ?";
        $sql_fetch_post = "SELECT * FROM posts WHERE id = ?";
        $sql_reset_post_views = "UPDATE posts SET post_views = :post_views WHERE id = :id";
        $path = 'Location: ' . $_SERVER['PHP_SELF'] . "?admin_page=posts";

        try {
            if (isset($_POST['bulk_action_submit'])) {
                if (isset($_POST['post_id']) && !empty($_POST['bulk_action_post'])) {
                    $post_id_array = $_POST['post_id'];
                    $bulk_action = $_POST['bulk_action_post'];


                    foreach ($post_id_array as $post_id) {
                        switch ($bulk_action) {
                            case 'delete':
                                $stmt_img = $this->connect_db()->prepare($sql_fetch_img);
                                if ($stmt_img->execute([$post_id])) {
                                    $img = $stmt_img->fetch();
                                    if (unlink('img/' . $img['post_image'])) {
                                        $stmt = $this->connect_db()->prepare($sql_delete);
                                        $stmt->execute([$post_id]);
                                        $this->connect_db()->query($sql_reset_ai);
                                        header($path);
                                    }
                                }
                                break;
                            case 'approve':
                                $status = 1;
                                $stmt = $this->connect_db()->prepare($sql_approve);
                                $stmt->execute(['post_status' => $status, 'id' => $post_id]);
                                header($path);
                                break;
                            case 'unapprove':
                                $status = 0;
                                $stmt = $this->connect_db()->prepare($sql_approve);
                                $stmt->execute(['post_status' => $status, 'id' => $post_id]);
                                header($path);
                                break;
                            case 'clone':
                                $stmt = $this->connect_db()->prepare($sql_fetch_post);
                                if ($stmt->execute([$post_id])) {
                                    while ($result = $stmt->fetch()) {
                                        $author = $result['post_author_id'];
                                        $cate = $result['post_category_id'];
                                        $title = $result['post_title'];
                                        $content = $result['post_content'];
                                        $image = $result['post_image'];
                                        $date = date('Y-m-d');
                                        $tags = $result['post_tags'];
                                        $comment_count = 0;
                                        $status = 1;
                                        $sql_clone = "INSERT INTO posts (post_author_id, post_category_id, post_title, post_content, post_image, post_date, post_tags, post_comments_count, post_status) VALUES ('{$author}', '{$cate}', '{$title}', '{$content}', '{$image}', '{$date}', '{$tags}', '{$comment_count}', '{$status}')";

                                        $this->connect_db()->query($sql_clone);
                                        header($path);
                                    }
                                }
                                break;
                            case 'reset_views':
                                $views = 0;
                                $stmt = $this->connect_db()->prepare($sql_reset_post_views);
                                if ($stmt->execute(['post_views' => $views, 'id' => $post_id])) {
                                    header($path);
                                }
                                break;
                        }
                    }
                } else {
                    echo "Please fill in all the blanks";
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }


    private function postImageHandler()
    {
        $image = $_FILES['post_image'];
        $image_name = $_FILES['post_image']['name'];
        $image_tmp_name = $_FILES['post_image']['tmp_name'];
        $upload_path = "img/";
        $file = $upload_path . basename($image_name);
        $upload_ok = array(
            'ok' => 1,
            'msg' => ""
        );
        $fileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if (!empty($image_tmp_name)) {
            $is_image = getimagesize($image_tmp_name);
            if ($is_image !== false) {
                if (file_exists($file)) {
                    $upload_ok['ok'] = 0;
                    $upload_ok['msg'] = "File exists";
                    return $upload_ok;
                } else if ($image['size'] > 3000000) {
                    $upload_ok['ok'] = 0;
                    $upload_ok['msg'] = "File is too large";
                    return $upload_ok;
                } else if ($fileType != 'jpg' && $fileType != 'jpeg' && $fileType != 'png' && $fileType != 'gif') {
                    $upload_ok['ok'] = 0;
                    $upload_ok['msg'] = "Wrong file type";
                    return $upload_ok;
                } else {
                    $upload_ok['ok'] = 1;
                    $upload_ok['msg'] = "Upload ok";
                    return $upload_ok;
                }
            } else {
                $upload_ok['ok'] = 0;
                $upload_ok['msg'] = "File is not an image";
                return $upload_ok;
            }
        } else {
            $upload_ok['ok'] = 2;
            $upload_ok['msg'] = "File is empty";
            return $upload_ok;
        }
    }
}
