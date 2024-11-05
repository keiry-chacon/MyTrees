<?php 
include '../inc/header_friend.php'; 
require_once('../utils/friend/friend_functions.php');

if (isset($_SESSION['purchase_message'])) {
    echo "<div class='bg-green-100 text-green-800 p-4 border border-green-300 rounded-lg mx-auto my-4 w-fit text-center text-lg'>" . $_SESSION['purchase_message'] . "</div>";
    unset($_SESSION['purchase_message']);
}

$trees = getAllAvailableTrees();
$uploads_folder = "../uploads_tree/";
?>

  

    <div class="content ml-64"> 
        <div class="hero-section bg-cover bg-center text-white text-center py-24" style="background-image: url('../img/background_friend.png');">
            <div class="hero-content">
                <h1 class="text-4xl mb-2">Welcome to Our Tree Garden</h1>
                <p class="text-lg mb-4">Discover a variety of trees available for you. Make your choice and add life to your space!</p>
                <a href="#available-trees" class="bg-green-200 text-green-800 py-2 px-4 rounded-lg transition duration-300 hover:bg-green-300">View Available Trees</a>
            </div>
        </div>

        <div id="available-trees" class="product-container text-center mt-12">
    <div class="tree-cards grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 p-6">
        <?php foreach ($trees as $tree):
            $photoTree = $uploads_folder . $tree['Photo_Path'];
            $treeDetailUrl = "tree_detail.php?id=" . $tree['Id_Tree']; ?>
            <a href="<?php echo $treeDetailUrl; ?>" class="card bg-white rounded-lg border-2 border-gray-300 shadow-2xl p-4 transition-transform transform hover:scale-105 hover:shadow-2xl">
                <img src="<?php echo $photoTree; ?>" alt="Tree Image" class="w-full h-48 object-contain rounded-lg mb-4">
                <div class="card-content">
                    <h3 class="text-xl font-semibold mb-2"><?php echo $tree['Commercial_Name']; ?></h3>
                    <p>Location: <?php echo $tree['Location']; ?></p>
                    <p>Price: ₡<?php echo number_format($tree['Price'], 0, ',', '.'); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>



    <script>
        setTimeout(function() {
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 4000);
    </script>
</body>

