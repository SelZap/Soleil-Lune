<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/style.css">
   <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">

</head>
<body style="padding-left: 0 !important;">

<?php getMessage(); ?>

<section class="form-container">

   <form action="" method="POST">
      <h3>Admin Login</h3>
      <p>Default username = <span>admin</span> & password = <span>111</span></p>
      <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" name="submit" class="btn">
   </form>

</section>

<script src="/Soleil-Lune/assets/js/script.js"></script>

</body>
</html>