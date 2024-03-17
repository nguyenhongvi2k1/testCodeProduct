<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Golden Sneaker</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <main>
        <?php
        // Function to get product by id
        function getProductById($productId)
        {
            $jsonFilePath = 'data/shoes.json'; // Path to the JSON file
            if (file_exists($jsonFilePath)) {
                $jsonData = file_get_contents($jsonFilePath);
                $shoes = json_decode($jsonData, true);
                if ($shoes !== null) {
                    foreach ($shoes['shoes'] as $shoe) {
                        if ($shoe['id'] == $productId) {
                            return $shoe;
                        }
                    }
                }
            }
            return null;
        }
        ?>
        <!-- Main content here -->
        <section id="products">
            <img src="./assets/nike.png" alt="icon" class="icon-nike">
            <h2>Our Products</h2>
            <div class="product-container">
                <?php
                // Đọc dữ liệu từ tệp JSON chứa thông tin về sản phẩm
                $jsonData = file_get_contents('data/shoes.json');
                $products = json_decode($jsonData, true);

                if ($products !== null && isset($products['shoes'])) {
                    foreach ($products['shoes'] as $product) {
                        echo '<div class="product">';
                        echo '<img src="' . $product['image'] . '" alt="' . $product['name'] . '"style="background : ' . $product['color'] . '">';
                        echo '<h3>' . $product['name'] . '</h3>';
                        echo '<p>' . $product['description'] . '</p>';
                        echo '<div class="pice-addcart">';
                        echo '<p>$' . $product['price'] . '</p>';
                        // Thêm nút "Add to Cart"
                        if (!isset($_SESSION['cart'][$product['id']])) {
                            echo '<button onclick="addToCart(' . $product['id'] . ')">Add To Cart</button>';
                        } else {
                            echo '<button disabled>✓</button>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No products available</p>';
                }
                ?>
            </div>
        </section>

        <section id="cart">
            <img src="./assets/nike.png" alt="icon" class="icon-nike">
            <h2>Your Cart</h2>
            <div class="cart-container">
                <?php
                // Kiểm tra nếu giỏ hàng không trống
                if (!empty($_SESSION['cart'])) {
                    $totalPrice = 0; 
                    foreach ($_SESSION['cart'] as $productId => $quantity) {
                        // Lấy thông tin sản phẩm từ cơ sở dữ liệu hoặc từ tệp JSON
                        $product = getProductById($productId); // Hàm getProductById() lấy thông tin sản phẩm từ cơ sở dữ liệu hoặc tệp JSON

                        if ($product) {
                            // Tính toán tổng giá trị giỏ hàng
                            $subtotal = $product['price'] * $quantity;
                            $totalPrice += $subtotal;

                            // Hiển thị thông tin sản phẩm trong giỏ hàng
                            echo '<div class="cart-item">';
                            echo '<img src="' . $product['image'] . '" alt="' . $product['name'] . '">';
                            echo '<h3>' . $product['name'] . '</h3>';
                            echo '<p>Price: $' . $product['price'] . '</p>';
                            echo '<p>Quantity: ' . $quantity . '</p>';
                            echo '<p>$' . $subtotal . '</p>';
                            echo '<button onclick="decreaseQuantity(' . $productId . ')">-</button>';
                            echo '<button onclick="increaseQuantity(' . $productId . ')">+</button>';
                            echo '<button onclick="removeFromCart(' . $productId . ')">Remove</button>';
                            echo '</div>';
                        }
                    }
                    echo '<div class="total-price">';
                    echo '<p>Total Price: $' . $totalPrice . '</p>';
                    echo '</div>';
                } else {
                    echo '<p>Your cart is empty</p>';
                }
                ?>
            </div>
        </section>
    </main>


    <script>
        let cartIcon = document.querySelector('.cart-icon');

        function addToCart() {
            let badge = cartIcon.querySelector('.badge');
            let count = parseInt(badge.innerText) || 0;
            count++;
            badge.innerText = count;
            cartIcon.classList.add('clicked');
            setTimeout(() => {
                cartIcon.classList.remove('clicked');
            }, 500);
        }
    </script>
</body>

</html>