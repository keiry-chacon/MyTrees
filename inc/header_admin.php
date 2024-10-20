<?php include 'header.php'; ?>
<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand d-flex flex-column align-items-center" href="admin.php">
                <img src="<?php echo htmlspecialchars($_SESSION['ProfileImage']); ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
                <div class="small text-center"><?php echo htmlspecialchars($_SESSION['Username']); ?></div> <!-- Nombre del usuario -->
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_trees.php">Administrar Árboles</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_species.php">Administrar Especies</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_friends.php">Administrar Amigos</a></li>
                </ul>
                <a class="nav-link" href="actions/logout.php" title="Cerrar Sesión">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </a>
            </div>
        </nav>
    </header>