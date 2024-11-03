<?php

/*
* Log Out
*/

  session_start();
  session_destroy();
  header('Location: ../index.php');