<?php
include '../inc/header_friend.php'; 
require('../utils/friend/friend_functions.php');

$id = $_GET['id']; 
$tree = getTreeDetailsById($id); 
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

        <!-- Información del dueño -->
        <div class="owner-info">
            <p><strong>Owner:</strong> <?php echo $tree['First_Name'] . " " . $tree['Last_Name1'] . " " . $tree['Last_Name2']; ?></p>
            <p><strong>Phone:</strong> <?php echo $tree['Phone']?></p>
        </div>

        <div class="buy-container">
        <button class="add-to-cart" data-name="Producto 1" data-price="29.99">
        <i class="fas fa-shopping-cart"></i> Agregar al Carrito
    </button>            <button class="buy-button" onclick="redirectToPurchaseForm(<?php echo $tree['Id_Tree']; ?>)">
    <i class="fas fa-money-bill-wave"></i> Comprar
</button>
        </div>
    </div>
</div>

</body>
<script>
function redirectToPurchaseForm(treeId) {
    window.location.href = `purchase_form.php?tree_id=${treeId}`;
}
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

    // Manejar el clic en "Agregar al carrito"
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productName = this.getAttribute('data-name');
            const productPrice = this.getAttribute('data-price');
            addToCart({ name: productName, price: productPrice });
            toggleCartPanel(event); // Abrir el panel del carrito
        });
    });

    function toggleCartPanel(event) {
        event.preventDefault();
        var cartPanel = document.getElementById('cart-panel');
        cartPanel.style.display = cartPanel.style.display === 'none' || cartPanel.style.display === '' ? 'block' : 'none';
    }

    function updateCartCount(count) {
        document.getElementById('cart-count').textContent = count;
    }

    function addToCart(product) {
        var cartItems = document.getElementById('cart-items');
        var listItem = document.createElement('li');
        listItem.textContent = `${product.name} - $${product.price}`;
        cartItems.appendChild(listItem);

        // Actualiza el contador
        updateCartCount(cartItems.children.length);
    }

    // Llama a esta función para agregar un producto como ejemplo
    // addToCart({ name: "Producto 1", price: 29.99 });

</script>

