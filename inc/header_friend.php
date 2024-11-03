<?php 
include 'header.php';
require('../utils/friend/friend_functions.php');
$uploads_folder = "../uploads_user/";
$uploads_folder_t = "../uploads_tree/";

$profilepic = $uploads_folder . ($_SESSION['ProfileImage']);
$cartItems = getCartItemsForUser($_SESSION['Id_User']);

// Mostrar el carrito si hay elementos
function displayCartItems($cartItems, $uploads_folder_t) {
    if (!empty($cartItems)) {
        echo "<div id='cart-panel' class='cart-panel'>";
        echo "<h2>Shopping Cart</h2><ul id='cart-items'>";
        foreach ($cartItems as $cartItem) {
            echo "<li class='cart-item'>";
            echo "<img src='" . $uploads_folder_t . htmlspecialchars($cartItem['Photo_Path']) . "' alt='Imagen del Árbol' style='width: 50px; height: auto;'>";
            echo "<span>" . htmlspecialchars($cartItem['Commercial_Name']) . " - $" . htmlspecialchars($cartItem['Price']) . "</span>"; // Mostrar nombre y precio
            echo "<button onclick='removeFromCart(" . htmlspecialchars($cartItem['Tree_Id']) . ")' class='remove-button'><i class='fas fa-trash'></i></button>";
            echo "</li>";
        }
        echo "</ul></div>";
    } else {
        echo "<div id='cart-panel' class='cart-panel'><h2>Shopping Cart</h2><p>No items in cart.</p></div>";
    }
}

// Mostrar el carrito
displayCartItems($cartItems,$uploads_folder_t);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand d-flex flex-column align-items-center" href="#" id="profileMenuToggle">
            <img src="<?php echo htmlspecialchars($profilepic); ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
            <div class="small text-center"><?php echo htmlspecialchars($_SESSION['Username']); ?></div>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="../friend/friend.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../friend/friends_trees.php">My Trees</a></li>
            </ul>
        </div>

        <!-- Icono de carrito -->
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="#" id="cart-icon" title="Carrito" onclick="toggleCartPanel(event)">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge badge-danger" id="cart-count"><?php echo count($cartItems); ?></span> <!-- Contador de carrito -->
            </a>
        </div>

        <!-- Submenú -->
        <div id="profileSubmenu" class="dropdown-menu" aria-labelledby="profileMenuToggle" style="display: none;">
            <a class="dropdown-item" href="../inc/profile.php?username=<?php echo urlencode($_SESSION['Username']); ?>">Profile</a>
            <a class="dropdown-item" href="../actions/logout.php">Log Out</a>
        </div>
    </nav>

    <!-- Panel del carrito -->
    <div id="cart-panel" class="cart-panel" style="display: none;">
        <h4>Your Cart</h4>
        <ul id="cart-items"></ul>
        <button id="checkout-btn" class="btn btn-primary">Buy Now</button>
    </div>
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

    function toggleCartPanel(event) {
        event.preventDefault();
        var cartPanel = document.getElementById('cart-panel');
        cartPanel.style.display = cartPanel.style.display === 'none' || cartPanel.style.display === '' ? 'block' : 'none';
    }

    // Función para eliminar un artículo del carrito
    function removeFromCart(treeId) {
        if (confirm('¿Estás seguro de que deseas eliminar este artículo del carrito?')) {
            // Realiza la llamada a PHP para eliminar el artículo del carrito y cambiar el estado a 'abandoned'
            fetch('../remove_from_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ treeId: treeId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                   
                    changeCartStateToAbandoned(); // Llama a la función para cambiar el estado
                    location.reload(); // Recargar la página para actualizar el carrito
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>

<link rel="stylesheet" href="../css/header_friend.css">


