<?php

define('BASE_URL', '/MyTrees/');


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
* Gets the species from the database
*/
function getSpecies(): array {
    $conn = getConnection();
    $species = [];

    if ($conn) {
        $query = "
            SELECT Id_Specie, Commercial_Name, Scientific_Name 
            FROM species 
            WHERE StatusS = 1 
        ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $species[] = [
                    'Id_Specie'          => $row['Id_Specie'],       
                    'Commercial_Name'    => $row['Commercial_Name'],     
                    'Scientific_Name'    => $row['Scientific_Name'],             
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
    return $species;
}




function getSpeciesSelect(): array {
    $conn = getConnection();
    $species = [];

    if ($conn) {
        $query = "
            SELECT Id_Specie, Commercial_Name, Scientific_Name 
            FROM species 
            WHERE StatusS = 1 
        ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Concatenamos ambos nombres para mostrarlos en el <select>
                $species[$row['Id_Specie']] = $row['Commercial_Name'] . " (" . $row['Scientific_Name'] . ")";
            }

            mysqli_free_result($result);
        } else {
            echo "Query error: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        echo "Connection error: " . mysqli_connect_error();
    }
    return $species;
}




/*
* Gets a specific specie from the database with ID
*/
function getSpecieById($id_specie): array {

    $conn = getConnection();
    $species = [];
  
    if ($conn) {
        $query = "
            SELECT Id_Specie, Commercial_Name, Scientific_Name, StatusS 
            FROM species 
            WHERE Id_Specie = ?
        ";
  
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id_specie); 
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
  
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) { 
                $species[] = [
                    'Id_Specie'          => $row['Id_Specie'],       
                    'Commercial_Name'    => $row['Commercial_Name'],     
                    'Scientific_Name'    => $row['Scientific_Name'],
                    'StatusS'            => $row['StatusS'],                          
                ];
            }
  
            mysqli_free_result($result);
        } else {
            echo "Query error: " . mysqli_error($conn);
        }
  
        mysqli_stmt_close($stmt); 
        mysqli_close($conn); 
    } else {
        echo "Connection error: " . mysqli_connect_error();
    }
    return $species;
}




/*
* Check if the specie already exists in the database by either Commercial or Scientific name
*/
function specieExists($commercialName, $scientificName): bool {
    
    $conn = getConnection();
  
    if ($conn) {
        // Escape both inputs to prevent SQL injection
        $commercialNameEscaped = mysqli_real_escape_string($conn, $commercialName);
        $scientificNameEscaped = mysqli_real_escape_string($conn, $scientificName);

        // Modify the query to check both Commercial_Name and Scientific_Name
        $query = "SELECT COUNT(*) as count FROM species 
                  WHERE Commercial_Name = '$commercialNameEscaped' 
                  OR Scientific_Name = '$scientificNameEscaped'";
        
        $result = mysqli_query($conn, $query);
  
        if ($result) {
            $row = mysqli_fetch_assoc($result);
  
            mysqli_free_result($result);
            mysqli_close($conn);
  
            // Return true if any matching record is found
            return $row['count'] > 0;
        } else {
            echo "Query error: " . mysqli_error($conn);
        }
  
        mysqli_close($conn);
    } else {
        echo "Connection error: " . mysqli_connect_error();
    }
    
    return false;
}




