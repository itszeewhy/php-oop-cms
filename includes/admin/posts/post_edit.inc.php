<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="post_image">
    <input type="text" name="edit_post[post_title]" placeholder="Post title" value="<?php echo $postView->displayPost()['post_title']; ?>">
    <select name="edit_post[post_cate]">
        <option value="">-- Select Category --</option>
        <?php
        foreach ($cateView->displayAllCate() as $cate) :
        ?>
            <option value="<?php echo htmlspecialchars($cate['id']); ?>" <?php echo ($cate['id'] == $postView->displayPost()['post_category_id']) ? "selected" : ""; ?>><?php echo $cate['category_name']; ?></option>
        <?php
        endforeach;
        ?>
    </select>
    <input type="text" name="edit_post[post_tags]" placeholder="Post tags" value="<?php echo $postView->displayPost()['post_tags']; ?>">
    <textarea name="edit_post[post_content]" cols="30" rows="10" placeholder="Post content"><?php echo $postView->displayPost()['post_content']; ?></textarea>
    <input type="submit" value="Update" name="edit_post_submit">
</form>
<?php $postContr->postUpdate(); ?>