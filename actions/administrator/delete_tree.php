<?php
include('../../utils/administrator/admin_functions.php');

if ($_POST && isset($_REQUEST['id_tree'])) {
    $id_tree = (int)$_REQUEST['id_tree'];

    $newState = isset($_REQUEST['new_state']) ? (int)$_REQUEST['new_state'] : 0; 

    $existingTree = getTreeById($id_tree);
    if (empty($existingTree)) {
        header("Location: ../../administrator/manage_trees.php?error=" . urlencode("Specie not found."));
        exit;
    }

    if (updateTreeStatus($id_tree, $newState)) { 
        header("Location: ../../administrator/manage_trees.php");
    } else {
        header("Location: ../../administrator/manage_trees.php?error=" . urlencode("Failed to update specie status."));
    }
}

