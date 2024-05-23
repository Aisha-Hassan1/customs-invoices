<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px;
        }
        main {
            margin-top: 50px;
        }
        button {
            padding: 15px 30px;
            font-size: 18px;
            margin: 20px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            color: white;
        }
        .btn-view {
            background-color: #28a745;
        }
        .btn-add {
            background-color: #17a2b8;
        }
        .btn-add:hover, .btn-view:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <header>
        <h1>إدارة المستخدمين</h1>
    </header>
    <main>
        <button class="btn-view" onclick="location.href='view_users.php'">عرض كل المستخدمين</button>
        <button class="btn-add" onclick="location.href='add_user.html'">إضافة عميل جديد</button>
        <div id="content"></div>
    </main>

    
</body>
</html>
