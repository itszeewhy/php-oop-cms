<?php
include 'includes/header.inc.php';

// Utility variables
$uri_cate = $_SERVER['PHP_SELF'] . "?admin_page=categories";
$uri_post = $_SERVER['PHP_SELF'] . "?admin_page=posts";
$uri_comment = $_SERVER['PHP_SELF'] . "?admin_page=comments";
$uri_user = $_SERVER['PHP_SELF'] . "?admin_page=users";

// Utility classes
$cateView = new CateView();
$cateContr = new CateContr();
$postView = new PostView();
$postContr = new PostContr();
$userView = new UserView();
$userContr = new UserContr();
$comView = new ComView();
$comContr = new ComContr();

if (isset($_SESSION['logged_in'], $_SESSION['user_info'])) :
    $userinfo = $_SESSION['user_info'];
    if ($userinfo['user_isadmin'] != 0) :
?>
        <header>
            <h1>Welcome to Admin Panel</h1>
            <p><a href="index.php">Return home</a></p>
            <nav>
                <ul>
                    <li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?admin_page=categories"); ?>">Categories</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?admin_page=posts"); ?>">Posts</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?admin_page=comments"); ?>">Comments</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?admin_page=users"); ?>">Users</a></li>
                </ul>
            </nav>
        </header>
        <section>
            <?php
            if (isset($_GET['admin_page'])) {
                $page = $_GET['admin_page'];

                switch ($page) {
                    case 'categories':
                        include 'includes/admin/categories.inc.php';
                        break;
                    case 'posts':
                        include 'includes/admin/posts.inc.php';
                        break;
                    case 'comments':
                        include 'includes/admin/comments.inc.php';
                        break;
                    case 'users':
                        include 'includes/admin/users.inc.php';
                        break;
                }
            }

            ?>
        </section>

<?php
    else :
        header('Location: 404.php');
    endif;
else :
    header('Location: 404.php');
endif;
include 'includes/footer.inc.php';
?>