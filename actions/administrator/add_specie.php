<?php

/*
* Add a new species to the table
*/

include('../../utils/administrator/admin_functions.php');

if ($_POST && isset($_REQUEST['commercial_name'])) {
  $specie['commercial_name'] = trim($_POST['commercial_name']);
  $specie['scientific_name'] = trim($_POST['scientific_name']);

  $required_fields = ['commercial_name', 'scientific_name'];

  foreach ($required_fields as $field) {
    if (empty($specie[$field])) {
      header("Location: ../../administrator/register_specie.php?error=" . urlencode("All fields are required."));
      exit;
    }
  }

  if (specieExists($specie['commercial_name'], $specie['scientific_name'])) {
    header("Location: ../../administrator/register_specie.php?error=" . urlencode("Specie already registered"));
    exit; 
  }

  if (saveSpecie($specie)) {
    header( "Location: ../../administrator/manage_species.php",);
  } else {
    header("Location: ../../administrator/register_specie.php?error=" . urlencode("Invalid specie data"));
  }
}