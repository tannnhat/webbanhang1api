<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        background: url('/webbanhang1/assets/images/login-bg.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-card {
        background: rgba(0, 0, 0, 0.9);
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        color: #fff;
        box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2);
        max-width: 400px;
        width: 100%;
    }

    .form-control {
        background: transparent;
        border: 1px solid #fff;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
    }
    
    .form-control:focus {
        background: transparent;
        color: #fff;
        border-color: #00c6ff;
        box-shadow: none;
    }

    .login-btn {
        background: linear-gradient(to right, #00c6ff, #0072ff);
        border: none;
        padding: 12px;
        border-radius: 25px;
        width: 100%;
        font-size: 18px;
        font-weight: bold;
        transition: 0.3s;
    }

    .login-btn:hover {
        background: linear-gradient(to right, #0072ff, #00c6ff);
    }

    .social-icons a {
        color: #fff;
        margin: 0 10px;
        font-size: 20px;
        transition: 0.3s;
    }
    
    .social-icons a:hover {
        color: #00c6ff;
    }

    .footer-link {
        color: #fff;
        text-decoration: none;
    }

    .footer-link:hover {
        text-decoration: underline;
    }

    .password-toggle {
        cursor: pointer;
        position: relative;
        top: -38px;
        right: 10px;
        color: #fff;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <h2 class="fw-bold mb-3">Đăng Nhập</h2>
        <p class="text-white-50 mb-4">Vui lòng nhập thông tin đăng nhập của bạn</p>
        
        <form action="/webbanhang1/account/checklogin" method="post">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Tên Đăng Nhập" required>
            </div>
            
            <div class="mb-3 position-relative">
                <input type="password" name="password" id="password" class="form-control" placeholder="Mật Khẩu" required>
                <span class="password-toggle" onclick="togglePasswordVisibility()">
                    <i id="toggleIcon" class="fas fa-eye"></i>
                </span>
            </div>
            
            <p class="small mb-3"><a class="text-white-50" href="#">Quên mật khẩu?</a></p>
            
            <button class="btn login-btn" type="submit">Đăng Nhập</button>
        </form>

        <div class="social-icons mt-4">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-google"></i></a>
        </div>

        <p class="mt-3">Chưa có tài khoản? <a href="/webbanhang1/account/register" class="text-white-50 fw-bold footer-link">Đăng Ký</a></p>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>

<?php include 'app/views/shares/footer.php'; ?>