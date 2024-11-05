<?php 
include 'header.php';
require('../utils/friend/friend_functions.php');
$uploads_folder = "../uploads_user/";
$uploads_folder_t = "../uploads_tree/";

$profilepic = $uploads_folder . ($_SESSION['ProfileImage']) . '?' . time();
$cartItems = getCartItemsForUser($_SESSION['Id_User']);

function displayCartItems($cartItems, $uploads_folder_t) {
    if (!empty($cartItems)) {
        echo "<div id='cart-panel' class='cart-panel'>";
        echo "<h2>Shopping Cart</h2><ul id='cart-items'>";
        foreach ($cartItems as $cartItem) {
            echo "<li class='cart-item'>";
            echo "<img src='" . $uploads_folder_t . htmlspecialchars($cartItem['Photo_Path']) . "' alt='Imagen del Árbol' style='width: 50px; height: auto;'>";
            echo "<span>" . htmlspecialchars($cartItem['Commercial_Name']) . " - $" . htmlspecialchars($cartItem['Price']) . "</span>"; 
            echo "<button onclick='removeFromCart(" . htmlspecialchars($cartItem['Tree_Id']) . ")' class='remove-button'><i class='fas fa-trash'></i></button>";
            echo "</li>";
        }
        echo "</ul></div>";
    } else {
        echo "<div id='cart-panel' class='cart-panel'><h2>Shopping Cart</h2><p>No items in cart.</p></div>";
    }
}

displayCartItems($cartItems, $uploads_folder_t);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="font-sans bg-gray-100">
    <header>
        <nav class="fixed top-0 left-0 h-full w-64 bg-gray-300 shadow-lg flex flex-col p-4 z-50"> 
            <a href="#" id="profile-link" class="flex flex-col items-center mb-8 p-4 bg-gray-300 rounded-lg hover:bg-green-500 hover:text-white transition duration-300">
                <img src="<?php echo htmlspecialchars($profilepic); ?>" alt="Profile Image" class="w-20 h-20 rounded-full border-4 border-white mb-3 object-cover">
                <div class="text-center font-semibold text-gray-700"><?php echo htmlspecialchars($_SESSION['Username']); ?></div>
            </a>
            <div id="profile-submenu" class="hidden flex-col p-4 space-y-2">
                <a href="../inc/profile.php?username=<?php echo urlencode($_SESSION['Username']); ?>" class="text-gray-800 hover:text-white hover:bg-green-500 px-4 py-2 rounded flex items-center space-x-2">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="../actions/logout.php" class="text-gray-800 hover:text-white hover:bg-green-500 px-4 py-2 rounded flex items-center space-x-2">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log Out</span>
                </a>
            </div>

            <ul class="space-y-4">
                <li>
                    <a href="../friend/friend.php" class="flex items-center px-4 py-2 text-gray-800 bg-gray-300 rounded-lg hover:bg-green-500 hover:text-white transition duration-300">
                        <i class="fas fa-home mr-3"></i> Home
                    </a>
                </li>
                <li>
                    <a href="../friend/friends_trees.php" class="flex items-center px-4 py-2 text-gray-800 bg-gray-300 rounded-lg hover:bg-green-500 hover:text-white transition duration-300">
                        <i class="fas fa-tree mr-3"></i> My Trees
                    </a>
                </li>
            </ul>
            
            <div class="relative mt-auto pt-6">
                <a href="#" id="cart-icon" class="flex items-center justify-center text-gray-800 hover:text-white hover:bg-green-500 transition duration-300 px-4 py-2 rounded-lg" title="Cart" onclick="toggleCartPanel(event)">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs px-2"><?php echo count($cartItems); ?></span>
                </a>
                <div id="cart-panel" class="absolute top-0 left-16 mt-2 w-64 bg-white shadow-lg rounded-lg p-4 hidden">
                    <h4 class="text-lg font-semibold mb-2">Your Cart</h4>
                    <ul id="cart-items" class="space-y-2"></ul>
                    <button id="checkout-btn" class="bg-blue-500 text-white rounded-lg py-2 px-4 hover:bg-blue-600 mt-2">Buy Now</button>
                </div>
            </div>
        </nav>
    </header>

    <div class="ml-64 p-8">
    <?php displayCartItems($cartItems, $uploads_folder_t); ?>
</div>

<div id="cart-panel" class="absolute top-0 left-16 mt-2 w-64 bg-white shadow-lg rounded-lg p-4 hidden">
    <h4 class="text-lg font-semibold mb-2">Your Cart</h4>
    <ul id="cart-items" class="space-y-2">
        <?php displayCartItems($cartItems, $uploads_folder_t); ?>
    </ul>
    <button id="checkout-btn" class="bg-blue-500 text-white rounded-lg py-2 px-4 hover:bg-blue-600 mt-2">Buy Now</button>
</div>
    
<script>
    window.onscroll = function() {
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = (winScroll / height) * 100;
        document.getElementById('progress-bar').style.width = scrolled + "%"; // Usa el id correcto
    };

    document.getElementById('profile-link').addEventListener('click', function(event) {
        event.preventDefault(); // Evita el comportamiento predeterminado del enlace
        const submenu = document.getElementById('profile-submenu');
        submenu.classList.toggle('hidden'); // Alternar visibilidad usando clases de Tailwind
    });

    function toggleCartPanel(event) {
    event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
    const cartPanel = document.getElementById('cart-panel');
    // Alternar visibilidad
    cartPanel.classList.toggle('hidden'); // Usar clases de Tailwind para mostrar/ocultar
}

    // Función para eliminar un artículo del carrito
    function removeFromCart(treeId) {
        if (confirm('¿Estás seguro de que deseas eliminar este artículo del carrito?')) {
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
