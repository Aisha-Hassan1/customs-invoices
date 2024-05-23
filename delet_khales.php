<?php
include 'connect.php';

// التأكد من وجود معرف الخالص المطلوب للحذف
if (!isset($_GET['khales_id'])) {
    header("Location: view_invoices.php"); // إذا لم يتم تحديد معرف الخالص، عودة للصفحة السابقة
    exit();
}

$khales_id = intval($_GET['khales_id']);

// استعلام للحصول على معرف العميل قبل الحذف
$khales_info_sql = "SELECT customer_id FROM khales WHERE id = $khales_id";
$khales_info_result = $conn->query($khales_info_sql);

if ($khales_info_result->num_rows > 0) {
    $row = $khales_info_result->fetch_assoc();
    $customer_id = $row['customer_id'];
} else {
    echo "لا يوجد خالص بهذا المعرف";
    exit();
}

// استعلام لحذف بيانات الخالص
$delete_sql = "DELETE FROM khales WHERE id = $khales_id";

if ($conn->query($delete_sql) === TRUE) {
    header("Location: view_invoices.php?customer_id=$customer_id");
    exit();
} else {
    echo "حدث خطأ أثناء حذف الخالص";
}

$conn->close();
?>
