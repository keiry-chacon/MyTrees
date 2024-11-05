
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

function savePurchase($treeId, $userId, $shippingLocation, $paymentMethod) {
    $conn = getConnection(); 

    $stmt = $conn->prepare("INSERT INTO purchase (Tree_Id, User_Id, Shipping_Location, Payment_Method) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $treeId, $userId, $shippingLocation, $paymentMethod);

    return $stmt->execute();
}


/*
* Gets the users from the database
*/
function getAllAvailableTrees(): array {
    $conn = getConnection(); 
    $trees = [];
    $statusAvailable = 1; 

    if ($conn) {
        $query = "
    SELECT 
        t.Id_Tree, 
        t.Specie_Id, 
        s.Commercial_Name,  
        t.Location, 
        t.StatusT, 
        t.Price, 
        t.Photo_Path
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
function purchaseTree($treeId) {
    $db = getConnection();
    $statusInactive = 0;

    $query = "UPDATE trees SET StatusT = ?  WHERE Id_Tree = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ii', $statusInactive, $treeId);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function getTreeDetailsById($Id): array {
    $conn = getConnection(); 
    $tree = [];

    if ($conn) {
        $Id = mysqli_real_escape_string($conn, $Id);

        $query = "
    SELECT 
        t.Id_Tree, 
        t.Specie_Id, 
        s.Commercial_Name,  
        s.Scientific_Name,  
        t.Location, 
        t.Size, 
        t.StatusT, 
        t.Price, 
        t.Photo_Path
    FROM trees t
    INNER JOIN species s ON t.Specie_Id = s.Id_Specie  
    WHERE t.Id_Tree = '$Id'
";


        $result = mysqli_query($conn, $query);

        if ($result) {
            $tree = mysqli_fetch_assoc($result);
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
function getFriendsTrees($friendId): array {
    $conn = getConnection(); 
    $trees = [];
    $statusAvailable = 1;
   

    $query = "
        SELECT 
            p.Id_Purchase, 
            p.Payment_Method, 
            p.Shipping_Location, 
            p.Purchase_Date, 
            t.Id_Tree, 
            t.Specie_Id, 
            s.Commercial_Name,  
            s.Scientific_Name,  
            t.Location, 
            t.Size, 
            p.StatusP, 
            t.Price, 
            t.Photo_Path
        FROM purchase p
        INNER JOIN trees t ON t.Id_Tree = p.Tree_Id  
        INNER JOIN species s ON t.Specie_Id = s.Id_Specie  
        WHERE p.User_Id = ? AND p.StatusP = ?
    ";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ii", $friendId, $statusAvailable);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
           
            while ($row = mysqli_fetch_assoc($result)) {
                $trees[] = [
                    'Id_Purchase'      => $row['Id_Purchase'],
                    'Payment_Method'   => $row['Payment_Method'],
                    'Shipping_Location'=> $row['Shipping_Location'],
                    'Purchase_Date'    => $row['Purchase_Date'],
                    'Id_Tree'          => $row['Id_Tree'],
                    'Specie_Id'        => $row['Specie_Id'],
                    'Commercial_Name'  => $row['Commercial_Name'],
                    'Scientific_Name'  => $row['Scientific_Name'],
                    'Location'         => $row['Location'],
                    'Size'             => $row['Size'],
                    'StatusP'          => $row['StatusP'],
                    'Price'            => $row['Price'],
                    'Photo_Path'       => $row['Photo_Path'],
                ];
            }
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
    return $trees;
}


function getTreeInvaibDetailsById($Id): array {
    $conn = getConnection();
    $tree = [];

    if ($conn) {
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
        t.Photo_Path
    FROM trees t
    INNER JOIN species s ON t.Specie_Id = s.Id_Specie  
    WHERE t.Id_Tree = '$Id'
";


        $result = mysqli_query($conn, $query);

        if ($result) {
            $tree = mysqli_fetch_assoc($result); 
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
function addToCart($userId, $treeId, $quantity = 1, $status = 'active') {
    $conn = getConnection();

    $priceQuery = "SELECT Price FROM trees WHERE Id_Tree = ?";
    $priceStmt = $conn->prepare($priceQuery);
    $priceStmt->bind_param("i", $treeId);
    $priceStmt->execute();
    $priceResult = $priceStmt->get_result();

    if ($priceResult->num_rows > 0) {
        $tree = $priceResult->fetch_assoc();
        $price = $tree['Price'];
        $statusAvailable = 'active';

        $query = "SELECT * FROM cart WHERE User_Id = ? AND Tree_Id = ? AND Status = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iis", $userId, $treeId, $statusAvailable);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $insertQuery = "INSERT INTO cart (User_Id, Tree_Id, Quantity, Status, Created_At, Price) VALUES (?, ?, ?, ?, NOW(), ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("iiisi", $userId, $treeId, $quantity, $status, $price);
            $insertStmt->execute();

            return true;
        } else {
            return false;
        }
    } 
}

function getCartItemsForUser($userId) {
    $statusAvailable = 'active';
    $dbConnection = getConnection(); 

    $query = "SELECT c.Tree_Id, c.Quantity, s.Commercial_Name, s.Scientific_Name, t.Photo_Path, t.Price
              FROM cart AS c 
              INNER JOIN Trees AS t ON c.Tree_Id = t.Id_Tree 
              INNER JOIN Species AS s ON t.Specie_Id = s.Id_Specie 
              WHERE c.User_Id = ? AND c.Status = ?"; 

    $stmt = mysqli_prepare($dbConnection, $query);
    mysqli_stmt_bind_param($stmt, "is", $userId, $statusAvailable);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $cartItems = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
    }
    mysqli_stmt_close($stmt);
    
    return $cartItems;
}

