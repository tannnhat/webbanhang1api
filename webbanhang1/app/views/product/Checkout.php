<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                <div class="card-header text-center bg-success text-white py-4">
                    <h3 class="mb-0 fw-bold">Thanh toán đơn hàng</h3>
                </div>
                <div class="card-body p-4">
                <form method="POST" action="/webbanhang1/Product/processCheckout">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Họ và Tên:</label>
                            <input type="text" id="name" name="name" class="form-control rounded-pill" placeholder="Nhập họ tên" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Số điện thoại:</label>
                            <input type="text" id="phone" name="phone" class="form-control rounded-pill" placeholder="Nhập số điện thoại" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">Địa chỉ giao hàng:</label>
                            <textarea id="address" name="address" class="form-control rounded-3" rows="3" placeholder="Nhập địa chỉ" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">Xác nhận thanh toán</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="/webbanhang1/Product/cart" class="btn btn-outline-secondary w-100 py-2 fw-bold shadow-sm">Quay lại giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
