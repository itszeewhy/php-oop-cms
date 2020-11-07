<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Author</th>
            <th>Content</th>
            <th>Post</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($comView->displayAllComments() as $comment) :
        ?>
            <tr>
                <td><?php echo $comment['id']; ?></td>
                <td><?php echo $comment['user_name']; ?></td>
                <td><?php echo $comment['comment_content']; ?></td>
                <td>
                    <a href="post.php?post_id=<?php echo $comment['comment_post_id']; ?>"><?php echo $comment['post_title']; ?></a>
                </td>
                <td><?php echo $comment['comment_date']; ?></td>
                <td>
                    <?php
                    if ($comment['comment_status'] == 1) {
                        echo "Approved";
                    } else {
                        if ($comment['comment_status'] == 0) {
                            echo "Pending";
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($comment['comment_status'] == 1) :
                    ?>
                        <a href="<?php echo $uri_comment . "&action=approve&status=0&comment_id=" . $comment['id']; ?>">Unapprove</a>
                        <?php
                    else :
                        if ($comment['comment_status'] == 0) :
                        ?>
                            <a href="<?php echo $uri_comment . "&action=approve&status=1&comment_id=" . $comment['id']; ?>">Approve</a>
                    <?php
                        endif;
                    endif;
                    ?>
                    <a href="<?php echo $uri_comment . "&action=edit&comment_id=" . $comment['id']; ?>">Edit</a>
                    <a href="<?php echo $uri_comment . "&action=delete&comment_id=" . $comment['id']; ?>" class="red">Delete</a>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>
<?php

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'approve':
            $comContr->approveComment();
            break;
        case 'delete':
            $comContr->deleteComment();
            break;
        case 'edit':
            include 'comments/comment_edit.inc.php';
            break;
    }
}





// var_dump($comView->displayAllComments());
?>