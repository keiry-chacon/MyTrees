<?php

/*
* Add a new tree to the table
*/


include('../../utils/administrator/admin_functions.php');

$uploads_folder = $_SERVER["DOCUMENT_ROOT"]."/uploads_tree/";

$error_msg = '';

if ($_POST && isset($_POST['specie_id'])) {
  $tree['specie_id']    = trim($_POST['specie_id']); 
  $tree['location']     = trim($_POST['location']);
  $tree['size']         = trim($_POST['size']);
  $tree['statusT']      = trim($_POST['statusT']);
  $tree['price']        = trim($_POST['price']);
  $tree['photoPath']    = "default_tree.php";

  if (!empty($_FILES["photoPath"]["tmp_name"])) {
    $file_tmp = $_FILES["photoPath"]["tmp_name"];
    $is_custom_image = true;
    }

  $required_fields = ['specie_id', 'location', 'statusT', 'price'];
  foreach ($required_fields as $field) {
    if (empty($tree[$field])) {
      header("Location: ../../administrator/register_tree.php?error=" . urlencode("All fields are required."));
      exit;
    }
  }

  if ($tree_id = saveTree($tree)) {
    if($is_custom_image){
    $file_name = $tree_id . '.' . pathinfo($_FILES["photoPath"]["name"], PATHINFO_EXTENSION);
    $target_file = $uploads_folder . $file_name;
    move_uploaded_file($file_tmp,$target_file);
    updateTreePic($tree_id, $file_name);
    header("Location: ../../administrator/manage_trees.php");
    }

  } else {
    header("Location: ../../administrator/register_tree.php?error=" . urlencode("Invalid tree data"));
  }
} else {
  header("Location: ../../administrator/register_tree.php?error=" . urlencode("Invalid request."));
}
?>
