<?php
$successMsg = [
    'store'    => 'Cập nhật thông tin cửa hàng thành công!',
    'bank'     => 'Cập nhật thông tin ngân hàng thành công!',
    'shipping' => 'Cập nhật bảng giá vận chuyển thành công!',
];
?>

<header class="admin-header">
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a;"><i class="fa-solid fa-gear" style="color: var(--primary);"></i> Cài Đặt Hệ Thống</h2>
        <p style="font-size: 0.82rem; color: #64748b;">Chỉnh sửa thông tin cửa hàng, ngân hàng và bảng giá vận chuyển</p>
    </div>
</header>

<div class="admin-body">
    <?php if (!empty($success) && isset($successMsg[$success])): ?>
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-left: 4px solid #10b981; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 0.88rem; color: #065f46;">
            <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 1.1rem;"></i>
            <strong><?php echo $successMsg[$success]; ?></strong>
        </div>
    <?php endif; ?>

    <!-- THÔNG TIN CỬA HÀNG -->
    <div style="background: #fff; border-radius: 14px; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-bottom: 22px;">
        <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9;">
            <i class="fa-solid fa-store" style="color: var(--primary);"></i> Thông Tin Cửa Hàng
        </h3>
        <form action="<?php echo url('admin/settings/store'); ?>" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Tên cửa hàng</label>
                    <input type="text" name="site_name" value="<?php echo htmlspecialchars(SITE_NAME); ?>" required
                        style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Hotline</label>
                    <input type="text" name="site_hotline" value="<?php echo htmlspecialchars(SITE_HOTLINE); ?>" required
                        style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
                </div>
                <div style="grid-column: 1 / -1;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Slogan</label>
                    <input type="text" name="site_slogan" value="<?php echo htmlspecialchars(SITE_SLOGAN); ?>"
                        style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Email</label>
                    <input type="email" name="site_email" value="<?php echo htmlspecialchars(SITE_EMAIL); ?>"
                        style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Địa chỉ</label>
                    <input type="text" name="site_address" value="<?php echo htmlspecialchars(SITE_ADDRESS); ?>"
                        style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
                </div>
                <div style="grid-column: 1 / -1;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Kho bãi</label>
                    <input type="text" name="site_warehouse" value="<?php echo htmlspecialchars(SITE_WAREHOUSE); ?>"
                        style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
                </div>
            </div>
            <div style="margin-top: 16px; text-align: right;">
                <button type="submit" style="padding: 10px 24px; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; font-family: inherit;">
                    <i class="fa-solid fa-save"></i> Lưu Thông Tin
                </button>
            </div>
        </form>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 22px;">
        <!-- NGÂN HÀNG -->
        <div style="background: #fff; border-radius: 14px; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9;">
                <i class="fa-solid fa-building-columns" style="color: #2563eb;"></i> Thanh Toán Ngân Hàng
            </h3>
            <form action="<?php echo url('admin/settings/bank'); ?>" method="POST">
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Mã ngân hàng (VietQR)</label>
                    <input type="text" name="bank_id" value="<?php echo htmlspecialchars(BANK_ID); ?>" required
                        style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Số tài khoản</label>
                    <input type="text" name="bank_account_no" value="<?php echo htmlspecialchars(BANK_ACCOUNT_NO); ?>" required
                        style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Tên chủ tài khoản</label>
                    <input type="text" name="bank_account_name" value="<?php echo htmlspecialchars(BANK_ACCOUNT_NAME); ?>" required
                        style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
                </div>
                <button type="submit" style="width: 100%; padding: 10px; background: #2563eb; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; font-family: inherit;">
                    <i class="fa-solid fa-save"></i> Lưu Ngân Hàng
                </button>
            </form>
        </div>

        <!-- BẢNG GIÁ VẬN CHUYỂN -->
        <div style="background: #fff; border-radius: 14px; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9;">
                <i class="fa-solid fa-truck" style="color: #10b981;"></i> Bảng Giá Vận Chuyển
            </h3>
            <form action="<?php echo url('admin/settings/shipping'); ?>" method="POST">
                <div style="font-size: 0.8rem; color: #64748b; margin-bottom: 12px;">
                    <strong>Giá cước cơ bản</strong> + phí/km ngoài phạm vi miễn phí
                </div>
                <?php foreach (SHIPPING_RATES as $vehicle => $rate): ?>
                    <div style="background: #f8fafc; border-radius: 8px; padding: 12px; margin-bottom: 10px;">
                        <input type="text" name="vehicle[]" value="<?php echo htmlspecialchars($vehicle); ?>" style="width: 100%; padding: 8px 10px; border: 2px solid #e2e8f0; border-radius: 6px; font-size: 0.84rem; font-family: inherit; font-weight: 600; margin-bottom: 8px; box-sizing: border-box;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                            <div>
                                <label style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Giá cơ bản</label>
                                <input type="number" name="base[]" value="<?php echo $rate['base']; ?>" style="width: 100%; padding: 6px 8px; border: 2px solid #e2e8f0; border-radius: 6px; font-size: 0.82rem; font-family: inherit; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">KM miễn phí</label>
                                <input type="number" name="free_km[]" value="<?php echo $rate['free_km']; ?>" style="width: 100%; padding: 6px 8px; border: 2px solid #e2e8f0; border-radius: 6px; font-size: 0.82rem; font-family: inherit; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Phí/km thêm</label>
                                <input type="number" name="per_km[]" value="<?php echo $rate['per_km']; ?>" style="width: 100%; padding: 6px 8px; border: 2px solid #e2e8f0; border-radius: 6px; font-size: 0.82rem; font-family: inherit; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button type="submit" style="width: 100%; padding: 10px; background: #10b981; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; font-family: inherit; margin-top: 6px;">
                    <i class="fa-solid fa-save"></i> Lưu Vận Chuyển
                </button>
            </form>
        </div>
    </div>
</div>
