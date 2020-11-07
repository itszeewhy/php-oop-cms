<?php
include 'includes/header.inc.php';
$postView = new PostView();
?>

<section>
    <?php foreach ($postView->displayAuthorPost() as $post) : ?>
        <h2><?php echo $post['post_title']; ?></h2>
        <p><small><a href="category.php?cate_name=<?php echo $post['category_name']; ?>"><?php echo $post['category_name']; ?></a></small></p>
        <p><small><?php echo $post['post_date']; ?></small></p>
        <img src="img/<?php echo $post['post_image']; ?>" alt="img">

    <?php endforeach; ?>
</section>
<a href="index.php">Return home</a>
<?php
include 'includes/footer.inc.php';
?>