<?php include 'header.php';
$profilepic = "../" . ($_SESSION['ProfileImage']);
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand d-flex flex-column align-items-center" href="#" id="profileMenuToggle">
            <img src="<?php echo htmlspecialchars($profilepic); ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
            <div class="small text-center"><?php echo htmlspecialchars($_SESSION['Username']); ?></div>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="../friend/friend.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../friend/mytrees.php">My Trees</a></li>
            </ul>
        </div>

        <!-- Icono de carrito -->
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="#" id="cart-icon" title="Carrito" onclick="toggleCartPanel(event)">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge badge-danger" id="cart-count">0</span> <!-- Aquí se mostrará el contador -->
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
        <h4>Tu Carrito</h4>
        <ul id="cart-items">
            <!-- Aquí se agregarán los elementos del carrito -->
        </ul>
        <button id="checkout-btn" class="btn btn-primary">Pagar Ahora</button>
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

    // Ejemplo: Actualizar el contador de carrito desde JavaScript
    function updateCartCount(count) {
        document.getElementById('cart-count').textContent = count;
    }

    // Función para agregar un artículo al carrito
    function addToCart(product) {
        // Suponiendo que `product` es un objeto que tiene `name` y `price`
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

<link rel="stylesheet" href="../css/profile.css">
<style>
    .cart-panel {
        position: absolute;
        right: 10px;
        top: 60px; /* Ajusta según sea necesario */
        width: 300px;
        background: white;
        border: 1px solid #ddd;
        padding: 15px;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
</style>


