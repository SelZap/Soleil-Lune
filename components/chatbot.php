<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = strtolower(trim($input['message'] ?? ''));
    $userId = $_SESSION['user_id'] ?? null;
    $sessionId = session_id();

    if (empty($message)) {
        echo json_encode([
            'response' => 'Please type a message!', 
            'button_text' => null, 
            'button_link' => null
        ]);
        exit;
    }

    // Test database connection
    $test = $conn->query("SELECT COUNT(*) FROM chatbot_intents");
    $count = $test->fetchColumn();
    
    if ($count == 0) {
        echo json_encode([
            'response' => 'No chatbot data found! Please run the SQL import.',
            'button_text' => null,
            'button_link' => null
        ]);
        exit;
    }

    // Find matching intent
    $stmt = $conn->prepare("
        SELECT ci.response, ci.button_text, ci.button_link, ci.tag, cp.pattern
        FROM chatbot_patterns cp 
        JOIN chatbot_intents ci ON cp.intent_id = ci.id 
        ORDER BY ci.priority DESC
    ");
    $stmt->execute();
    $patterns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = null;
    foreach ($patterns as $pattern) {
        $keywords = explode('|', $pattern['pattern']);
        foreach ($keywords as $keyword) {
            if (strpos($message, trim($keyword)) !== false) {
                $result = $pattern;
                break 2;
            }
        }
    }

    if ($result) {
        $response = $result['response'];
        $buttonText = $result['button_text'];
        $buttonLink = $result['button_link'];
        $tag = $result['tag'];
    } else {
        $stmt = $conn->prepare("SELECT response, button_text, button_link FROM chatbot_intents WHERE tag = 'default'");
        $stmt->execute();
        $default = $stmt->fetch(PDO::FETCH_ASSOC);
        $response = $default['response'] ?? "I'm not sure about that!";
        $buttonText = $default['button_text'] ?? null;
        $buttonLink = $default['button_link'] ?? null;
        $tag = 'default';
    }

    // Log conversation (optional)
    try {
        $logStmt = $conn->prepare("INSERT INTO chatbot_conversations (user_id, session_id, user_message, bot_response, intent_tag) VALUES (?, ?, ?, ?, ?)");
        $logStmt->execute([$userId, $sessionId, $message, $response, $tag]);
    } catch (Exception $e) {
        // Ignore logging errors
    }

    echo json_encode([
        'response' => $response,
        'button_text' => $buttonText,
        'button_link' => $buttonLink,
        'debug' => [
            'intents_count' => $count,
            'message' => $message,
            'matched' => $result ? 'yes' : 'no'
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'response' => 'Error: ' . $e->getMessage(),
        'button_text' => null,
        'button_link' => null,
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}