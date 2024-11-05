<?php
/*
* Shows the list of species
*/

include('../utils/administrator/admin_functions.php');

$species = getSpecies();
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
            <h1 class="text-6xl font-bold">Manage Species</h1>
            <p class="text-gray-600 mt-2">Here is a list of all registered species.</p>
            <div class="flex justify-center space-x-4 mt-4">
                <a href="register_specie.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add Specie</a>
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
                    <th class="px-6 py-3 text-center">ID Specie</th>
                    <th class="px-6 py-3">Commercial Name</th>
                    <th class="px-6 py-3">Scientific Name</th>
                    <th class="px-6 py-3 text-center">Edit</th>
                    <th class="px-6 py-3 text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($species)) : ?>
                    <?php foreach ($species as $specie) : ?>
                        <tr class="border-b">
                            <td class="text-center px-6 py-4"><?= htmlspecialchars($specie['Id_Specie']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($specie['Commercial_Name']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($specie['Scientific_Name']) ?></td>
                            <td class="px-6 py-4 text-center">
                                <a href="update_specie.php?id=<?= $specie['Id_Specie'] ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 flex flex-col items-center" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="<?= BASE_URL; ?>/actions/administrator/delete_specie.php" method="POST" style="display:inline;" title="Delete">
                                    <input type="hidden" name="id_specie" value="<?= $specie['Id_Specie'] ?>">
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 flex flex-col items-center" onclick="return confirm('Are you sure you want to delete this specie?');">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">No species found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.4.2/dist/cdn.min.js" defer></script>
