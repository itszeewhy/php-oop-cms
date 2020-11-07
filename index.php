<?php
include 'includes/header.inc.php';
$postView = new PostView();
$postContr = new PostContr();
$cateView = new CateView();
$userContr = new UserContr();
$userView = new UserView();

?>

<header>
    <?php
    if (isset($_SESSION['logged_in'], $_SESSION['user_info'])) :
        $userinfo = $_SESSION['user_info'];
    ?>
        <h1>Welcome back, <?php echo $userinfo['user_name']; ?></h1>
    <?php
    else :
    ?>
        <h1>Welcome to the blog</h1>
        <p>Please <a href="login.php">log in</a> to use more features</p>
    <?php
    endif;
    ?>
</header>

<nav>
    <!-- Home navigation -->
    <ul>
        <?php
        foreach ($cateView->displayAllCate() as $category_link) :
        ?>
            <li><a href="category.php?cate_name=<?php echo $category_link['category_name']; ?>"><?php echo $category_link['category_name']; ?></a></li>
            <?php
        endforeach;

        // Check if logged in

        if (isset($_SESSION['logged_in'], $_SESSION['user_info'])) :
            $userinfo = $_SESSION['user_info'];

            if ($userinfo['user_isadmin'] == 1) :
            ?>
                <!-- Admin link -->
                <li><a href="admin.php">Admin Panel</a></li>
            <?php
            endif;
            ?>
            <!-- Log out link -->
            <li><a href="logout.php">Log out</a></li>
        <?php
        else :
        ?>
            <!-- Log in link -->
            <li><a href="login.php">Log in</a></li>
        <?php
        endif;
        ?>
        <li><a href="signup.php">Sign up</a></li>
    </ul>
</nav>
<section>
    <!-- Home search form -->
    <form action="search.php" method="post">
        <input type="search" name="search_post" placeholder="Search">
        <input type="submit" name="search_post_submit" value="Search">
    </form>


</section>
<!-- ajax -->
<button id="showUser">show user</button>
<div id="users"></div>













<section>
    <!-- Home posts -->
    <?php
    foreach ($postView->displayPostPerPage() as $post) :
        if ($post['post_status'] == 1) :
    ?>
            <h2>
                <a href="post.php?post_id=<?php echo $post['id']; ?>">
                    <?php echo $post['post_title']; ?>
                </a>
            </h2>
            <p><small><a href="user.php?user_id=<?php echo $post['post_author_id']; ?>"><?php echo $post['user_name']; ?></a><?php echo " - " . $post['post_date']; ?></small></p>
            <img class="imgs" src="img/<?php echo $post['post_image']; ?>" alt="">
            <p><small>Post views: <?php echo $post['post_views']; ?></small></p>
    <?php
        endif;
    endforeach;
    ?>
</section>

<section>
    <!-- pagination -->
    <ul class="pagination">
        <?php
        for ($i = 0; $i < $postView->displayPagination() / 2; $i++) :
        ?>
            <li>
                <a href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($i + 1); ?>"><?php echo $i + 1; ?></a>
            </li>
        <?php
        endfor;
        ?>
    </ul>
</section>
<section>
    <?php
    if (isset($_SESSION['logged_in'], $_SESSION['user_info'])) :
    ?>
        <h2>Add a post</h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
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
    <?php
        $postContr->addPost();
    else :
    ?>
        <p><a href="login.php"><b>Log in</b></a> to add a post</p>
    <?php
    endif;
    ?>
</section>
<?php
include 'includes/footer.inc.php';
?>