<?php
include 'includes/header.inc.php';

$postView = new PostView();
?>
<section>
    <h1>Category: <?php echo $_GET['cate_name']; ?></h1>
    <!-- Home posts -->
    <?php
    if (count($postView->displayCatePost()) > 0) :
        foreach ($postView->displayCatePost() as $post) :
    ?>
            <h2>
                <a href="post.php?post_id=<?php echo $post['id']; ?>">
                    <?php echo $post['post_title']; ?>
                </a>
            </h2>
            <p><small><?php echo $post['user_name'] . " - " . $post['post_date']; ?></small></p>
            <img class="imgs" src="img/<?php echo $post['post_image']; ?>" alt="">
            <p><?php echo $post['post_content']; ?></p>
        <?php
        endforeach;
    else :
        ?>
        <p><?php echo PostView::$no_post_in_cate_msg; ?></p>
    <?php
    endif;

    ?>
    <p><a href="index.php">Back home</a></p>
</section>
<?php
include 'includes/footer.inc.php';
?>