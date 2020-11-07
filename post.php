<?php
include 'includes/header.inc.php';
$postView = new PostView();
$comView = new ComView();
$comContr = new ComContr();
$postContr = new PostContr();

$postContr->postViewsUpdate();
?>
<section>
    <h2>
        <?php echo $postView->displayPost()['post_title']; ?>
    </h2>
    <p><small><?php echo $postView->displayPost()['user_name'] . " - " . $postView->displayPost()['post_date']; ?></small></p>
    <img class="imgs" src="img/<?php echo $postView->displayPost()['post_image']; ?>" alt="">
    <p><?php echo $postView->displayPost()['post_content']; ?></p>
</section>
<section>
    <h3>Comments</h3>
    <?php
    foreach ($comView->displayPostComments() as $comment) :
        if ($comment['comment_status'] == 1) :
    ?>
            <article>
                <p><?php echo $comment['comment_content']; ?></p>
                <p><small><b>Commented by: </b><?php echo $comment['user_name']; ?></small></p>
                <p><small><?php echo $comment['comment_date']; ?></small></p>
            </article>
    <?php
        endif;
    endforeach;
    ?>
    <?php
    if (isset($_SESSION['logged_in'], $_SESSION['user_info'])) :
        $user_info = $_SESSION['user_info'];
    ?>
        <form action="<?php $comContr->insertComment(); ?>" method="post">
            <textarea name="post_comment" cols="30" rows="10" placeholder="Comment"></textarea>
            <input type="submit" value="Comment" name="post_comment_submit">
        </form>
    <?php
    else :
    ?>
        <p><b>Please <a href="login.php">log in</a> to comment</b></p>
    <?php
    endif;
    ?>
</section>
<p><a href="index.php">Back home</a></p>
<?php
include 'includes/footer.inc.php';
?>