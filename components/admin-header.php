<?php
// Display admin messages if any
if (isset($_SESSION['message'])) {
    $type = $_SESSION['message_type'] ?? 'error';
    $message = $_SESSION['message'];
    
    echo '
    <div class="message" style="position: fixed; top: 8rem; left: 50%; transform: translateX(-50%); z-index: 10000; max-width: 1200px; width: 90%; margin: 0;">
        <span>' . htmlspecialchars($message) . '</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>
    ';
    
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

// Get admin info
$admin_id = $_SESSION['admin_id'] ?? null;
$admin_name = $_SESSION['admin_name'] ?? 'Admin';
?>

<header class="header">
   <section class="flex">

      <a href="/Soleil-Lune/admin/index.php" class="logo">
         <img src="/Soleil-Lune/assets/images/Soleil_logo.png" alt="Soleil|Lune">
      </a>

      <div style="display: flex; align-items: center; gap: 1rem; margin-left: auto;">
         <span style="font-size: 1.6rem; color: var(--main-color); font-weight: 600;">
            <i class="fas fa-user-shield"></i> Admin Panel
         </span>
      </div>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <nav class="navbar">
         <a href="/Soleil-Lune/admin/index.php"> <i class="fas fa-angle-right"></i> dashboard</a>
         <a href="/Soleil-Lune/admin/posts.php"> <i class="fas fa-angle-right"></i> posts</a>
         <a href="/Soleil-Lune/admin/settings.php"> <i class="fas fa-angle-right"></i> settings</a>
         <a href="/Soleil-Lune/public/index.php"> <i class="fas fa-angle-right"></i> view blog</a>
         <a href="/Soleil-Lune/admin/index.php?action=logout" onclick="return confirm('Logout from admin panel?');"> <i class="fas fa-angle-right"></i> logout</a>
      </nav>

      <div class="profile">
         <?php if($admin_id): ?>
            <p class="name"><?= htmlspecialchars($admin_name) ?></p>
            <p style="font-size: 1.4rem; color: var(--light-color); padding-bottom: 1rem;">Administrator</p>
            <div class="flex-btn">
               <a href="/Soleil-Lune/admin/posts.php" class="option-btn">manage posts</a>
               <a href="/Soleil-Lune/admin/settings.php" class="option-btn">settings</a>
            </div>
            <a href="/Soleil-Lune/admin/index.php?action=logout" onclick="return confirm('logout from admin panel?');" class="delete-btn">logout</a>
         <?php endif; ?>
      </div>

   </section>
</header>