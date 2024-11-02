<?php
require '../utils/functions.php';

$uploads_folder = $_SERVER["DOCUMENT_ROOT"]."/uploads/";

if ($_POST && isset($_REQUEST['first_name'])) {
  // Sanitize input fields to avoid malicious input
  $user['first_name'] = trim($_POST['first_name']);
  $user['last_name1'] = trim($_POST['last_name1']);
  $user['last_name2'] = trim($_POST['last_name2']);
  $user['email']      = trim($_POST['email']);
  $user['phone']      = trim($_POST['phone']);
  $user['gender']     = trim($_POST['gender']);
  $user['country']    = trim($_POST['country']);
  $user['province']   = trim($_POST['province']);
  $user['district']   = trim($_POST['district']);
  $user['username']   = trim($_POST['username']);
  $user['password']   = trim($_POST['password']);

  // upload image
  $file_tmp = $_FILES["profilePic"]["tmp_name"];
  $file_name = basename($_FILES["profilePic"]["name"]);
  $target_file = $uploads_folder . $file_name;

  move_uploaded_file($file_tmp,$target_file);

  $user['pic'] = $file_name;

 // Required fields to validate
 $required_fields = ['first_name', 'last_name1', 'email', 'username', 'password', 'province', 'country','district'];

  foreach ($required_fields as $field) {
    if (empty($user[$field])) {
      header("Location: ../signup.php?error=" . urlencode("All fields are required."));
      exit;
    }
  }

  if (emailExists($user['email'])) {
    header("Location: ../signup.php?error=" . urlencode("Email already registered"));
    exit; 
  }
  if (emailExists($user['username'])) {
    header("Location: ../signup.php?error=" . urlencode("User already registered"));
    exit; 
  }
  if (saveUser($user)) {
    header( "Location: ../index.php",);
  } else {
    header("Location: ../signup.php?error=" . urlencode("Invalid user data"));
  }
}