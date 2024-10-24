<?php
require('../utils/functions.php');

if ($_POST) {
    $login    = $_REQUEST['username']; 
    $password = $_REQUEST['password'];

    $user = authenticate($login, $password);

    if ($user) {
        session_start();
        $_SESSION['Username']     = $user['username'];
        $_SESSION['ProfileImage'] = $user['profile_pic'];
        $_SESSION['Role_id']      = $user['role_id']; 

        if ($user['role_id'] == 1) {
            header('Location: ../administrator/admin.php'); 
            exit();
        } else if ($user['role_id'] == 2) {
            header('Location: ../friend/friend.php'); 
            exit();
        }
        
    } else {
        header('Location: ../index.php?error=Invalid credentials');
        exit();
    }
}
