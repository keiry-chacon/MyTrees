<?php



/*
* General functions
*/



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
*-------------------------------------------------------------------------------------------------------------
* Location Functions
*/



/*
* Gets the countries from the database
*/
function getCountries(): array {
    $conn = getConnection();
    $countries = [];

    if ($conn) {
        $query = "SELECT Id_Country, Country_Name FROM country";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $countries[$row['Id_Country']] = $row['Country_Name'];
            }
            mysqli_free_result($result);
        } else {
            echo "Query error: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        echo "Connection error: " . mysqli_connect_error();
    }
    return $countries;
}




/*
* Gets the provinces from the database
*/
function getProvinces($country_id): array {

  $conn = getConnection();

  $provinces = [];

  if ($conn) {

      $query = "SELECT Id_Province, Province_Name, Country_Id FROM province WHERE Country_Id = $country_id";
      $result = mysqli_query($conn, $query);

      if ($result) {

          while ($row = mysqli_fetch_assoc($result)) {
              $provinces[$row['Id_Province']] = $row['Province_Name'];  
          }

          mysqli_free_result($result);
      } else {
          echo "Query error: " . mysqli_error($conn);
      }

      mysqli_close($conn);
  } else {
      echo "Connection error: " . mysqli_connect_error();
  }
  return $provinces;
}




/*
* Gets the districts from the database
*/
function getDistricts($province_id): array {
    $conn = getConnection();
    $districts = [];

    if ($conn) {
        $query = "SELECT Id_District, District_Name, Province_Id FROM district WHERE Province_Id = $province_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $districts[$row['Id_District']] = $row['District_Name'];  
            }
  
            
            mysqli_free_result($result);
        } else {
            echo "Query error: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        echo "Connection error: " . mysqli_connect_error();
    }
    return $districts;
}





/*
*-------------------------------------------------------------------------------------------------------------
* Users Functions
*/



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
            WHERE StatusU = 1 
        ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = [
                    'id_user'       => $row['Id_User'],       
                    'first_name'    => $row['First_Name'],     
                    'last_name1'    => $row['Last_Name1'],     
                    'last_name2'    => $row['Last_Name2'],     
                    'username'      => $row['Username'], 
                    'email'         => $row['Email'],          
                    'phone'         => $row['Phone'],          
                    'gender'        => $row['Gender'],         
                    'profile_pic'   => $row['Profile_Pic'],    
                    'district_id'   => $row['District_Id'],    
                    'created_at'    => $row['Created_At'],     
                    'role_id'       => $row['Role_Id'],         
                    'statusu'       => $row['StatusU'],        
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




/*
* Gets the users from the database so a friend can edit 
*/
function getUserData($username) {
    $conn = getConnection();
    
    if ($conn->connect_error) {
        die("Failed Connection: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; 
    }
}





/*
*-------------------------------------------------------------------------------------------------------------
* Graphs Functions
*/



/*
* Get the information for the graphs
*/
function getAvailableTreesCount() {
 $conn = getConnection(); 

    $sql = "SELECT COUNT(*) as count FROM trees WHERE StatusT = 1";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0; 
    }
}




/*
* Get the information for the graphs
*/
function getSoldTreesCount() {
 $conn = getConnection(); 
    $sql = "SELECT COUNT(*) as count FROM trees WHERE StatusT = 0";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0; 
    }
}



/*
* Get the information for the graphs
*/
function getFriends(): array {
    $conn = getConnection();
    $genderCounts = [
        'F' => 0, 
        'M' => 0, 
        'O' => 0  
    ];

    if ($conn) {
        $query = "
            SELECT Gender, COUNT(*) as count
            FROM users 
            WHERE StatusU = 1
            AND Role_Id = 2
            GROUP BY Gender
        ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $gender = $row['Gender'];
                $count = $row['count'];

                if (isset($genderCounts[$gender])) {
                    $genderCounts[$gender] = $count;
                }
            }
            mysqli_free_result($result);
        } else {
            echo "Error en la consulta: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        echo "Error en la conexión: " . mysqli_connect_error();
    }

    return $genderCounts; 
}



