<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <input type="text" name="cate_name" placeholder="Category name" value="<?php $cateView->displayEditingCate(); ?>">
    <input type="submit" value="Update" name="cate_edit_submit">
</form>
<?php
$cateContr->updateCate();
?>