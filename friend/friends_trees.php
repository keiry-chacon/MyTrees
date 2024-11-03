<?php 
require_once '../inc/header_friend.php'; 
require_once('../utils/friend/friend_functions.php');
$uploads_folder_t = "../uploads_tree/";

$trees = getFriendsTrees($_SESSION['Id_User']);

if (empty($trees)) {
    echo "No trees found for this user.";

} 
?>
<div class="product-detail-container">
<div class="tree-cards">
        <?php foreach ($trees as $tree):
            $photoTree = $uploads_folder_t . $tree['Photo_Path'];
            $treeDetailUrl = "tree_detail_friend.php?id=" . $tree['Id_Tree']; // URL de detalle del árbol
            ?>
            <a href="<?php echo $treeDetailUrl; ?>" class="card">
                <img src="<?php echo $photoTree; ?>" alt="Imagen del Árbol">
                <div class="card-content">
                    <h3><?php echo $tree['Commercial_Name']; ?></h3>
                    <p>Location: <?php echo $tree['Location']; ?></p>
                    <p>Purchase date: <?php echo $tree['Purchase_Date']; ?></p>
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
