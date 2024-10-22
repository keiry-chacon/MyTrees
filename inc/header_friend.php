<?php include 'header.php'; ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand d-flex flex-column align-items-center" href="#" id="profileMenuToggle">
            <img src="<?php echo htmlspecialchars($_SESSION['ProfileImage']); ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
            <div class="small text-center"><?php echo htmlspecialchars($_SESSION['Username']); ?></div> 
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="friend.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="mytrees.php">My Trees</a></li>
            </ul>
        </div>
        <!-- Submenú -->
        <div id="profileSubmenu" class="dropdown-menu" aria-labelledby="profileMenuToggle" style="display: none;">
        <a class="dropdown-item" href="../inc/profile.php?username=<?php echo urlencode($_SESSION['Username']); ?>">Profile</a>
        <a class="dropdown-item" href="actions/logout.php">Log Out</a>
        </div>
    </nav>
</header>

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
<link rel="stylesheet" href="../css/profile.css"> 

