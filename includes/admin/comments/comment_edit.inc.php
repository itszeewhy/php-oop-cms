<?php
$comment = $comView->displayComment();
?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <textarea name="comment_content" cols="30" rows="10"><?php echo $comment['comment_content']; ?></textarea>
    <input type="submit" name="edit_comment_submit" value="Update">
</form>
<?php
$comContr->updateComment();
?>