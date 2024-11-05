<?php
/*
* Shows the list of trees
*/

include('../utils/administrator/admin_functions.php');

$uploads_folder = $_SERVER["DOCUMENT_ROOT"] . "/uploads_tree/";

$trees = getTrees();
$error_msg = '';
if (isset($_GET['error'])) {
    $error_msg = $_GET['error'];
}
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/12d578a4cd.js" crossorigin="anonymous"></script>

<?php require('../inc/header_admin.php') ?>

<div class="container mx-auto mt-10 text-center px-4">
    <div class="bg-white shadow-lg rounded-lg p-4 max-w-4xl mx-auto">
        <div class="text-center">
            <h1 class="text-6xl font-bold">Manage Trees</h1>
            <p class="text-gray-600 mt-2">Here is a list of all registered trees.</p>
            <div class="flex justify-center space-x-4 mt-4">
                <a href="register_tree.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add Tree</a>
            </div>
        </div>
    </div>

    <?php if ($error_msg) : ?>
        <div class="bg-red-500 text-white text-center py-2 mt-4 rounded max-w-4xl mx-auto">
            <?= htmlspecialchars($error_msg) ?>
        </div>
    <?php endif; ?>

    <div class="mt-6 max-w-4xl mx-auto overflow-hidden">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden w-full">
            <thead>
                <tr class="bg-blue-200 text-gray-700">
                    <th class="px-6 py-3">Specie</th>
                    <th class="px-6 py-3">Location</th>
                    <th class="px-6 py-3">Size</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Price</th>
                    <th class="px-6 py-3 text-center">Edit</th>
                    <th class="px-6 py-3 text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($trees)) : ?>
                    <?php foreach ($trees as $tree) : ?>
                        <tr class="border-b">
                            <td class="px-6 py-4"><?= htmlspecialchars($tree['Specie_Name']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($tree['Location']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($tree['Size']) ?></td>
                            <td class="px-6 py-4">
                                <?= $tree['StatusT'] == 1 ? 'Active' : 'Inactive' ?>
                            </td>                              
                            <td class="px-6 py-4"><?= htmlspecialchars($tree['Price']) ?></td>
                            <td class="px-6 py-4 text-center">
                                <a href="update_tree.php?id=<?= $tree['Id_Tree'] ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 flex flex-col items-center" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit
                                </a>
                            </td>
                            <td>
                                <form action="<?= BASE_URL; ?>actions/administrator/delete_tree.php" method="POST" style="display:inline;" title="Delete">
                                    <input type="hidden" name="id_tree" value="<?= $tree['Id_Tree'] ?>">
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 flex flex-col items-center" onclick="return confirm('Are you sure you want to delete this tree?');">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center text-gray-500 py-4">No trees found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.4.2/dist/cdn.min.js" defer></script>
