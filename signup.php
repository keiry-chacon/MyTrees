<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<?php

/*
* Sign Up Interface
*/

  include('utils/functions.php');

  $countries = getCountries();
  
  $error_msg = '';
  if(isset($_GET['error'])) {
    $error_msg = $_GET['error'];
  }

?>

<?php require('inc/header.php')?>
  <div class="container-fluid">
    <div class="jumbotron">
      <h1 class="display-4">Sign Up</h1>
      <p class="lead">This is the signup process</p>
      <hr class="my-4">
    </div>

    <form method="post" action="actions/signup.php" enctype="multipart/form-data">

        <?php if ($error_msg): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

      <div class="container">
        <div class="form-group">
        <label for="profilePic" style="display: none;">Profile Picture</label>
        <input type="file" class="form-control" name="profilePic" id="profilePic" accept="image/png, image/jpeg" style="display: none;">
    </div>

    <div style="position: relative; display: inline-block;">
        <img id="previewImage" src="img/default_profile.png"  class="rounded-circle" style="width: 150px; height: 150px;">
        
        <span class="edit-icon" style="position: absolute; top: 10px; right: 10px; cursor: pointer;" id="editProfilePic">
            <i class="fas fa-pencil-alt"></i>
        </span>
    </div>

            <div class="form-group">
                <label for="first-name">First Name</label>
                <input id="first-name" class="form-control" type="text" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last-name1">Last Name 1</label>
                <input id="last-name1" class="form-control" type="text" name="last_name1" required>
            </div>
            <div class="form-group">
                <label for="last-name2">Last Name 2</label>
                <input id="last-name2" class="form-control" type="text" name="last_name2" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" class="form-control" type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input id="phone" class="form-control" type="text" name="phone" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" class="form-control" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="O">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <select id="country" class="form-control" name="country" required onchange="loadProvinces()">
                    <option value="">Select Country</option>
                    <?php
                        foreach($countries as $id => $country) {
                            echo "<option value=\"$id\">$country</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="province">Province</label>
                <select id="province" class="form-control" name="province" required onchange="loadDistricts()">
                    <option value="">Select Province</option>
                </select>
            </div>
            <div class="form-group">
                <label for="district">District</label>
                <select id="district" class="form-control" name="district" required>
                    <option value="">Select District</option>
                </select>
            </div>
            <div class="form-group">
                <label for="username">User</label>
                <input id="username" class="form-control" type="text" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" class="form-control" type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign up</button>
        </form>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const fileInput = document.getElementById('profilePic');
    const previewImage = document.getElementById('previewImage');
    const editProfilePic = document.getElementById('editProfilePic');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0]; 
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result; 
            }
            reader.readAsDataURL(file); 
        }
    });

    editProfilePic.addEventListener('click', function() {
        fileInput.click(); 
    });
</script>

<script>
  $('#country').on('change', function() {
    var country_id = $(this).val();

    $.ajax({
      url: 'utils/country/get_provinces.php',
      type: 'POST',
      data: {country_id: country_id},
      success: function(data) {
        $('#province').html(data);
        $('#district').html('<option value="">Select District</option>'); // Resetear los distritos
      }
    });
  });

  $('#province').on('change', function() {
    var province_id = $(this).val();

    $.ajax({
      url: 'utils/country/get_districts.php',
      type: 'POST',
      data: {province_id: province_id},
      success: function(data) {
        $('#district').html(data);
      }
    });
  });
</script>
    <?php require('inc/footer.php'); ?>