<?php
// بيانات الاتصال
$host = "localhost";
$username = "root";
$password = "";
$dbname = "notesapp_db";

// عمل الاتصال
$conn = mysqli_connect($host, $username, $password, $dbname);

// التأكد من الاتصال
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// لو عايز تتأكد إنه شغال، فك الكومنت اللي تحت وجرب تفتح الملف في المتصفح
// echo "Connected successfully"; 
?>