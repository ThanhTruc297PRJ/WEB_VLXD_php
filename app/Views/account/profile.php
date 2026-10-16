<?php
$errors = [
    'empty' => 'Vui lòng nhập đầy đủ họ tên và số điện thoại.',
    'wrong_password' => 'Mật khẩu hiện tại không đúng.',
    'short_password' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
    'mismatch' => 'Mật khẩu xác nhận không khớp.',
];
$successes = [
    'profile' => 'Cập nhật hồ sơ thành công!',
    'password' => 'Đổi mật khẩu thành công!',
];
?>

<div class="container" style="padding: 30px 20px;">
    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
        <a href="<?php echo url('/'); ?>" style="color: var(--primary);"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <span style="margin: 0 8px;">/</span><span>Hồ sơ tài khoản</span>
    </div>

    <div class="account-layout">
        <!-- SIDEBAR -->
        <div class="account-sidebar">
            <div style="background: #fff; border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; box-shadow: var(--shadow-sm);">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #f36f21, #ff9a56); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800;">
                        <?php echo mb_strtoupper(mb_substr($_SESSION['customer_name'], 0, 1)); ?>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 0.9rem; color: #1e293b;"><?php echo htmlspecialchars($_SESSION['customer_name']); ?></div>
                        <div style="font-size: 0.78rem; color: #94a3b8;"><?php echo htmlspecialchars($_SESSION['customer_email']); ?></div>
                    </div>
                </div>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li><a href="<?php echo url('account/orders'); ?>" style="display: flex; align-items: center; gap: 8px; padding: 10px 12px; border-radius: 8px; text-decoration: none; font-size: 0.88rem; font-weight: 600; color: #475569;"><i class="fa-solid fa-clipboard-list"></i> Đơn hàng của tôi</a></li>
                    <li><a href="<?php echo url('account/profile'); ?>" style="display: flex; align-items: center; gap: 8px; padding: 10px 12px; border-radius: 8px; text-decoration: none; font-size: 0.88rem; font-weight: 700; background: rgba(243,111,33,0.08); color: var(--primary);"><i class="fa-solid fa-user"></i> Hồ sơ tài khoản</a></li>
                </ul>
            </div>
        </div>

        <!-- NỘI DUNG -->
        <div class="account-content">
            <?php if (!empty($error) && isset($errors[$error])): ?>
                <div style="background: #fee2e2; border-left: 4px solid #ef4444; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 0.88rem; color: #991b1b;">
                    <i class="fa-solid fa-circle-exclamation"></i> <?php echo $errors[$error]; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success) && isset($successes[$success])): ?>
                <div style="background: #d1fae5; border-left: 4px solid #10b981; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 0.88rem; color: #065f46;">
                    <i class="fa-solid fa-circle-check"></i> <?php echo $successes[$success]; ?>
                </div>
            <?php endif; ?>

            <!-- THÔNG TIN CÁ NHÂN -->
            <div style="background: #fff; border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; box-shadow: var(--shadow-sm); margin-bottom: 20px;">
                <h3 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9;">
                    <i class="fa-solid fa-user-pen" style="color: var(--primary);"></i> Thông Tin Cá Nhân
                </h3>
                <form action="<?php echo url('account/profile/update'); ?>" method="POST">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Họ và tên <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="fullname" value="<?php echo htmlspecialchars($customer['fullname']); ?>" required
                                style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.88rem; font-family: inherit; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Số điện thoại <span style="color: #ef4444;">*</span></label>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" required
                                style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.88rem; font-family: inherit; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Email</label>
                            <input type="email" value="<?php echo htmlspecialchars($customer['email']); ?>" disabled
                                style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.88rem; font-family: inherit; box-sizing: border-box; background: #f8fafc; color: #94a3b8;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Địa chỉ</label>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($customer['address'] ?? ''); ?>" placeholder="Nhập địa chỉ giao hàng mặc định"
                                style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.88rem; font-family: inherit; box-sizing: border-box;">
                        </div>
                    </div>
                    <div style="margin-top: 16px; text-align: right;">
                        <button type="submit" class="btn-primary" style="padding: 10px 24px;">
                            <i class="fa-solid fa-save"></i> Lưu Thông Tin
                        </button>
                    </div>
                </form>
            </div>

            <!-- ĐỔI MẬT KHẨU -->
            <div style="background: #fff; border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9;">
                    <i class="fa-solid fa-lock" style="color: #2563eb;"></i> Đổi Mật Khẩu
                </h3>
                <form action="<?php echo url('account/profile/password'); ?>" method="POST">
                    <div class="profile-password-grid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Mật khẩu hiện tại <span style="color: #ef4444;">*</span></label>
                            <input type="password" name="current_password" required
                                style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.88rem; font-family: inherit; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Mật khẩu mới <span style="color: #ef4444;">*</span></label>
                            <input type="password" name="new_password" required minlength="6"
                                style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.88rem; font-family: inherit; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Xác nhận mật khẩu <span style="color: #ef4444;">*</span></label>
                            <input type="password" name="confirm_password" required minlength="6"
                                style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.88rem; font-family: inherit; box-sizing: border-box;">
                        </div>
                    </div>
                    <div style="margin-top: 16px; text-align: right;">
                        <button type="submit" style="padding: 10px 24px; background: #2563eb; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.88rem; cursor: pointer; font-family: inherit;">
                            <i class="fa-solid fa-key"></i> Đổi Mật Khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
