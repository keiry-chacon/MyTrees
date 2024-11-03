<?php

/*
* Form that adds a new tree
*/

include('../utils/administrator/admin_functions.php');
$species = getSpecies();  
$tree = [
    'Specie_Id' => 1 
];$error_msg = '';
if(isset($_GET['error'])) {
  $error_msg = $_GET['error'];
}
?>

<?php require('../inc/header_admin.php')?>
  <div class="container-fluid">
    <div class="jumbotron">
      <h1 class="display-4">Register Tree</h1>
      <p class="lead">Register Tree</p>
      <hr class="my-4">
    </div>

    <form method="post" action="../actions/administrator/add_tree.php" enctype="multipart/form-data">

        <?php if ($error_msg): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

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
        <input id="location" class="form-control" type="text" name="location">
      </div>

      <div class="form-group">
        <label for="size">Size</label>
        <input id="size" class="form-control" type="number" name="size">
      </div>
      
      <div class="form-group">
            <label for="statusT">Status</label>
            <select id="statusT" class="form-control" name="statusT" required>
                <option value="1">Available</option>
                <option value="0">Sold</option>
            </select>
        </div>

      <div class="form-group">
        <label for="price">Price</label>
        <input id="price" class="form-control" type="number" name="price">
      </div>

      <div class="form-group">
        <label for="photoPath">Tree Picture</label>
        <input type="file" class="form-control" name="photoPath" id="photoPath" accept="image/png, image/jpeg" multiple="true">
      </div>

      <button type="submit" class="btn btn-primary"> Add Specie </button>
    </form>
    <a href="../administrator/admin.php" class="btn btn-secondary mt-3">Administration</a>
  </div>
<?php require('../inc/footer.php');

