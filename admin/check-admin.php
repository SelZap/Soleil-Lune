<?php
/**
 * TEMPORARY DEBUG FILE - Delete after fixing login
 * This file shows what's in your admin table
 */
require_once '../config/database.php';

// Test the exact credentials you're trying
$test_email = 'Admin_Crissel_Zapatero_001';
$test_password = '84326719';
$hashed_password = sha1($test_password);

echo "<h2>Admin Database Debug</h2>";
echo "<hr>";

// Show all admins in database
echo "<h3>All Admins in Database:</h3>";
$stmt = $conn->query("SELECT id, name, email, password, created_at FROM admin");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Password Hash</th><th>Created</th></tr>";
foreach ($admins as $admin) {
    echo "<tr>";
    echo "<td>" . $admin['id'] . "</td>";
    echo "<td>" . htmlspecialchars($admin['name']) . "</td>";
    echo "<td>" . htmlspecialchars($admin['email']) . "</td>";
    echo "<td>" . substr($admin['password'], 0, 20) . "...</td>";
    echo "<td>" . $admin['created_at'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<hr>";
echo "<h3>Testing Your Credentials:</h3>";
echo "<p><strong>Email you're trying:</strong> " . htmlspecialchars($test_email) . "</p>";
echo "<p><strong>Password you're trying:</strong> " . htmlspecialchars($test_password) . "</p>";
echo "<p><strong>SHA1 Hash of password:</strong> " . $hashed_password . "</p>";

echo "<hr>";
echo "<h3>Login Test:</h3>";

$stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
$stmt->execute([$test_email]);

if ($stmt->rowCount() > 0) {
    echo "<p style='color: green;'>✓ Email found in database!</p>";
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p><strong>Stored password hash:</strong> " . $admin['password'] . "</p>";
    echo "<p><strong>Your password hash:</strong> " . $hashed_password . "</p>";
    
    if ($admin['password'] === $hashed_password) {
        echo "<p style='color: green;'>✓ Password matches!</p>";
        echo "<p style='color: green; font-weight: bold;'>LOGIN SHOULD WORK!</p>";
    } else {
        echo "<p style='color: red;'>✗ Password does NOT match!</p>";
        echo "<p>The password in the database is different from what you're entering.</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Email NOT found in database!</p>";
    echo "<p>The email '<strong>" . htmlspecialchars($test_email) . "</strong>' does not exist in the admin table.</p>";
}

echo "<hr>";
echo "<h3>SQL to Fix (if needed):</h3>";
echo "<pre>";
echo "-- Use this SQL to update the admin credentials:\n";
echo "UPDATE admin SET \n";
echo "  email = 'Admin_Crissel_Zapatero_001',\n";
echo "  password = SHA1('84326719')\n";
echo "WHERE name = 'Crissel Zapatero';\n";
echo "</pre>";

echo "<hr>";
echo "<h3>Manual Login Test:</h3>";
echo "<form method='POST' action=''>";
echo "<input type='text' name='test_email' placeholder='Enter email' style='padding: 10px; font-size: 16px; width: 300px;'><br><br>";
echo "<input type='text' name='test_pass' placeholder='Enter password' style='padding: 10px; font-size: 16px; width: 300px;'><br><br>";
echo "<button type='submit' name='test_login' style='padding: 10px 20px; font-size: 16px;'>Test Login</button>";
echo "</form>";

if (isset($_POST['test_login'])) {
    $email = $_POST['test_email'];
    $pass = $_POST['test_pass'];
    $hashed = sha1($pass);
    
    echo "<hr>";
    echo "<h4>Testing:</h4>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    echo "<p><strong>Password:</strong> " . htmlspecialchars($pass) . "</p>";
    echo "<p><strong>Hashed:</strong> " . $hashed . "</p>";
    
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
    $stmt->execute([$email, $hashed]);
    
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green; font-size: 20px; font-weight: bold;'>✓ LOGIN SUCCESSFUL!</p>";
        $admin = $stmt->fetch();
        echo "<p>Admin found: " . htmlspecialchars($admin['name']) . " (ID: " . $admin['id'] . ")</p>";
    } else {
        echo "<p style='color: red; font-size: 20px; font-weight: bold;'>✗ LOGIN FAILED!</p>";
        
        // Check email separately
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: orange;'>Email exists but password is wrong.</p>";
            $admin = $stmt->fetch();
            echo "<p><strong>Expected hash:</strong> " . $admin['password'] . "</p>";
            echo "<p><strong>Your hash:</strong> " . $hashed . "</p>";
        } else {
            echo "<p style='color: red;'>Email not found in database.</p>";
        }
    }
}

echo "<hr>";
echo "<p><strong>⚠️ IMPORTANT: Delete this file after debugging!</strong></p>";
?>

<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    th {
        background: #333;
        color: white;
        padding: 10px;
    }
    td {
        padding: 10px;
    }
    pre {
        background: #f4f4f4;
        padding: 15px;
        border-radius: 5px;
        overflow-x: auto;
    }
</style>