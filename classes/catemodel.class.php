<?php

class CateModel extends Database
{
    protected function fetchAllCate()
    {
        $sql = "SELECT * FROM categories";
        $query = $this->connect_db()->query($sql);
        $row = $query->fetchAll();
        return $row;
    }

    protected function fetchExistingCateByName()
    {
        $sql = "SELECT * FROM categories WHERE category_name = ?";
        $cate_name = htmlspecialchars($_POST['cate_name']);
        $stmt = $this->connect_db()->prepare($sql);
        $stmt->execute([$cate_name]);
        $stmt->fetch();
        $num_row = $stmt->rowCount();
        return $num_row;
    }

    public function fetchEditingCate()
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $cate_id = $_GET['id'];
        $stmt = $this->connect_db()->prepare($sql);
        $stmt->execute([$cate_id]);
        $result = $stmt->fetch();
        return $result['category_name'];
    }
}
