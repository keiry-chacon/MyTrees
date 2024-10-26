<?php
// purchase_form.php
include '../inc/header_friend.php'; 
require_once('../utils/friend/friend_functions.php');

$treeId = $_GET['tree_id'];

$tree = getTreeDetailsById($treeId); 
?>
<div class="purchase-form-container">
    <h1>Purchase Form</h1>

    <!-- Resumen de la compra -->
    <div class="purchase-summary">
        <h2>Purchase Summary</h2>
        <img src="<?php echo "../" . $tree['Photo_Path']; ?>" alt="<?php echo $tree['Commercial_Name']; ?>" class="tree-image">
        <p><strong>Tree Name:</strong> <?php echo $tree['Commercial_Name']; ?></p>
        <p><strong>Scientific Name:</strong> <?php echo $tree['Scientific_Name']; ?></p>
        <p><strong>Price:</strong> ₡<?php echo number_format($tree['Price'], 0, ',', '.'); ?></p>
    </div>

    <form action="../actions/friend/process_purchase.php" method="POST">
        <input type="hidden" name="tree_id" value="<?php echo $treeId; ?>">

        <div>
            <label for="shipping_location">Shipping Location:</label>
            <input type="text" id="shipping_location" name="shipping_location" required placeholder="Enter your shipping address">
        </div>

        <div>
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
            </select>
        </div>

        <!-- Botón para pagar ahora -->
        <button type="submit" class="pay-now-button">Pay Now</button>
    </form>
</div>

<style>
    .purchase-form-container {
        max-width: 600px; /* Ancho máximo del formulario */
        margin: 30px auto; /* Margen para centrar el formulario y separar del navegador */
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
    }

    .purchase-summary {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
        text-align: center; /* Centrar texto e imagen */
    }

    .tree-image {
        max-width: 50%; /* Ajusta la imagen al 50% del contenedor para hacerla más pequeña */
        height: auto; /* Mantiene la proporción de la imagen */
        border-radius: 5px; /* Bordes redondeados para la imagen */
        margin-bottom: 10px; /* Espacio debajo de la imagen */
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    select {
        width: 100%; /* Ocupa todo el ancho del formulario */
        padding: 10px;
        margin-bottom: 15px; /* Separación entre campos */
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .pay-now-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 15px;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1.2em;
        transition: background-color 0.3s ease; /* Transición para el hover */
    }

    .pay-now-button:hover {
        background-color: #0056b3; /* Cambio de color al pasar el ratón */
    }
</style>