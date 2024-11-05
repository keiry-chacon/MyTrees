<?php
/*
* To buy or add to cart
*/

require_once ('../inc/header_friend.php'); 
require_once('../utils/friend/friend_functions.php');

$uploads_folder = "../uploads_tree/";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $treeId     = $_POST['tree_id'];
    $userId     = $_SESSION['Id_User'];
    $response   = addToCart($userId, $treeId);
    
    if ($response) {
        header("Location: friend.php");
        exit; 
    } else {
        echo "Error al agregar el árbol al carrito.";
    }
}

if (isset($_GET['id'])) {
    $id     = $_GET['id'];
    $tree   = getTreeDetailsById($id); 
}
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<div class="flex justify-center items-center py-12 px-8">
    <div class="bg-white max-w-6xl rounded-xl shadow-lg p-10 relative ml-60 transform transition-transform duration-500 hover:shadow-2xl">
        
        <div class="flex flex-col md:flex-row items-center gap-6">
            <!-- Image Section -->
            <div class="md:w-1/2 p-4">
                <img class="w-full h-96 object-cover rounded-lg shadow-md transition-shadow duration-300 hover:shadow-xl" src="<?php echo $uploads_folder . $tree['Photo_Path']; ?>" alt="<?php echo $tree['Commercial_Name']; ?>">
            </div>

            <!-- Details Section -->
            <div class="md:w-1/2 p-4 space-y-6">
                
                <!-- Commercial Name -->
                <div class="text-3xl font-bold text-gray-800 hover:text-blue-500 transition-colors duration-300">
                    <?php echo $tree['Commercial_Name']; ?>
                </div>

                <!-- Scientific Name -->
                <div class="text-xl italic text-gray-500">
                    <?php echo $tree['Scientific_Name']; ?>
                </div>

                <!-- Location -->
                <div class="text-md text-gray-600">
                    <i class="fas fa-map-marker-alt mr-1 text-red-400"></i> 
                    Location: <?php echo $tree['Location']; ?>
                </div>

                <!-- Price -->
                <div class="text-4xl font-semibold text-gray-800 mt-4">
                    ₡<?php echo number_format($tree['Price'], 2, ',', '.'); ?>
                </div>

                <!-- Size Selection -->
                <div class="mt-4">
                    <label class="block text-gray-600 font-semibold">Size:</label>
                    <div class="flex space-x-2 mt-1">
                        <button class="px-6 py-2 bg-gray-200 text-gray-700 rounded-full shadow hover:bg-gray-300 focus:outline-none transform transition-transform duration-300 hover:scale-105"><?php echo $tree['Size']; ?> cm</button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-6 mt-6">
                    <form method="POST">
                        <input type="hidden" name="tree_id" value="<?php echo $tree['Id_Tree']; ?>">
                        <button type="submit" class="flex items-center px-6 py-3 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 focus:outline-none transition-colors duration-300" name="add_to_cart">
                            <i class="fas fa-shopping-cart mr-2"></i> Add To Cart
                        </button>
                    </form>
                    <button onclick="showPurchaseForm(<?php echo $tree['Id_Tree']; ?>)" class="flex items-center px-6 py-3 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 focus:outline-none transition-colors duration-300">
                        <i class="fas fa-money-bill-wave mr-2"></i> Buy Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Purchase Form -->
<div id="purchaseModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-end items-center backdrop-blur-sm">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Purchase Form</h1>

        <!-- Purchase Summary -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">Purchase Summary</h2>
            <img src="<?php echo $uploads_folder . $tree['Photo_Path']; ?>" alt="<?php echo $tree['Commercial_Name']; ?>" class="w-full h-48 object-contain rounded-lg shadow-md mb-4">
            <p class="text-lg text-gray-800"><strong>Commercial Name:</strong> <?php echo $tree['Commercial_Name']; ?></p>
            <p class="text-lg text-gray-600"><strong>Scientific Name:</strong> <?php echo $tree['Scientific_Name']; ?></p>
            <p class="text-xl font-bold text-gray-800 mt-2"><strong>Price:</strong> ₡<?php echo number_format($tree['Price'], 0, ',', '.'); ?></p>
        </div>

        <form action="../actions/friend/process_purchase.php" method="POST">
            <input type="hidden" name="tree_id" id="tree_id" value="">

            <div class="mb-4">
                <label for="shipping_location" class="block text-gray-700 font-semibold mb-2">Shipping Location:</label>
                <input type="text" id="shipping_location" name="shipping_location" required placeholder="Enter your shipping address" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:ring-blue-400">
            </div>

            <div class="mb-6">
                <label for="payment_method" class="block text-gray-700 font-semibold mb-2">Payment Method:</label>
                <select id="payment_method" name="payment_method" required class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:ring-blue-400">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                </select>
            </div>

            <!-- Pay Now Button -->
            <button type="submit" class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg shadow hover:bg-blue-600 transition duration-200">Pay Now</button>
            <button type="button" onclick="closePurchaseForm()" class="mt-4 w-full py-2 bg-red-500 text-white rounded-lg">Cancel</button>
        </form>
    </div>
</div>
<link rel="stylesheet" href="../css/tree_detail.css">

<script>
    function goBack() {
        window.history.back();
    }

    function showPurchaseForm(treeId) {
        document.getElementById('tree_id').value = treeId;
        document.getElementById('purchaseModal').classList.remove('hidden');
    }

    function closePurchaseForm() {
        document.getElementById('purchaseModal').classList.add('hidden');
    }
</script>
</body>





