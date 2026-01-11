CREATE DATABASE IF NOT EXISTS soleil_lune_db;
USE soleil_lune_db;

-- Users Table (Unified for both Regular Users and Admins)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    profile_pic VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Posts Table
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50),
    image VARCHAR(255),
    status ENUM('active', 'hidden') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Comments Table
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Anti-Bullying Reports Table (New for Moderation)
CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reporter_id INT NOT NULL,
    post_id INT,
    comment_id INT,
    reason TEXT NOT NULL,
    status ENUM('pending', 'resolved') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reporter_id) REFERENCES users(id)
);

-- Chatbot Database
-- Ami Chatbot Database Schema for Soleil|Lune

DROP TABLE IF EXISTS chatbot_patterns;
DROP TABLE IF EXISTS chatbot_conversations;
DROP TABLE IF EXISTS chatbot_intents;

-- Menu-based navigation table
CREATE TABLE IF NOT EXISTS chatbot_menu (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `parent_id` INT DEFAULT NULL,
  `button_text` VARCHAR(100) NOT NULL,
  `response_text` TEXT NOT NULL,
  `has_children` BOOLEAN DEFAULT FALSE,
  `link_url` VARCHAR(255) DEFAULT NULL,
  `display_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`parent_id`) REFERENCES `chatbot_menu`(`id`) ON DELETE CASCADE,
  INDEX idx_parent (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Rule-based queries table
CREATE TABLE IF NOT EXISTS chatbot_rules (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `menu_id` INT DEFAULT NULL,
  `keywords` TEXT NOT NULL,
  `response_text` TEXT NOT NULL,
  `button_text` VARCHAR(100) DEFAULT NULL,
  `button_link` VARCHAR(255) DEFAULT NULL,
  `priority` INT DEFAULT 5,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`menu_id`) REFERENCES `chatbot_menu`(`id`) ON DELETE SET NULL,
  INDEX idx_menu (`menu_id`),
  INDEX idx_priority (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Conversation history
CREATE TABLE IF NOT EXISTS chatbot_conversations (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT DEFAULT NULL,
  `session_id` VARCHAR(100) NOT NULL,
  `user_message` TEXT NOT NULL,
  `bot_response` TEXT NOT NULL,
  `response_type` ENUM('menu', 'rule', 'default') DEFAULT 'rule',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  INDEX idx_session (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert main menu items 
INSERT INTO chatbot_menu (id, parent_id, button_text, response_text, link_url, has_children, display_order) VALUES
(1, NULL, 'Account & Profile', 'What would you like to know about accounts and profiles?', NULL, 1, 1),
(2, NULL, 'Post Rules', 'What would you like to know about posting?', NULL, 1, 2),
(3, NULL, 'Comment Rules', 'What would you like to know about commenting?', NULL, 1, 3),
(4, NULL, 'Warnings & Bans', 'What would you like to know about warnings and bans?', NULL, 1, 4),
(5, NULL, 'Find People', 'What would you like to know about finding people?', NULL, 1, 5);

-- Account & Profile submenu 
INSERT INTO chatbot_menu (parent_id, button_text, response_text, link_url, has_children, display_order) VALUES
(1, 'Personalize Account', 'You can personalize your account by updating your profile information, changing your display name, and customizing your preferences in the profile settings.', '/Soleil-Lune/public/profile.php', 0, 1),
(1, 'Business Account', 'Users can post contents of their business but unfortunately, Soleil|Lune does not have a direct message feature. Instead, business owners who post contents of their store can include their whatsapp or viber account to continue the sales talk.', NULL, 0, 2);

-- Post Rules submenu 
INSERT INTO chatbot_menu (parent_id, button_text, response_text, link_url, has_children, display_order) VALUES
(2, 'Post Format', 'Posts should include a clear title and content. You can also add images to make your post more engaging. Keep your posts respectful and relevant to the community.', NULL, 0, 1),
(2, 'Choosing Category', 'You can choose a category from the category selection that will be presented to you upon post creation. Categories include travels, education, fashion, entertainment, gaming, music, and more.', '/Soleil-Lune/public/categories.php', 0, 2),
(2, 'Post Limit', 'You can post as much as you like! There is no daily limit on how many posts you can create. Just make sure each post follows our community guidelines.', NULL, 0, 3),
(2, 'Delete Post', 'To delete your post, go to your post page and click the delete button. Note that only admins can delete posts. Regular users can report posts that violate guidelines.', NULL, 0, 4),
(2, 'Content Removal', 'Content that violates our guidelines will be removed. This includes hate speech, spam, harassment, and inappropriate content. Our anti-hate system helps keep the community safe.', NULL, 0, 5);

-- Comment Rules submenu 
INSERT INTO chatbot_menu (parent_id, button_text, response_text, link_url, has_children, display_order) VALUES
(3, 'How to Comment', 'To comment on a post, you need to be logged in. Navigate to any post and scroll down to the comment section. Type your comment and click "Add Comment".', '/Soleil-Lune/public/auth.php?action=login', 0, 1),
(3, 'Comment Guidelines', 'Comments should be respectful and relevant to the post. Hate speech, spam, and harassment are not allowed. Keep discussions constructive and friendly.', NULL, 0, 2),
(3, 'Delete Comment', 'You can delete your own comments by clicking the delete button next to your comment. You cannot delete other users comments unless you are an admin.', NULL, 0, 3);

-- Warnings & Bans submenu 
INSERT INTO chatbot_menu (parent_id, button_text, response_text, link_url, has_children, display_order) VALUES
(4, 'Why Get Warned', 'You may receive a warning for violating community guidelines, posting inappropriate content, harassment, or spam. Warnings are meant to help you understand the rules.', NULL, 0, 1),
(4, 'Ban Duration', 'Ban durations vary based on the severity of the violation. First offenses may result in temporary bans, while repeat violations can lead to permanent bans.', NULL, 0, 2),
(4, 'Appeal Process', 'If you believe you were banned unfairly, you can contact the administrators to appeal your ban. Provide clear reasoning and evidence to support your appeal.', NULL, 0, 3);

-- Find People submenu 
INSERT INTO chatbot_menu (parent_id, button_text, response_text, link_url, has_children, display_order) VALUES
(5, 'Search Users', 'You can find people by using the search feature. Search for users by their name or browse through recent posts to discover content creators.', NULL, 0, 1),
(5, 'View Authors', 'Check out all content creators on our Authors page. You can see their post count, likes, and comments, then view all their posts.', '/Soleil-Lune/public/authors.php', 0, 2),
(5, 'Follow Users', 'While we dont have a direct follow feature yet, you can bookmark your favorite authors by visiting their profile pages regularly or searching for their names.', NULL, 0, 3);


-- Insert rule-based responses into chatbot_rules table

-- Greetings and common phrases
INSERT INTO chatbot_rules (menu_id, keywords, response_text, button_text, button_link, priority) VALUES
(NULL, 'hello|hi|hey|bonjour|hola|greetings|good morning|good afternoon|good evening', 'Bonjour! I''m Ami, your friendly Soleil|Lune assistant! How can I help you today?', NULL, NULL, 10),
(NULL, 'bye|goodbye|see you|au revoir|cya|later|gotta go|exit', 'Au revoir! 🌙 Feel free to come back anytime you need help. Have a wonderful day!', NULL, NULL, 10),
(NULL, 'thanks|thank you|merci|thx|ty|appreciate|grateful', 'You''re very welcome! I''m always here to help!', NULL, NULL, 10);

-- Account & Profile (menu_id = 1)
INSERT INTO chatbot_rules (menu_id, keywords, response_text, button_text, button_link, priority) VALUES
(1, 'personalize|customize|change profile|edit profile|update profile|profile picture', 'You can personalize your account in the profile button. There, you will see a pen-like button next to your profile picture where you can change your profile picture.', 'Update Profile', '/Soleil-Lune/public/profile.php', 8),
(1, 'business|business account|sell|selling|store|shop', 'Users can post contents of their business but unfortunately, Soleil | Lune does not have a direct message feature. Instead, business owners can include their whatsapp or viber account.', 'Create Post', '/Soleil-Lune/public/posts.php', 7);

-- Post Rules (menu_id = 2)
INSERT INTO chatbot_rules (menu_id, keywords, response_text, button_text, button_link, priority) VALUES
(2, 'post format|how to post|posting|upload|what can i post|post type', 'You can post images (jpeg, jpg, png) and videos (mp4) with description. However, there is a maximum of 5 images or 5 videos per post.', 'Create Post', '/Soleil-Lune/public/posts.php', 7),
(2, 'category|categories|tag|tags|choose category|select category', 'You can choose a category from the category selection that will be presented to you upon post creation.', 'View Categories', '/Soleil-Lune/public/categories.php', 7),
(2, 'post limit|how many posts|post maximum|posting limit|limit post', 'You can post as much as you like!', 'Start Posting', '/Soleil-Lune/public/posts.php', 7),
(2, 'delete post|remove post|delete my post|how to delete', 'You can delete your post by clicking your post and selecting delete.', 'View My Posts', '/Soleil-Lune/public/profile.php', 7),
(2, 'post removed|why removed|why was my post removed|post deleted', 'Your post must''ve violated our strict rules for keeping Soleil | Lune safe and hate post/comments free.', NULL, NULL, 8),
(2, 'content removal|remove content|deleted content|removed post', 'Contents that violate the rules and regulation of Soleil | Lune will receive a warning and the content will automatically be removed.', NULL, NULL, 8);

-- Comment Rules (menu_id = 3)
INSERT INTO chatbot_rules (menu_id, keywords, response_text, button_text, button_link, priority) VALUES
(3, 'comment rules|commenting rules|comment guidelines|can i swear|profanity', 'Hurtful, harmful, and swearing are STRICTLY not allowed! Please follow the rules in keeping a safe environment for each users.', NULL, NULL, 9),
(3, 'report|reporting|how to report|report post|report comment|flag', 'You can report any post or comment you believe breaks our rules, and our moderation team will review it carefully and take action if needed.', NULL, NULL, 8),
(3, 'comment removed|why removed comment|why was my comment removed|comment deleted', 'Your comment must''ve violated our strict rules for keeping Soleil | Lune safe and hate post/comments free.', NULL, NULL, 8);

-- Warnings & Bans (menu_id = 4)
INSERT INTO chatbot_rules (menu_id, keywords, response_text, button_text, button_link, priority) VALUES
(4, 'warning|warnings|strikes|how many warnings|three strikes', 'On Soleil | Lune, you can receive up to three warnings and each one is sent to your email with a chance to appeal by replying, but a fourth violation will result in a ban.', NULL, NULL, 9),
(4, 'appeal|dispute|contest warning|disagree|unfair|challenge warning', 'You can appeal for a warning or report upon receiving the warning in your email. You can reply to the email with your appeal with an explanation.', NULL, NULL, 8),
(4, 'warning reset|warnings reset|do warnings reset|clear warnings|expire', 'Each user has 3 maximum warnings and the 4th will result in an account ban. Warnings, however, are reset every 6 months.', NULL, NULL, 8),
(4, 'permanent ban|perma ban|forever ban|permanently banned|banned forever', 'A permanent ban means your account has been permanently removed for repeated or severe rule violations.', NULL, NULL, 9),
(4, 'banned|new account|create account|banned account|make new|after ban', 'Banned users are not allowed to create new accounts, and any attempts to do so may result in immediate removal.', NULL, NULL, 8),
(4, 'hate speech|criticism|difference|confused|what is hate speech|vs criticism', 'Hate speech attacks or uses derogatory language. Criticism expresses disapproval based on perceived faults. Share your thoughts in a nice way on Soleil | Lune.', NULL, NULL, 9),
(4, 'mute|muted|get muted|warning mute|ban|automatic ban', 'Soleil | Lune does not support a mute feature. Warnings are only sent to the user and will result in content removal. Being warned 4 times will result in a ban.', NULL, NULL, 8),
(4, 'restricted|restriction|account restricted|limited|temporarily limited', 'If your account is restricted, certain actions are temporarily limited due to a rule violation. You''ll receive an email explaining what happened and how to appeal.', NULL, NULL, 8),
(4, 'view content|suspended|restricted|can i view|still see|while suspended', 'Yes, you can still view content while your account is suspended or restricted, but actions like posting or commenting may be temporarily disabled.', NULL, NULL, 7);

-- Find People (menu_id = 5)
INSERT INTO chatbot_rules (menu_id, keywords, response_text, button_text, button_link, priority) VALUES
(5, 'find people|search people|find users|discover|content creators', 'You can find new people, content creators, and business owners in the search button at the home page.', 'Search Now', '/Soleil-Lune/public/posts.php', 7),
(5, 'trending|trends|popular|latest|whats hot|whats new', 'You can access the latest trends and posts in the sidebar at the homepage.', 'Go to Home', '/Soleil-Lune/public/index.php', 7);

-- General (no menu_id)
INSERT INTO chatbot_rules (menu_id, keywords, response_text, button_text, button_link, priority) VALUES
(NULL, 'block|blocking|block user|block someone|unblock', 'You can block users by going to their account and pressing the three dots next to their user name where you can choose to block or report them.', NULL, NULL, 7),
(NULL, 'rules broken|what rules|which rule|violated rules|broke rules', 'If you broke the rules, your account will be sent a warning and the content removed. Each user has 3 maximum warnings; the 4th violation results in an account ban.', NULL, NULL, 8);

-- ---------------------------------------------------
