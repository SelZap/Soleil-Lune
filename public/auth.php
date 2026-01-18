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
        $_SESSION['auth_error'] = 'Incorrect email or password! Please check your credentials and try again.';
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
        $_SESSION['auth_error'] = $result['message'];
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
   <title>Login - Soleil|Lune</title>
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/header.css">
   <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
   
   <style>
      body {
         padding-bottom: 7rem;
      }
      
      .auth-error-message {
         position: fixed;
         top: 10rem;
         left: 50%;
         transform: translateX(-50%);
         z-index: 10001;
         max-width: 55rem;
         width: 90%;
         background: linear-gradient(135deg, #FFE5E5 0%, #FFD5D5 100%);
         padding: 2rem 2.5rem;
         display: flex;
         align-items: center;
         gap: 1.5rem;
         justify-content: space-between;
         border-radius: 1.2rem;
         box-shadow: 0 .8rem 2rem rgba(216, 155, 155, 0.3);
         border: .2rem solid #D89B9B;
         animation: errorSlide 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      }
      
      @keyframes errorSlide {
         0% {
            opacity: 0;
            transform: translate(-50%, -4rem) scale(0.9);
         }
         60% {
            transform: translate(-50%, 0.5rem) scale(1.02);
         }
         100% {
            opacity: 1;
            transform: translate(-50%, 0) scale(1);
         }
      }
      
      .auth-error-message .error-content {
         display: flex;
         align-items: center;
         gap: 1.5rem;
         flex: 1;
      }
      
      .auth-error-message .error-icon {
         font-size: 3rem;
         color: #C75B5B;
         animation: shake 0.5s ease;
      }
      
      @keyframes shake {
         0%, 100% { transform: translateX(0); }
         25% { transform: translateX(-5px); }
         75% { transform: translateX(5px); }
      }
      
      .auth-error-message .error-text {
         font-size: 1.8rem;
         color: #8B4545;
         font-weight: 600;
         line-height: 1.5;
      }
      
      .auth-error-message .close-error {
         font-size: 2.8rem;
         color: #C75B5B;
         cursor: pointer;
         transition: all 0.3s ease;
         background: none;
         border: none;
         padding: 0;
         width: 3.5rem;
         height: 3.5rem;
         display: flex;
         align-items: center;
         justify-content: center;
         border-radius: 50%;
      }
      
      .auth-error-message .close-error:hover {
         background-color: rgba(199, 91, 91, 0.1);
         color: #8B4545;
         transform: rotate(90deg);
      }
      
      .form-container {
         margin-top: 3rem;
      }
   </style>
</head>
<body>
   
<?php include '../components/header.php'; ?>

<?php 
// Display auth error message if exists (using separate session variable)
if (isset($_SESSION['auth_error'])) {
    $errorMsg = $_SESSION['auth_error'];
    echo '<div class="auth-error-message">
            <div class="error-content">
               <i class="fas fa-exclamation-triangle error-icon"></i>
               <span class="error-text">' . htmlspecialchars($errorMsg) . '</span>
            </div>
            <button class="close-error" onclick="this.parentElement.style.display=\'none\';">
               <i class="fas fa-times"></i>
            </button>
          </div>';
    unset($_SESSION['auth_error']);
}
?>

<section class="form-container">
   <form action="" method="post">
      <h3>login now</h3>
      
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" name="submit" class="btn">
      <p>don't have an account? <a href="?action=register">register now</a></p>
   </form>
</section>

<div class="footer">
   <p>&copy; 2026 <span>Soleil|Lune</span> | All Rights Reserved</p>
</div>

<script src="/Soleil-Lune/assets/js/script.js"></script>

<script>
// Auto-hide error message after 6 seconds
setTimeout(function() {
   const errorMsg = document.querySelector('.auth-error-message');
   if(errorMsg) {
      errorMsg.style.opacity = '0';
      errorMsg.style.transform = 'translate(-50%, -3rem)';
      setTimeout(() => errorMsg.remove(), 400);
   }
}, 6000);
</script>

</body>
</html>

<?php elseif ($action == 'register'): ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register - Soleil|Lune</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/header.css">
   <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
   
   <style>
      body {
         padding-bottom: 7rem;
      }
      
      .auth-error-message {
         position: fixed;
         top: 10rem;
         left: 50%;
         transform: translateX(-50%);
         z-index: 10001;
         max-width: 55rem;
         width: 90%;
         background: linear-gradient(135deg, #FFE5E5 0%, #FFD5D5 100%);
         padding: 2rem 2.5rem;
         display: flex;
         align-items: center;
         gap: 1.5rem;
         justify-content: space-between;
         border-radius: 1.2rem;
         box-shadow: 0 .8rem 2rem rgba(216, 155, 155, 0.3);
         border: .2rem solid #D89B9B;
         animation: errorSlide 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      }
      
      @keyframes errorSlide {
         0% {
            opacity: 0;
            transform: translate(-50%, -4rem) scale(0.9);
         }
         60% {
            transform: translate(-50%, 0.5rem) scale(1.02);
         }
         100% {
            opacity: 1;
            transform: translate(-50%, 0) scale(1);
         }
      }
      
      .auth-error-message .error-content {
         display: flex;
         align-items: center;
         gap: 1.5rem;
         flex: 1;
      }
      
      .auth-error-message .error-icon {
         font-size: 3rem;
         color: #C75B5B;
         animation: shake 0.5s ease;
      }
      
      @keyframes shake {
         0%, 100% { transform: translateX(0); }
         25% { transform: translateX(-5px); }
         75% { transform: translateX(5px); }
      }
      
      .auth-error-message .error-text {
         font-size: 1.8rem;
         color: #8B4545;
         font-weight: 600;
         line-height: 1.5;
      }
      
      .auth-error-message .close-error {
         font-size: 2.8rem;
         color: #C75B5B;
         cursor: pointer;
         transition: all 0.3s ease;
         background: none;
         border: none;
         padding: 0;
         width: 3.5rem;
         height: 3.5rem;
         display: flex;
         align-items: center;
         justify-content: center;
         border-radius: 50%;
      }
      
      .auth-error-message .close-error:hover {
         background-color: rgba(199, 91, 91, 0.1);
         color: #8B4545;
         transform: rotate(90deg);
      }
      
      .form-container {
         margin-top: 3rem;
      }
   </style>
</head>
<body>
   
<?php include '../components/header.php'; ?>

<?php 
// Display auth error message if exists (using separate session variable)
if (isset($_SESSION['auth_error'])) {
    $errorMsg = $_SESSION['auth_error'];
    echo '<div class="auth-error-message">
            <div class="error-content">
               <i class="fas fa-exclamation-triangle error-icon"></i>
               <span class="error-text">' . htmlspecialchars($errorMsg) . '</span>
            </div>
            <button class="close-error" onclick="this.parentElement.style.display=\'none\';">
               <i class="fas fa-times"></i>
            </button>
          </div>';
    unset($_SESSION['auth_error']);
}
?>

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

<div class="footer">
   <p>&copy; 2026 <span>Soleil|Lune</span> | All Rights Reserved</p>
</div>

<script src="/Soleil-Lune/assets/js/script.js"></script>

<script>
// Auto-hide error message after 6 seconds
setTimeout(function() {
   const errorMsg = document.querySelector('.auth-error-message');
   if(errorMsg) {
      errorMsg.style.opacity = '0';
      errorMsg.style.transform = 'translate(-50%, -3rem)';
      setTimeout(() => errorMsg.remove(), 400);
   }
}, 6000);
</script>

</body>
</html>
<?php endif; ?>