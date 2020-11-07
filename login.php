<?php
include 'includes/header.inc.php';
// session_start();
$userContr = new UserContr();
?>

<section>
    <h1>Log in</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="email" name="user_email" placeholder="Email">
        <input type="password" name="user_password" placeholder="Password">
        <input type="submit" value="Log in" name="user_login_submit">
    </form>
    <?php $userContr->loginUser(); ?>
    <p><a href="index.php">Back home</a></p>
</section>


<?php
include 'includes/footer.inc.php';
?>