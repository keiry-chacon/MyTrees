<?php
  include('utils/functions.php');
  $error_msg = isset($_GET['error']) ? $_GET['error'] : '';
?>
<?php require('inc/header.php')?>
  <div class="container-fluid">
    <div class="jumbotron">
      <h1 class="display-4">Login</h1>
      <p class="lead">User Login</p>
      <hr class="my-4">
    </div>
    <form method="post" action="actions/login.php">
      <div class="error">
        <?php echo $error_msg; ?>
      </div>
      <div class="form-group">
        <label for="email">User</label>
        <input id="email" class="form-control" type="text" name="username">
      </div>
      <div class="form-group"> 
        <label for="password">Password</label>
        <input id="password" class="form-control" type="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary"> Login </button>
    </form>
    <a href="signup.php" class="btn btn-secondary mt-3">Have you not registered yet?</a>
  </div>
<?php require('inc/footer.php');