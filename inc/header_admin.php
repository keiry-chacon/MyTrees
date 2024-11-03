<?php
include 'header.php';
$uploads_folder = "../uploads_user/";
$profilePic = $uploads_folder . ($_SESSION['ProfileImage']). '?' . time();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="height: 100vh; width: 250px; position: fixed; top: 0; left: 0; flex-direction: column; align-items: center;">
        <a class="navbar-brand d-flex flex-column align-items-center mt-3" href="#" id="profileMenuToggle">
            <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
            <div class="small text-center mt-2"><?php echo htmlspecialchars($_SESSION['Username']); ?></div> 
        </a>
        <div class="navbar-nav flex-column mt-4">
            <a class="nav-item nav-link" href="../administrator/admin.php">
                <i class="fas fa-home"></i> Home
            </a>
            <a class="nav-item nav-link" href="../administrator/manage_trees.php">
                <i class="fas fa-tree"></i> Manage Trees
            </a>
            <a class="nav-item nav-link" href="../administrator/manage_species.php">
                <i class="fas fa-seedling"></i> Manage Species
            </a>
            <a class="nav-item nav-link" href="../administrator/manage_friends.php">
                <i class="fas fa-users"></i> Manage Friends
            </a>
        </div>

        <!-- Submenú -->
        <div id="profileSubmenu" class="dropdown-menu" aria-labelledby="profileMenuToggle" style="display: none;">
            <a class="dropdown-item" href="../inc/profile.php?username=<?php echo urlencode($_SESSION['Username']); ?>">
                <i class="fas fa-user"></i> Profile
            </a>
            <a class="dropdown-item" href="../actions/logout.php">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </a>
        </div>
    </nav>
</header>


<div style="margin-left: 260px; padding: 20px;">
    <!-- Aquí va el contenido principal de la página -->
</div>

<script>
    document.getElementById('profileMenuToggle').addEventListener('click', function(event) {
        event.preventDefault(); 
        var submenu = document.getElementById('profileSubmenu');
        submenu.style.display = submenu.style.display === 'none' || submenu.style.display === '' ? 'block' : 'none';
    });

    window.addEventListener('click', function(event) {
        var submenu = document.getElementById('profileSubmenu');
        if (!event.target.closest('#profileMenuToggle') && !event.target.closest('#profileSubmenu')) {
            submenu.style.display = 'none';
        }
    });
</script>

<link rel="stylesheet" href="../css/header_admin.css"> 

<link rel="stylesheet" href="../css/profile.css"> 

