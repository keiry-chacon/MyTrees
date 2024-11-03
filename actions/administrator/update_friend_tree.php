<?php

/*
* Update the information of a friend's tree
*/

include('../../utils/administrator/admin_functions.php');

$uploads_folder = $_SERVER["DOCUMENT_ROOT"]."/uploads_tree/";

$error_msg = '';

if ($_POST && isset($_POST['specie_id'])) {
  $id_tree              = (int)$_POST['id'];
  $tree['specie_id']    = trim($_POST['specie_id']); 
  $tree['location']     = trim($_POST['location']);
  $tree['size']         = trim($_POST['size']);
  $tree['statusT']      = trim($_POST['statusT']);
  
  if (updateFriendTree($tree, $id_tree)) {
    header("Location: ../../administrator/manage_friends.php");
  } else {
    header("Location: ../../administrator/update_friend_tree.php?error=" . urlencode("Invalid tree data"));
  }
} else {
  header("Location: ../../administrator/update_friend_tree.php?error=" . urlencode("Invalid request."));
}
?>
