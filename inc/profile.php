<?php
include 'header.php';
include '../utils/functions.php';

$username = isset($_GET['username']) ? $_GET['username'] : null;
if (!$username) {
    die("No se ha proporcionado un nombre de usuario.");
}
$userData = getUserData($username);
if (!$userData) {
    die("No se encontró el usuario.");
}
$profileImage = "../" . $userData['Profile_Pic'];
$username = $userData['Username'];
$userRole = isset($userData['Role']) ? $userData['Role'] : 'friend'; // Default to 'friend'

// Manejar la actualización de la foto de perfil y otros detalles si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['profileImage'])) {
    }

    // Actualizar otros datos del usuario si es necesario
    if (isset($_POST['username'])) {
        $newUsername = $_POST['username'];
    }
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<form method="post" action="../actions/signup.php">
<div class="container mt-5">
    <div class="card" style="max-width: 600px; margin: auto;">
        <div class="card-body text-center">

        <div style="position: relative; display: inline-block;">
                <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Imagen de Perfil" class="rounded-circle" style="width: 150px; height: 150px;">

                <span class="edit-icon" style="position: absolute; top: 10px; right: 10px; cursor: pointer;">
                    <i class="fas fa-pencil-alt"></i>
                </span>
                
        </div>
            

            <form action="profile.php?username=<?php echo urlencode($username); ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                <input type="file" name="profileImage" id="profileImage" accept="image/*" style="display: none;">
                <button type="submit" class="btn btn-primary mt-2" id="submitImage" style="display: none;">Actualizar Imagen</button>

            </form>
            

            <div class="mt-4">
                <h4 style="display: inline-block;"><?php echo htmlspecialchars($username); ?></h4>
                <span class="edit-icon" style="cursor: pointer;" id="edit-username">
                    <i class="fas fa-pencil-alt"></i>
                </span>
            </div>


            <form action="profile.php?username=<?php echo urlencode($username); ?>" method="POST" id="username-form" class="mt-4" style="display: none;">
            <label for="username">Username</label>
            <div class="form-group">
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                </div>
                <label for="first_name">First Name</label>

                <div class="form-group">
                    <input type="text" class="form-control" name="first_name" placeholder="Nombre" value="<?php echo htmlspecialchars($userData['First_Name']); ?>">
                </div>
                <label for="last_name1">Last Name (First)</label>

                <div class="form-group">
                    <input type="text" class="form-control" name="last_name1" placeholder="Primer Apellido" value="<?php echo htmlspecialchars($userData['Last_Name1']); ?>">
                </div>
                <label for="last_name2">Last Name (Second)</label>

                <div class="form-group">
                    <input type="text" class="form-control" name="last_name2" placeholder="Segundo Apellido" value="<?php echo htmlspecialchars($userData['Last_Name2']); ?>">
                </div>
                <label for="phone">Phone</label>

                <div class="form-group">
                    <input type="text" class="form-control" name="phone" placeholder="Teléfono" value="<?php echo htmlspecialchars($userData['Phone']); ?>">
                </div>
                <label for="gender">Gender</label>

                <div class="form-group">
                    <select class="form-control" name="gender">
                        <option value="male" <?php if($userData['Gender'] == 'M') echo 'selected'; ?>>M</option>
                        <option value="female" <?php if($userData['Gender'] == 'F') echo 'selected'; ?>>F</option>
                        <option value="other" <?php if($userData['Gender'] == 'O') echo 'selected'; ?>>Other</option>

                    </select>
                </div>
                <label for="password">Password</label>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="" value="">
                </div>
                <div class="form-group mt-4 d-flex justify-content-between">
                    <a href="<?php echo ($userRole === 'admin') ? '../administrator/admin.php' : '../friend/friend.php'; ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success ms-2">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
 document.querySelector('.edit-icon').addEventListener('click', function() {
        document.getElementById('profileImage').click();
    });

    document.getElementById('profileImage').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('img.rounded-circle').src = e.target.result;
        }
        reader.readAsDataURL(event.target.files[0]);
        document.getElementById('submitImage').style.display = 'block'; 
    });

    document.getElementById('edit-username').addEventListener('click', function() {
        document.getElementById('username-form').style.display = 'block';
    });
</script>
<link rel="stylesheet" href="../css/profile.css"> 


<?php
include 'footer.php';
?>

