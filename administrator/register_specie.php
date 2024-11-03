<?php

/*
* Form that adds a specie
*/

include('../utils/administrator/admin_functions.php');

$error_msg = '';
if(isset($_GET['error'])) {
  $error_msg = $_GET['error'];
}
?>

<?php require('../inc/header_admin.php')?>
  <div class="container-fluid">
    <div class="jumbotron">
      <h1 class="display-4">Manage Species</h1>
      <p class="lead">Manage Species</p>
      <hr class="my-4">
    </div>

    <form method="post" action="../actions/administrator/add_specie.php">

        <?php if ($error_msg): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

      <div class="form-group">
        <label for="commercial_name">Commercial Name</label>
        <input id="commercial_name" class="form-control" type="text" name="commercial_name">
      </div>

      <div class="form-group">
        <label for="scientific_name">Scientific Name</label>
        <input id="scientific_name" class="form-control" type="text" name="scientific_name">
      </div>

      <button type="submit" class="btn btn-primary"> Add Specie </button>

    </form>
    
    <a href="../administrator/admin.php" class="btn btn-secondary mt-3">Administration</a>
  </div>
<?php require('../inc/footer.php');

