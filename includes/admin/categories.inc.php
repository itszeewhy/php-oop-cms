<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <table>
        <thead>
            <tr>
                <th><input type="checkbox" class="select_all"></th>
                <th>id</th>
                <th>Categories</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cateView->displayAllCate() as $cate) : ?>
                <tr>
                    <td><input type="checkbox" name="cate_id[]" value="<?php echo $cate['id']; ?>" class="select_this"></td>
                    <td><?php echo $cate['id']; ?></td>
                    <td><?php echo $cate['category_name']; ?></td>
                    <td><a href="<?php echo $uri_cate . "&action=delete&id=" . $cate['id']; ?>" class="red">Delete</a><a href="<?php echo $uri_cate . "&action=edit&id=" . $cate['id']; ?>">Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <label for="bulk_action_cate"><b>Bulk action</b></label>
    <select name="bulk_action_cate" id="bulk_action_cate">
        <option value="">-- Select an action --</option>
        <option value="delete">Delete</option>
    </select>
    <input type="submit" value="Apply" name="bulk_action_submit">
    <?php $cateContr->cateBulkAction(); ?>
</form>
<p><a href="<?php echo $uri_cate . "&action=add" ?>">Add Categories</a></p>

<?php
// Page actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            // add
            include 'categories/cate_add.inc.php';
            break;
        case 'delete':
            // delete
            $cateContr->deleteCate();
            header('Location: ' . $uri_cate);
            break;
        case 'edit':
            // edit
            include 'categories/cate_edit.inc.php';
            break;
    }
}

// if (isset($_POST['bulk_action_submit'], $_POST['cate_id'])) {
//     print_r($_POST['cate_id']);
// } else {
//     echo 
// }

?>