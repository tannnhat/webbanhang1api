<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'app/views/shares/header.php';
?>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: url('/webbanhang1/images/xe.jpg') no-repeat center center fixed;
        background-size: cover;
        color: #fff;
        margin: 0;
        padding: 0;
    }

    .container {
        background: rgba(0, 0, 0, 0.8);
        padding: 30px;
        border-radius: 10px;
        margin-top: 20px;
    }

    h1 {
        color: #f8f9fa;
    }

    .card {
        background: rgba(255, 255, 255, 0.95);
        color: #333;
        border-radius: 15px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2);
    }

    .card img {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .btn {
        border-radius: 20px;
    }

    .btn-warning, .btn-danger, .btn-primary {
        transition: all 0.2s ease-in-out;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .text-muted {
        font-size: 0.9rem;
    }

    .product-price {
        font-size: 1.1rem;
        font-weight: bold;
        color: #dc3545;
    }

    .category-label {
        font-size: 0.9rem;
    }
</style>

<div class="container mt-4">
    <h1 class="text-center mb-4">Danh sách sản phẩm</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="/webbanhang1/Product/add" class="btn btn-success">+ Thêm sản phẩm mới</a>
    </div>

    <?php if (!empty($products)): ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <?php if (!empty($product->image)): ?>
                            <img src="/webbanhang1/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                                 class="card-img-top img-fluid" 
                                 alt="Hình ảnh sản phẩm">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="/webbanhang1/Product/show/<?php echo $product->id; ?>" 
                                   class="text-decoration-none text-dark">
                                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h5>

                            <p class="card-text text-muted">
                                <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                            
                            <p class="product-price">Giá: 
                                <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                            </p>
                            
                            <p class="text-muted category-label">Danh mục: 
                                <?php echo isset($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Chưa có danh mục'; ?>
                            </p>
                        </div>

                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between">
                                <a href="/webbanhang1/Product/edit/<?php echo $product->id; ?>" 
                                   class="btn btn-warning btn-sm">
                                    ✏️ Sửa
                                </a>

                                <a href="/webbanhang1/Product/delete/<?php echo $product->id; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    ❌ Xóa
                                </a>

                                <a href="/webbanhang1/Product/addToCart/<?php echo $product->id; ?>" 
                                   class="btn btn-primary btn-sm">
                                    🛒 Thêm vào giỏ hàng
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">Không có sản phẩm nào.</p>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>