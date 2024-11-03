<?php



include 'header.php';
include '../utils/functions.php';

$uploads_folder = "../uploads_user/";

$username = isset($_GET['username']) ? $_GET['username'] : null;
if (!$username) {
    die("No se ha proporcionado un nombre de usuario.");
}

$userData = getUserData($username);
if (!$userData) {
    die("No se encontró el usuario.");
}

$profileImage   = $uploads_folder . $userData['Profile_Pic'];
$username       = $userData['Username'];

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
        $firstName = $_POST['first_name'];
        $lastName1 = $_POST['last_name1'];
        $lastName2 = $_POST['last_name2'];
        $email     = $_POST['email']; 
        $phone     = $_POST['phone'];
        $gender    = $_POST['gender'];
        $password  = $_POST['password'];

        $updateSuccess = updateUserData($_SESSION['Id_User'], $newUsername, $firstName, $lastName1, $lastName2, $email, $phone, $gender, $password);
        $_SESSION['Username']     = $newUsername;

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
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($userData['First_Name']); ?>">
    </div>

    <label for="last_name1">Last Name (First)</label>
    <div class="form-group">
        <input type="text" class="form-control" id="last_name1" name="last_name1" value="<?php echo htmlspecialchars($userData['Last_Name1']); ?>">
    </div>

    <label for="last_name2">Last Name (Second)</label>
    <div class="form-group">
        <input type="text" class="form-control" id="last_name2" name="last_name2" value="<?php echo htmlspecialchars($userData['Last_Name2']); ?>">
    </div>
    <label for="email">Email</label>
    <div class="form-group">
        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userData['Email']); ?>">
    </div>
    <label for="phone">Phone</label>
    <div class="form-group">
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($userData['Phone']); ?>">
    </div>

    <label for="gender">Gender</label>
    <div class="form-group">
        <select class="form-control" name="gender" id="gender">
            <option value="M" <?php if ($userData['Gender'] == 'M') echo 'selected'; ?>>Male</option>
            <option value="F" <?php if ($userData['Gender'] == 'F') echo 'selected'; ?>>Female</option>
            <option value="O" <?php if ($userData['Gender'] == 'O') echo 'selected'; ?>>Other</option>
        </select>
    </div>

    <label for="password">Password</label>
    <div class="form-group">
        <input type="password" class="form-control" id="password" name="password" placeholder="">
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

