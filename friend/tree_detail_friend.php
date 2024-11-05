<?php
/*
* Tree display page, similar to a product view on AliExpress
*/

include '../inc/header_friend.php'; 
require_once('../utils/friend/friend_functions.php');

$uploads_folder_t = "../uploads_tree/";
$friendId = $_SESSION['Id_User'];
$idTree = isset($_GET['id']) ? intval($_GET['id']) : 0;
$trees = getFriendsTrees($friendId);

if (empty($trees)) {
    echo "<div class='text-center mt-20 text-gray-500'>No trees found for this user.</div>";
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
        <div class="flex justify-center mt-20 px-4">
            <div class="w-full max-w-3xl bg-white rounded-lg shadow-lg border border-gray-200 p-6 transform transition hover:scale-105">
                <div class="flex flex-col md:flex-row">
                    <div class="flex-shrink-0 md:w-1/2 mb-4 md:mb-0">
                        <img src="<?php echo $uploads_folder_t . $tree['Photo_Path']; ?>" alt="<?php echo $tree['Commercial_Name']; ?>" class="w-full h-auto max-h-72 object-contain rounded-lg shadow-md">
                    </div>

                    <div class="md:ml-6 w-full">
                        <h1 class="text-2xl font-semibold text-gray-800"><?php echo $tree['Commercial_Name']; ?></h1>
                        <h2 class="text-xl text-gray-600"><?php echo $tree['Scientific_Name']; ?></h2>
                        <p class="text-xl text-green-600 font-bold my-4">₡<?php echo number_format($tree['Price'], 0, ',', '.'); ?></p>

                        <div class="text-gray-700 space-y-2">
                            <p><strong class="font-semibold">Location:</strong> <?php echo $tree['Location']; ?></p>
                            <p><strong class="font-semibold">Size:</strong> <?php echo isset($tree['Size']) ? $tree['Size'] . " cm" : "Size not available"; ?></p>
                            <p><strong class="font-semibold">Purchase Date:</strong> <?php echo date("F j, Y", strtotime($tree['Purchase_Date'])); ?></p>
                            <p><strong class="font-semibold">Payment Method:</strong> <?php echo $tree['Payment_Method']; ?></p>
                            <p><strong class="font-semibold">Shipping Location:</strong> <?php echo $tree['Shipping_Location']; ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<div class='text-center mt-20 text-red-500'>Tree not found.</div>";
    }
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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




