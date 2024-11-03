<?php 
include '../inc/header_friend.php'; 
require_once('../utils/friend/friend_functions.php');
if (isset($_SESSION['purchase_message'])) {
    echo "<div class='success-message'>" . $_SESSION['purchase_message'] . "</div>";
    
    unset($_SESSION['purchase_message']);
}
$trees = getAllAvailableTrees();

$uploads_folder = "../uploads_tree/";


?>
<div class="hero-section">
    <div class="hero-content">
        <h1>Welcome to Our Tree Garden</h1>
        <p>Discover a variety of trees available for you. Make your choice and add life to your space!</p>
        <a href="#available-trees" class="button-primary">View Available Trees</a>
    </div>
</div>

<div id="available-trees" class="product-container">
    <div class="tree-cards">
        <?php foreach ($trees as $tree):
            $photoTree = $uploads_folder . $tree['Photo_Path'];
            $treeDetailUrl = "tree_detail.php?id=" . $tree['Id_Tree']; // URL de detalle del árbol
            ?>
            <a href="<?php echo $treeDetailUrl; ?>" class="card">
                <img src="<?php echo $photoTree; ?>" alt="Imagen del Árbol">
                <div class="card-content">
                    <h3><?php echo $tree['Commercial_Name']; ?></h3>
                    <p>Ubicación: <?php echo $tree['Location']; ?></p>
                    <p>Precio: ₡<?php echo number_format($tree['Price'], 0, ',', '.'); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>


<link rel="stylesheet" href="../css/friend.css">

<script>
    // JavaScript para ocultar el mensaje después de 4 segundos
    setTimeout(function() {
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 4000); // 4000 ms = 4 segundos
</script>
