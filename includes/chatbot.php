<?php
session_start();
require_once __DIR__ . '/../config/database.php';

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

    // Find matching intent using better pattern matching
    $stmt = $conn->prepare("
        SELECT ci.id, ci.tag, ci.response, ci.button_text, ci.button_link, ci.priority
        FROM chatbot_intents ci
    ");
    $stmt->execute();
    $intents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $bestMatch = null;
    $highestPriority = -1;

    foreach ($intents as $intent) {
        // Get patterns for this intent
        $patternStmt = $conn->prepare("SELECT pattern FROM chatbot_patterns WHERE intent_id = ?");
        $patternStmt->execute([$intent['id']]);
        $patterns = $patternStmt->fetchAll(PDO::FETCH_COLUMN);

        // Check each pattern
        foreach ($patterns as $pattern) {
            $keywords = array_map('trim', explode('|', $pattern));
            
            foreach ($keywords as $keyword) {
                // Check if message contains this keyword
                if (stripos($message, $keyword) !== false) {
                    // Higher priority wins
                    if ($intent['priority'] > $highestPriority) {
                        $bestMatch = $intent;
                        $highestPriority = $intent['priority'];
                    }
                    break 2; // Found match, move to next intent
                }
            }
        }
    }

    if ($bestMatch) {
        $response = $bestMatch['response'];
        $buttonText = $bestMatch['button_text'];
        $buttonLink = $bestMatch['button_link'];
        $tag = $bestMatch['tag'];
    } else {
        // Default response
        $stmt = $conn->prepare("SELECT response, button_text, button_link FROM chatbot_intents WHERE tag = 'default'");
        $stmt->execute();
        $default = $stmt->fetch(PDO::FETCH_ASSOC);
        $response = $default['response'] ?? "I'm not sure about that! Type 'help' to see what I can do.";
        $buttonText = $default['button_text'] ?? null;
        $buttonLink = $default['button_link'] ?? null;
        $tag = 'default';
    }

    // Log conversation
    try {
        $logStmt = $conn->prepare("INSERT INTO chatbot_conversations (user_id, session_id, user_message, bot_response, intent_tag) VALUES (?, ?, ?, ?, ?)");
        $logStmt->execute([$userId, $sessionId, $message, $response, $tag]);
    } catch (Exception $e) {
        // Continue if logging fails
    }

    echo json_encode([
        'response' => $response,
        'button_text' => $buttonText,
        'button_link' => $buttonLink
    ]);

} catch (Exception $e) {
    echo json_encode([
        'response' => 'Error: ' . $e->getMessage(),
        'button_text' => null,
        'button_link' => null
    ]);
}