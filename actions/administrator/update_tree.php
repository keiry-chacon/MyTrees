<?php

/*
* Update the information of a tree
*/
include('../../utils/administrator/admin_functions.php');

$uploads_folder = "../../uploads_tree/";

$error_msg = '';

if ($_POST && isset($_POST['specie_id'])) {
  $id_tree              = (int)$_POST['id'];
  $tree['specie_id']    = trim($_POST['specie_id']); 
  $tree['location']     = trim($_POST['location']);
  $tree['size']         = trim($_POST['size']);
  $tree['statusT']      = trim($_POST['statusT']);
  $tree['price']        = trim($_POST['price']);

  if (isset($_FILES['photoPath']) && $_FILES['photoPath']['error'] == UPLOAD_ERR_OK) {
      $profileImage = $_FILES['photoPath'];
      $currentImage = $id_tree; 
      if ($currentImage && $currentImage !== "default_tree.png") {
          $currentImagePath = $uploads_folder . $currentImage;
          if (file_exists($currentImagePath)) {
              unlink($currentImagePath); 
          }
      }

      $newImageName =  $id_tree  . '.' . pathinfo($profileImage['name'], PATHINFO_EXTENSION); 
      move_uploaded_file($profileImage['tmp_name'], $uploads_folder . $newImageName);
      updateTreePic($id_tree, $newImageName); 
    }
 
  $required_fields    = ['location', 'price'];

  foreach ($required_fields as $field) {
    if (empty($tree[$field])) {
      header("Location: ../../administrator/update_tree.php?error=" . urlencode("All fields are required."));
      exit;
    }
  }

  if (updateTree($tree, $id_tree)) {
    header("Location: ../../administrator/manage_trees.php");
  } else {
    header("Location: ../../administrator/update_tree.php?error=" . urlencode("Invalid tree data"));
  }
} else {
  header("Location: ../../administrator/update_tree.php?error=" . urlencode("Invalid request."));
}
?>
