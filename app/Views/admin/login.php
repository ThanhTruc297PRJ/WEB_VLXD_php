<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: #fff; border-radius: 16px; padding: 40px 36px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .login-logo { text-align: center; margin-bottom: 30px; }
        .login-logo .icon { width: 64px; height: 64px; background: linear-gradient(135deg, #f36f21, #e85d04); border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px; }
        .login-logo .icon i { font-size: 28px; color: #fff; }
        .login-logo h1 { font-size: 1.3rem; color: #0f172a; font-weight: 800; }
        .login-logo p { font-size: 0.85rem; color: #64748b; margin-top: 4px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .form-group .input-wrap { position: relative; }
        .form-group .input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 12px 14px 12px 42px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 0.92rem; transition: border-color 0.2s; outline: none; }
        .form-group input:focus { border-color: #f36f21; }
        .error-msg { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 10px 14px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 18px; }
        .error-msg i { margin-right: 6px; }
        .btn-login { width: 100%; padding: 14px; background: linear-gradient(135deg, #f36f21, #e85d04); color: #fff; border: none; border-radius: 10px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: opacity 0.2s; }
        .btn-login:hover { opacity: 0.9; }
        .login-footer { text-align: center; margin-top: 24px; font-size: 0.8rem; color: #94a3b8; }
        .login-footer a { color: #f36f21; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <div class="icon"><i class="fa-solid fa-trowel-bricks"></i></div>
            <h1>QUẢN TRỊ VLXD</h1>
            <p>Đăng nhập vào hệ thống quản lý kho vật tư</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-msg">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo url('admin/login'); ?>" method="POST">
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Nhập tên đăng nhập" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fa-solid fa-right-to-bracket"></i> Đăng Nhập
            </button>
        </form>

        <div class="login-footer">
            <a href="<?php echo url('/'); ?>"><i class="fa-solid fa-arrow-left"></i> Quay về trang chủ</a>
        </div>
    </div>
</body>
</html>
