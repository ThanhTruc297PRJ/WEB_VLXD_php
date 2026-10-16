<?php if (!empty($order_success) && $order_success === true): ?>
<!-- ORDER SUCCESS PAGE -->
<div class="container" style="padding: 40px 20px;">
    <div style="max-width: 680px; margin: 0 auto; background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 40px; text-align: center; box-shadow: var(--shadow-sm);">
        <div style="width: 80px; height: 80px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fa-solid fa-circle-check" style="font-size: 42px; color: #10b981;"></i>
        </div>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: var(--secondary-dark); margin-bottom: 8px;">Đặt Hàng Thành Công!</h2>
        <p style="color: var(--text-muted); font-size: 0.92rem; margin-bottom: 20px;">
            Cảm ơn bạn đã đặt hàng tại VLXD Hương Tiến. Chúng tôi sẽ liên hệ xác nhận đơn hàng trong thời gian sớm nhất.
        </p>

        <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-bottom: 25px; text-align: left;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 0.88rem;">
                <div>
                    <span style="color: var(--text-muted);">Mã đơn hàng:</span><br>
                    <strong style="color: var(--primary); font-size: 1.1rem;"><?php echo htmlspecialchars($order_code); ?></strong>
                </div>
                <div>
                    <span style="color: var(--text-muted);">Tổng thanh toán:</span><br>
                    <strong style="color: var(--secondary-dark); font-size: 1.1rem;"><?php echo number_format($order_total, 0, ',', '.'); ?> đ</strong>
                </div>
                <div>
                    <span style="color: var(--text-muted);">Phí vận chuyển:</span><br>
                    <strong style="color: var(--secondary-dark);"><?php echo number_format($order_shipping, 0, ',', '.'); ?> đ</strong>
                </div>
                <div>
                    <span style="color: var(--text-muted);">Phương thức thanh toán:</span><br>
                    <strong style="color: var(--secondary-dark);"><?php echo $order_payment === 'BANK_TRANSFER' ? 'Chuyển khoản ngân hàng' : 'Thanh toán khi nhận hàng (COD)'; ?></strong>
                </div>
            </div>
        </div>

        <?php if ($order_payment === 'BANK_TRANSFER'): ?>
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #1e40af; margin-bottom: 12px;">
                    <i class="fa-solid fa-qrcode"></i> Quét Mã VietQR Để Thanh Toán
                </h3>
                <img src="<?php echo buildVietQRUrl($order_total, $order_code); ?>" alt="VietQR thanh toán" style="max-width: 280px; border-radius: 8px; border: 1px solid #bfdbfe; margin-bottom: 12px;">
                <div style="font-size: 0.82rem; color: #1e40af; text-align: left; line-height: 1.7;">
                    <p><strong>Ngân hàng:</strong> <?php echo BANK_ID; ?></p>
                    <p><strong>Số tài khoản:</strong> <?php echo BANK_ACCOUNT_NO; ?></p>
                    <p><strong>Chủ tài khoản:</strong> <?php echo BANK_ACCOUNT_NAME; ?></p>
                    <p><strong>Nội dung CK:</strong> <?php echo htmlspecialchars($order_code); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            <a href="<?php echo url('/'); ?>" class="btn-secondary" style="text-decoration: none;">
                <i class="fa-solid fa-house"></i> Về Trang Chủ
            </a>
            <a href="<?php echo url('products'); ?>" class="btn-primary" style="text-decoration: none;">
                <i class="fa-solid fa-boxes-stacked"></i> Tiếp Tục Mua Hàng
            </a>
        </div>
    </div>
</div>

