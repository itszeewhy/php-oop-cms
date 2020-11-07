<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="post_image">
    <input type="text" name="add_post[post_title]" placeholder="Post title">
    <select name="add_post[post_cate]">
        <option value="">-- Select Category --</option>
        <?php
        foreach ($cateView->displayAllCate() as $cate) :
        ?>
            <option value="<?php echo htmlspecialchars($cate['id']); ?>"><?php echo $cate['category_name']; ?></option>
        <?php
        endforeach;
        ?>
    </select>
    <input type="text" name="add_post[post_tags]" placeholder="Post tags">
    <textarea name="add_post[post_content]" cols="30" rows="10" placeholder="Post content"></textarea>
    <input type="submit" value="Add" name="add_post_submit">
</form>
<?php $postContr->addPost(); ?>