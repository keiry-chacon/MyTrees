<?php

/*
* Form that updates a specie
*/

require_once(__DIR__ . '/../utils/administrator/admin_functions.php');

    $specie = null; 

    if (isset($_GET['id'])) {
        $id_specie  = (int)$_GET['id'];
        $specieID   = getSpecieById($id_specie);

        if (!is_array($specieID) || empty($specieID)) {
            die("Specie not found.");
        } else {
            $specie = $specieID[0]; 
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
        <h1 class="display-4">Update Specie</h1>
        <p class="lead">This is the update process</p>
        <hr class="my-4">
    </div>

    <form method="post" action="../actions/administrator/update_specie.php">

        <?php if ($error_msg): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?php echo $specie['Id_Specie']; ?>">

        <div class="form-group">
            <label for="commercial-name">Commercial Name</label>
            <input id="commercial-name" class="form-control" type="text" name="commercial_name" value="<?php echo htmlspecialchars($specie['Commercial_Name']); ?>">
        </div>

        <div class="form-group">
            <label for="scientific-name">Scientific Name</label>
            <input id="scientific-name" class="form-control" type="text" name="scientific_name" value="<?php echo htmlspecialchars($specie['Scientific_Name']); ?>">
        </div>

        <button type="submit" class="btn btn-primary"> Update Specie </button> 

    </form>

    <a href="../administrator/manage_species.php" class="btn btn-secondary mt-3">Manage Species</a>
</div>
