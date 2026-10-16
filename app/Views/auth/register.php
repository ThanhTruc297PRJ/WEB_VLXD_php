<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .auth-card { background: #fff; border-radius: 16px; padding: 36px 34px; width: 100%; max-width: 480px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); }
        .auth-logo { text-align: center; margin-bottom: 24px; }
        .auth-logo .icon { width: 60px; height: 60px; background: linear-gradient(135deg, #f36f21, #e85d04); border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; }
        .auth-logo .icon i { font-size: 26px; color: #fff; }
        .auth-logo h1 { font-size: 1.25rem; color: #0f172a; font-weight: 800; }
        .auth-logo p { font-size: 0.85rem; color: #64748b; margin-top: 4px; }
        .form-row { display: flex; gap: 12px; }
        .form-row .form-group { flex: 1; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 5px; }
        .form-group label .required { color: #ef4444; }
        .form-group .input-wrap { position: relative; }
        .form-group .input-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem; }
        .form-group input { width: 100%; padding: 11px 12px 11px 38px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; transition: border-color 0.2s; outline: none; font-family: inherit; }
        .form-group input:focus { border-color: #f36f21; }
        .error-msg { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 10px 14px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 14px; }
        .error-msg i { margin-right: 6px; }
        .btn-submit { width: 100%; padding: 13px; background: linear-gradient(135deg, #f36f21, #e85d04); color: #fff; border: none; border-radius: 10px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: opacity 0.2s; font-family: inherit; }
        .btn-submit:hover { opacity: 0.9; }
        .auth-footer { text-align: center; margin-top: 20px; font-size: 0.88rem; color: #64748b; }
        .auth-footer a { color: #f36f21; text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }
        .divider { display: flex; align-items: center; gap: 12px; margin: 18px 0; color: #94a3b8; font-size: 0.82rem; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
        .note { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 10px 14px; border-radius: 8px; font-size: 0.82rem; margin-bottom: 14px; }
        .note i { margin-right: 6px; }
        @media (max-width: 500px) { .form-row { flex-direction: column; gap: 0; } }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <div class="icon"><i class="fa-solid fa-user-plus"></i></div>
            <h1>ĐĂNG KÝ TÀI KHOẢN</h1>
            <p>Tạo tài khoản để mua hàng & theo dõi đơn hàng</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-msg">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="note">
            <i class="fa-solid fa-envelope-circle-check"></i> Sau khi đăng ký, hệ thống sẽ gửi mã xác thực 6 số về email của bạn.
        </div>

        <form action="<?php echo url('register'); ?>" method="POST">
            <div class="form-group">
                <label>Họ và tên <span class="required">*</span></label>
                <div class="input-wrap">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="fullname" placeholder="Nguyễn Văn A" required
                           value="<?php echo htmlspecialchars($old['fullname'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Số điện thoại <span class="required">*</span></label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" name="phone" placeholder="0912 345 678" required
                               value="<?php echo htmlspecialchars($old['phone'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" placeholder="email@example.com" required
                               value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Mật khẩu <span class="required">*</span></label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" placeholder="Tối thiểu 6 ký tự" required minlength="6">
                    </div>
                </div>
                <div class="form-group">
                    <label>Xác nhận mật khẩu <span class="required">*</span></label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password_confirm" placeholder="Nhập lại mật khẩu" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Gửi Mã Xác Thực
            </button>
        </form>

        <div class="divider">hoặc</div>

        <div class="auth-footer">
            <p>Đã có tài khoản? <a href="<?php echo url('login'); ?>">Đăng nhập</a></p>
            <p style="margin-top: 12px;">
                <a href="<?php echo url('/'); ?>" style="color: #64748b; font-weight: 500;">
                    <i class="fa-solid fa-arrow-left"></i> Quay về trang chủ
                </a>
            </p>
        </div>
    </div>
</body>
</html>
