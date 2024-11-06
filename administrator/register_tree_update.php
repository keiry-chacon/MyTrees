<?php

/*
* Form that register a Tree Update
*/

require_once(__DIR__ . '/../utils/administrator/admin_functions.php');


    $tree = null; 

    if (isset($_GET['id'])) {
        $id_tree    = (int)$_GET['id'];
        $treeID     = getTreeById($id_tree);
        $species    = getSpecies();

        if (!is_array($treeID) || empty($treeID)) {
            die("Tree not found.");
        } else {
            $tree = $treeID[0]; 
            if (!isset($tree['StatusT'])) {
                $tree['StatusT'] = ''; 
            }
        }
    }

    $error_msg = '';
    if(isset($_GET['error'])) {
    $error_msg = $_GET['error'];
    }
?>

<?php require('../inc/header_admin.php')?>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="display-4">Register Tree Update</h1>
        <p class="lead">This is the register update process</p>
        <hr class="my-4">
    </div>

    <form method="post" action="../actions/administrator/register_tree_update.php">
        <?php if ($error_msg): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?php echo $tree['Id_Tree']; ?>">

        <div class="form-group">
            <label for="size">Size</label>
            <input id="size" class="form-control" type="number" name="size" value="<?php echo htmlspecialchars($tree['Size']); ?>">
        </div>

        <div class="form-group">
            <label for="statusT">Status</label>
            <select id="statusT" class="form-control" name="statusT">
                <option value="1" <?php echo (isset($tree['StatusT']) && $tree['StatusT'] == 1) ? 'selected' : ''; ?>>Available</option>
                <option value="0" <?php echo (isset($tree['StatusT']) && $tree['StatusT'] == 0) ? 'selected' : ''; ?>>Sold</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary"> Register Tree update </button> 

    </form>

    <a href="../administrator/manage_friends.php" class="btn btn-secondary mt-3">Manage Friends</a>
</div>
