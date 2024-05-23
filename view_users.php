<?php
include 'connect.php';
$sql = "SELECT customer_id, name, phone_number FROM customers";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض العملاء</title>
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
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            color: white;
            background-color: #17a2b8;
        }
        button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <header>
        <h1>عرض العملاء</h1>
    </header>
    <main>
        <table>
            <tr>
                <th>اسم العميل</th>
                <th>رقم الهاتف</th>
                <th colspan="2">الإجراءات</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["phone_number"] . "</td>";
                    echo "<td><button onclick=\"location.href='view_invoices.php?customer_id=" . $row["customer_id"] . "'\">عرض الفواتير</button></td>";
                    echo "<td><button onclick=\"location.href='delete_customer.php?customer_id=" . $row["customer_id"] . "'\"> حذف المستخدم</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>لا يوجد عملاء</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </main>
</body>
</html>
