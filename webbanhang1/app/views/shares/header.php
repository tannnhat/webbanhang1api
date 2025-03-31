<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            max-width: 100px;
            height: auto;
        }
        .navbar {
            background-color:rgb(70, 77, 85) !important;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .nav-link:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 900px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
        <a class="navbar-brand" href="/webbanhang1/Product/">
            <img src="webbanhang1/images/logoxe.webp" width="50" class="me-2"> Quản lý sản phẩm
        </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang1/Product/">Danh sách sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang1/Product/add">Thêm sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <?php if(SessionHelper::isLoggedIn()): ?>
                            <span class="nav-link">Xin chào, <?php echo $_SESSION['username']; ?></span>
                        <?php else: ?>
                            <a class="nav-link" href="/webbanhang1/account/login">Đăng nhập</a>
                        <?php endif; ?>
                    </li>
                    <?php if(SessionHelper::isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="/webbanhang1/account/logout">Đăng xuất</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="alert alert-primary text-center" role="alert" width = "100%" style = "font-size: 1.5rem; padding: 20px;">
            Của Hàng Mercedes-Benz 
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>