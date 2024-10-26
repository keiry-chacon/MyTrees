<?php
// process_purchase.php
require('../../utils/friend/friend_functions.php');
session_start();
// Asegúrate de recibir el ID del árbol, el ID del usuario y la información de pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $treeId = $_POST['tree_id'];
    $userId = $_SESSION['Id_User'];
    
    $shippingLocation = $_POST['shipping_location'];
    $paymentMethod = $_POST['payment_method'];

    // Función para actualizar el estado del árbol
    $purchaseSuccess = purchaseTree($treeId);

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
        // Manejar errores en la compra (puedes mostrar un mensaje de error en la misma página)
        echo "Error processing your purchase. Please try again.";
    }
}


?>
