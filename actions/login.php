<?php
  require('../utils/functions.php');

  if($_POST) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $user = authenticate($username, MD5($password));

    if ($user) {
      if ($user['State'] == 1) {

        session_start();
        $_SESSION['Username'] = $user;

        

        if ($user['Role'] == 1) {
          header('Location: ../index.php?error=Admin'); 
        } else {
          header('Location: ../index.php?error=User'); 
        }
      } else {
        header('Location: ../index.php?error=User doesn´t exist');
      }
    } else {
      header('Location: ../index.php?error=error');
    }
  }