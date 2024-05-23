<?php
include 'connect.php';

$customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : intval($_GET['customer_id']);

$sql = "SELECT id, product_description, expected_price, paid_price, sale_price FROM invoices WHERE customer_id = $customer_id";
$result = $conn->query($sql);

$total_expected_price = 0;
$total_paid_price = 0;

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الفواتير</title>
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
            margin: 5px;
        }
        button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <header>
        <h1>عرض الفواتير</h1>
    </header>
    <main>
        <table>
            <tr>
                <th>وصف المنتج</th>
                <th>السعر المتوقع</th>
                <th>السعر المدفوع</th>
                <th>السعر المتوقع للبيع</th>
                <th>المكسب</th>
                <th>الإجراءات</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $profit = $row["expected_price"] - $row["sale_price"];
                    $total_expected_price += $row["expected_price"];
                    $total_paid_price += $row["paid_price"];

                    echo "<tr>";
                    echo "<td>" . $row["product_description"] . "</td>";
                    echo "<td>" . $row["expected_price"] . "</td>";
                    echo "<td>" . $row["paid_price"] . "</td>";
                    echo "<td>" . $row["sale_price"] . "</td>";
                    echo "<td>" . $profit . "</td>";
                    echo "<td>";
                    echo "<button onclick=\"location.href='edit_invoice.php?invoice_id=" . $row["id"] . "'\">تعديل</button>";
                    echo "<button onclick=\"location.href='delete_invoice.php?invoice_id=" . $row["id"] . "&customer_id=$customer_id'\"> حذف  </button>";
                    echo "</td>";
                    echo "</tr>";
                }

                // حساب الحالة النهائية
                $balance = $total_paid_price - $total_expected_price;
                $status = "";
                if ($balance < 0) {
                    $status = "مديون بـ " . abs($balance) . " جنيه";
                } elseif ($balance > 0) {
                    $status = "عندي ربح " . $balance . " جنيه";
                } else {
                    $status = "خالص";
                }
            } else {
                echo "<tr><td colspan='6'>لا توجد فواتير</td></tr>";
            }
            ?>
        </table>
        <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <td>إجمالي السعر المتوقع:</td>
                <td><?php echo $total_expected_price; ?></td>
            </tr>
            <tr>
                <td>إجمالي المبلغ المدفوع:</td>
                <td><?php echo $total_paid_price; ?></td>
            </tr>
            <tr>
                <td>الحالة:</td>
                <td><?php echo $status; ?></td>
            </tr>
        </table>
        <?php endif; ?>
        <?php
        if ($result->num_rows == 0) {
            echo "<button onclick=\"location.href='add_invoice.php?customer_id=$customer_id'\">إضافة فاتورة</button>";
        }
        ?>
       
        <!-- Button for adding khales -->
        <?php if ($total_expected_price > 0): ?>
    <button onclick="location.href='add_khales.php?customer_id=<?php echo $customer_id; ?>&total_expected_price=<?php echo $total_expected_price; ?>'">إضافة خالص</button>
<?php else: ?>
    <button disabled>إضافة خالص</button>
<?php endif; ?>
    </main>
    <table>
        <tr>
            <th>إجمالي السعر المتوقع</th>
            <th>المبلغ المراد دفعه</th>
            <th>الربح</th>
            <th>تعديل المبلغ</th>
            <th>حذف الخالص</th>
        </tr>
        <?php
        $khales_sql = "SELECT * FROM khales WHERE customer_id = $customer_id";
        $khales_result = $conn->query($khales_sql);
        if ($khales_result->num_rows > 0) {
            while($row = $khales_result->fetch_assoc()) {
                $profit = $row["total_expected_amount"] - $row["amount_to_pay"];
                echo "<tr>";
                echo "<td>" . $row["total_expected_amount"] . "</td>";
                echo "<td>" . $row["amount_to_pay"] . "</td>";
                echo "<td>" . $profit . "</td>";
                echo "<td><button onclick=\"location.href='edit_khales.php?khales_id=" . $row["id"] . "'\">تعديل المبلغ</button></td>";
                echo "<td><button onclick=\"location.href='delet_khales.php?khales_id=" . $row["id"] . "'\"> حذف الخالص</button></td>";


               
            }
        } else {
            echo "<tr><td colspan='4'>لا توجد بيانات خالص متاحة</td></tr>";
        }
        ?>
    </table>
</body>
</html>

</body>
</html>
