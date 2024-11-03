<?php 

/*
* Make the purchase of the tree and change the status of the tree
*/

require_once '../inc/header_admin.php'; 
require_once('../utils/administrator/admin_functions.php');
$uploads_folder_t = "../uploads_tree/";

$trees = null; 
if (isset($_GET['id'])) {
    $userID = (int)$_GET['id'];
    $trees = getFriendsTrees($userID); 
    if (!is_array($trees) || empty($trees)) {
        die("User not found or no trees available.");
    }
}

$error_msg = '';
if(isset($_GET['error'])) {
$error_msg = $_GET['error'];
}
?>

<div class="product-detail-container">
    <div class="tree-cards">
        <?php foreach ($trees as $tree):
            $photoTree          = $uploads_folder_t . $tree['Photo_Path'];
            $treeDetailUrl      = "update_friend_tree.php?id=" . $tree['Id_Tree']; // Updates all tree information
            $treeRegisterUrl    = "register_tree_update.php?id=" . $tree['Id_Tree']; // Register update of a tree
            ?>
            <div class="card">
                <img src="<?php echo $photoTree; ?>" alt="Tree´s Picture">
                <div class="card-content">
                    <h3><?php echo $tree['Commercial_Name']; ?></h3>
                    <p>Location: <?php echo $tree['Location']; ?></p>
                    <p>Purchase date: <?php echo $tree['Purchase_Date']; ?></p>
                    
                    <a href="<?php echo $treeDetailUrl; ?>" class="btn btn-primary">Update Tree</a>
                    <a href="<?php echo $treeRegisterUrl; ?>" class="btn btn-secondary">Register Update</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<link rel="stylesheet" href="../css/friend.css">

<script>
    // JavaScript to hide message after 4 seconds
    setTimeout(function() {
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 4000); // 4000 ms = 4 seconds
</script>
