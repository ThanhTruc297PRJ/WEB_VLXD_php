<?php
$statuses = [
    'Chờ xác nhận' => ['icon' => 'fa-clock', 'color' => '#f59e0b', 'bg' => '#fef3c7'],
    'Đang bốc xếp & vận chuyển' => ['icon' => 'fa-truck-fast', 'color' => '#3b82f6', 'bg' => '#dbeafe'],
    'Đã giao tới công trình' => ['icon' => 'fa-circle-check', 'color' => '#10b981', 'bg' => '#d1fae5'],
    'Đã hủy' => ['icon' => 'fa-ban', 'color' => '#ef4444', 'bg' => '#fee2e2'],
];
?>

<header class="admin-header">
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a;">
            <a href="<?php echo url('admin/customers'); ?>" style="color: #94a3b8; text-decoration: none; margin-right: 6px;"><i class="fa-solid fa-arrow-left"></i></a>
            Chi Tiết Khách Hàng
        </h2>
    </div>
</header>

<div class="admin-body">
    <!-- THÔNG TIN KHÁCH HÀNG -->
    <div style="background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-bottom: 22px;">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #f36f21, #ff9a56); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.5rem;">
                <?php echo mb_strtoupper(mb_substr($customer['fullname'], 0, 1)); ?>
            </div>
            <div>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0;"><?php echo htmlspecialchars($customer['fullname']); ?></h3>
                <p style="font-size: 0.82rem; color: #64748b; margin: 4px 0 0;">Khách hàng từ <?php echo date('d/m/Y', strtotime($customer['created_at'])); ?></p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
            <div style="padding: 14px; background: #f8fafc; border-radius: 10px;">
                <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; text-transform: uppercase;">SĐT</div>
                <div style="font-weight: 700; color: #1e293b; margin-top: 4px;"><?php echo htmlspecialchars($customer['phone']); ?></div>
            </div>
            <div style="padding: 14px; background: #f8fafc; border-radius: 10px;">
                <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; text-transform: uppercase;">Email</div>
                <div style="font-weight: 700; color: #1e293b; margin-top: 4px; font-size: 0.88rem;"><?php echo htmlspecialchars($customer['email']); ?></div>
            </div>
            <div style="padding: 14px; background: #f8fafc; border-radius: 10px;">
                <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; text-transform: uppercase;">Tổng đơn hàng</div>
                <div style="font-weight: 800; color: #2563eb; margin-top: 4px; font-size: 1.1rem;"><?php echo count($orders); ?> đơn</div>
            </div>
            <div style="padding: 14px; background: #f8fafc; border-radius: 10px;">
                <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; text-transform: uppercase;">Tổng chi tiêu</div>
                <div style="font-weight: 800; color: #e11d48; margin-top: 4px; font-size: 1.1rem;"><?php echo number_format($total_spent, 0, ',', '.'); ?>đ</div>
            </div>
        </div>
        <?php if (!empty($customer['address'])): ?>
            <div style="margin-top: 14px; padding: 10px 14px; background: #f8fafc; border-radius: 10px; font-size: 0.85rem; color: #475569;">
                <i class="fa-solid fa-location-dot" style="color: #ef4444;"></i> <strong>Địa chỉ:</strong> <?php echo htmlspecialchars($customer['address']); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- LỊCH SỬ ĐƠN HÀNG -->
    <div style="background: #fff; border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <div style="padding: 18px 20px; border-bottom: 1px solid #f1f5f9;">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0;">
                <i class="fa-solid fa-clock-rotate-left" style="color: var(--primary);"></i> Lịch Sử Đơn Hàng
                <span style="font-size: 0.8rem; font-weight: 500; color: #64748b; margin-left: 6px;">(<?php echo count($orders); ?> đơn)</span>
            </h3>
        </div>

        <?php if (empty($orders)): ?>
            <div style="text-align: center; padding: 50px 20px; color: #94a3b8;">
                <i class="fa-solid fa-bag-shopping" style="font-size: 2rem; margin-bottom: 8px; display: block;"></i>
                <p style="font-size: 0.9rem; font-weight: 600;">Khách hàng chưa có đơn hàng nào</p>
            </div>
        <?php else: ?>
            <?php foreach ($orders as $o): ?>
                <?php
                    $oid = $o['id'];
                    $items = $order_items[$oid] ?? [];
                    $os = $o['order_status'];
                    $si = $statuses[$os] ?? ['icon' => 'fa-question', 'color' => '#94a3b8', 'bg' => '#f1f5f9'];
                ?>
                <div style="border-bottom: 1px solid #f1f5f9;">
                    <div onclick="toggleOrder(<?php echo $oid; ?>)" style="padding: 14px 20px; cursor: pointer; display: flex; align-items: center; gap: 14px; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                        <i class="fa-solid fa-chevron-right" id="arrow-<?php echo $oid; ?>" style="color: #cbd5e1; font-size: 0.8rem; transition: transform 0.2s; min-width: 14px;"></i>

                        <div style="flex: 1; display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                            <div style="min-width: 130px;">
                                <div style="font-weight: 800; color: var(--primary); font-size: 0.85rem;"><?php echo htmlspecialchars($o['order_code']); ?></div>
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 2px;"><?php echo date('d/m/Y H:i', strtotime($o['created_at'])); ?></div>
                            </div>
                            <div style="flex: 1; font-size: 0.82rem; color: #64748b;">
                                <i class="fa-solid fa-location-dot" style="color: #ef4444; font-size: 0.72rem;"></i> <?php echo htmlspecialchars($o['delivery_address']); ?>
                            </div>
                            <div style="min-width: 100px; text-align: right;">
                                <div style="font-weight: 800; color: #e11d48; font-size: 0.92rem;"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?>đ</div>
                                <div style="font-size: 0.72rem; color: #94a3b8;"><?php echo count($items); ?> sản phẩm</div>
                            </div>
                            <span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 16px; font-size: 0.75rem; font-weight: 700; background: <?php echo $si['bg']; ?>; color: <?php echo $si['color']; ?>; white-space: nowrap;">
                                <i class="fa-solid <?php echo $si['icon']; ?>"></i> <?php echo htmlspecialchars($os); ?>
                            </span>
                        </div>
                    </div>

                    <div id="detail-<?php echo $oid; ?>" style="display: none; background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 20px 16px 48px;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.82rem;">
                            <thead>
                                <tr style="background: #e2e8f0;">
                                    <th style="padding: 8px 10px; text-align: left; font-weight: 700; color: #334155;">#</th>
                                    <th style="padding: 8px 10px; text-align: left; font-weight: 700; color: #334155;">Sản phẩm</th>
                                    <th style="padding: 8px 10px; text-align: center; font-weight: 700; color: #334155;">SL</th>
                                    <th style="padding: 8px 10px; text-align: right; font-weight: 700; color: #334155;">Đơn giá</th>
                                    <th style="padding: 8px 10px; text-align: right; font-weight: 700; color: #334155;">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $j => $item): ?>
                                    <tr style="border-bottom: 1px solid #e2e8f0;">
                                        <td style="padding: 8px 10px; color: #94a3b8;"><?php echo $j + 1; ?></td>
                                        <td style="padding: 8px 10px; font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($item['product_name']); ?></td>
                                        <td style="padding: 8px 10px; text-align: center;"><?php echo number_format($item['quantity']); ?> <?php echo htmlspecialchars($item['unit']); ?></td>
                                        <td style="padding: 8px 10px; text-align: right;"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                        <td style="padding: 8px 10px; text-align: right; font-weight: 700; color: #e11d48;"><?php echo number_format($item['subtotal'], 0, ',', '.'); ?>đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr style="background: #f1f5f9;">
                                    <td colspan="4" style="padding: 10px; text-align: right; font-weight: 800;">Tổng:</td>
                                    <td style="padding: 10px; text-align: right; font-weight: 800; color: #e11d48;"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?>đ</td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php if (!empty($o['notes'])): ?>
                            <div style="margin-top: 10px; padding: 8px 12px; background: #fef3c7; border-radius: 6px; font-size: 0.8rem; color: #92400e;">
                                <i class="fa-solid fa-note-sticky"></i> <?php echo htmlspecialchars($o['notes']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleOrder(id) {
    var d = document.getElementById('detail-' + id);
    var a = document.getElementById('arrow-' + id);
    if (d.style.display === 'none') {
        d.style.display = '';
        a.style.transform = 'rotate(90deg)';
    } else {
        d.style.display = 'none';
        a.style.transform = 'rotate(0deg)';
    }
}
</script>
