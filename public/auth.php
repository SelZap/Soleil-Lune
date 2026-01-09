<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

$action = $_GET['action'] ?? 'login';

// Handle logout
if ($action == 'logout') {
    logout(false);
}

// Handle login form submission
if ($action == 'login' && isset($_POST['submit'])) {
    $email = sanitize($_POST['email']);
    $password = $_POST['pass'];
    
    if (login($email, $password, false)) {
        header('Location: /Soleil-Lune/public/index.php');
        exit();
    } else {
        setMessage('Incorrect email or password!');
    }
}

// Handle registration form submission
if ($action == 'register' && isset($_POST['submit'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['pass'];
    $confirmPassword = $_POST['cpass'];
    
    $result = register($name, $email, $password, $confirmPassword);
    
    if ($result['success']) {
        header('Location: /Soleil-Lune/public/index.php');
        exit();
    } else {
        setMessage($result['message']);
    }
}

// Display login form
if ($action == 'login'):
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/favicon.ico">
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/style.css">
</head>
<body>
   
<?php include '../components/header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" name="submit" class="btn">
      <p>don't have an account? <a href="?action=register">register now</a></p>
   </form>

</section>

<script src="/Soleil-Lune/assets/js/script.js"></script>

</body>
</html>

<?php elseif ($action == 'register'): ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/favicon.ico">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/style.css">
   <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
</head>
<body>
   
<?php include '../components/header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirm your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" name="submit" class="btn">
      <p>already have an account? <a href="?action=login">login now</a></p>
   </form>

</section>

<script src="/Soleil-Lune/assets/js/script.js"></script>

</body>
</html>
<?php endif; ?>