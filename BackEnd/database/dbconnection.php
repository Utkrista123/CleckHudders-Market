<?php
include 'connect.php';

$db = getDBConnection();

if ($db) {
    try {
        // Create users table
        $db->exec("CREATE TABLE IF NOT EXISTS users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(150) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            contact_no VARCHAR(20) NOT NULL,
            password VARCHAR(255) NOT NULL,
            verification_code VARCHAR(100) DEFAULT NULL,
            role ENUM('customer', 'trader', 'admin') NOT NULL DEFAULT 'customer',
            created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('active', 'inactive', 'pending') NOT NULL DEFAULT 'pending'
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS product (
            product_id INTEGER AUTO_INCREMENT,
            product_name VARCHAR(8),
            description LONGTEXT,
            price INTEGER,
            stock INTEGER,
            min_order INTEGER,
            max_order INTEGER,
            product_image VARCHAR(50),
            add_date DATE,
            update_date DATE,
            product_status VARCHAR(8),
            shop_id INTEGER NOT NULL,
            user_id INTEGER NOT NULL,
            product_categroy_id INTEGER NOT NULL,
            PRIMARY KEY (product_id)
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS cart (    
            cart_id INT AUTO_INCREMENT,
            user_id INTEGER NOT NULL,
            shopping_list_id INTEGER NOT NULL,
            item_numbers INTEGER,
            add_date DATE,
            PRIMARY KEY (cart_id)
        )");
        echo "Created cart table successfully.<br>";

        $db->exec("CREATE TABLE IF NOT EXISTS product_cart (    
            cart_id INTEGER NOT NULL,
            product_id INTEGER NOT NULL,
            quantity INTEGER NOT NULL
        )");
        echo "Created product_cart table successfully.<br>";

      
        $checkStmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");

        
        $users = [
            ['full_name' => 'Admin User', 'email' => 'admin@example.com', 'contact_no' => '1234567890', 'password' => 'admin123', 'role' => 'admin'],
            ['full_name' => 'Trader User', 'email' => 'trader@example.com', 'contact_no' => '0987654321', 'password' => 'trader123', 'role' => 'trader'],
            ['full_name' => 'Customer User', 'email' => 'customer@example.com', 'contact_no' => '1122334455', 'password' => 'customer123', 'role' => 'customer'],
        ];

        
        $insertStmt = $db->prepare("INSERT INTO users (full_name, email, contact_no, password, role, status) 
                                    VALUES (:full_name, :email, :contact_no, :password, :role, 'active')");

        foreach ($users as $user) {
            
            $checkStmt->execute(['email' => $user['email']]);
            if ($checkStmt->fetchColumn() == 0) {
                $insertStmt->execute([
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'contact_no' => $user['contact_no'],
                    'password' => password_hash($user['password'], PASSWORD_BCRYPT),
                    'role' => $user['role']
                ]);
                echo "Inserted user: {$user['full_name']}<br>";
            } else {
                echo "User {$user['email']} already exists. Skipping...<br>";
            }
        }

        // Create posts table
        $db->exec("CREATE TABLE IF NOT EXISTS posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(200) NOT NULL,
            content TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
        )");
        echo "Created posts table successfully.<br>";

        
        $stmt = $db->prepare("INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content)");

        $samplePosts = [
            ['user_id' => 1, 'title' => 'First Post', 'content' => 'This is my first post content'],
            ['user_id' => 1, 'title' => 'Second Post', 'content' => 'This is my second post content'],
            ['user_id' => 2, 'title' => 'Hello World', 'content' => 'Welcome to my blog'],
        ];

        foreach ($samplePosts as $post) {
            try {
                $stmt->execute($post);
                echo "Inserted post: {$post['title']}<br>";
            } catch (PDOException $e) {
                echo "Skipping post '{$post['title']}' (User ID may not exist).<br>";
            }
        }

        echo "<br>Database setup completed successfully!<br>";

    } catch (PDOException $e) {
        echo "Error setting up database: " . $e->getMessage() . "<br>";
    }
} else {
    echo "Failed to connect to database.<br>";
}
?>