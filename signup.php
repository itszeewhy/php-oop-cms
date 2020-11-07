<?php
include 'includes/header.inc.php';

$userContr = new UserContr();
?>
<section>
    <h1>Sign up</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="text" name="signup_username" placeholder="username">
        <input type="email" name="signup_email" placeholder="email">
        <input type="password" name="signup_password" placeholder="password">
        <input type="password" name="signup_password_r" placeholder="repeat password">
        <input type="submit" name="signup_submit" value="Sign up">
    </form>
    <p><?php $userContr->signupUser(); ?></p>
</section>
<p><a href="index.php">Back home</a></p>
<?php
include 'includes/footer.inc.php';
?>