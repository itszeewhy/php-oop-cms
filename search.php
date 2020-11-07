<?php

include 'includes/header.inc.php';

$postView = new PostView();

?>

<section>
    <h1>Search result</h1>
    <?php
    foreach ($postView->displaySearchResult() as $searchResult) :
    ?>
        <h2>
            <a href="post.php?post_id=<?php echo $searchResult['id']; ?>">
                <?php echo $searchResult['post_title']; ?>
            </a>
        </h2>
        <p><small><?php echo $searchResult['user_name'] . " - " . $searchResult['post_date']; ?></small></p>
        <img class="imgs" src="img/<?php echo $searchResult['post_image']; ?>" alt="">
    <?php
    endforeach;
    ?>
</section>

<?php

include 'includes/footer.inc.php'

?>