<?php
require('../utils/administrator/admin_functions.php');

if ($_POST && isset($_REQUEST['commercial_name'])) {
  // Sanitize input fields to avoid malicious input
  $id_specie                 = (int)$_POST['id'];
  $specie['commercial_name'] = trim($_POST['commercial_name']);
  $specie['scientific_name'] = trim($_POST['scientific_name']);

  // Required fields to validate
  $required_fields = ['commercial_name', 'scientific_name'];

  foreach ($required_fields as $field) {
    if (empty($specie[$field])) {
      header("Location: ../administrator/update_specie.php?error=" . urlencode("All fields are required."));
      exit;
    }
  }

  if (updateSpecie($specie, $id_specie)) {
    header( "Location: ../administrator/manage_species.php",);
  } else {
    header("Location: ../administrator/update_specie.php?error=" . urlencode("Invalid specie data"));
  }
}