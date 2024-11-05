<?php
/*
* Shows friends list
*/

include('../utils/administrator/admin_functions.php');

$uploads_folder = $_SERVER["DOCUMENT_ROOT"] . "/uploads_user/";

$users = getUsers();
$error_msg = '';
if (isset($_GET['error'])) {
    $error_msg = $_GET['error'];
}
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/12d578a4cd.js" crossorigin="anonymous"></script>

<?php require('../inc/header_admin.php') ?>

<div class="container mx-auto mt-10 text-center px-4">
    <div class="bg-white shadow-lg rounded-lg p-4 max-w-4xl mx-auto mb-5">
        <div class="text-center">
            <h1 class="text-6xl font-bold">Manage Friends</h1>
            <p class="text-gray-600 mt-2">List of all registered friends</p>
            <a href="../administrator/admin.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-3 inline-block">Go to Home</a>
        </div>
    </div>

    <?php if ($error_msg) : ?>
        <div class="bg-red-500 text-white text-center py-2 rounded max-w-4xl mx-auto">
            <?= htmlspecialchars($error_msg) ?>
        </div>
    <?php endif; ?>

    <div class="mt-6 max-w-4xl mx-auto overflow-hidden">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden w-full">
            <thead>
                <tr class="bg-blue-200 text-gray-700">
                    <th scope="col" class="px-6 py-3 text-center">Profile Picture</th>
                    <th scope="col" class="px-6 py-3">First Name</th>
                    <th scope="col" class="px-6 py-3">Last Name</th>
                    <th scope="col" class="px-6 py-3">Username</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3 text-center">View Trees</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr class="border-b">
                            <td class="text-center px-6 py-4">
                                <?php if (!empty($user['Photo_Path'])) : ?>
                                    <img src="<?= htmlspecialchars($uploads_folder . $user['Photo_Path']) ?>" alt="Profile Picture" class="rounded-full w-12 h-12 mx-auto">
                                <?php else : ?>
                                    <span class="text-gray-400">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4"><?= htmlspecialchars($user['First_Name']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($user['Last_Name1']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($user['Username']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($user['Email']) ?></td>
                            <td class="px-6 py-4 text-center">
                                <a href="friend_trees.php?id=<?= $user['Id_User'] ?>" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 flex flex-col items-center" title="View Trees">
                                    <i class="fas fa-tree"></i> View Trees
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No friends found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.4.2/dist/cdn.min.js" defer></script>
