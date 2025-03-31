<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/AccountModel.php');

class ProductController
{
    private $productModel;
    private $db;
    
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    
    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }
    
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không tìm thấy sản phẩm.";
        }
    }
    
    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include 'app/views/product/add.php';
    }
    
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = filter_var($_POST['price'] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $category_id = $_POST['category_id'] ?? null;
            $stock = intval($_POST['stock'] ?? 0);
            $image = $this->handleImageUpload($_FILES['image'] ?? null);
            
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image, $stock);
            if ($result) {
                header('Location: /webbanhang1/Product');
                exit;
            } else {
                $errors = ['Lỗi khi thêm sản phẩm.'];
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            }
        }
    }
    
    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không tìm thấy sản phẩm.";
        }
    }
    
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $price = floatval($_POST['price']);
            $category_id = $_POST['category_id'];
            $stock = intval($_POST['stock'] ?? 0);
            $image = $this->handleImageUpload($_FILES['image'] ?? null, $_POST['existing_image']);
            
            if ($this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image, $stock)) {
                header('Location: /webbanhang1/Product');
                exit;
            } else {
                echo "Lỗi khi cập nhật sản phẩm.";
            }
        }
    }
    
    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang1/Product');
            exit;
        } else {
            echo "Lỗi khi xóa sản phẩm.";
        }
    }
    
    private function handleImageUpload($file, $existingImage = '')
    {
        if (!$file || $file['error'] != 0) return $existingImage;
        
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        if (!getimagesize($file["tmp_name"])) return $existingImage;
        if ($file["size"] > 10 * 1024 * 1024) return $existingImage;
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) return $existingImage;
        if (!move_uploaded_file($file["tmp_name"], $target_file)) return $existingImage;
        
        return $target_file;
    }
    
    public function cart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        // Đảm bảo giỏ hàng luôn được khởi tạo
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    
        $cart = $_SESSION['cart'];
        include 'app/views/product/cart.php';
    }
    
    public function updateCart()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['quantity'])) {
        $id = $_POST['id'];
        $quantity = intval($_POST['quantity']);

        if ($quantity > 0 && isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        }

        // Tính lại tổng tiền của sản phẩm
        $subtotal = $_SESSION['cart'][$id]['quantity'] * $_SESSION['cart'][$id]['price'];

        // Tính tổng tiền của giỏ hàng
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        echo json_encode([
            'success' => true,
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'total' => number_format($total, 0, ',', '.')
        ]);
        exit;
    }
    
    echo json_encode(['success' => false]);
    exit;
}

    public function addToCart($id)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Lấy thông tin sản phẩm từ model
    $product = $this->productModel->getProductById($id);
    
    if (!$product) {
        die("Sản phẩm không tồn tại.");
    }

    // Kiểm tra nếu giỏ hàng chưa tồn tại, tạo giỏ hàng
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        // Thêm sản phẩm vào giỏ hàng
        $_SESSION['cart'][$id] = [
            'name' => $product->name,  // ✅ Đã sửa lỗi
            'price' => $product->price,
            'quantity' => 1,
        ];
    }

    // Chuyển hướng về trang giỏ hàng
    header("Location: /webbanhang1/Product/cart");
    exit;
}



    
public function checkout()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        header('Location: /webbanhang1/Product/cart');
        exit;
    }

    include 'app/views/product/checkout.php';
}
public function processCheckout()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {
        try {
            $this->db->beginTransaction();

            // Tính tổng tiền đơn hàng
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['quantity'] * $item['price'];
            }

            // Thêm đơn hàng vào bảng `orders` (có thêm `total`)
            $stmt = $this->db->prepare("INSERT INTO orders (name, phone, address, total) VALUES (:name, :phone, :address, :total)");
            $stmt->execute([
                ':name' => $_POST['name'],
                ':phone' => $_POST['phone'],
                ':address' => $_POST['address'],
                ':total' => $total
            ]);
            $order_id = $this->db->lastInsertId();

            // Thêm chi tiết đơn hàng
            $stmt = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
            foreach ($_SESSION['cart'] as $product_id => $item) {
                $stmt->execute([
                    ':order_id' => $order_id,
                    ':product_id' => $product_id,
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price']
                ]);
            }

            unset($_SESSION['cart']);
            $this->db->commit();
            header('Location: /webbanhang1/Product/orderConfirmation?success=true');
            exit;
        } catch (Exception $e) {
            $this->db->rollBack();
            echo "Lỗi xử lý đơn hàng: " . $e->getMessage();
        }
    } else {
        echo "Lỗi: Không có sản phẩm trong giỏ hàng!";
    }
}
public function orderConfirmation()
{
    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        echo "<div style='max-width: 600px; margin: 50px auto; padding: 20px; text-align: center; border: 1px solid #ddd; border-radius: 10px; background: #f9f9f9;'>";
        echo "<h2 style='color: #28a745;'>🎉 Đặt hàng thành công! 🎉</h2>";
        echo "<p style='font-size: 18px; color: #555;'>Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đang được xử lý.</p>";
        echo "<p style='font-size: 16px; color: #666;'>Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận đơn hàng.</p>";
        echo "<a href='/webbanhang1/Product' style='display: inline-block; margin-top: 15px; padding: 10px 20px; font-size: 18px; color: white; background: #007bff; text-decoration: none; border-radius: 5px;'>⬅️ Tiếp tục mua sắm</a>";
        echo "</div>";
    } else {
        echo "<div style='max-width: 600px; margin: 50px auto; padding: 20px; text-align: center; border: 1px solid #ddd; border-radius: 10px; background: #f8d7da;'>";
        echo "<h2 style='color: #dc3545;'>❌ Lỗi khi xử lý đơn hàng</h2>";
        echo "<p style='font-size: 18px; color: #721c24;'>Vui lòng thử lại hoặc liên hệ với bộ phận hỗ trợ.</p>";
        echo "<a href='/webbanhang1/Product' style='display: inline-block; margin-top: 15px; padding: 10px 20px; font-size: 18px; color: white; background: #007bff; text-decoration: none; border-radius: 5px;'>⬅️ Quay lại cửa hàng</a>";
        echo "</div>";
    }
}

public function removeFromCart($id)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Kiểm tra nếu sản phẩm có trong giỏ hàng thì xóa
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    // Chuyển hướng về giỏ hàng sau khi xóa
    header("Location: /webbanhang1/Product/cart");
    exit;
}




}