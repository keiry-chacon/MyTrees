<?php
  include('../utils/administrator/admin_functions.php');
  $users = getUsers();
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
      <h1 class="display-4">Manage Friends</h1>
      <p class="lead">Here is a list of all registered friends.</p>
      <hr class="my-4">
      <a href="../administrator/admin.php" class="btn btn-primary">Go to Home</a>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Photo_Path</th>

            </tr>
        </thead>
        <tbody>
          <?php
              if (!empty($users)) {
                foreach ($users as $user) { ?>
                    <tr>
                        <td><?= $user['First_Name'] ?></td>
                        <td><?= $user['Last_Name1'] ?></td>
                        <td><?= $user['Username'] ?></td>
                        <td><?= $user['Email'] ?></td>
                        <td><?= $user['Photo_Path'] ?></td>
                    </tr>
                <?php }  
              } 
            ?>
        </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</div>
