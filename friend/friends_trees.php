<?php 
include '../inc/header_friend.php'; 
require_once('../utils/friend/friend_functions.php');

$trees = getFriendsTrees($_SESSION['Id_User']);

if (empty($trees)) {
    echo "No trees found for this user.";

} 
?>
<div class="product-detail-container">
<div class="tree-cards">
        <?php foreach ($trees as $tree):
            $photoTree = "../" . $tree['Photo_Path'];
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


<style>
    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        width: fit-content;
        margin: 20px auto;
        text-align: center;
        font-size: 1.1em;
        animation: fadeOut 4s forwards; /* Para desaparecer después de 4 segundos */
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        100% { opacity: 0; display: none; }
    }

    .product-container {
        text-align: center;
        margin-top: 50px;
    }

    .tree-cards {
        display: flex;
        gap: 30px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
        width: 250px;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card img {
        width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .card-content h3 {
        font-size: 1.3rem;
        margin: 10px 0;
    }

    .card-content p {
        margin: 5px 0;
        color: #555;
    }

    .add-to-cart-btn {
        background-color: #ff9800;
        color: white;
        border: none;
        padding: 10px;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;
    }

    .add-to-cart-btn:hover {
        background-color: #e68a00;
    }
</style>

<script>
    // JavaScript para ocultar el mensaje después de 4 segundos
    setTimeout(function() {
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 4000); // 4000 ms = 4 segundos
</script>
