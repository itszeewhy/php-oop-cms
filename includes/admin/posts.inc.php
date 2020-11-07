<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <table>
        <thead>
            <tr>
                <th><input type="checkbox" class="select_all"></th>
                <th>id</th>
                <th>Post Title</th>
                <th>Post Category</th>
                <th>Post Author</th>
                <th>Post Date</th>
                <th>Post Tags</th>
                <th>Post Comments</th>
                <th>Post Date</th>
                <th>Post Views</th>
                <th>Post Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($postView->displayAllPosts() as $post) : ?>
                <tr>
                    <td><input type="checkbox" name="post_id[]" class="select_this" value="<?php echo $post['id']; ?>"></td>
                    <td><?php echo $post['id']; ?></td>
                    <td><?php echo $post['post_title']; ?></td>
                    <td>
                        <?php echo $post['category_name']; ?>
                    </td>
                    <td><?php echo $post['user_name']; ?></td>
                    <td><?php echo $post['post_date']; ?></td>
                    <td><?php echo $post['post_tags']; ?></td>
                    <td><?php echo $post['post_comments_count']; ?></td>
                    <td><?php echo $post['post_date']; ?></td>
                    <td><?php echo $post['post_views']; ?></td>
                    <td><?php echo ($post['post_status'] == 1) ? "Approved" : "Pending"; ?></td>
                    <td>
                        <?php
                        if ($post['post_status'] == 1) :
                        ?>
                            <a href="<?php echo $uri_post . "&action=approve&status=0&post_id=" . $post['id']; ?>">Unapprove</a>
                        <?php
                        else :
                        ?>
                            <a href="<?php echo $uri_post . "&action=approve&status=1&post_id=" . $post['id']; ?>">Approve</a>
                        <?php
                        endif;
                        ?>
                        <a href="<?php echo $uri_post . "&action=edit&post_id=" . $post['id']; ?>">Edit</a>
                        <a class="red" onclick="javascript: return confirm('are you sure?');" href="<?php echo $uri_post . "&action=delete&post_id=" . $post['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <label for="bulk_action_post"><b>Bulk actions</b></label>
    <select name="bulk_action_post" id="bulk_action_post">
        <option value="">-- Select an action --</option>
        <option value="delete">Delete</option>
        <option value="approve">Approve</option>
        <option value="unapprove">Unapprove</option>
        <option value="clone">Clone</option>
        <option value="reset_views">Reset Views</option>
    </select>
    <input type="submit" value="Apply" name="bulk_action_submit">
    <?php $postContr->postBulkAction(); ?>
</form>
<p><a href="<?php echo $uri_post . "&action=add" ?>">Add Post</a></p>
<?php
// Page actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            // add
            include 'posts/post_add.inc.php';
            break;
        case 'delete':
            // delete
            $postContr->postDelete();
            break;
        case 'edit':
            // edit
            include 'posts/post_edit.inc.php';
            break;
        case 'approve':
            // approve
            $postContr->postApproval();
            break;
    }
}
?>