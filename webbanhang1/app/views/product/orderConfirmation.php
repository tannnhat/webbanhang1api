<?php include 'app/views/shares/header.php'; ?>

<div class="container text-center mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-success fw-bold">🎉 Đặt hàng thành công!</h2>
        <p class="text-muted">Cảm ơn bạn đã mua hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất.</p>
        <a href="/webbanhang1/Product" class="btn btn-primary btn-lg mt-3">
            🏠 Quay lại trang chủ
        </a>
    </div>
</div>

<style>
    .card {
        background: #f8f9fa;
        border-radius: 15px;
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: scale(1.02);
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>
