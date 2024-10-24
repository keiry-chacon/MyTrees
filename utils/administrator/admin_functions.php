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




/*
* Gets a specific user from the database with ID
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
* Updates about an specific user into the database
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

  