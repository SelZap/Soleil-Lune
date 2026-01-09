<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Get all unique categories with post counts
$stmt = $conn->prepare("SELECT category, COUNT(*) as count FROM posts WHERE status = 'active' GROUP BY category ORDER BY category");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Categories - Soleil|Lune</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/header.css">
   <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
</head>
<body>
   
<?php include '../components/header.php'; ?>

<section class="categories">

   <h1 class="heading">post categories</h1>

   <div class="box-container">
      <?php 
         $counter = 1;
         foreach($categories as $cat): 
      ?>
      <div class="box">
         <span><?php echo str_pad($counter, 2, '0', STR_PAD_LEFT); ?></span>
         <a href="/Soleil-Lune/public/posts.php?category=<?php echo urlencode($cat['category']); ?>">
            <?php echo htmlspecialchars($cat['category']); ?> (<?php echo $cat['count']; ?>)
         </a>
      </div>
      <?php 
         $counter++;
         endforeach; 
      ?>
      
      <?php if(empty($categories)): ?>
         <p class="empty">no categories found</p>
      <?php endif; ?>
   </div>

</section>

<div class="footer">
   <p>&copy; 2026 <span>Soleil|Lune</span> | All Rights Reserved</p>
</div>

<script src="/Soleil-Lune/assets/js/script.js"></script>

</body>
</html>