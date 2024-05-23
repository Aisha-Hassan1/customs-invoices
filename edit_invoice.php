<?php
include 'connect.php';

// التأكد من وجود معرف الفاتورة المطلوب للتعديل
if (!isset($_GET['invoice_id'])) {
    header("Location: view_invoices.php"); // إذا لم يتم تحديد معرف الفاتورة، عودة للصفحة السابقة
    exit();
}

$invoice_id = intval($_GET['invoice_id']);

// استعلام للحصول على بيانات الفاتورة قبل التعديل
$invoice_info_sql = "SELECT * FROM invoices WHERE id = $invoice_id";
$invoice_info_result = $conn->query($invoice_info_sql);

if ($invoice_info_result->num_rows > 0) {
    $row = $invoice_info_result->fetch_assoc();
    $customer_id = $row['customer_id'];
    $product_description = $row['product_description'];
    $expected_price = $row['expected_price'];
    $paid_price = $row['paid_price'];
    $sale_price = $row['sale_price'];
} else {
    echo "لا يوجد فاتورة بهذا المعرف";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استقبال البيانات المعدلة من النموذج
    $product_description = $_POST['product_description'];
    $expected_price = $_POST['expected_price'];
    $paid_price = $_POST['paid_price'];
    $sale_price = $_POST['sale_price'];

    // استعلام لتحديث بيانات الفاتورة
    $update_sql = "UPDATE invoices SET product_description = '$product_description', expected_price = '$expected_price', paid_price = '$paid_price', sale_price = '$sale_price' WHERE id = $invoice_id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: view_invoices.php?customer_id=$customer_id");
        exit();
    } else {
        echo "حدث خطأ أثناء تحديث الفاتورة: " . $conn->error;
        exit();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الفاتورة</title>
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
        <h1>تعديل الفاتورة</h1>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?invoice_id=$invoice_id"; ?>" method="POST">
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
            <label for="product_description">وصف المنتج:</label>
            <input type="text" id="product_description" name="product_description" value="<?php echo $product_description; ?>" required>
            <label for="expected_price">السعر المتوقع:</label>
            <input type="number" step="0.01" id="expected_price" name="expected_price" value="<?php echo $expected_price; ?>" required>
            <label for="paid_price">السعر المدفوع:</label>
            <input type="number" step="0.01" id="paid_price" name="paid_price" value="<?php echo $paid_price; ?>" required>
            <label for="sale_price">السعر المتوقع للبيع:</label>
            <input type="number" step="0.01" id="sale_price" name="sale_price" value="<?php echo $sale_price; ?>" required>
           
            <button type="submit">حفظ التغييرات</button>
        </form>
    </main>
</body>
</html>
