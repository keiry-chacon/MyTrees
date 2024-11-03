<?php

/*
* Login
*/

  include('utils/functions.php');
  $error_msg = isset($_GET['error']) ? $_GET['error'] : '';
?>
<?php require('inc/header.php') ?>

<section>
  <div class="info-box">
    <h2>Welcome to Tree Haven!</h2>
    <p>Join us in supporting reforestation efforts by buying and selling trees!</p>
    <button onclick="showLoginForm()">Access Login</button>
  </div>

  <div class="form-container" id="form-container">
    <div class="form-box" id="login-form">
      <form method="post" action="actions/login.php">
        <h2>Login</h2>
        <?php if ($error_msg): ?>
          <div class="error"><?php echo $error_msg; ?></div>
        <?php endif; ?>
        <div class="inputbox">
          <input id="email" type="text" name="username" placeholder="Email Address" required>
        </div>
        <div class="inputbox">
          <input id="password" type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit">Login</button>
        <div class="register">
          <p>Not registered yet? <a href="signup.php">Sign Up</a></p>
        </div>
      </form>
    </div>
  </div>
</section>

<link rel="stylesheet" href="css/index.css">
<script>
 function showLoginForm() {
    const formContainer = document.getElementById("form-container");
    formContainer.style.display = "flex"; // Cambia la propiedad de display aquí
    setTimeout(() => {
        formContainer.classList.add("show");
    }, 10); // Espera un poco para que el display flex se aplique antes de agregar la clase
}



</script>
