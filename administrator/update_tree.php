<?php

/*
* Form that updates a tree
*/

require_once(__DIR__ . '/../utils/administrator/admin_functions.php');

    $action_path = $_SERVER["DOCUMENT_ROOT"] . "/MyTreesProject/actions/administrator/update_tree.php"; 

    $tree = null; 

    if (isset($_GET['id'])) {
        $id_tree    = (int)$_GET['id'];
        $treeID     = getTreeById($id_tree);
        $species    = getSpecies();

        if (!is_array($treeID) || empty($treeID)) {
            die("Tree not found.");
        } else {
            $tree = $treeID[0]; 
        }
    }

    $error_msg = '';
    if(isset($_GET['error'])) {
    $error_msg = $_GET['error'];
    }
?>

<?php require('../inc/header_admin.php')?>
<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="display-4">Update Tree</h1>
        <p class="lead">This is the update process</p>
        <hr class="my-4">
    </div>

    <form method="post" action="<?php echo $action_path; ?>">

        <?php if ($error_msg): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?php echo $tree['Id_Tree']; ?>">

        <div class="form-group">
            <label for="specie_id">Specie</label>
            <select id="specie_id" class="form-control" name="specie_id">
                <?php foreach ($species as $specie): ?>
                    <option value="<?php echo $specie['Id_Specie']; ?>" 
                        <?php echo ($specie['Id_Specie'] == $tree['Specie_Id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($specie['Commercial_Name']) . " (" . htmlspecialchars($specie['Scientific_Name']) . ")"; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input id="location" class="form-control" type="text" name="location" value="<?php echo htmlspecialchars($tree['Location']); ?>">
        </div>

        <div class="form-group">
            <label for="size">Size</label>
            <input id="size" class="form-control" type="number" name="size" value="<?php echo htmlspecialchars($tree['Size']); ?>">
        </div>

        <div class="form-group">
            <label for="statusT">Status</label>
            <select id="statusT" class="form-control" name="statusT">
                <option value="1" <?php if ($tree['StatusT'] == 1) echo 'selected'; ?>>Available</option>
                <option value="0" <?php if ($tree['StatusT'] == 0) echo 'selected'; ?>>Sold</option>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input id="price" class="form-control" type="number" name="price" value="<?php echo htmlspecialchars($tree['Price']); ?>">
        </div>

        <div class="form-group">
            <label for="photoPath">Tree Picture</label>
            
            <?php if (!empty($tree['photoPath'])): ?>
                <div>
                    <p>Current Image:</p>
                    <img src="<?php echo htmlspecialchars($tree['Photo_Path']); ?>" alt="Tree Picture" style="max-width: 200px; height: auto;">
                </div>
            <?php endif; ?>
            
            <input type="file" class="form-control" name="photoPath" id="photoPath" accept="image/png, image/jpeg">
        </div>

        <button type="submit" class="btn btn-primary"> Update Tree </button> 

    </form>

    <a href="../administrator/manage_trees.php" class="btn btn-secondary mt-3">Manage Trees</a>
</div>
<?php require('../inc/footer.php'); ?>
