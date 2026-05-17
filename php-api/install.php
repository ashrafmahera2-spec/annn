<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تثبيت فحم العاصمة</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
            padding: 40px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
            font-size: 24px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
            font-size: 14px;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #bee5eb;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚙️ تثبيت فحم العاصمة</h1>
        <p class="subtitle">إعداد قاعدة البيانات</p>

        <?php
        $installed = false;
        $error = null;

        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db_host = trim($_POST['db_host'] ?? '');
            $db_user = trim($_POST['db_user'] ?? '');
            $db_pass = trim($_POST['db_password'] ?? '');
            $db_name = trim($_POST['db_name'] ?? 'capital_charcoal');

            if (!$db_host || !$db_user) {
                $error = "❌ الرجاء إدخال اسم المضيف واسم المستخدم";
            } else {
                try {
                    // Connect to MySQL without database
                    $conn = new PDO("mysql:host=$db_host", $db_user, $db_pass);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Create database
                    $conn->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    
                    // Select database
                    $conn->exec("USE `$db_name`");
                    
                    // Create tables
                    $tables = [
                        "CREATE TABLE IF NOT EXISTS products (
                            id VARCHAR(255) PRIMARY KEY,
                            name_ar TEXT,
                            name_en TEXT,
                            description_ar TEXT,
                            description_en TEXT,
                            images LONGTEXT,
                            category VARCHAR(100),
                            price VARCHAR(100)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
                        
                        "CREATE TABLE IF NOT EXISTS articles (
                            id VARCHAR(255) PRIMARY KEY,
                            title_ar TEXT,
                            title_en TEXT,
                            content_ar TEXT,
                            content_en TEXT,
                            image TEXT,
                            date VARCHAR(100)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
                        
                        "CREATE TABLE IF NOT EXISTS gallery (
                            id VARCHAR(255) PRIMARY KEY,
                            url TEXT,
                            title_ar TEXT,
                            title_en TEXT,
                            category VARCHAR(100)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
                        
                        "CREATE TABLE IF NOT EXISTS reviews (
                            id VARCHAR(255) PRIMARY KEY,
                            author VARCHAR(255),
                            rating INT,
                            comment_ar TEXT,
                            comment_en TEXT,
                            avatar TEXT
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
                        
                        "CREATE TABLE IF NOT EXISTS inquiries (
                            id VARCHAR(255) PRIMARY KEY,
                            name VARCHAR(255),
                            email VARCHAR(255),
                            msg TEXT,
                            date VARCHAR(100)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
                        
                        "CREATE TABLE IF NOT EXISTS settings (
                            id INT PRIMARY KEY,
                            phone VARCHAR(50),
                            whatsapp VARCHAR(50),
                            logo TEXT,
                            address_ar TEXT,
                            address_en TEXT,
                            heroTitle_ar TEXT,
                            heroTitle_en TEXT,
                            heroSub_ar TEXT,
                            heroSub_en TEXT,
                            heroImage TEXT
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
                    ];
                    
                    foreach ($tables as $sql) {
                        $conn->exec($sql);
                    }
                    
                    // Check if settings exist
                    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM settings WHERE id = 1");
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($result['count'] == 0) {
                        $stmt = $conn->prepare("INSERT INTO settings (id, phone, whatsapp, logo, address_ar, address_en, heroTitle_ar, heroTitle_en, heroSub_ar, heroSub_en, heroImage) VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute(['01000187892', '201000187892', '', 'دمياط الجديدة', 'New Damietta', 'فحم العاصمة', 'Capital Charcoal', 'جودة لا تضاهى', 'Unmatched Quality', '']);
                    }
                    
                    $installed = true;
                    
                } catch(PDOException $e) {
                    $error = "❌ خطأ في الاتصال: " . $e->getMessage();
                }
            }
        }

        if ($installed) {
            echo '<div class="success">
                <strong>✅ تم التثبيت بنجاح!</strong><br><br>
                تم إنشاء قاعدة البيانات والجداول بنجاح.
                <br><br>
                <strong>البيانات المحفوظة:</strong><br>
                المضيف: <code>' . htmlspecialchars($db_host) . '</code><br>
                قاعدة البيانات: <code>' . htmlspecialchars($db_name) . '</code><br><br>
                <em>الآن يمكنك العودة إلى الموقع والبدء في الاستخدام.</em>
            </div>';
        } elseif ($error) {
            echo '<div class="error">' . htmlspecialchars($error) . '</div>';
        }
        ?>

        <?php if (!$installed): ?>
        <div class="info">
            💡 أدخل بيانات قاعدة البيانات MySQL الخاصة بك لتثبيت الموقع تلقائياً
        </div>

        <form method="POST">
            <div class="form-group">
                <label for="db_host">اسم المضيف (Host)</label>
                <input type="text" id="db_host" name="db_host" value="localhost" required>
            </div>

            <div class="form-group">
                <label for="db_user">اسم المستخدم (Username)</label>
                <input type="text" id="db_user" name="db_user" value="root" required>
            </div>

            <div class="form-group">
                <label for="db_password">كلمة المرور (Password)</label>
                <input type="password" id="db_password" name="db_password" placeholder="اتركها فارغة إن لم تكن موجودة">
            </div>

            <div class="form-group">
                <label for="db_name">اسم قاعدة البيانات (Database Name)</label>
                <input type="text" id="db_name" name="db_name" value="capital_charcoal" required>
            </div>

            <button type="submit">🚀 تثبيت الموقع</button>
        </form>
        <?php endif; ?>

    </div>
</body>
</html>
