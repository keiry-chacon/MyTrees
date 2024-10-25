<?php
include('../../utils/administrator/admin_functions.php');

if ($_POST && isset($_REQUEST['id_specie'])) {
    $id_specie = (int)$_REQUEST['id_specie'];

    $newState = isset($_REQUEST['new_state']) ? (int)$_REQUEST['new_state'] : 0; 

    $existingSpecie = getSpecieById($id_specie);
    if (empty($existingSpecie)) {
        header("Location: ../../administrator/manage_species.php?error=" . urlencode("Specie not found."));
        exit;
    }

    if (updateSpecieStatus($id_specie, $newState)) { 
        header("Location: ../../administrator/manage_species.php");
    } else {
        header("Location: ../../administrator/manage_species.php?error=" . urlencode("Failed to update specie status."));
    }
}

