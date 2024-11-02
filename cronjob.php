<?php

// Verificar que se esté ejecutando con el argumento "días"
if ($argc != 2) {
    echo "Uso: php verificarArboles.php <dias>\n";
    exit(1);
}

// Número de días a verificar
$max_dias = (int)$argv[1]; 

// Incluir funciones necesarias para conectar a la base de datos y enviar correos
require(__DIR__ . '/utils/functions.php');

// Conexión a la base de datos
$conn = getConnection();

$current_datetime = new DateTime();

// Query para obtener árboles actualizados
$sql = "SELECT id_arbol, nombre, fecha_ultima_actualizacion FROM arboles";
$result = mysqli_query($conn, $sql);

$lista_arboles_desactualizados = [];
if (mysqli_num_rows($result) > 0) {
    while ($arbol = mysqli_fetch_assoc($result)) {
        $arbol_id = $arbol['id_arbol'];
        $nombre_arbol = $arbol['nombre'];
        $fecha_ultima_actualizacion = $arbol['fecha_ultima_actualizacion'];

        if (empty($fecha_ultima_actualizacion)) {
            continue;
        }

        $fecha_ultima_datetime = new DateTime($fecha_ultima_actualizacion);
        $interval = $current_datetime->diff($fecha_ultima_datetime);
        $dias_pasados = $interval->days;

        // Verificar si el árbol no se ha actualizado en más de los días especificados
        if ($dias_pasados > $max_dias) {
            $lista_arboles_desactualizados[] = "● $nombre_arbol";
        }
    }
}

// Verificar si hay árboles desactualizados y enviar correo
if (!empty($lista_arboles_desactualizados)) {
    $admin_email = "admin@ejemplo.com";
    $asunto = "Alerta: Árboles desactualizados";
    $cuerpo_mensaje = "Los siguientes árboles no han sido actualizados desde hace más de $max_dias días:\n\n";
    $cuerpo_mensaje .= implode("\n", $lista_arboles_desactualizados);

    // Enviar correo
    if (mail($admin_email, $asunto, $cuerpo_mensaje)) {
        echo "Correo enviado al administrador con la lista de árboles desactualizados.\n";
    } else {
        echo "Error al enviar el correo.\n";
    }
} else {
    echo "No se encontraron árboles desactualizados.\n";
}

mysqli_close($conn);
