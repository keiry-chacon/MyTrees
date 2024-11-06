<?php

if ($argc != 2) {
    echo "Uso: php verificarArboles.php <dias>\n";
    exit(1);
}

$max_dias = (int)$argv[1];

require(_DIR_ . '/utils/functions.php');
require 'vendor/autoload.php';  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = getConnection();
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

$current_date = date('Y-m-d H:i:s');
$threshold_date = date('Y-m-d H:i:s', strtotime("-$max_dias days"));

$sql = "SELECT t.Id_Tree, t.Location, s.Commercial_Name, s.Scientific_Name
        FROM trees t
        JOIN tree_update tu ON t.Id_Tree = tu.Tree_Id
        JOIN species s ON t.Specie_Id = s.Id_Specie
        WHERE tu.UpdateDate < ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $threshold_date);
$stmt->execute();
$result = $stmt->get_result();

$lista_arboles_desactualizados = [];
while ($arbol = $result->fetch_assoc()) {
    $nombre_arbol = "Árbol ID: " . $arbol['Id_Tree'] . 
                    " (Especie: " . $arbol['Commercial_Name'] . 
                    ", Nombre Científico: " . $arbol['Scientific_Name'] . 
                    ", Ubicación: " . $arbol['Location'] . ")";
    $lista_arboles_desactualizados[] = "● $nombre_arbol";
}

$stmt->close();
$conn->close();

if (!empty($lista_arboles_desactualizados)) {
    $admin_email = "greddycorrales.m@gmail.com";
    $asunto = "Alerta: Árboles desactualizados";
    $cuerpo_mensaje = "Los siguientes árboles no han sido actualizados desde hace más de $max_dias días:\n\n";
    $cuerpo_mensaje .= implode("\n", $lista_arboles_desactualizados);

    if (enviarCorreo($admin_email, $asunto, $cuerpo_mensaje)) {
        echo "Correo enviado al administrador con la lista de árboles desactualizados.\n";
    } else {
        echo "Error al enviar el correo.\n";
    }
} else {
    echo "No se encontraron árboles desactualizados.\n";
}

/**
 * 
 * @param string $to
 * @param string $subject
 * @param string $message
 * @return bool
 */
function enviarCorreo($to, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
       
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                   
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = 'greddymendoza2@gmail.com';            
        $mail->Password   = 'ptfv unzw gveq rxml';       
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        $mail->Port       = 587;                                  

        $mail->setFrom('greddymendoza2@gmail.com', 'MyTrees');
        $mail->addAddress($to);                                   

        $mail->isHTML(false);                                     
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
        return false; 
    }
}