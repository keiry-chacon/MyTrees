<?php
  include('../utils/administrator/admin_functions.php');
  $trees = getTrees();
  $error_msg = '';
  if(isset($_GET['error'])) {
    $error_msg = $_GET['error'];
  }
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="../css/styles_manage_specie.css"> 
<script src="https://kit.fontawesome.com/12d578a4cd.js" crossorigin="anonymous"></script>

<?php require('../inc/header_admin.php')?>
<div class="container mt-5">
    <div class="jumbotron text-center">
      <h1 class="display-4">Manage Trees</h1>
      <p class="lead">Here is a list of all registered trees.</p>
      <hr class="my-4">
      <a href="../administrator/admin.php" class="btn btn-primary">Go to Home</a>
      <a href="register_tree.php" class="btn btn-primary">Add Tree</a>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Id Tree</th>
                <th>Specie Id</th>
                <th>Location</th>
                <th>Size</th>
                <th>Status</th>
                <th>Price</th>
                <th>Photo_Path</th>

            </tr>
        </thead>
        <tbody>
          <?php
              if (!empty($trees)) {
                foreach ($trees as $tree) { ?>
                    <tr>
                        <td><?= $tree['Id_Tree'] ?></td>
                        <td><?= $tree['Specie_Id'] ?></td>
                        <td><?= $tree['Location'] ?></td>
                        <td><?= $tree['Size'] ?></td>
                        <td><?= $tree['StatusT'] ?></td>
                        <td><?= $tree['Price'] ?></td>
                        <td><?= $tree['Photo_Path'] ?></td>

                        <td class="text-center">
                        <a href="update_tree.php?id=<?= $tree['Id_Tree'] ?>" class="btn btn-edit" title="Edit">
                        <i class="fa-solid fa-pen-to-square fa-lg"></i>
                            </a>
                            <form action="<?= BASE_URL; ?>actions/administrator/delete_tree.php" method="POST" style="display:inline;" title="Delete">
                                <input type="hidden" name="id_tree" value="<?= $tree['Id_Tree'] ?>">
                                <input type="hidden" name="new_state" value="0"> 
                                <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this tree?');">
                                    <i class="fa-solid fa-trash fa-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php }  
              } 
            ?>
        </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</div>