/*
* Saves a specific specie into the database
*/
function saveSpecie($specie): bool {

    $conn = getConnection();

    $Commercial_Name   = $specie['commercial_name'];
    $Scientific_Name   = $specie['scientific_name'];

    $sql = "INSERT INTO species (Commercial_Name, Scientific_Name) 
            VALUES (?, ?)";

    try {
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("ss", $Commercial_Name, $Scientific_Name);
        
        $stmt->execute();
        
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
    return true;
}




/*
* Updates about an specific specie into the database
*/
function updateSpecie($specie, $id_specie): bool {

    $Commercial_Name   = $specie['commercial_name'];
    $Scientific_Name   = $specie['scientific_name'];

    $sql = "UPDATE species SET 
                Commercial_Name = '$Commercial_Name', 
                Scientific_Name = '$Scientific_Name' 
            WHERE Id_Specie = $id_specie";

    try {
        $conn = getConnection();
        mysqli_query($conn, $sql);
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
    return true;
}




/*
* Deletes an specific specie into the database
*/
function updateSpecieStatus(int $id_specie, int $statusS): bool {

    $sql = "UPDATE species SET StatusS = '$statusS' WHERE Id_Specie = $id_specie";

    try {
        $conn = getConnection(); 
        mysqli_query($conn, $sql); 

        if (mysqli_affected_rows($conn) > 0) {
            return true; 
        } else {
            return false; 
        }
    } catch (Exception $e) {
        echo $e->getMessage(); 
        return false; 
    }
}





/*
*-------------------------------------------------------------------------------------------------------------
* Trees Functions
*/



/*
* Gets the trees from the database
*/
function getTrees(): array {
    $conn = getConnection();
    $trees = [];

    if ($conn) {
        $query = "
            SELECT Id_Tree, Specie_Id, Location, Size, StatusT, Price, Photo_Path 
            FROM trees 
        ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $trees[] = [
                    'Id_Tree'       => $row['Id_Tree'],       
                    'Specie_Id'     => $row['Specie_Id'],     
                    'Location'      => $row['Location'],  
                    'Size'          => $row['Size'],             
                    'StatusT'       => $row['StatusT'],   
                    'Price'         => $row['Price'],             
                    'Photo_Path'    => $row['Photo_Path'],             
          
           
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




/*
* Gets a specific tree from the database with ID
*/
function getTreeById($id_tree): array {

    $conn = getConnection();
    $trees = [];
  
    if ($conn) {
        $query = "
            SELECT Id_Tree, Specie_Id, Location, Size, StatusT, Price, Photo_Path
            FROM trees 
            WHERE Id_Tree = ?
        ";
  
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id_tree); 
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
  
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) { 
                $trees[] = [
                    'Id_Tree'       => $row['Id_Tree'],       
                    'Specie_Id'     => $row['Specie_Id'],     
                    'Location'      => $row['Location'],  
                    'Size'          => $row['Size'],             
                    'StatusT'       => $row['StatusT'],   
                    'Price'         => $row['Price'],             
                    'Photo_Path'    => $row['Photo_Path'],                          
                ];
            }
  
            mysqli_free_result($result);
        } else {
            echo "Query error: " . mysqli_error($conn);
        }
  
        mysqli_stmt_close($stmt); 
        mysqli_close($conn); 
    } else {
        echo "Connection error: " . mysqli_connect_error();
    }
    return $trees;
}




/*
* Saves a specific tree into the database
*/
function saveTree($tree) {
    $conn = getConnection();

    // Asignar valores del array $tree a variables individuales
    $Specie_Id  = $tree['specie_id'];
    $Location   = $tree['location'];
    $Size       = $tree['size'];
    $StatusT    = $tree['statusT'];
    $Price      = $tree['price'];
    $Photo_Path = $tree['photoPath'] ?? null; // Asegurarse de que la imagen puede ser opcional

    // Incluir todos los campos en la consulta SQL
    $sql = "INSERT INTO trees (Specie_Id, Location, Size, StatusT, Price, Photo_Path) 
            VALUES (?, ?, ?, ?, ?, ?)";

    try {
        $stmt = $conn->prepare($sql);
        
        // Enlazar todos los parámetros
        $stmt->bind_param("isisds", $Specie_Id, $Location, $Size, $StatusT, $Price, $Photo_Path);
        
        $stmt->execute();

        // Obtener el ID del árbol recién insertado
        $tree_id = $conn->insert_id;

        $stmt->close();
        $conn->close();
        
        return $tree_id; // Retornar el ID del árbol
    } catch (Exception $e) {
        echo $e->getMessage();
        return false; // Retornar false en caso de error
    }
}
function updateTreePic($userId, $fileName) {
    $conn = getConnection();
    $sql = "UPDATE trees SET Photo_Path = ? WHERE Id_Tree = ?";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $fileName, $userId);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
}




/*
* Updates about an specific tree into the database
*/
function updateTree($tree, $id_tree): bool {

    $Specie_Id         = $tree['specie_id'];
    $Location          = $tree['location'];
    $Size              = $tree['size'];
    $StatusT           = $tree['statusT'];
    $Price             = $tree['price'];
    $Photo_Path        = $tree['photoPath'] ?? null; // Asegurarse de que la imagen puede ser opcional

    $sql = "UPDATE trees SET 
                Specie_Id   = '$Specie_Id', 
                Location    = '$Location', 
                Size        = '$Size', 
                StatusT     = '$StatusT', 
                Price       = '$Price', 
                Photo_Path  = '$Photo_Path' 

            WHERE Id_Tree = $id_tree";

    try {
        $conn = getConnection();
        mysqli_query($conn, $sql);
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
    return true;
}




/*
*  Updates an specific tree status into the database
*/
function updateTreeStatus(int $id_tree, int $statusT): bool {

    $sql = "UPDATE trees SET StatusT = '$statusT' WHERE Id_Tree = $id_tree";

    try {
        $conn = getConnection(); 
        mysqli_query($conn, $sql); 

        if (mysqli_affected_rows($conn) > 0) {
            return true; 
        } else {
            return false; 
        }
    } catch (Exception $e) {
        echo $e->getMessage(); 
        return false; 
    }
}




/*
* Gets the users from the database
*/
function getUsers(): array {
    $conn = getConnection();
    $users = [];

    if ($conn) {
        $query = "
            SELECT Id_User, First_Name, Last_Name1, Last_Name2, Username, 
            Email, Phone, Gender, Profile_Pic, District_Id, 
            Created_At, Role_Id, StatusU 
            FROM users 
            WHERE StatusU = 1 AND Role_Id = 2;
        ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = [
                    'Id_User'       => $row['Id_User'],       
                    'First_Name'    => $row['First_Name'],     
                    'Last_Name1'    => $row['Last_Name1'],     
                    'Last_Name2'    => $row['Last_Name2'],     
                    'Username'      => $row['Username'], 
                    'Email'         => $row['Email'],          
                    'Photo_Path'    => $row['Profile_Pic']         
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
    return $users;
}










  