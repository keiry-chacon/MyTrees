<?php

/*
* Shows friends list
*/

  include('../utils/administrator/admin_functions.php');

  $uploads_folder = $_SERVER["DOCUMENT_ROOT"]."/uploads_user/";

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
                <th>Profile Picture</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
          <?php
              if (!empty($users)) {
                foreach ($users as $user) { ?>
                    <tr>
                    <td>
                          <?php if(!empty($user['Photo_Path'])) { ?>
                            <img src="<?= htmlspecialchars($uploads_folder. $user['Photo_Path']) ?>" alt="Profile Picture" class="rounded-circle" style="width: 50px; height: 50px;">
                          <?php } else { ?>
                            <span>No Image</span>
                          <?php } ?>
                        <td><?= htmlspecialchars($user['First_Name']) ?></td>
                        <td><?= htmlspecialchars($user['Last_Name1']) ?></td>
                        <td><?= htmlspecialchars($user['Username']) ?></td>
                        <td><?= htmlspecialchars($user['Email']) ?></td>
                        <td class="text-center">
                          <a href="friend_trees.php?id=<?= $user['Id_User'] ?>" class="btn btn-edit" title="Edit">
                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                          </a>
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