/*
* Check if the email already exists in the database
*/
function emailExists($email): bool {
    
  $conn = getConnection();

  if ($conn) {
      $query = "SELECT COUNT(*) as count FROM users WHERE Email = '" . mysqli_real_escape_string($conn, $email) . "'";
      $result = mysqli_query($conn, $query);

      if ($result) {
          $row = mysqli_fetch_assoc($result);

          mysqli_free_result($result);
          mysqli_close($conn);

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
* Saves a specific user into the database
*/
function saveUser($user) {
    $conn = getConnection();

    $first_name   = $user['first_name'];
    $last_name1   = $user['last_name1'];
    $last_name2   = $user['last_name2'];
    $username     = $user['username'];
    $password     = $user['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
    $district_id  = (int)$user['district']; 
    $role         = 2; 
    $email        = $user['email']; 
    $phone        = $user['phone']; 
    $gender       = $user['gender']; 
    $created_at   = date('Y-m-d H:i:s'); 
    $url_pic      = $user['pic'] ;

    $sql = "INSERT INTO users (First_Name, Last_Name1, Last_Name2, Username, Password, Email, Phone, Gender, Profile_Pic, District_Id, Created_At, Role_Id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssisi", $first_name, $last_name1, $last_name2, $username, $hashedPassword, $email, $phone, $gender, $url_pic, $district_id, $created_at, $role);
        
        if ($stmt->execute()) {
            $userId = $stmt->insert_id;
        } else {
            $userId = false; 
        }
        
        $stmt->close();
        $conn->close();
        
        return $userId;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}




/*
* Updates a user pic
*/
function updateUserPic($userId, $fileName) {
    $conn = getConnection();
    $sql = "UPDATE users SET Profile_Pic = ? WHERE Id_User = ?";

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
* 
*/
function updateUserData($userId, $username, $firstName, $lastName1, $lastName2, $email, $phone, $gender, $password) {
    $conn = getConnection();
  
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE (Email = ? OR Username = ?) AND Id_User != ?");
    $stmt->bind_param("ssi", $email, $username, $userId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        return false; 
    }
    if (empty($password)) {
        $query = "UPDATE users SET Username = '$username', First_Name = '$firstName', Last_Name1 = '$lastName1', Last_Name2 = '$lastName2', Email = '$email', Phone = '$phone', Gender = '$gender' WHERE Id_User = $userId";
        echo "Consulta a ejecutar: $query\n";  
        $stmt = $conn->prepare("UPDATE users SET Username = ?, First_Name = ?, Last_Name1 = ?, Last_Name2 = ?, Email = ?, Phone = ?, Gender = ? WHERE Id_User = ?");
        $stmt->bind_param("sssssssi", $username, $firstName, $lastName1, $lastName2, $email, $phone, $gender, $userId);
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET Username = '$username', First_Name = '$firstName', Last_Name1 = '$lastName1', Last_Name2 = '$lastName2', Email = '$email', Phone = '$phone', Gender = '$gender', Password = '$hashedPassword' WHERE Id_User = $userId";
        echo "Consulta a ejecutar: $query\n";  
        $stmt = $conn->prepare("UPDATE users SET Username = ?, First_Name = ?, Last_Name1 = ?, Last_Name2 = ?, Email = ?, Phone = ?, Gender = ?, Password = ? WHERE Id_User = ?");
        $stmt->bind_param("ssssssssi", $username, $firstName, $lastName1, $lastName2, $email, $phone, $gender, $hashedPassword, $userId);
    }

    return $stmt->execute();
}




/**
 * Get one specific user from the database, and authenticate if you have a user
 *
 * @id Id of the user
 */
function authenticate($login, $password): bool|array|null {

    $conn = getConnection();

    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM users WHERE Email = ?";
    } else {
        $sql = "SELECT * FROM users WHERE Username = ?";
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $conn->close();
        return false;
    }

    $stmt->bind_param("s", $login);

    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    if ($user && password_verify($password, $user['Password'])) {
        return [
            'username'     => $user['Username'],
            'profile_pic'  => $user['Profile_Pic'],
            'role_id'      => $user['Role_Id'],
            'id_user'      => $user['Id_User'],

        ];     
    }

    return false;
}






