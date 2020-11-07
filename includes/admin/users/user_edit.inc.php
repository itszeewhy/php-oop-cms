<?php
$user = $userView->displayUser();
if ($user['user_isadmin'] == 0) :
?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <input type="text" name="user[name]" value="<?php echo $user['user_name']; ?>" placeholder="username">
        <input type="email" name="user[email]" value="<?php echo $user['user_email']; ?>" placeholder="email">
        <label for="user_role"><b>User Role</b></label>
        <select name="user[role]" id="user_role">
            <option value="">-- Select an option --</option>
            <option value="0" <?php echo ($user['user_isadmin'] == 0) ? "selected" : ""; ?>>User</option>
            <option value="1" <?php echo ($user['user_isadmin'] == 1) ? "selected" : ""; ?>>Admin</option>
        </select>
        <input type="submit" value="Update" name="user_update_submit">
    </form>
<?php
    $userContr->updateUser();
else :
?>
    <p>No action available</p>
<?php
endif;
?>