<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .auth-card { background: #fff; border-radius: 16px; padding: 40px 36px; width: 100%; max-width: 440px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); }
        .auth-logo { text-align: center; margin-bottom: 28px; }
        .auth-logo .icon { width: 60px; height: 60px; background: linear-gradient(135deg, #f36f21, #e85d04); border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; }
        .auth-logo .icon i { font-size: 26px; color: #fff; }
        .auth-logo h1 { font-size: 1.25rem; color: #0f172a; font-weight: 800; }
        .auth-logo p { font-size: 0.85rem; color: #64748b; margin-top: 4px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .form-group .input-wrap { position: relative; }
        .form-group .input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 12px 14px 12px 42px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 0.92rem; transition: border-color 0.2s; outline: none; font-family: inherit; }
        .form-group input:focus { border-color: #f36f21; }
        .error-msg { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 10px 14px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; }
        .error-msg i { margin-right: 6px; }
        .btn-submit { width: 100%; padding: 14px; background: linear-gradient(135deg, #f36f21, #e85d04); color: #fff; border: none; border-radius: 10px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: opacity 0.2s; font-family: inherit; }
        .btn-submit:hover { opacity: 0.9; }
        .auth-footer { text-align: center; margin-top: 22px; font-size: 0.88rem; color: #64748b; }
        .auth-footer a { color: #f36f21; text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }
        .divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; color: #94a3b8; font-size: 0.82rem; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <div class="icon"><i class="fa-solid fa-trowel-bricks"></i></div>
            <h1>ĐĂNG NHẬP</h1>
            <p>Đăng nhập tài khoản khách hàng</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-msg">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo url('login'); ?>" method="POST">
            <div class="form-group">
                <label>Email</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="Nhập email của bạn" required autofocus
                           value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
            </div>
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-right-to-bracket"></i> Đăng Nhập
            </button>
        </form>

        <div class="divider">hoặc</div>

        <div class="auth-footer">
            <p>Chưa có tài khoản? <a href="<?php echo url('register'); ?>">Đăng ký ngay</a></p>
            <p style="margin-top: 12px;">
                <a href="<?php echo url('/'); ?>" style="color: #64748b; font-weight: 500;">
                    <i class="fa-solid fa-arrow-left"></i> Quay về trang chủ
                </a>
            </p>
            <p style="margin-top: 10px;">
                <a href="<?php echo url('admin/login'); ?>" style="color: #94a3b8; font-weight: 500; font-size: 0.8rem;">
                    <i class="fa-solid fa-user-shield"></i> Dành cho quản trị viên
                </a>
            </p>
        </div>
    </div>
</body>
</html>
