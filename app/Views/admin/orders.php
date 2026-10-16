<?php
$statuses = [
    'Chờ xác nhận' => ['icon' => 'fa-clock', 'color' => '#f59e0b', 'bg' => '#fef3c7'],
    'Đang bốc xếp & vận chuyển' => ['icon' => 'fa-truck-fast', 'color' => '#3b82f6', 'bg' => '#dbeafe'],
    'Đã giao tới công trình' => ['icon' => 'fa-circle-check', 'color' => '#10b981', 'bg' => '#d1fae5'],
    'Đã hủy' => ['icon' => 'fa-ban', 'color' => '#ef4444', 'bg' => '#fee2e2'],
];
$allCount = array_sum($status_counts);
$currentQuery = http_build_query(array_filter(['status' => $status_filter, 'search' => $search]));
?>

<header class="admin-header">
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a;"><i class="fa-solid fa-clipboard-list" style="color: var(--primary);"></i> Quản Lý Đơn Hàng</h2>
        <p style="font-size: 0.82rem; color: #64748b;">Xem, tìm kiếm và cập nhật trạng thái đơn hàng</p>
    </div>
</header>

<div class="admin-body">
    <!-- TABS TRẠNG THÁI -->
    <div style="display: flex; gap: 8px; margin-bottom: 18px; flex-wrap: wrap;">
        <a href="<?php echo url('admin/orders'); ?>" style="padding: 8px 16px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; font-family: inherit; border: 2px solid <?php echo $status_filter === '' ? 'var(--primary)' : '#e2e8f0'; ?>; background: <?php echo $status_filter === '' ? 'rgba(243,111,33,0.08)' : '#fff'; ?>; color: <?php echo $status_filter === '' ? 'var(--primary)' : '#64748b'; ?>;">
            Tất cả <span style="background: #f1f5f9; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; margin-left: 4px;"><?php echo $allCount; ?></span>
        </a>
        <?php foreach ($statuses as $sName => $sInfo): ?>
            <?php $cnt = $status_counts[$sName] ?? 0; $active = ($status_filter === $sName); ?>
            <a href="<?php echo url('admin/orders?status=' . urlencode($sName) . ($search ? '&search=' . urlencode($search) : '')); ?>"
               style="padding: 8px 16px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; font-family: inherit; border: 2px solid <?php echo $active ? $sInfo['color'] : '#e2e8f0'; ?>; background: <?php echo $active ? $sInfo['bg'] : '#fff'; ?>; color: <?php echo $active ? $sInfo['color'] : '#64748b'; ?>;">
                <i class="fa-solid <?php echo $sInfo['icon']; ?>"></i> <?php echo $sName; ?>
                <span style="background: <?php echo $sInfo['bg']; ?>; color: <?php echo $sInfo['color']; ?>; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; margin-left: 4px;"><?php echo $cnt; ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- THANH TÌM KIẾM -->
    <div style="background: #fff; border-radius: 12px; padding: 14px 18px; margin-bottom: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
        <form action="<?php echo url('admin/orders'); ?>" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <?php if ($status_filter): ?>
                <input type="hidden" name="status" value="<?php echo htmlspecialchars($status_filter); ?>">
            <?php endif; ?>
            <div style="flex: 1; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm theo mã đơn, tên hoặc SĐT khách hàng..."
                    style="width: 100%; padding: 10px 10px 10px 36px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
            </div>
            <button type="submit" style="padding: 10px 20px; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; font-family: inherit;">
                Tìm Kiếm
            </button>
            <?php if ($search): ?>
                <a href="<?php echo url('admin/orders' . ($status_filter ? '?status=' . urlencode($status_filter) : '')); ?>" style="padding: 10px 16px; background: #f1f5f9; color: #64748b; border-radius: 8px; font-weight: 600; font-size: 0.85rem; text-decoration: none; font-family: inherit;">
                    Xóa lọc
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- THÔNG TIN -->
    <div style="font-size: 0.82rem; color: #64748b; margin-bottom: 12px;">
        Hiển thị <strong><?php echo count($orders); ?></strong> / <strong><?php echo $total_rows; ?></strong> đơn hàng
        <?php if ($search): ?> — Tìm kiếm: "<strong><?php echo htmlspecialchars($search); ?></strong>"<?php endif; ?>
    </div>

    <!-- BẢNG ĐƠN HÀNG -->
    <div style="background: #fff; border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <?php if (empty($orders)): ?>
            <div style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                <i class="fa-solid fa-inbox" style="font-size: 2.5rem; margin-bottom: 10px; display: block;"></i>
                <p style="font-size: 0.95rem; font-weight: 600;">Không có đơn hàng nào</p>
            </div>
        <?php else: ?>
            <?php foreach ($orders as $i => $o): ?>
                <?php
                    $oid = $o['id'];
                    $items = $order_items[$oid] ?? [];
                    $os = $o['order_status'];
                    $si = $statuses[$os] ?? ['icon' => 'fa-question', 'color' => '#94a3b8', 'bg' => '#f1f5f9'];
                ?>
                <!-- ĐƠN HÀNG -->
                <div style="border-bottom: 1px solid #f1f5f9;">
                    <!-- HEADER ĐƠN -->
                    <div onclick="toggleOrder(<?php echo $oid; ?>)" style="padding: 16px 20px; cursor: pointer; transition: background 0.15s; display: flex; align-items: center; gap: 14px;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                        <i class="fa-solid fa-chevron-right" id="arrow-<?php echo $oid; ?>" style="color: #cbd5e1; font-size: 0.8rem; transition: transform 0.2s; min-width: 14px;"></i>

                        <div style="flex: 1; display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                            <!-- Mã đơn + ngày -->
                            <div style="min-width: 140px;">
                                <div style="font-weight: 800; color: var(--primary); font-size: 0.88rem;"><?php echo htmlspecialchars($o['order_code']); ?></div>
                                <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 2px;"><?php echo date('d/m/Y H:i', strtotime($o['created_at'])); ?></div>
                            </div>

                            <!-- Khách hàng -->
                            <div style="min-width: 150px;">
                                <div style="font-weight: 700; font-size: 0.85rem; color: #1e293b;"><?php echo htmlspecialchars($o['customer_name']); ?></div>
                                <div style="font-size: 0.78rem; color: #64748b;"><i class="fa-solid fa-phone" style="font-size: 0.7rem;"></i> <?php echo htmlspecialchars($o['customer_phone']); ?></div>
                            </div>

                            <!-- Địa chỉ -->
                            <div style="flex: 1; min-width: 180px; font-size: 0.82rem; color: #64748b; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <i class="fa-solid fa-location-dot" style="color: #ef4444; font-size: 0.75rem;"></i> <?php echo htmlspecialchars($o['delivery_address']); ?>
                            </div>

                            <!-- Tổng tiền -->
                            <div style="min-width: 120px; text-align: right;">
                                <div style="font-weight: 800; color: #e11d48; font-size: 0.95rem;"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?>đ</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;"><?php echo count($items); ?> sản phẩm</div>
                            </div>

                            <!-- Trạng thái -->
                            <div style="min-width: 100px;">
                                <span style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; background: <?php echo $si['bg']; ?>; color: <?php echo $si['color']; ?>; white-space: nowrap;">
                                    <i class="fa-solid <?php echo $si['icon']; ?>"></i> <?php echo htmlspecialchars($os); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- CHI TIẾT ĐƠN (ẨN MẶC ĐỊNH) -->
                    <div id="detail-<?php echo $oid; ?>" style="display: none; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                        <div style="padding: 18px 20px 18px 48px;">
                            <!-- THÔNG TIN ĐƠN HÀNG -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-bottom: 16px; font-size: 0.82rem;">
                                <div>
                                    <span style="color: #94a3b8; font-weight: 600;">Thanh toán:</span>
                                    <strong style="color: #334155; margin-left: 4px;"><?php echo htmlspecialchars($o['payment_method']); ?></strong>
                                </div>
                                <div>
                                    <span style="color: #94a3b8; font-weight: 600;">Yêu cầu xe:</span>
                                    <strong style="color: #334155; margin-left: 4px;"><?php echo htmlspecialchars($o['vehicle_requirement'] ?? 'Không'); ?></strong>
                                </div>
                                <div>
                                    <span style="color: #94a3b8; font-weight: 600;">Email:</span>
                                    <strong style="color: #334155; margin-left: 4px;"><?php echo htmlspecialchars($o['customer_email'] ?? 'N/A'); ?></strong>
                                </div>
                            </div>
                            <?php if (!empty($o['notes'])): ?>
                                <div style="padding: 10px 14px; background: #fef3c7; border-radius: 8px; font-size: 0.82rem; color: #92400e; margin-bottom: 16px;">
                                    <i class="fa-solid fa-note-sticky"></i> <strong>Ghi chú:</strong> <?php echo htmlspecialchars($o['notes']); ?>
                                </div>
                            <?php endif; ?>

                            <!-- BẢNG SẢN PHẨM -->
                            <div style="font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 8px;">
                                <i class="fa-solid fa-box-open" style="color: var(--primary);"></i> Sản phẩm trong đơn
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 0.82rem; margin-bottom: 16px;">
                                <thead>
                                    <tr style="background: #e2e8f0;">
                                        <th style="padding: 8px 10px; text-align: left; font-weight: 700; color: #334155;">#</th>
                                        <th style="padding: 8px 10px; text-align: left; font-weight: 700; color: #334155;">Tên sản phẩm</th>
                                        <th style="padding: 8px 10px; text-align: center; font-weight: 700; color: #334155;">Số lượng</th>
                                        <th style="padding: 8px 10px; text-align: right; font-weight: 700; color: #334155;">Đơn giá</th>
                                        <th style="padding: 8px 10px; text-align: right; font-weight: 700; color: #334155;">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($items)): ?>
                                        <tr><td colspan="5" style="text-align: center; padding: 14px; color: #94a3b8;">Không có dữ liệu</td></tr>
                                    <?php else: ?>
                                        <?php foreach ($items as $j => $item): ?>
                                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                                <td style="padding: 8px 10px; color: #94a3b8;"><?php echo $j + 1; ?></td>
                                                <td style="padding: 8px 10px; font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                <td style="padding: 8px 10px; text-align: center;"><?php echo number_format($item['quantity']); ?> <?php echo htmlspecialchars($item['unit']); ?></td>
                                                <td style="padding: 8px 10px; text-align: right;"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                                <td style="padding: 8px 10px; text-align: right; font-weight: 700; color: #e11d48;"><?php echo number_format($item['subtotal'], 0, ',', '.'); ?>đ</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr style="background: #f1f5f9;">
                                        <td colspan="4" style="padding: 10px; text-align: right; font-weight: 800;">Tổng cộng:</td>
                                        <td style="padding: 10px; text-align: right; font-weight: 800; color: #e11d48; font-size: 0.95rem;"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?>đ</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- CẬP NHẬT TRẠNG THÁI -->
                            <div style="display: flex; align-items: center; gap: 10px; padding: 14px 16px; background: #fff; border-radius: 10px; border: 2px solid #e2e8f0;">
                                <span style="font-weight: 700; font-size: 0.85rem; color: #334155; white-space: nowrap;">
                                    <i class="fa-solid fa-pen-to-square" style="color: var(--primary);"></i> Cập nhật trạng thái:
                                </span>
                                <form action="<?php echo url('admin/orders?redirect=' . urlencode($currentQuery)); ?>" method="POST" style="display: flex; gap: 8px; align-items: center; flex: 1;" onsubmit="return confirm('Xác nhận đổi trạng thái đơn hàng #<?php echo htmlspecialchars($o['order_code']); ?>?')">
                                    <input type="hidden" name="order_id" value="<?php echo $oid; ?>">
                                    <select name="new_status" style="flex: 1; padding: 8px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.84rem; font-family: inherit; font-weight: 600;">
                                        <?php foreach ($statuses as $sName => $sInfo): ?>
                                            <option value="<?php echo htmlspecialchars($sName); ?>" <?php echo $os === $sName ? 'selected' : ''; ?>><?php echo $sName; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" style="padding: 8px 18px; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.84rem; cursor: pointer; font-family: inherit; white-space: nowrap;">
                                        <i class="fa-solid fa-check"></i> Lưu
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- PHÂN TRANG -->
    <?php if ($total_pages > 1): ?>
        <div style="display: flex; justify-content: center; gap: 6px; margin-top: 20px;">
            <?php if ($page > 1): ?>
                <a href="<?php echo url('admin/orders?' . http_build_query(array_filter(['status' => $status_filter, 'search' => $search, 'page' => $page - 1]))); ?>"
                   style="padding: 8px 14px; border-radius: 8px; background: #fff; border: 2px solid #e2e8f0; color: #475569; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            <?php endif; ?>

            <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);
            ?>
            <?php for ($p = $start; $p <= $end; $p++): ?>
                <a href="<?php echo url('admin/orders?' . http_build_query(array_filter(['status' => $status_filter, 'search' => $search, 'page' => $p]))); ?>"
                   style="padding: 8px 14px; border-radius: 8px; border: 2px solid <?php echo $p === $page ? 'var(--primary)' : '#e2e8f0'; ?>; background: <?php echo $p === $page ? 'var(--primary)' : '#fff'; ?>; color: <?php echo $p === $page ? '#fff' : '#475569'; ?>; text-decoration: none; font-size: 0.85rem; font-weight: 700;">
                    <?php echo $p; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="<?php echo url('admin/orders?' . http_build_query(array_filter(['status' => $status_filter, 'search' => $search, 'page' => $page + 1]))); ?>"
                   style="padding: 8px 14px; border-radius: 8px; background: #fff; border: 2px solid #e2e8f0; color: #475569; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
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
