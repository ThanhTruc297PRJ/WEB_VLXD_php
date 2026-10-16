<?php
$statuses = [
    'Chờ xác nhận' => ['icon' => 'fa-clock', 'color' => '#f59e0b', 'bg' => '#fef3c7'],
    'Đang bốc xếp & vận chuyển' => ['icon' => 'fa-truck-fast', 'color' => '#3b82f6', 'bg' => '#dbeafe'],
    'Đã giao tới công trình' => ['icon' => 'fa-circle-check', 'color' => '#10b981', 'bg' => '#d1fae5'],
    'Đã hủy' => ['icon' => 'fa-ban', 'color' => '#ef4444', 'bg' => '#fee2e2'],
];
?>

<div class="container" style="padding: 30px 20px;">
    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
        <a href="<?php echo url('/'); ?>" style="color: var(--primary);"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <span style="margin: 0 8px;">/</span><span>Đơn hàng của tôi</span>
    </div>

    <div style="display: flex; gap: 24px; align-items: flex-start;">
        <!-- SIDEBAR -->
        <div style="width: 240px; flex-shrink: 0;">
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
                    <li><a href="<?php echo url('account/orders'); ?>" style="display: flex; align-items: center; gap: 8px; padding: 10px 12px; border-radius: 8px; text-decoration: none; font-size: 0.88rem; font-weight: 700; background: rgba(243,111,33,0.08); color: var(--primary);"><i class="fa-solid fa-clipboard-list"></i> Đơn hàng của tôi</a></li>
                    <li><a href="<?php echo url('account/profile'); ?>" style="display: flex; align-items: center; gap: 8px; padding: 10px 12px; border-radius: 8px; text-decoration: none; font-size: 0.88rem; font-weight: 600; color: #475569;"><i class="fa-solid fa-user"></i> Hồ sơ tài khoản</a></li>
                </ul>
            </div>
        </div>

        <!-- NỘI DUNG -->
        <div style="flex: 1;">
            <h2 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 18px;">
                <i class="fa-solid fa-clipboard-list" style="color: var(--primary);"></i> Đơn Hàng Của Tôi
                <span style="font-size: 0.85rem; font-weight: 500; color: #64748b;">(<?php echo count($orders); ?> đơn)</span>
            </h2>

            <?php if (empty($orders)): ?>
                <div style="background: #fff; border: 1px solid var(--border-color); border-radius: 12px; padding: 50px; text-align: center; box-shadow: var(--shadow-sm);">
                    <i class="fa-solid fa-bag-shopping" style="font-size: 2.5rem; color: #e2e8f0; margin-bottom: 10px;"></i>
                    <p style="color: #94a3b8; font-size: 0.95rem; font-weight: 600;">Bạn chưa có đơn hàng nào</p>
                    <a href="<?php echo url('products'); ?>" class="btn-primary" style="display: inline-flex; margin-top: 14px; padding: 10px 20px;">
                        <i class="fa-solid fa-boxes-stacked"></i> Mua sắm ngay
                    </a>
                </div>
            <?php else: ?>
                <?php foreach ($orders as $o): ?>
                    <?php
                        $oid = $o['id'];
                        $items = $order_items[$oid] ?? [];
                        $os = $o['order_status'];
                        $si = $statuses[$os] ?? ['icon' => 'fa-question', 'color' => '#94a3b8', 'bg' => '#f1f5f9'];
                    ?>
                    <div style="background: #fff; border: 1px solid var(--border-color); border-radius: 12px; margin-bottom: 14px; box-shadow: var(--shadow-sm); overflow: hidden;">
                        <!-- Header -->
                        <div onclick="toggleOrder(<?php echo $oid; ?>)" style="padding: 16px 20px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 14px; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                            <div style="display: flex; align-items: center; gap: 14px; flex: 1;">
                                <i class="fa-solid fa-chevron-right" id="arrow-<?php echo $oid; ?>" style="color: #cbd5e1; font-size: 0.8rem; transition: transform 0.2s;"></i>
                                <div>
                                    <div style="font-weight: 800; color: var(--primary); font-size: 0.9rem;"><?php echo htmlspecialchars($o['order_code']); ?></div>
                                    <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 2px;"><?php echo date('d/m/Y H:i', strtotime($o['created_at'])); ?> - <?php echo count($items); ?> sản phẩm</div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-weight: 800; color: #e11d48; font-size: 0.95rem; margin-bottom: 4px;"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?>đ</div>
                                <span style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 16px; font-size: 0.75rem; font-weight: 700; background: <?php echo $si['bg']; ?>; color: <?php echo $si['color']; ?>;">
                                    <i class="fa-solid <?php echo $si['icon']; ?>"></i> <?php echo htmlspecialchars($os); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Detail -->
                        <div id="detail-<?php echo $oid; ?>" style="display: none; border-top: 1px solid var(--border-color); padding: 16px 20px; background: #f8fafc;">
                            <?php foreach ($items as $item): ?>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #e2e8f0; font-size: 0.85rem;">
                                    <div>
                                        <strong style="color: #1e293b;"><?php echo htmlspecialchars($item['product_name']); ?></strong>
                                        <span style="color: #94a3b8; margin-left: 8px;">x<?php echo $item['quantity']; ?> <?php echo htmlspecialchars($item['unit']); ?></span>
                                    </div>
                                    <strong style="color: #e11d48;"><?php echo number_format($item['subtotal'], 0, ',', '.'); ?>đ</strong>
                                </div>
                            <?php endforeach; ?>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 12px; font-size: 0.82rem; color: #64748b;">
                                <div><i class="fa-solid fa-location-dot" style="color: #ef4444;"></i> <?php echo htmlspecialchars($o['delivery_address']); ?></div>
                                <div><i class="fa-solid fa-credit-card"></i> <?php echo htmlspecialchars($o['payment_method']); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleOrder(id) {
    var d = document.getElementById('detail-' + id);
    var a = document.getElementById('arrow-' + id);
    if (d.style.display === 'none') { d.style.display = ''; a.style.transform = 'rotate(90deg)'; }
    else { d.style.display = 'none'; a.style.transform = 'rotate(0deg)'; }
}
</script>
