<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$message = $_POST['message'] ?? '';
$menuId = isset($_POST['menu_id']) ? intval($_POST['menu_id']) : null;

if (!isset($_SESSION['chatbot_session'])) {
    $_SESSION['chatbot_session'] = uniqid('chat_', true);
}
$sessionId = $_SESSION['chatbot_session'];
$userId = $_SESSION['user_id'] ?? null;

function getMainMenu($conn) {
    $stmt = $conn->prepare("SELECT * FROM chatbot_menu WHERE parent_id IS NULL ORDER BY display_order");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSubmenu($conn, $parentId) {
    $stmt = $conn->prepare("SELECT * FROM chatbot_menu WHERE parent_id = ? ORDER BY display_order");
    $stmt->execute([$parentId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function matchRuleQuery($conn, $message) {
    $stmt = $conn->prepare("SELECT * FROM chatbot_rules ORDER BY priority DESC");
    $stmt->execute();
    $rules = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $message = strtolower(trim($message));
    
    foreach ($rules as $rule) {
        $keywords = explode('|', strtolower($rule['keywords']));
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);
            if (strpos($message, $keyword) !== false) {
                return $rule;
            }
        }
    }
    
    return null;
}

function saveConversation($conn, $userId, $sessionId, $userMessage, $botResponse, $responseType) {
    try {
        $stmt = $conn->prepare("INSERT INTO chatbot_conversations (user_id, session_id, user_message, bot_response, response_type) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $sessionId, $userMessage, $botResponse, $responseType]);
    } catch (Exception $e) {
        error_log("Chatbot conversation save error: " . $e->getMessage());
    }
}

// Initialize chat
if ($action === 'init') {
    try {
        $mainMenu = getMainMenu($conn);
        
        $response = [
            'success' => true,
            'message' => "Bonjour! I'm Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?",
            'buttons' => array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'text' => $item['button_text'],
                    'has_children' => (bool)$item['has_children']
                ];
            }, $mainMenu)
        ];
        
        saveConversation($conn, $userId, $sessionId, '[INIT]', $response['message'], 'menu');
        echo json_encode($response);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error initializing chat: ' . $e->getMessage()]);
    }
    exit;
}

// Handle menu selection
if ($action === 'menu' && $menuId) {
    try {
        $isAskAgain = isset($_POST['is_ask_again']) && $_POST['is_ask_again'] === '1';
        
        $stmt = $conn->prepare("SELECT * FROM chatbot_menu WHERE id = ?");
        $stmt->execute([$menuId]);
        $menu = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($menu) {
            $response = [
                'success' => true,
                'message' => $menu['response_text'],
                'buttons' => [],
                'menu_id' => $menuId,
                'parent_id' => $menu['parent_id']
            ];
            
            // If "Ask Again" - return to parent with its children
            if ($isAskAgain && $menu['parent_id']) {
                // Get the parent menu
                $parentStmt = $conn->prepare("SELECT * FROM chatbot_menu WHERE id = ?");
                $parentStmt->execute([$menu['parent_id']]);
                $parentMenu = $parentStmt->fetch(PDO::FETCH_ASSOC);
                
                if ($parentMenu && $parentMenu['has_children']) {
                    // Get parent's submenu options
                    $submenu = getSubmenu($conn, $menu['parent_id']);
                    
                    $response = [
                        'success' => true,
                        'message' => $parentMenu['response_text'], // Show parent message
                        'buttons' => array_map(function($item) {
                            return [
                                'id' => $item['id'],
                                'text' => $item['button_text'],
                                'link' => $item['link_url']
                            ];
                        }, $submenu),
                        'menu_id' => $menu['parent_id'],
                        'parent_id' => $parentMenu['parent_id']
                    ];
                    
                    saveConversation($conn, $userId, $sessionId, '[ASK_AGAIN]', $parentMenu['response_text'], 'menu');
                    echo json_encode($response);
                    exit;
                }
            }
            
            // Normal selection - if has children, get submenu
            if ($menu['has_children']) {
                $submenu = getSubmenu($conn, $menuId);
                $response['buttons'] = array_map(function($item) {
                    return [
                        'id' => $item['id'],
                        'text' => $item['button_text'],
                        'link' => $item['link_url']
                    ];
                }, $submenu);
            } else if ($menu['link_url']) {
                $response['link'] = $menu['link_url'];
            }
            
            saveConversation($conn, $userId, $sessionId, '[MENU:' . $menu['button_text'] . ']', $menu['response_text'], 'menu');
            echo json_encode($response);
        } else {
            echo json_encode(['success' => false, 'message' => 'Menu not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error loading menu: ' . $e->getMessage()]);
    }
    exit;
}

// Handle text message
if ($action === 'message' && $message) {
    try {
        $rule = matchRuleQuery($conn, $message);
        
        if ($rule) {
            $response = [
                'success' => true,
                'message' => $rule['response_text'],
                'buttons' => []
            ];
            
            if ($rule['button_text'] && $rule['button_link']) {
                $response['button'] = [
                    'text' => $rule['button_text'],
                    'link' => $rule['button_link']
                ];
            }
            
            if ($rule['menu_id']) {
                $submenu = getSubmenu($conn, $rule['menu_id']);
                if (!empty($submenu)) {
                    $response['buttons'] = array_map(function($item) {
                        return [
                            'id' => $item['id'],
                            'text' => $item['button_text'],
                            'link' => $item['link_url']
                        ];
                    }, array_slice($submenu, 0, 3));
                }
            }
            
            saveConversation($conn, $userId, $sessionId, $message, $rule['response_text'], 'rule');
            echo json_encode($response);
        } else {
            $mainMenu = getMainMenu($conn);
            
            $response = [
                'success' => true,
                'message' => "Hmm, I'm not quite sure about that! Could you rephrase your question?\n\nOr select a topic below:",
                'buttons' => array_map(function($item) {
                    return [
                        'id' => $item['id'],
                        'text' => $item['button_text'],
                        'has_children' => (bool)$item['has_children']
                    ];
                }, array_slice($mainMenu, 0, 4))
            ];
            
            saveConversation($conn, $userId, $sessionId, $message, $response['message'], 'default');
            echo json_encode($response);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error processing message: ' . $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>