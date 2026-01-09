<?php
/**
 * Display messages from session
 * Include this at the top of pages to show error/success messages
 */

if (isset($_SESSION['message'])) {
    $type = $_SESSION['message_type'] ?? 'error';
    $message = $_SESSION['message'];
    
    echo '
    <div class="message ' . $type . '">
        <span>' . htmlspecialchars($message) . '</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>
    ';
    
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>