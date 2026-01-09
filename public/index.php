<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Soleil | Lune - Home</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/public.css">
   <link rel="stylesheet" href="/Soleil-Lune/assets/css/header.css">
   <link rel="icon" type="image/x-icon" href="/Soleil-Lune/assets/images/Soleil.ico">
</head>
<body>
   
<?php include '../components/header.php'; ?>

<section class="posts-container">

   <h1 class="heading">latest posts</h1>

   <div class="box-container">

      <?php
         $stmt = $conn->prepare("SELECT * FROM posts WHERE status = 'active' ORDER BY date DESC LIMIT 6");
         $stmt->execute();
         
         if($stmt->rowCount() > 0){
            while($post = $stmt->fetch(PDO::FETCH_ASSOC)){
               
               $post_id = $post['id'];

               $comment_stmt = $conn->prepare("SELECT COUNT(*) FROM comments WHERE post_id = ?");
               $comment_stmt->execute([$post_id]);
               $comment_count = $comment_stmt->fetchColumn();

               $like_stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
               $like_stmt->execute([$post_id]);
               $like_count = $like_stmt->fetchColumn();
               
               $liked = false;
               if($user_id){
                  $check_like = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
                  $check_like->execute([$user_id, $post_id]);
                  $liked = $check_like->rowCount() > 0;
               }
               
               // Truncate content
               $content = $post['content'];
               if(strlen($content) > 150){
                  $content = substr($content, 0, 150) . '...';
               }
      ?>
      <div class="box">
         <div class="post-admin">
            <i class="fas fa-user"></i>
            <div>
               <a href="/Soleil-Lune/public/posts.php?author=<?php echo urlencode($post['name']); ?>"><?php echo htmlspecialchars($post['name']); ?></a>
               <div><?php echo date('M j, Y', strtotime($post['date'])); ?></div>
            </div>
         </div>
         
         <?php if(!empty($post['image'])): ?>
         <img src="/Soleil-Lune/assets/uploads/<?php echo htmlspecialchars($post['image']); ?>" class="post-image" alt="">
         <?php endif; ?>
         
         <div class="post-title"><?php echo htmlspecialchars($post['title']); ?></div>
         <div class="post-content content-150"><?php echo htmlspecialchars($content); ?></div>
         <a href="/Soleil-Lune/public/post.php?id=<?php echo $post_id; ?>" class="inline-btn">read more</a>
         <a href="/Soleil-Lune/public/posts.php?category=<?php echo urlencode($post['category']); ?>" class="post-cat">
            <i class="fas fa-tag"></i> <span><?php echo htmlspecialchars($post['category']); ?></span>
         </a>
         <div class="icons">
            <a href="/Soleil-Lune/public/post.php?id=<?php echo $post_id; ?>">
               <i class="fas fa-comment"></i><span>(<?php echo $comment_count; ?>)</span>
            </a>
            <form method="post" action="/Soleil-Lune/public/post.php?id=<?php echo $post_id; ?>" style="display:inline;">
               <button type="submit" name="like_post" style="background:none;border:none;cursor:pointer;">
                  <i class="fas fa-heart" style="<?php echo $liked ? 'color:var(--red);' : ''; ?>"></i>
                  <span>(<?php echo $like_count; ?>)</span>
               </button>
            </form>
         </div>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">no posts added yet!</p>';
         }
      ?>
   </div>

   <div class="more-btn" style="text-align: center; margin-top:2rem;">
      <a href="/Soleil-Lune/public/posts.php" class="inline-btn">view all posts</a>
   </div>

</section>

<div class="footer">
   <p>&copy; 2026 <span>Soleil|Lune</span> | All Rights Reserved</p>
</div>

<script src="/Soleil-Lune/assets/js/script.js"></script>

</body>
</html>