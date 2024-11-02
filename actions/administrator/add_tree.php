<?php
include('../../utils/administrator/admin_functions.php');

$uploads_folder = $_SERVER["DOCUMENT_ROOT"]."/uploads/";

$error_msg = '';

if ($_POST && isset($_POST['specie_id'])) {
  // Sanitize input fields to avoid malicious input
  $tree['specie_id']    = trim($_POST['specie_id']); 
  $tree['location']     = trim($_POST['location']);
  $tree['size']         = trim($_POST['size']);
  $tree['statusT']      = trim($_POST['statusT']);
  $tree['price']        = trim($_POST['price']);

  $file_tmp = $_FILES["photoPath"]["tmp_name"];
  $file_name = basename($_FILES["photoPath"]["name"]);
  $target_file = $uploads_folder . $file_name;
  move_uploaded_file($file_tmp,$target_file);

  $tree['photoPath'] = $file_name;

  // Campos requeridos para validar
  $required_fields = ['specie_id', 'location', 'statusT', 'price'];
  foreach ($required_fields as $field) {
    if (empty($tree[$field])) {
      header("Location: ../../administrator/register_tree.php?error=" . urlencode("All fields are required."));
      exit;
    }
  }

  // Llamada a la función para guardar los datos de la especie
  if (saveTree($tree)) {
    header("Location: ../../administrator/manage_trees.php");
  } else {
    header("Location: ../../administrator/register_tree.php?error=" . urlencode("Invalid tree data"));
  }
} else {
  header("Location: ../../administrator/register_tree.php?error=" . urlencode("Invalid request."));
}
?>
