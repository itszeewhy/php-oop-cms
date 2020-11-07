<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <input type="password" name="user[new_password]" placeholder="new password">
    <input type="password" name="user[new_password_r]" placeholder="repeat password">
    <input type="submit" name="user_reset_pw_submit" value="Update password">
</form>
<?php
$userContr->updateUserPassword();
?>