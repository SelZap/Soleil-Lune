<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login - Soleil|Lune</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
   <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
   
   <style>
      body {
         background: linear-gradient(135deg, #FFF9F0 0%, #FFE5E5 100%);
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
      }
      
      .form-container form {
         max-width: 50rem;
         background: var(--white);
         box-shadow: 0 1rem 3rem rgba(0,0,0,.15);
      }
      
      .admin-badge {
         display: inline-block;
         background: linear-gradient(135deg, var(--main-color), var(--orange));
         color: var(--white);
         padding: 0.8rem 2rem;
         border-radius: 3rem;
         font-size: 1.4rem;
         margin-bottom: 2rem;
         font-weight: 600;
      }
   </style>
</head>
<body>

<?php getMessage(); ?>

<section class="form-container">
   <form action="" method="POST">
      <div class="admin-badge">
         <i class="fas fa-shield-alt"></i> Admin Access
      </div>
      
      <h3>Admin Login</h3>
      
      <p style="font-size: 1.5rem; color: var(--light-color); margin-bottom: 2rem;">
         Enter your admin credentials to continue
      </p>
      
      <input type="text" name="email" maxlength="100" required 
             placeholder="Admin identifier (e.g., Admin_Crissel_Zapatero_001)" class="box">
             
      <input type="password" name="pass" maxlength="20" required 
             placeholder="Password (8 digits)" class="box" 
             oninput="this.value = this.value.replace(/\s/g, '')">
             
      <input type="submit" value="Login Now" name="submit" class="btn">
      
      <div style="margin-top: 2rem; padding-top: 2rem; border-top: var(--border);">
         <a href="/Soleil-Lune/public/index.php" style="color: var(--main-color); font-size: 1.5rem;">
            <i class="fas fa-arrow-left"></i> Back to Blog
         </a>
      </div>
   </form>
</section>

<script src="/Soleil-Lune/assets/js/script.js"></script>

</body>
</html>