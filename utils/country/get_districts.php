<?php
include('../functions.php');

if (isset($_POST['province_id'])) {
    $province_id = intval($_POST['province_id']); // Validar que sea un número entero

    // Obtener distritos por provincia
    $districts = getDistricts($province_id);

    if ($districts) {
        // Devolver opciones HTML
        echo '<option value="">Select District</option>';
        foreach ($districts as $id => $district) {
            echo "<option value=\"$id\">$district</option>";
        }
    } else {
        echo '<option value="">No districts available</option>';
    }
}
?>

