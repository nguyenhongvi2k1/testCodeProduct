<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy ID sản phẩm được gửi từ trình duyệt
    $productId = $_POST['id'];

    // Tạo hoặc cập nhật giỏ hàng nếu không tồn tại
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$productId])) {
        // Nếu sản phẩm đã tồn tại, tăng số lượng lên 1
        $_SESSION['cart'][$productId]['quantity'] += 1;
    } else {
        // Nếu sản phẩm chưa tồn tại, thêm sản phẩm vào giỏ hàng với số lượng là 1
        $_SESSION['cart'][$productId] = ['quantity' => 1];
    }

    // Trả về một phản hồi cho trình duyệt để thông báo thành công
    http_response_code(200);
    echo 'Sản phẩm đã được thêm vào giỏ hàng.';
} else {
    // Trả về mã lỗi 400 nếu không có dữ liệu POST
    http_response_code(400);
    echo 'Yêu cầu không hợp lệ.';
}
?>
