<?php
    include 'connect.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = intval($_POST['customer_id']);
    $product_description = $_POST['product_description'];
    $expected_price = $_POST['expected_price'];
    $paid_price = $_POST['paid_price'];
    $sale_price = $_POST['sale_price'];

    $sql = "INSERT INTO invoices (customer_id, product_description, expected_price, paid_price , sale_price) VALUES ('$customer_id', '$product_description', '$expected_price', '$paid_price' , '$sale_price')";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_invoices.php?customer_id=$customer_id");
        exit();
    } 

    $conn->close();
}
else {
    $customer_id = intval($_GET['customer_id']);
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة فاتورة جديدة</title>
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
        <h1>إضافة فاتورة جديدة</h1>
    </header>
    <main>
        <form action="add_invoice.php" method="POST">
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
            <label for="product_description">وصف المنتج:</label>
            <input type="text" id="product_description" name="product_description" required>
            <label for="expected_price">السعر المتوقع:</label>
            <input type="number" step="0.01" id="expected_price" name="expected_price" required>
            <label for="paid_price">السعر المدفوع:</label>
            <input type="number" step="0.01" id="paid_price" name="paid_price" required>
            <label for="sale_price">السعر المتوقع للبيع:</label>
            <input type="number" step="0.01" id="sale_price" name="sale_price" required>
           
            <button type="submit">إضافة</button>
        </form>
    </main>
</body>
</html>
