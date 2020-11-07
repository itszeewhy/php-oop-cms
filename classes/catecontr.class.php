<?php

class CateContr extends CateModel
{

    public function deleteCate()
    {
        $sql = "DELETE FROM categories WHERE id = ?";
        $sql_reset_auto_increment = "ALTER TABLE categories AUTO_INCREMENT = 1";
        $path  = $_SERVER['PHP_SELF'] . "?admin_page=categories";

        try {
            if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'delete') {
                $id = $_GET['id'];
                $stmt = $this->connect_db()->prepare($sql);
                if ($stmt->execute([$id])) {
                    $this->connect_db()->query($sql_reset_auto_increment);
                    header('Location: ' . $path);
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function insertCate()
    {
        $sql = "INSERT INTO categories (category_name) VALUES (?)";
        $path  = $_SERVER['PHP_SELF'] . "?admin_page=categories";

        try {
            if (isset($_POST['cate_add_submit'])) {
                if (!empty($_POST['cate_name'])) {
                    $cate_name = htmlspecialchars($_POST['cate_name']);
                    $num_row = $this->fetchExistingCateByName();

                    if ($num_row == 0) {
                        $stmt = $this->connect_db()->prepare($sql);
                        $stmt->execute([$cate_name]);
                        header('Location: ' . $path);
                    } else {
                        echo "Category exists";
                    }
                } else {
                    echo "Please fill in the blanks";
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function updateCate()
    {
        $sql = "UPDATE categories SET category_name = :category_name WHERE id = :id";
        $path  = $_SERVER['PHP_SELF'] . "?admin_page=categories";
        try {

            if (isset($_POST['cate_edit_submit'])) {
                $cate_name = htmlspecialchars($_POST['cate_name']);
                $cate_id = $_GET['id'];
                if (!empty($cate_name)) {
                    $num_row = $this->fetchExistingCateByName();
                    echo $num_row;
                    if ($num_row == 0) {
                        $stmt = $this->connect_db()->prepare($sql);
                        $stmt->execute(['category_name' => $cate_name, 'id' => $cate_id]);
                        header('Location: ' . $path);
                    } else {
                        header('Location: ' . $path);
                    }
                } else {
                    echo "Please enter a valid category name";
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function cateBulkAction()
    {
        $sql = "DELETE FROM categories WHERE id = ?";
        $path  = $_SERVER['PHP_SELF'] . "?admin_page=categories";

        try {
            if (isset($_POST['bulk_action_submit'])) {
                if (isset($_POST['cate_id']) && !empty($_POST['bulk_action_cate'])) {
                    $cate_id_array = $_POST['cate_id'];
                    $bulk_action = $_POST['bulk_action_cate'];
                    foreach ($cate_id_array as $cate_id) {
                        if ($bulk_action == 'delete') {
                            $stmt = $this->connect_db()->prepare($sql);
                            $stmt->execute([$cate_id]);
                            header('Location: ' . $path);
                        }
                    }
                } else {
                    echo "Please select an action and category";
                }
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }
}
