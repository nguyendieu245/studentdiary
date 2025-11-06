<?php
$host = "localhost";
$user = "root";
$pass = ""; // Đảm bảo mật khẩu này chính xác
$db = "student_diary";

// Bật báo cáo lỗi để nhìn rõ vấn đề trong môi trường phát triển
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli($host, $user, $pass, $db);

// Thay vì die(), ném một ngoại lệ
if ($conn->connect_error) {
    // throw new Exception("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
    // Để an toàn hơn, không hiển thị thông tin chi tiết lỗi CSDL ra ngoài môi trường Production
    throw new Exception("Database connection failed.");
}
?>