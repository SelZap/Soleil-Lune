<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/like_post.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>category</title>
   <link rel="icon" type="image/x-icon" href="fav/sm.ico">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>



<section class="categories">

   <h1 class="heading">post categories</h1>

   <div class="box-container">
      <div class="box"><span>01</span><a href="category.php?category=travels">travels</a></div>
      <div class="box"><span>02</span><a href="category.php?category=eduction">education</a></div>
      <div class="box"><span>03</span><a href="category.php?category=fashion,style,shopping">fashion,style,shopping</a></div>
      <div class="box"><span>04</span><a href="category.php?category=life lately">life lately</a></div>
      <div class="box"><span>05</span><a href="category.php?category=entertainment">entertainment</a></div>
      <div class="box"><span>06</span><a href="category.php?category=movies">movies</a></div>
      <div class="box"><span>07</span><a href="category.php?category=gaming">gaming</a></div>
      <div class="box"><span>08</span><a href="category.php?category=music">music</a></div>

   </div>

</section>


<script src="js/script.js"></script>

</body>
</html>