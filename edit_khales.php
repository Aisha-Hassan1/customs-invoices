<?php
include 'connect.php';

// التأكد من وجود معرف الخالص المطلوب للتعديل
if (!isset($_GET['khales_id'])) {
    header("Location: view_invoices.php"); // إذا لم يتم تحديد معرف الخالص، عودة للصفحة السابقة
    exit();
}

$khales_id = intval($_GET['khales_id']);

// استعلام للحصول على بيانات الخالص
$sql = "SELECT * FROM khales WHERE id = $khales_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $customer_id = $row['customer_id'];
    $total_expected_amount = $row['total_expected_amount'];
    $amount_to_pay = $row['amount_to_pay'];
} else {
    echo "لا يوجد خالص بهذا المعرف";
    exit();
}

// التعديل على المبلغ في قاعدة البيانات إذا تم إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_amount_to_pay = $_POST['amount_to_pay'];

    $update_sql = "UPDATE khales SET amount_to_pay = '$new_amount_to_pay' WHERE id = $khales_id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: view_invoices.php?customer_id=$customer_id");
        exit();
    } else {
        echo "حدث خطأ أثناء تحديث المبلغ";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المبلغ</title>
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
        form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: inline-block;
            margin-top: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            color: white;
            background-color: #28a745;
        }
        button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <header>
        <h1>تعديل المبلغ</h1>
    </header>
    <main>
        <form action="edit_khales.php?khales_id=<?php echo $khales_id; ?>" method="POST">
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
            <label for="amount_to_pay">المبلغ الجديد:</label>
            <input type="number" step="0.01" id="amount_to_pay" name="amount_to_pay" value="<?php echo $amount_to_pay; ?>" required>
            <button type="submit">تحديث المبلغ</button>
        </form>
    </main>
</body>
</html>