<?php else: ?>
<!-- CHECKOUT FORM PAGE -->
<div class="container" style="padding: 30px 20px;">

    <!-- Breadcrumb -->
    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 25px;">
        <a href="<?php echo url('/'); ?>" style="color: var(--primary);"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <span style="margin: 0 8px;">/</span>
        <a href="<?php echo url('cart'); ?>" style="color: var(--primary);">Giỏ hàng</a>
        <span style="margin: 0 8px;">/</span>
        <span>Đặt hàng & Giao nhận</span>
    </div>

    <h2 style="font-size: 1.4rem; font-weight: 800; color: var(--secondary-dark); margin-bottom: 25px;">
        <i class="fa-solid fa-file-invoice-dollar" style="color: var(--primary);"></i> Thông Tin Đặt Hàng & Giao Nhận Công Trình
    </h2>

    <form action="<?php echo url('checkout'); ?>" method="POST" id="checkout-form">
        <div style="display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 30px; align-items: start;">

            <!-- LEFT: Form fields -->
            <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 25px; box-shadow: var(--shadow-sm);">

                <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 18px; border-bottom: 2px solid var(--primary-light); padding-bottom: 8px;">
                    <i class="fa-solid fa-user-pen" style="color: var(--primary);"></i> Thông Tin Người Nhận
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--secondary-dark); margin-bottom: 6px;">
                            Họ tên người nhận <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="customer_name" required placeholder="VD: Nguyễn Văn Thắng" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--secondary-dark); margin-bottom: 6px;">
                            Số điện thoại <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="tel" name="customer_phone" required placeholder="VD: 0912.345.678" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
                    </div>
                </div>

                <div style="margin-top: 16px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--secondary-dark); margin-bottom: 6px;">
                        Email (nhận xác nhận đơn hàng)
                    </label>
                    <input type="email" name="customer_email" placeholder="VD: email@congty.vn" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
                </div>

                <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--secondary-dark); margin: 25px 0 18px; border-bottom: 2px solid var(--primary-light); padding-bottom: 8px;">
                    <i class="fa-solid fa-truck-fast" style="color: var(--primary);"></i> Thông Tin Giao Hàng
                </h3>

                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--secondary-dark); margin-bottom: 6px;">
                        Địa chỉ công trình / giao hàng <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="delivery_address" required placeholder="VD: 123 Đường Võ Nguyên Giáp, TP Thủ Đức" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 16px;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--secondary-dark); margin-bottom: 6px;">
                            Cự ly vận chuyển (km) <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="number" name="distance_km" id="distance_km" required min="0" max="200" value="5" step="0.5" placeholder="VD: 10" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--secondary-dark); margin-bottom: 6px;">
                            Yêu cầu phương tiện <span style="color: #ef4444;">*</span>
                        </label>
                        <select name="vehicle_requirement" id="vehicle_requirement" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem; background: #fff; box-sizing: border-box;">
                            <option value="Xe ben 5 tấn">Xe ben 5 tấn</option>
                            <option value="Xe tải 2.5 tấn">Xe tải 2.5 tấn</option>
                            <option value="Xe ba gác trung chuyển">Xe ba gác trung chuyển</option>
                            <option value="Xe cẩu 15 tấn">Xe cẩu 15 tấn</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 16px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--secondary-dark); margin-bottom: 6px;">
                        Ghi chú thêm
                    </label>
                    <textarea name="notes" rows="3" placeholder="VD: Giao trước 7h sáng, hẻm rộng 3m, cần xe nhỏ trung chuyển..." style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem; resize: vertical; box-sizing: border-box;"></textarea>
                </div>

                <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--secondary-dark); margin: 25px 0 18px; border-bottom: 2px solid var(--primary-light); padding-bottom: 8px;">
                    <i class="fa-solid fa-credit-card" style="color: var(--primary);"></i> Phương Thức Thanh Toán
                </h3>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <label style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 2px solid var(--primary); border-radius: 8px; cursor: pointer; transition: border-color 0.2s;">
                        <input type="radio" name="payment_method" value="COD" checked style="accent-color: var(--primary); width: 18px; height: 18px;">
                        <div>
                            <strong style="color: var(--secondary-dark); font-size: 0.92rem;"><i class="fa-solid fa-money-bill-wave" style="color: #10b981;"></i> Thanh toán khi nhận hàng (COD)</strong>
                            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;">Thanh toán tiền mặt cho tài xế khi nhận đủ hàng tại công trình</p>
                        </div>
                    </label>
                    <label style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 2px solid var(--border-color); border-radius: 8px; cursor: pointer; transition: border-color 0.2s;">
                        <input type="radio" name="payment_method" value="BANK_TRANSFER" style="accent-color: var(--primary); width: 18px; height: 18px;">
                        <div>
                            <strong style="color: var(--secondary-dark); font-size: 0.92rem;"><i class="fa-solid fa-building-columns" style="color: #3b82f6;"></i> Chuyển khoản ngân hàng (VietQR)</strong>
                            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;">Quét mã QR thanh toán nhanh qua ứng dụng ngân hàng</p>
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; font-size: 1rem; padding: 14px; margin-top: 25px;">
                    <i class="fa-solid fa-paper-plane"></i> Xác Nhận Đặt Hàng
                </button>
            </div>

            <!-- RIGHT: Order summary -->
            <div>
                <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 22px; box-shadow: var(--shadow-sm); position: sticky; top: 20px;">
                    <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 16px; border-bottom: 2px solid var(--primary-light); padding-bottom: 8px;">
                        <i class="fa-solid fa-clipboard-list" style="color: var(--primary);"></i> Đơn Hàng Của Bạn
                    </h3>

                    <div style="max-height: 320px; overflow-y: auto; margin-bottom: 16px;">
                        <?php foreach ($cart_items as $id => $item): ?>
                            <div style="display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f1f5f9; align-items: center;">
                                <img src="<?php echo htmlspecialchars($item['image'] ?? asset('images/no-image.svg')); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 48px; height: 48px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-color);" onerror="this.onerror=null;this.src='<?php echo asset('images/no-image.svg'); ?>'">
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-size: 0.84rem; font-weight: 600; color: var(--secondary-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo htmlspecialchars($item['name']); ?></div>
                                    <div style="font-size: 0.78rem; color: var(--text-muted);">SL: <?php echo (int)$item['quantity']; ?> <?php echo htmlspecialchars($item['unit'] ?? ''); ?></div>
                                </div>
                                <div style="font-size: 0.85rem; font-weight: 700; color: var(--primary); white-space: nowrap;">
                                    <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div style="border-top: 1px solid var(--border-color); padding-top: 14px; font-size: 0.88rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: var(--text-muted);">Tạm tính hàng hóa:</span>
                            <strong style="color: var(--secondary-dark);"><?php echo number_format($cart_total, 0, ',', '.'); ?> đ</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: var(--text-muted);">Cự ly giao hàng:</span>
                            <span style="color: var(--secondary-dark); font-weight: 600;" id="ship-km">5 km</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: var(--text-muted);">Phí vận chuyển:</span>
                            <strong style="color: #f59e0b;" id="ship-fee">250.000 đ</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 12px; border-top: 2px solid var(--secondary-dark); font-size: 1.1rem; font-weight: 800;">
                            <span style="color: var(--secondary-dark);">Tổng thanh toán:</span>
                            <span style="color: var(--primary);" id="grand-total"><?php echo number_format($cart_total + 250000, 0, ',', '.'); ?> đ</span>
                        </div>
                    </div>

                    <div style="margin-top: 16px; padding: 12px; background: #fffbeb; border-radius: 6px; font-size: 0.8rem; color: #92400e; line-height: 1.6;">
                        <i class="fa-solid fa-circle-info" style="color: #f59e0b;"></i>
                        <strong>Lưu ý:</strong> Phí vận chuyển được tính tự động theo cự ly và loại xe. Miễn phí trong bán kính <span id="ship-free-note">5</span> km đầu tiên (tùy loại xe).
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 16px; margin-top: 16px; box-shadow: var(--shadow-sm);">
                    <a href="<?php echo url('cart'); ?>" style="display: flex; align-items: center; gap: 8px; color: var(--primary); font-size: 0.88rem; font-weight: 600; text-decoration: none;">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại chỉnh sửa giỏ hàng
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- Shipping fee calculation script -->
<script>
(function() {
    var cartTotal = <?php echo (float)$cart_total; ?>;
    var rates = <?php echo json_encode(SHIPPING_RATES, JSON_UNESCAPED_UNICODE); ?>;

    var distanceInput = document.getElementById('distance_km');
    var vehicleSelect = document.getElementById('vehicle_requirement');
    var shipKmEl      = document.getElementById('ship-km');
    var shipFeeEl     = document.getElementById('ship-fee');
    var grandTotalEl  = document.getElementById('grand-total');
    var freeNoteEl    = document.getElementById('ship-free-note');

    function formatNumber(n) {
        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function calcShipping() {
        var km = parseFloat(distanceInput.value) || 0;
        if (km < 0) km = 0;
        var vehicle = vehicleSelect.value;
        var rate = rates[vehicle] || rates[Object.keys(rates)[0]];
        var freeKm = rate.free_km || 0;
        var extraKm = Math.max(0, Math.ceil(km) - freeKm);
        var fee = rate.base + extraKm * rate.per_km;

        shipKmEl.textContent = km + ' km';
        shipFeeEl.textContent = formatNumber(fee) + ' đ';
        grandTotalEl.textContent = formatNumber(cartTotal + fee) + ' đ';
        freeNoteEl.textContent = freeKm;
    }

    distanceInput.addEventListener('input', calcShipping);
    vehicleSelect.addEventListener('change', calcShipping);
    calcShipping();

    // Payment method radio style
    document.querySelectorAll('[name=payment_method]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.querySelectorAll('[name=payment_method]').forEach(function(r) {
                r.closest('label').style.borderColor = r.checked ? 'var(--primary)' : 'var(--border-color)';
            });
        });
    });
})();
</script>

<?php endif; ?>
