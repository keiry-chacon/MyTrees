
<?php

/*
* Connects to the database
*/
function getConnection(): bool|mysqli {
    $servername = "localhost"; 
    $username   = "root"; 
    $password   = ""; 
    $dbname     = "mytrees"; 

    try {
        $conn = new mysqli($servername, $username, $password, $dbname, 3306);

        if ($conn->connect_error) {
            throw new Exception("Conexión fallida: " . $conn->connect_error);
        }

        return $conn; 
    } catch (Exception $e) {
        echo "Error de conexión: " . $e->getMessage();
        return false; 
    }
}


/*
* Gets the users from the database
*/
function getAllAvailableTrees(): array {
    $conn = getConnection(); // Asumiendo que tienes una función para obtener la conexión a la base de datos
    $trees = [];
    $statusAvailable = 1; // Asumiendo que '1' indica un estado disponible

    if ($conn) {
        $query = "
            SELECT 
                t.Id_Tree, 
                t.Specie_Id, 
                s.Commercial_Name,  
                t.Location, 
                t.StatusT, 
                t.Price, 
                t.Photo_Path,
                t.User_Id
            FROM trees t
            INNER JOIN species s ON t.Specie_Id = s.Id_Specie  
            WHERE t.StatusT = $statusAvailable
        ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $trees[] = [
                    'Id_Tree'      => $row['Id_Tree'],
                    'Specie_Id'    => $row['Specie_Id'],
                    'Commercial_Name'  => $row['Commercial_Name'], // Incluyendo el nombre de la especie
                    'Location'     => $row['Location'],
                    'StatusT'      => $row['StatusT'],
                    'Price'        => $row['Price'],
                    'Photo_Path'   => $row['Photo_Path'],
                    'User_Id'      => $row['User_Id'],
                ];
            }

            mysqli_free_result($result);
        } else {
            echo "Query error: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        echo "Connection error: " . mysqli_connect_error();
    }

    return $trees;
}
function purchaseTree($treeId, $userId) {
    // Conectar a la base de datos
    $db = getConnection();
    $statusInactive = 0;

    // Actualizar el estado del árbol y asignar el ID del nuevo dueño
    $query = "UPDATE trees SET User_Id = ?, StatusT = ?  WHERE Id_Tree = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('iii', $userId, $statusInactive, $treeId);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function getTreeDetailsById($Id): array {
    $conn = getConnection(); // Función que obtiene la conexión a la base de datos
    $tree = [];

    if ($conn) {
        // Escapando el valor del ID para evitar inyección SQL
        $Id = mysqli_real_escape_string($conn, $Id);

        $query = "
            SELECT 
                t.Id_Tree, 
                t.Specie_Id, 
                s.Commercial_Name,  
                s.Scientific_Name,  
                t.Location, 
                t.StatusT, 
                t.Price, 
                t.Photo_Path,
                t.User_Id,
                u.Phone,        
                u.First_Name,
                u.Last_Name1,  -- Corrección en el nombre de la columna
                u.Last_Name2   -- Corrección en el nombre de la columna
            FROM trees t
            INNER JOIN species s ON t.Specie_Id = s.Id_Specie  
            INNER JOIN users u ON t.User_Id = u.Id_User  
            WHERE t.Id_Tree = '$Id'
        ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $tree = mysqli_fetch_assoc($result); // Obtener los detalles del árbol si se encuentra
            mysqli_free_result($result);
        } else {
            echo "Query error: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        echo "Connection error: " . mysqli_connect_error();
    }

    return $tree;
}

