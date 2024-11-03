<?php

/*
* You only see the tree information but you can't do anything
*/

include '../inc/header_friend.php'; 
require_once('../utils/friend/friend_functions.php');

$uploads_folder_t   = "../uploads_tree/";
$friendId           = $_SESSION['Id_User'];
$idTree             = isset($_GET['id']) ? intval($_GET['id']) : 0;
$trees              = getFriendsTrees($friendId);

if (empty($trees)) {
    echo "No trees found for this user.";
} else {
    $tree = null;
    foreach ($trees as $t) {
        if ($t['Id_Tree'] == $idTree) {
            $tree = $t;
            break;
        }
    }

    if ($tree) {
        ?>
        <div class="product-detail-container">
            <div class="image-container">
                <img src="<?php echo $uploads_folder_t . $tree['Photo_Path']; ?>" alt="<?php echo $tree['Commercial_Name']; ?>">
            </div>

            <div class="product-info">
                <h1><?php echo $tree['Commercial_Name']; ?></h1>
                <h2><?php echo $tree['Scientific_Name']; ?></h2>
                <div class="price">
                    ₡<?php echo number_format($tree['Price'], 0, ',', '.'); ?>
                </div>
                <p><strong>Location:</strong> <?php echo $tree['Location']; ?></p>
                <p><strong>Purchase Date:</strong> <?php echo date("F j, Y", strtotime($tree['Purchase_Date'])); ?></p>
                <p><strong>Payment Method:</strong> <?php echo $tree['Payment_Method']; ?></p>
                <p><strong>Shipping Location:</strong> <?php echo $tree['Shipping_Location']; ?></p>
                <div class="buy-container">
                    <button onclick="window.history.back();">Back</button>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "Tree not found.";
    }
}
?>










<!-- Asegúrate de incluir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }

    .product-detail-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 20px;
        padding: 20px;
    }

    .image-container img {
        width: 300px;
        height: auto;
        border-radius: 8px;
    }

    .product-info {
        max-width: 400px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .product-info h1 {
        font-size: 1.8rem;
        margin-bottom: 10px;
    }

    .price {
        font-size: 1.5rem;
        color: blue;
        margin-bottom: 10px;
    }

    .price del {
        color: #888;
        font-size: 1.2rem;
        margin-right: 10px;
    }

    .discount {
        background-color: #ff9800;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .rating {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .rating-stars {
        color: #ffcc00;
        margin-right: 5px;
    }

    .color, .material {
        margin: 10px 0;
    }

    .select-model {
        margin: 15px 0;
    }

    .select-model select {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .buy-container {
        margin-top: 20px;
        display: flex;
        gap: 10px; /* Espacio entre los botones */
    }

    .buy-container button {
        flex: 1; /* Los botones ocuparán espacio igual */
        padding: 15px;
        background-color: #d32f2f;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        cursor: pointer;
    }

    .buy-container button:hover {
        background-color: #b71c1c;
    }

    .buy-container .add-to-cart {
        background-color: #ffa000; /* Color diferente para agregar al carrito */
    }

    .buy-container .add-to-cart:hover {
        background-color: #ff8f00; /* Hover para agregar al carrito */
    }

    .buy-container i {
        margin-right: 8px; /* Espacio entre el ícono y el texto */
    }

    @media (max-width: 768px) {
        .card {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .card img {
            max-width: 80%;
            margin-bottom: 20px;
        }

        .buy-button {
            width: 100%;
            padding: 15px;
            font-size: 1.2em;
        }
    }
    .cart-panel {
    position: absolute;
    right: 10px;
    top: 60px; /* Ajusta según sea necesario */
    width: 300px;
    background: white;
    border: 1px solid #ddd;
    padding: 15px;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

</style>

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

