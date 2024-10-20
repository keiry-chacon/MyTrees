<?php




/*
* Connects to the database
*/
function getConnection(): bool|mysqli {
    $servername = "localhost"; // Nombre del servidor donde está la BD
    $username   = "root"; // Usuario por defecto
    $password   = ""; // Contraseña (vacía por defecto)
    $dbname     = "mytress"; // Nombre de la base de datos

    try {
        // Crear la conexión usando la extensión mysqli
        $conn = new mysqli($servername, $username, $password, $dbname, 3306);

        // Verificar si hay errores de conexión
        if ($conn->connect_error) {
            throw new Exception("Conexión fallida: " . $conn->connect_error);
        }

        return $conn; // Retorna el objeto de conexión si es exitosa
    } catch (Exception $e) {
        // Manejar el error de conexión
        echo "Error de conexión: " . $e->getMessage();
        return false; // Retorna false si hay algún problema
    }
}

/*
* Gets the countries from the database
*/
function getCountries(): array {
    $conn = getConnection();
    $countries = [];

    if ($conn) {
        $query = "SELECT Id, Name FROM country";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $countries[$row['Id']] = $row['Name'];
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

      $query = "SELECT Id, Name, Country_Id FROM province WHERE Country_Id = $country_id";
      $result = mysqli_query($conn, $query);

      if ($result) {

          while ($row = mysqli_fetch_assoc($result)) {
              $provinces[$row['Id']] = $row['Name'];  
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
        $query = "SELECT Id, Name, Province_Id FROM district WHERE Province_Id = $province_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $districts[$row['Id']] = $row['Name'];  
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
          SELECT u.id_user, u.first_name, u.last_name, u.username, u.password, u.province_id, p.province_name 
          FROM users u
          JOIN provinces p ON u.province_id = p.id_province
          WHERE u.status_id = 1 
      ";

      $result = mysqli_query($conn, $query);

      if ($result) {

          while ($row = mysqli_fetch_assoc($result)) {
              $users[] = [
                  'id_user'       => $row['id_user'],
                  'first_name'    => $row['first_name'],
                  'last_name'     => $row['last_name'],
                  'username'      => $row['username'],
                  'password'      => $row['password'],
                  'province_id'   => $row['province_id'], 
                  'province_name' => $row['province_name'] 
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
* Saves an specific user into the database
*/
function saveUser($user): bool {
    // Obtiene los datos del usuario
    $conn = getConnection();

    $query = "SELECT Id FROM users ORDER BY Id DESC LIMIT 1";
    // se ejecuta la consulta y el resultado se almacena en la variable result
    $result = $conn->query($query);
    
    // Verificar si el resultado es mayor a 1
    if ($result->num_rows > 0) {
        // Si hay registros, obtener el último Id y sumarle 1
        //fetch_assoc lo convierte en un array asociativo es decir clave y valor para que sea mas facil acceder
        $row = $result->fetch_assoc();
        $nuevoId = $row['Id'] + 1;
    } else {
        // Si no hay registros, el nuevo Id será 1
        $nuevoId = 1;
    }
    $first_name   = $user['first_name'];
    $last_name1   = $user['last_name1'];
    $last_name2   = $user['last_name2'];
    $username     = $user['username'];
    $password     = MD5($user['password']); 
    $district_id  = (int)$user['district']; // Asegúrate de obtener el ID del distrito
    $role         = 2; // Establece el rol Amigo
    $email        = $user['email']; // Correo electrónico
    $phone        = $user['phone']; // Teléfono
    $gender       = $user['gender']; // Género
    $created_at   = date('Y-m-d H:i:s'); // Fecha y hora actuales
    $url_pic      = $user['pic']; 

   
    // Consulta SQL con sentencias preparadas
    $sql = "INSERT INTO users (Id, First_Name, Last_Name1, Last_Name2, Username, Password, Email, Phone, Gender, Profile_Pic, District_Id, Created_At, Role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    try {
        $stmt = $conn->prepare($sql);
        
        // Vincula los parámetros
        $stmt->bind_param("isssssssssisi", $nuevoId, $first_name, $last_name1, $last_name2, $username, $password, $email, $phone, $gender, $url_pic, $district_id, $created_at, $role);
        
        // Ejecuta la consulta
        $stmt->execute();
        
        // Cierra la declaración y la conexión
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        // Manejo de errores
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
function authenticate($username, $password): bool|array|null{
  $conn = getConnection();
  $sql = "SELECT * FROM users WHERE `Username` = '$username' AND `Password` = '$password'";
  $result = $conn->query($sql);

  if ($conn->connect_errno) {
    $conn->close();
    return false;
  }

  $results = $result->fetch_assoc();
  $conn->close();

  return $results;
}