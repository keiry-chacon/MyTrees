<?php
include 'header.php';
include '../utils/functions.php';
$userRole = $_SESSION['Role_id']; 

$uploads_folder = "../uploads_user/";

$username = isset($_GET['username']) ? $_GET['username'] : null;
if (!$username) {
    die("No se ha proporcionado un nombre de usuario.");
}

$userData = getUserData($username);
if (!$userData) {
    die("No se encontró el usuario.");
}
$profileImage = $uploads_folder . $userData['Profile_Pic'] . '?' . time();
$username = $userData['Username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateSuccess = false;
    $userId = $_SESSION['Id_User']; 

    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == UPLOAD_ERR_OK) {
        $profileImage = $_FILES['profileImage'];

        $currentImage = $userId; 
        
        if ($currentImage && $currentImage !== "default_profile.png") {
            $currentImagePath = $uploads_folder . $currentImage;
            if (file_exists($currentImagePath)) {
                unlink($currentImagePath); 
            }
        }

        $newImageName = $userId . '.' . pathinfo($profileImage['name'], PATHINFO_EXTENSION); 
        move_uploaded_file($profileImage['tmp_name'], $uploads_folder . $newImageName);

        updateUserPic($userId, $newImageName); 
        $_SESSION['ProfileImage'] = $newImageName;

        $updateSuccess = true;
    }

    if (isset($_POST['username'])) {
        $newUsername = $_POST['username'];
        $firstName   = $_POST['first_name'];
        $lastName1   = $_POST['last_name1'];
        $lastName2   = $_POST['last_name2'];
        $email       = $_POST['email']; 
        $phone       = $_POST['phone'];
        $gender      = $_POST['gender'];
        $password    = $_POST['password'];

        $updateSuccess = updateUserData($_SESSION['Id_User'], $newUsername, $firstName, $lastName1, $lastName2, $email, $phone, $gender, $password);
        $_SESSION['Username'] = $newUsername;
    }

    if ($updateSuccess) {
        $userRole = $_SESSION['Role_id']; 
        $adminRole = 1;
        $friendRole = 2;
        if ($userRole ==  $adminRole) {
            header("Location: ../administrator/admin.php");
        } elseif ($userRole == $friendRole) {
            header("Location: ../friend/friend.php");
        }
        exit;  
    } else {
        echo "<script>alert('Username or email already exists.');</script>";
    }
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">



<div class="container mx-auto mt-5">
    <a href="<?php echo ($userRole === '1') ? '../administrator/admin.php' : '../friend/friend.php'; ?>" class="close-button">
        <i class="fas fa-times"></i> <!-- Icono de "X" -->
    </a>
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg">
        <div class="p-5 text-center">
            <div class="relative inline-block mb-4">
                <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Imagen de Perfil" class="profile-image">
                <span class="absolute top-2 right-2 cursor-pointer edit-icon">
                    <i class="fas fa-pencil-alt text-blue-600 text-xl"></i>
                </span>
            </div>

            <form action="profile.php?username=<?php echo urlencode($username); ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                <input type="file" name="profileImage" id="profileImage" accept="image/*" style="display: none;">
                <button type="submit" class="btn btn-primary mt-2 hidden" id="submitImage">Actualizar Imagen</button>
            </form>

            <div class="mt-4">
                <h4 class="inline-block text-xl font-semibold"><?php echo htmlspecialchars($username); ?></h4>
                <span class="cursor-pointer edit-icon" id="edit-username">
                    <i class="fas fa-pencil-alt text-blue-600"></i>
                </span>
            </div>

            <form action="profile.php?username=<?php echo urlencode($username); ?>" method="POST" id="username-form" class="mt-4 hidden">
                <div class="form-group">
                    <label for="username" class="block text-left">Username</label>
                    <input type="text" class="form-control border rounded p-2 w-full" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                </div>
                <div class="form-group">
                    <label for="first_name" class="block text-left">First Name</label>
                    <input type="text" class="form-control border rounded p-2 w-full" id="first_name" name="first_name" value="<?php echo htmlspecialchars($userData['First_Name']); ?>">
                </div>
                <div class="form-group">
                    <label for="last_name1" class="block text-left">Last Name (First)</label>
                    <input type="text" class="form-control border rounded p-2 w-full" id="last_name1" name="last_name1" value="<?php echo htmlspecialchars($userData['Last_Name1']); ?>">
                </div>
                <div class="form-group">
                    <label for="last_name2" class="block text-left">Last Name (Second)</label>
                    <input type="text" class="form-control border rounded p-2 w-full" id="last_name2" name="last_name2" value="<?php echo htmlspecialchars($userData['Last_Name2']); ?>">
                </div>
                <div class="form-group">
                    <label for="email" class="block text-left">Email</label>
                    <input type="email" class="form-control border rounded p-2 w-full" id="email" name="email" value="<?php echo htmlspecialchars($userData['Email']); ?>">
                </div>
                <div class="form-group">
                    <label for="phone" class="block text-left">Phone</label>
                    <input type="text" class="form-control border rounded p-2 w-full" id="phone" name="phone" value="<?php echo htmlspecialchars($userData['Phone']); ?>">
                </div>
                <div class="form-group">
                    <label for="gender" class="block text-left">Gender</label>
                    <select class="form-control border rounded p-2 w-full" name="gender" id="gender">
                        <option value="M" <?php if ($userData['Gender'] == 'M') echo 'selected'; ?>>Male</option>
                        <option value="F" <?php if ($userData['Gender'] == 'F') echo 'selected'; ?>>Female</option>
                        <option value="O" <?php if ($userData['Gender'] == 'O') echo 'selected'; ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password" class="block text-left">Password</label>
                    <input type="password" class="form-control border rounded p-2 w-full" id="password" name="password" placeholder="">
                </div>
                <div class="flex justify-between mt-4">
                    <button type="submit" class="btn btn-success bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Update</button>
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
            document.querySelector('.profile-image').src = e.target.result; // Cambia la imagen a la nueva seleccionada
        }
        reader.readAsDataURL(event.target.files[0]);
        document.getElementById('submitImage').classList.remove('hidden'); // Muestra el botón de actualización
    });

    document.getElementById('edit-username').addEventListener('click', function() {
        document.getElementById('username-form').classList.toggle('hidden');
    });
</script>


<link rel="stylesheet" href="../css/profile.css">
