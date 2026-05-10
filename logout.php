<?php
session_start();      // بنفتح الجلسة عشان نعرف نقفلها
session_unset();      // بنمسح البيانات اللي متخزنة في الـ Session
session_destroy();    // بندمر الجلسة تماماً
header("Location: login.php"); // بنرجعه لصفحة الـ Login
exit();
?>