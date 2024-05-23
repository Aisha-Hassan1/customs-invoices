<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $total_expected_price = $_POST['total_expected_price'];
    $amount_to_pay = $_POST['amount_to_pay'];

    $sql = "INSERT INTO khales (customer_id, total_expected_amount, amount_to_pay) VALUES ('$customer_id', '$total_expected_price', '$amount_to_pay')";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_invoices.php?customer_id=$customer_id");
        exit();
    } 

    $conn->close();

}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة خالص جديد</title>
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
        <h1>إضافة خالص جديد</h1>
    </header>
    <main>
        <form action="add_khales.php" method="POST">
            <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id']; ?>">
            <input type="hidden" name="total_expected_price" value="<?php echo $_GET['total_expected_price']; ?>">
            <label for="amount_to_pay">المبلغ المراد دفعه:</label>
            <input type="number" step="0.01" id="amount_to_pay" name="amount_to_pay" required>
            <button type="submit">إضافة</button>
        </form>
    </main>
</body>
</html>
