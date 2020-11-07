<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <input type="text" name="cate_name" placeholder="Category name">
    <input type="submit" value="Add" name="cate_add_submit">
</form>
<?php
$cateContr->insertCate();
?>