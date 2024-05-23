<?php
// تضمين ملف الاتصال بقاعدة البيانات
include 'connect.php';

// التحقق من طريقة الطلب
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // استقبال معرف العميل من الرابط
    $customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : null;

    // التحقق من وجود معرف العميل
    if ($customer_id !== null) {
        // استعلام SQL لحذف العميل
        $sql = "DELETE FROM customers WHERE customer_id = $customer_id";

        // تنفيذ الاستعلام
        if ($conn->query($sql) === TRUE) {
            // تم حذف العميل بنجاح، إعادة التوجيه إلى صفحة عرض العملاء
            header("Location:view_users.php");
            exit();
        } else {
            echo "<script>alert('لا يمكن حذف العميل لأنه لديه فواتير مرتبطة به. يرجى حذف الفواتير المرتبطة أولاً.'); window.location.href = 'view_users.php';</script>";

        }
    } else {
        // في حالة عدم وجود معرف العميل، يمكنك تنفيذ إجراء معين هنا مثل إظهار رسالة خطأ
        echo "Customer ID is missing!";
    }

    // إغلاق اتصال قاعدة البيانات
    $conn->close();
} else {
    // في حالة عدم استخدام طريقة GET، يتم إعادة التوجيه إلى الصفحة الرئيسية أو الصفحة السابقة
    header("Location: index.php");
    exit();
}
?>
