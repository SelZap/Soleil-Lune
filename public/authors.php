<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Get all authors with their stats
$stmt = $conn->prepare("SELECT * FROM admin");
$stmt->execute();
$authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Authors - Soleil|Lune</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/style.css">
   <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
</head>

<body>
   
<?php include '../components/header.php'; ?>

<section class="authors">

   <h1 class="heading">authors</h1>

   <div class="box-container">

   <?php
      if(count($authors) > 0){
         foreach($authors as $author){ 

            $count_posts = $conn->prepare("SELECT COUNT(*) FROM posts WHERE admin_id = ? AND status = 'active'");
            $count_posts->execute([$author['id']]);
            $total_posts = $count_posts->fetchColumn();

            $count_likes = $conn->prepare("SELECT COUNT(*) FROM likes WHERE admin_id = ?");
            $count_likes->execute([$author['id']]);
            $total_likes = $count_likes->fetchColumn();

            $count_comments = $conn->prepare("SELECT COUNT(*) FROM comments WHERE admin_id = ?");
            $count_comments->execute([$author['id']]);
            $total_comments = $count_comments->fetchColumn();

   ?>
   <div class="box">
      <p>author : <span><?php echo htmlspecialchars($author['name']); ?></span></p>
      <p>total posts : <span><?php echo $total_posts; ?></span></p>
      <p>posts likes : <span><?php echo $total_likes; ?></span></p>
      <p>posts comments : <span><?php echo $total_comments; ?></span></p>
      <a href="/Soleil-Lune/public/posts.php?author=<?php echo urlencode($author['name']); ?>" class="btn">view posts</a>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no authors found</p>';
   }
   ?>

   </div>
      
</section>

<div class="footer">
   <p>&copy; 2026 <span>Soleil|Lune</span> | All Rights Reserved</p>
</div>

<script src="/Soleil-Lune/assets/js/script.js"></script>

</body>
</html>