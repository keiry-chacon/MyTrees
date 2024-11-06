<?php

/*
* Form that updates a tree
*/
require_once '../inc/header_admin.php'; 
require_once('../utils/administrator/admin_functions.php');
$uploads_folder = "../uploads_tree/";


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
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="display-4">Update Tree</h1>
        <p class="lead">This is the update process</p>
        <hr class="my-4">
    </div>

    <form method="post" action="../actions/administrator/update_tree.php" enctype="multipart/form-data">

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

            <div class="w-48 h-48 flex items-center justify-center bg-gray-100 border rounded">
                <img id="imagePreview" 
                    src="<?php echo !empty($tree['Photo_Path']) ? htmlspecialchars($uploads_folder . $tree['Photo_Path'] . '?' . time()) : ''; ?>" 
                    alt="Tree Picture" 
                    class="max-w-full max-h-full object-contain">
            </div>
            <input type="file" class="form-control" name="photoPath" id="photoPath" accept="image/png, image/jpeg" onchange="previewImage(event)">
        </div>

        <button type="submit" class="btn btn-primary"> Update Tree </button> 

    </form>

    <a href="../administrator/manage_trees.php" class="btn btn-secondary mt-3">Manage Trees</a>
</div>
<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;  
            };
            reader.readAsDataURL(file);
        }
    }
</script>