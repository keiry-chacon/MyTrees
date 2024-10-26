<?php
session_start(); // Asegúrate de iniciar la sesión al comienzo
include '../inc/header_friend.php'; 
require_once('../utils/friend/friend_functions.php');

$id = $_GET['id']; 
$tree = getTreeDetailsById($id); 

// Call addToCart when a button is pressed
if (isset($_POST['add_to_cart'])) {
    $treeId = $_POST['tree_id'];
    $response = addToCart($_SESSION['Id_User'], $treeId);
    
    // Retornar la respuesta JSON
    echo $response;
    exit;  
}
?>

<!-- Asegúrate de incluir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Tu CSS aquí */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }
    .product-detail-container {
        display: flex;
        justify-content: center;
        padding: 20px;
    }
    .image-container img {
        max-width: 300px;
        border-radius: 8px;
    }
    .product-info {
        margin-left: 20px;
    }
    .price {
        font-size: 24px;
        color: #4CAF50;
        margin: 10px 0;
    }
    .buy-container {
        display: flex;
        align-items: center;
    }
    .add-to-cart {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
        margin-right: 10px;
    }
    .buy-button {
        background-color: #FF5733;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }
    .cart-panel {
        position: fixed;
        right: 20px;
        top: 20px;
        width: 300px;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        display: none; /* Oculto por defecto */
        padding: 10px;
    }
    .cart-item {
        display: flex;
        justify-content: space-between;
        margin: 5px 0;
    }
</style>

<body>

<div class="product-detail-container">
    <div class="image-container">
        <img src="<?php echo "../" . $tree['Photo_Path']; ?>" alt="<?php echo $tree['Commercial_Name']; ?>">
    </div>

    <div class="product-info">
        <h1><?php echo $tree['Commercial_Name']; ?></h1>
        <h2><?php echo $tree['Scientific_Name']; ?></h2>

        <div class="price">
            ₡<?php echo number_format($tree['Price'], 0, ',', '.'); ?>
        </div>

        <div class="buy-container">
            <form method="post" id="cart-form">
                <input type="hidden" name="tree_id" value="<?php echo $tree['Id_Tree']; ?>">
                <button type="submit" name="add_to_cart" class="add-to-cart">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
            </form>
            <button class="buy-button" onclick="redirectToPurchaseForm(<?php echo $tree['Id_Tree']; ?>)">
                <i class="fas fa-money-bill-wave"></i> Buy
            </button>
        </div>
    </div>
</div>

<!-- Cart Panel -->
<div id="cart-panel" class="cart-panel">
    <h2>Shopping Cart</h2>
    <ul id="cart-items">
        <?php if (isset($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $cartItem): ?>
                <li class="cart-item">
                    <span><?php echo $cartItem['name']; ?> (<?php echo $cartItem['quantity']; ?>)</span>
                    <button onclick="removeFromCart(<?php echo $cartItem['id']; ?>)">
                        <i class="fas fa-trash"></i>
                    </button>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No items in cart.</li>
        <?php endif; ?>
    </ul>
</div>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var cartForm = document.getElementById('cart-form');
        var addToCartButton = cartForm.querySelector('.add-to-cart');

        addToCartButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir el envío del formulario
            
            // Usar AJAX para agregar al carrito
            var formData = new FormData(cartForm);
            fetch('', { // Enviar al mismo archivo
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Si el árbol fue agregado, actualiza la visualización del carrito
                    displayCartItems(data.cartItems); // Actualiza los elementos del carrito
                    alert(data.message); // Muestra mensaje de éxito
                } else {
                    // Si el árbol ya existe, muestra un mensaje
                    alert(data.message); // Muestra mensaje de que ya existe
                }
                toggleCartPanel(); // Mostrar el carrito
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Función para mostrar los elementos del carrito
    function displayCartItems(cartItems) {
        var cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = ''; // Limpiar contenido anterior

        // Si necesitas un nuevo método para obtener cartItems
        // Este es solo un ejemplo; ajusta según la estructura real de tus datos
        cartItems.forEach(item => {
            cartItemsContainer.innerHTML += `
                <li class="cart-item">
                    <span>${item.name}</span>
                    <button onclick="removeFromCart(${item.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </li>`;
        });

        // Si el carrito está vacío, mostrar mensaje
        if (cartItems.length === 0) {
            cartItemsContainer.innerHTML = '<li>No items in cart.</li>';
        }
    }

    function toggleCartPanel() {
        var cartPanel = document.getElementById('cart-panel');
        cartPanel.style.display = cartPanel.style.display === 'none' || cartPanel.style.display === '' ? 'block' : 'none';
    }

    // Función para eliminar el artículo del carrito (implementa esta lógica en PHP)
    function removeFromCart(treeId) {
        // Lógica para eliminar el artículo del carrito
        alert('This function needs to be implemented to remove item with ID: ' + treeId);
    }

    // Función para redirigir al formulario de compra
    function redirectToPurchaseForm(treeId) {
        // Lógica para redirigir al formulario de compra
        alert('Redirecting to purchase form for Tree ID: ' + treeId);
    }
</script>

