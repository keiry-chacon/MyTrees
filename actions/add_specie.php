<?php
require '../utils/admin_functions.php';


if ($_POST && isset($_REQUEST['commercial_name'])) {
  // Sanitize input fields to avoid malicious input
  $specie['commercial_name'] = trim($_POST['commercial_name']);
  $specie['scientific_name'] = trim($_POST['scientific_name']);

  // Required fields to validate
  $required_fields = ['commercial_name', 'scientific_name'];

  foreach ($required_fields as $field) {
    if (empty($specie[$field])) {
      header("Location: ../index.php?error=" . urlencode("All fields are required."));
      exit;
    }
  }

  if (specieExists($specie['commercial_name'], $specie['scientific_name'])) {
    header("Location: ../manage_species.php?error=" . urlencode("Specie already registered"));
    exit; 
  }

  if (saveSpecie($specie)) {
    header( "Location: ../manage_species.php",);
  } else {
    header("Location: ../manage_species.php?error=" . urlencode("Invalid specie data"));
  }
}