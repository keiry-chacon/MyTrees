<?php

/*
* Get Districts 
*/

include('../functions.php');

if (isset($_POST['province_id'])) {

    $province_id    = intval($_POST['province_id']); 
    $districts      = getDistricts($province_id);

    if ($districts) {
        echo '<option value="">Select District</option>';
        foreach ($districts as $id => $district) {
            echo "<option value=\"$id\">$district</option>";
        }
    } else {
        echo '<option value="">No districts available</option>';
    }
}
?>

