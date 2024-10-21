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
                    'id_user'       => $row['Id_Users'],       
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
* Gets a specific user from the database with ID
*/
function getUserById($id_user): array {

  $conn = getConnection();
  $user = [];

  if ($conn) {
      $query = "
          SELECT u.id_user, u.first_name, u.last_name, u.username, u.password, u.province_id, p.province_name 
          FROM users u
          JOIN provinces p ON u.province_id = p.id_province
          WHERE u.id_user = ?
      ";

      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'i', $id_user); 
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($result) {
          while ($row = mysqli_fetch_object($result)) {
              $user[] = [
                  'id_user'       => $row->id_user,
                  'first_name'    => $row->first_name,
                  'last_name'     => $row->last_name,
                  'username'      => $row->username,
                  'password'      => $row->password,
                  'province_id'   => $row->province_id, 
                  'province_name' => $row->province_name 
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
  return $user;
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




function userExists($username): bool {
    $conn = getConnection();
  
    if ($conn) {
        $query = "SELECT COUNT(*) as count FROM users WHERE Username = '" . mysqli_real_escape_string($conn, $username) . "'";
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
function saveUser($user): bool {

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
    $url_pic      = $user['pic']; 

    $sql = "INSERT INTO users (First_Name, Last_Name1, Last_Name2, Username, Password, Email, Phone, Gender, Profile_Pic, District_Id, Created_At, Role_Id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("sssssssssisi", $first_name, $last_name1, $last_name2, $username, $hashedPassword, $email, $phone, $gender, $url_pic, $district_id, $created_at, $role);
        
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
function updateUser($user, $id_user): bool {

    $first_name  = $user['first_name'];
    $last_name   = $user['last_name'];
    $username    = $user['username'];
    $password    = $user['password'];
    $province    = $user['province'];

    $sql = "UPDATE users SET 
                first_name = '$first_name', 
                last_name = '$last_name', 
                username = '$username', 
                password = '$password', 
                province_id = '$province' 
            WHERE id_user = $id_user";

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
* Deletes an specific user into the database
*/
function updateUserState(int $id_user, int $status_id): bool {

    $sql = "UPDATE users SET status_id = '$status_id' WHERE id_user = $id_user";

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




/**
 * Get one specific student from the database
 *
 * @id Id of the student
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
        ];     
    }

    return false;
}
