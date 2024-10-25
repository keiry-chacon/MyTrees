<?php 
include '../inc/header_friend.php'; 
require('../utils/friend/friend_functions.php');

$trees = getAllAvailableTrees();
?>

<div class="product-container">
    <div class="tree-cards">
        <?php foreach ($trees as $tree):
            $photoTree = "../" . $tree['Photo_Path'];
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

<style>
    .product-container {
        text-align: center;
        margin-top: 50px; /* Espacio adicional desde la parte superior */
    }

    .tree-cards {
        display: flex;
        gap: 30px; /* Aumentar el espacio entre las tarjetas */
        justify-content: center;
        flex-wrap: wrap;
    }

    .card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px; /* Aumentar padding para más espacio interno */
        width: 250px; /* Aumentar el ancho del contenedor */
        position: relative;
        overflow: hidden;
        transition: transform 0.3s; /* Agregar efecto de transformación */
    }

    .card:hover {
        transform: scale(1.05); /* Efecto de zoom al pasar el mouse */
    }

    .card img {
        width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .card-content h3 {
        font-size: 1.3rem; /* Aumentar tamaño de fuente */
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
