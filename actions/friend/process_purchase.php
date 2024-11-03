<?php

/*
* Make the purchase of the tree and change the status of the tree
*/

require('../../utils/friend/friend_functions.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $treeId = $_POST['tree_id'];
    $userId = $_SESSION['Id_User'];
    
    $shippingLocation   = $_POST['shipping_location'];
    $paymentMethod      = $_POST['payment_method'];

    $purchaseSuccess = purchaseTree($treeId); // Function to update tree state

    if ($purchaseSuccess) {
        $saveSuccess = savePurchase($treeId, $userId, $shippingLocation, $paymentMethod);

        if ($saveSuccess) {
            $_SESSION['purchase_message'] = 'Thank you for your purchase!';
            header("Location: ../../friend/friend.php");
            exit();
        } else {
            echo "Error saving your purchase. Please try again.";
        }
    } else {
        echo "Error processing your purchase. Please try again.";
    }
}
?>
