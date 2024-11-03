<?php

/*
* Register a tree update
*/

include('../../utils/administrator/admin_functions.php');

$error_msg = '';

if ($_POST && isset($_POST['size'])) {
    $id_tree              = (int)$_POST['id'];
    $tree['size']         = trim($_POST['size']);
    $tree['statusT']      = trim($_POST['statusT']);

    $registerSuccess    = registerTreeUpdate($tree, $id_tree); // Add Register Tree Update 
    $updateSuccess      = updateTreeRegister($tree, $id_tree); // Updates Tree Table

    if ($registerSuccess && $updateSuccess) {
        header("Location: ../../administrator/manage_friends.php");
    } else {
        header("Location: ../../administrator/register_tree_update.php?error=" . urlencode("Error updating or registering tree data"));
    }
} else {
    header("Location: ../../administrator/register_tree_update.php?error=" . urlencode("Invalid request."));
}
?>
