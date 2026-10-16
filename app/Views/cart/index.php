<?php
/** @var array $cart_items */
/** @var float $cart_total */
/** @var array|null $flash */
?>
<div class="container" style="padding: 30px 20px;">

    <!-- Breadcrumb -->
    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 25px;">
        <a href="<?php echo url('/'); ?>" style="color: var(--primary);"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <span style="margin: 0 8px;">/</span>
        <span>Giỏ hàng vật tư</span>
    </div>

    <!-- Flash message -->
    <?php if ($flash): ?>
        <div style="padding: 14px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; font-weight: 600;
            <?php if ($flash['type'] === 'success'): ?>
                background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46;
            <?php elseif ($flash['type'] === 'error'): ?>
                background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b;
            <?php else: ?>
                background: #fffbeb; border-left: 4px solid #f59e0b; color: #92400e;
            <?php endif; ?>
        ">
            <i class="fa-solid <?php echo $flash['type'] === 'success' ? 'fa-circle-check' : ($flash['type'] === 'error' ? 'fa-circle-xmark' : 'fa-triangle-exclamation'); ?>"></i>
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($cart_items)): ?>
        <!-- Empty cart -->
        <div style="background: #ffffff; border: 1px dashed var(--border-color); border-radius: var(--radius-md); padding: 60px 20px; text-align: center;">
            <i class="fa-solid fa-cart-shopping" style="font-size: 64px; color: #cbd5e1; margin-bottom: 20px;"></i>
            <h3 style="font-size: 1.25rem; color: var(--secondary-dark); margin-bottom: 10px;">Giỏ hàng vật tư đang trống</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 25px;">Bạn chưa chọn sản phẩm nào. Hãy xem danh mục vật liệu xây dựng để đặt mua.</p>
            <a href="<?php echo url('products'); ?>" class="btn-primary">
                <i class="fa-solid fa-boxes-stacked"></i> Xem Danh Mục Vật Tư
            </a>
        </div>
    <?php else: ?>
        <form action="<?php echo url('cart'); ?>" method="POST" id="cart-form">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="product_id" id="delete-product-id" value="">

            <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-sm);">
                <table class="cart-table" style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                    <thead>
                        <tr style="background: var(--secondary-dark); color: #ffffff;">
                            <th style="padding: 14px 16px; text-align: left; font-weight: 700;">Tên Vật Liệu</th>
                            <th style="padding: 14px 16px; text-align: right; font-weight: 700;">Đơn Giá</th>
                            <th style="padding: 14px 16px; text-align: center; font-weight: 700;">Số Lượng</th>
                            <th style="padding: 14px 16px; text-align: right; font-weight: 700;">Thành Tiền</th>
                            <th style="padding: 14px 16px; text-align: center; font-weight: 700;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $id => $item): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 14px 16px;">
                                    <div class="cart-product-info" style="display: flex; align-items: center; gap: 14px;">
                                        <img class="cart-product-img" src="<?php echo htmlspecialchars($item['image'] ?? asset('images/no-image.svg')); ?>" onerror="this.onerror=null;this.src='<?php echo asset('images/no-image.svg'); ?>'" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 64px; height: 64px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color);">
                                        <div>
                                            <strong style="color: var(--secondary-dark); font-size: 0.92rem;"><?php echo htmlspecialchars($item['name']); ?></strong>
                                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 3px;">ĐVT: <?php echo htmlspecialchars($item['unit'] ?? 'Cây'); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 14px 16px; text-align: right; font-weight: 600; color: var(--secondary-dark); white-space: nowrap;">
                                    <?php echo formatCurrency($item['price']); ?>
                                </td>
                                <td style="padding: 14px 16px; text-align: center;">
                                    <div class="quantity-control" style="display: inline-flex; align-items: center; border: 1px solid var(--border-color); border-radius: 6px; overflow: hidden;">
                                        <button type="button" class="qty-btn-minus" data-id="<?php echo $id; ?>" style="width: 34px; height: 36px; border: none; background: #f1f5f9; cursor: pointer; font-size: 1rem; font-weight: 700; color: var(--secondary-dark);">-</button>
                                        <input type="number" name="quantities[<?php echo $id; ?>]" value="<?php echo (int)$item['quantity']; ?>" min="1" max="9999" style="width: 56px; height: 36px; border: none; border-left: 1px solid var(--border-color); border-right: 1px solid var(--border-color); text-align: center; font-weight: 700; font-size: 0.9rem;" id="qty-<?php echo $id; ?>">
                                        <button type="button" class="qty-btn-plus" data-id="<?php echo $id; ?>" style="width: 34px; height: 36px; border: none; background: #f1f5f9; cursor: pointer; font-size: 1rem; font-weight: 700; color: var(--secondary-dark);">+</button>
                                    </div>
                                </td>
                                <td style="padding: 14px 16px; text-align: right; font-weight: 700; color: var(--primary); white-space: nowrap;">
                                    <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> <span class="currency-symbol">đ</span>
                                </td>
                                <td style="padding: 14px 16px; text-align: center;">
                                    <button type="button" class="btn-delete-item" data-id="<?php echo $id; ?>" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.1rem; padding: 6px;" title="Xóa sản phẩm này">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Cart action buttons -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; flex-wrap: wrap; gap: 10px;">
                <a href="<?php echo url('products'); ?>" class="btn-secondary" style="text-decoration: none;">
                    <i class="fa-solid fa-arrow-left"></i> Tiếp tục chọn vật tư
                </a>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-rotate"></i> Cập nhật giỏ hàng
                    </button>
                    <button type="button" id="btn-clear-cart" class="btn-secondary" style="color: #ef4444; border-color: #fca5a5;">
                        <i class="fa-solid fa-xmark"></i> Làm trống giỏ hàng
                    </button>
                </div>
            </div>
        </form>

        <!-- Summary -->
        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 25px; margin-top: 30px; align-items: start;">
            <!-- Delivery notes -->
            <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 22px; box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 14px; border-bottom: 2px solid var(--primary-light); padding-bottom: 8px;">
                    <i class="fa-solid fa-truck-ramp-box" style="color: var(--primary);"></i> Lưu Ý Giao Nhận Vật Tư Công Trình
                </h3>
                <ul style="list-style: none; font-size: 0.85rem; color: var(--text-muted); line-height: 1.8;">
                    <li><i class="fa-solid fa-check" style="color: #10b981; width: 18px;"></i> Đơn hàng sẽ được xác nhận qua điện thoại trước khi xuất kho.</li>
                    <li><i class="fa-solid fa-check" style="color: #10b981; width: 18px;"></i> Phí vận chuyển tính theo cự ly (km) và loại phương tiện yêu cầu.</li>
                    <li><i class="fa-solid fa-check" style="color: #10b981; width: 18px;"></i> Cát đá đong thùng m³ chuẩn, sắt thép cân tải trọng rõ ràng.</li>
                    <li><i class="fa-solid fa-check" style="color: #10b981; width: 18px;"></i> Hỗ trợ giao hàng ban đêm và ngày chủ nhật (phụ thu 10%).</li>
                    <li><i class="fa-solid fa-check" style="color: #10b981; width: 18px;"></i> Cung cấp đầy đủ phiếu xuất kho, CO/CQ và hóa đơn VAT.</li>
                </ul>
            </div>

            <!-- Cart total -->
            <div style="background: #ffffff; border: 2px solid var(--primary); border-radius: var(--radius-md); padding: 22px; box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 16px;">
                    <i class="fa-solid fa-receipt" style="color: var(--primary);"></i> Tổng Giỏ Hàng
                </h3>
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border-color); font-size: 0.9rem;">
                    <span style="color: var(--text-muted);">Tạm tính hàng hóa:</span>
                    <strong style="color: var(--secondary-dark);"><?php echo number_format($cart_total, 0, ',', '.'); ?> đ</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border-color); font-size: 0.85rem;">
                    <span style="color: var(--text-muted);">Phí vận chuyển:</span>
                    <span style="color: var(--primary); font-weight: 600;">Tính khi đặt hàng</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 14px 0; font-size: 1.15rem; font-weight: 800;">
                    <span style="color: var(--secondary-dark);">Tổng cộng:</span>
                    <span style="color: var(--primary);"><?php echo number_format($cart_total, 0, ',', '.'); ?> đ</span>
                </div>
                <a href="<?php echo url('checkout'); ?>" class="btn-primary" style="width: 100%; justify-content: center; font-size: 1rem; padding: 14px; margin-top: 5px; text-decoration: none;">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Tiến Hành Đặt Hàng
                </a>
                <p style="text-align: center; font-size: 0.78rem; color: var(--text-muted); margin-top: 10px;">
                    <i class="fa-solid fa-shield-halved" style="color: #10b981;"></i> Xác nhận đơn hàng qua điện thoại trước khi giao
                </p>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity minus buttons
    document.querySelectorAll('.qty-btn-minus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var input = document.getElementById('qty-' + id);
            var val = parseInt(input.value) || 1;
            if (val > 1) input.value = val - 1;
        });
    });

    // Quantity plus buttons
    document.querySelectorAll('.qty-btn-plus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var input = document.getElementById('qty-' + id);
            var val = parseInt(input.value) || 1;
            if (val < 9999) input.value = val + 1;
        });
    });

    // Delete item buttons
    document.querySelectorAll('.btn-delete-item').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                var form = document.getElementById('cart-form');
                document.querySelector('input[name="action"]').value = 'delete';
                document.getElementById('delete-product-id').value = this.getAttribute('data-id');
                form.submit();
            }
        });
    });

    // Clear cart button
    var clearBtn = document.getElementById('btn-clear-cart');
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            if (confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')) {
                var form = document.getElementById('cart-form');
                document.querySelector('input[name="action"]').value = 'clear';
                form.submit();
            }
        });
    }
});
</script>
