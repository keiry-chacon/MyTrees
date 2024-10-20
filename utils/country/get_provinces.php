<?php
include('../functions.php');

if (isset($_POST['country_id'])) {
    $country_id = intval($_POST['country_id']); // Asegúrate de que sea un número entero válido.

    // Obtener provincias por país
    $provinces = getProvinces($country_id);

    if ($provinces) {
        // Devolver opciones HTML
        echo '<option value="">Select Province</option>';
        foreach ($provinces as $id => $province) {
            echo "<option value=\"$id\">$province</option>";
        }
    } else {
        echo '<option value="">No provinces available</option>';
    }
}
?>

