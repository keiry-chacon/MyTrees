<?php
  require('../utils/functions.php');

  if($_POST) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $user = authenticate($username, MD5($password));

    if ($user) {
      if ($user['State'] == 1) {

        session_start();
        $_SESSION['Username']     = $user['Username'];
        $_SESSION['ProfileImage'] = $user['Profile_Pic']; 

        

        if ($user['Role'] == 1) {
          header('Location: ../admin.php'); 
          exit();
        } else if($user['Role'] == 2) {
          header('Location: ../friend.php'); 
          exit();
        }
      } else {
        header('Location: ../index.php?error=User doesn´t exist');
        exit();
      }
    } else {
      header('Location: ../index.php?error');
      exit();
    }
  }