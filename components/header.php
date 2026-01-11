<?php
// Display messages if any
if (isset($_SESSION['message'])) {
    $type = $_SESSION['message_type'] ?? 'error';
    $message = $_SESSION['message'];
    
    echo '
    <div class="message">
        <span>' . htmlspecialchars($message) . '</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>
    ';
    
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<header class="header">
   <section class="flex">

      <a href="/Soleil-Lune/public/index.php" class="logo">
         <img src="/Soleil-Lune/assets/images/Soleil_logo.png" alt="Soleil|Lune">
      </a>

      <form action="/Soleil-Lune/public/posts.php" method="GET" class="search-form">
         <input type="text" name="search" class="box" maxlength="100" placeholder="search for blogs" required>
         <button type="submit" class="fas fa-search"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="chatbot-btn" class="fas fa-comments"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <nav class="navbar">
         <a href="/Soleil-Lune/public/index.php"> <i class="fas fa-angle-right"></i> home</a>
         <a href="/Soleil-Lune/public/posts.php"> <i class="fas fa-angle-right"></i> posts</a>
         <a href="/Soleil-Lune/public/categories.php"> <i class="fas fa-angle-right"></i> categories</a>
         <a href="/Soleil-Lune/public/authors.php"> <i class="fas fa-angle-right"></i> authors</a>
         <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/Soleil-Lune/public/profile.php"> <i class="fas fa-angle-right"></i> profile</a>
            <a href="/Soleil-Lune/public/auth.php?action=logout"> <i class="fas fa-angle-right"></i> logout</a>
         <?php else: ?>
            <a href="/Soleil-Lune/public/auth.php?action=login"> <i class="fas fa-angle-right"></i> login</a>
         <?php endif; ?>
      </nav>

      <div class="profile">
         <?php if(isset($_SESSION['user_id'])): ?>
            <?php
               $user_id = $_SESSION['user_id'];
               $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
               $stmt->execute([$user_id]);
               $user = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <p class="name"><?= htmlspecialchars($user['name']) ?></p>
            <a href="/Soleil-Lune/public/profile.php" class="btn">update profile</a>
            <div class="flex-btn">
               <a href="/Soleil-Lune/public/profile.php?tab=likes" class="option-btn">likes</a>
               <a href="/Soleil-Lune/public/profile.php?tab=comments" class="option-btn">comments</a>
            </div> 
            <a href="/Soleil-Lune/public/auth.php?action=logout" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         <?php else: ?>
            <p class="name">please login first!</p>
            <a href="/Soleil-Lune/public/auth.php?action=login" class="option-btn">login</a>
         <?php endif; ?>
      </div>

   </section>
</header>

<!-- Chatbot (placed AFTER header closes) -->
<div class="chatbot-overlay"></div>
<div class="chatbot-window">
   <div class="chatbot-header">
      <div class="chatbot-header-info">
         <div class="chatbot-avatar">🌙</div>
         <div>
            <h3>Ami</h3>
            <p>Online • Ready to help!</p>
         </div>
      </div>
      <button class="chatbot-close"><i class="fas fa-times"></i></button>
   </div>
   <div class="chatbot-messages"></div>
   <div class="chatbot-input-area">
      <input type="text" class="chatbot-input" placeholder="Type your message...">
      <button class="chatbot-send"><i class="fas fa-paper-plane"></i></button>
   </div>
</div>

<link rel="stylesheet" href="/Soleil-Lune/assets/css/chatbot.css">
<script src="/Soleil-Lune/assets/js/chatbot.js"></script>