<?php 

/*
* Tree Friend Interview
*/

require_once '../inc/header_admin.php'; 
require_once('../utils/administrator/admin_functions.php');

$uploads_folder_t = "../uploads_tree/";

$trees = null; 
if (isset($_GET['id'])) {
    $userID     = (int)$_GET['id'];
    $trees      = getFriendsTrees($userID); 
    if (!is_array($trees) || empty($trees)) {
        die("User not found or no trees available.");
    }
}

$error_msg = '';
if(isset($_GET['error'])) {
    $error_msg = $_GET['error'];
}
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/12d578a4cd.js" crossorigin="anonymous"></script>

<div class="container mx-auto mt-10 text-center px-4">
    <div class="bg-white shadow-lg rounded-lg p-4 max-w-4xl mx-auto mb-5">
        <div class="text-center">
            <h1 class="text-6xl font-bold">Tree Management</h1>
            <p class="text-gray-600 mt-2">List of all trees associated with this friend</p>
            <a href="../administrator/admin.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-3 inline-block">Go to Home</a>
        </div>
    </div>

    <?php if ($error_msg) : ?>
        <div class="bg-red-500 text-white text-center py-2 rounded max-w-4xl mx-auto">
            <?= htmlspecialchars($error_msg) ?>
        </div>
    <?php endif; ?>

    <div class="mt-6 max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($trees as $tree):
            $photoTree          = $uploads_folder_t . $tree['Photo_Path'];
            $treeDetailUrl      = "update_friend_tree.php?id=" . $tree['Id_Tree']; // Updates all tree information
            $treeRegisterUrl    = "register_tree_update.php?id=" . $tree['Id_Tree']; // Register update of a tree
        ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="<?php echo $photoTree; ?>" alt="Tree Picture" class="w-full h-32 object-contain mx-auto">
                <div class="p-4">
                    <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($tree['Commercial_Name']); ?></h3>
                    <p class="text-gray-600">Location: <?php echo htmlspecialchars($tree['Location']); ?></p>
                    <p class="text-gray-600">Purchase date: <?php echo htmlspecialchars(date('Y-m-d', strtotime($tree['Purchase_Date']))); ?></p>
                    <div class="mt-4 flex justify-between">
                        <a href="<?php echo $treeDetailUrl; ?>" class="bg-yellow-500 text-white px-1 py-2 rounded hover:bg-yellow-600">Update Tree</a>
                        <a href="<?php echo $treeRegisterUrl; ?>" class="bg-green-500 text-white px-1 py-2 rounded hover:bg-green-600">Register Update</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.4.2/dist/cdn.min.js" defer></script>