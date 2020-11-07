<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userView->displayAllUsers() as $user) : ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['user_name']; ?></td>
                <td><?php echo $user['user_email']; ?></td>
                <td><?php echo ($user['user_isadmin'] == 1) ? 'Admin' : 'User'; ?></td>
                <td>
                    <?php if ($user['user_isadmin'] != 1) : ?>
                        <a href="<?php echo $uri_user . "&action=delete&user_id=" . $user['id']; ?>" class="red">Delete</a>
                        <a href="<?php echo $uri_user . "&action=edit&user_id=" . $user['id']; ?>">Edit</a>
                    <?php endif; ?>
                    <a href="<?php echo $uri_user . "&action=reset_pw&user_id=" . $user['id']; ?>">Reset Password</a>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
// Actions

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'edit':
            include 'users/user_edit.inc.php';
            break;
        case 'delete':
            $userContr->deleteUser();
            break;
        case 'reset_pw':
            include 'users/user_reset_pw.inc.php';
            break;
    }
}

?>