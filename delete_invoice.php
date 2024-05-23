<?php
// تضمين ملف الاتصال بقاعدة البيانات
include 'connect.php';

// التحقق من طريقة الطلب
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // استقبال معرف الفاتورة ومعرف العميل من الرابط
    $invoice_id = isset($_GET['invoice_id']) ? intval($_GET['invoice_id']) : null;
    $customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : null;

    // التحقق من وجود معرف الفاتورة ومعرف العميل
    if ($invoice_id !== null && $customer_id !== null) {
        // استعلام SQL لحذف الفاتورة
        $sql = "DELETE FROM invoices WHERE id = $invoice_id";

        // تنفيذ الاستعلام
        if ($conn->query($sql) === TRUE) {
            // تم حذف الفاتورة بنجاح، إعادة التوجيه إلى صفحة عرض الفواتير لنفس العميل
            header("Location: view_invoices.php?customer_id=$customer_id");
            exit();
        } else {
            // في حالة وجود خطأ في التنفيذ، يمكنك تنفيذ إجراء معين هنا مثل إظهار رسالة خطأ
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        // في حالة عدم وجود معرف الفاتورة أو معرف العميل، يمكنك تنفيذ إجراء معين هنا مثل إظهار رسالة خطأ
        echo "Invoice ID or Customer ID is missing!";
    }

    // إغلاق اتصال قاعدة البيانات
    $conn->close();
} else {
    // في حالة عدم استخدام طريقة GET، يتم إعادة التوجيه إلى الصفحة الرئيسية أو الصفحة السابقة
    header("Location: index.php");
    exit();
}
?>
