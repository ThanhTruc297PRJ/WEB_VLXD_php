<header class="admin-header">
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a;"><i class="fa-solid fa-file-invoice-dollar" style="color: var(--primary);"></i> Báo Cáo Doanh Thu</h2>
        <p style="font-size: 0.82rem; color: #64748b;">Phân tích chi tiết doanh thu, sản phẩm bán chạy & sổ sách đơn hàng</p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #0f172a; color: #fff; border: none; border-radius: 8px; font-size: 0.82rem; font-weight: 700; cursor: pointer; font-family: inherit;">
            <i class="fa-solid fa-print"></i> In Báo Cáo
        </button>
    </div>
</header>

<div class="admin-body">
    <!-- BỘ LỌC -->
    <div style="background: #fff; border-radius: 12px; padding: 18px 22px; margin-bottom: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
        <span style="font-weight: 700; font-size: 0.88rem; color: #334155;"><i class="fa-solid fa-filter" style="color: var(--primary);"></i> Lọc theo:</span>
        <form action="<?php echo url('admin/revenue'); ?>" method="GET" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <select name="filter" id="filterType" onchange="toggleFilterFields()" style="padding: 8px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; font-weight: 600;">
                <option value="month" <?php echo $filter === 'month' ? 'selected' : ''; ?>>Theo Tháng</option>
                <option value="quarter" <?php echo $filter === 'quarter' ? 'selected' : ''; ?>>Theo Quý</option>
                <option value="year" <?php echo $filter === 'year' ? 'selected' : ''; ?>>Theo Năm</option>
            </select>
            <select name="month" id="monthField" style="padding: 8px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit;">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?php echo $m; ?>" <?php echo $month == $m ? 'selected' : ''; ?>>Tháng <?php echo $m; ?></option>
                <?php endfor; ?>
            </select>
            <select name="quarter" id="quarterField" style="padding: 8px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; display: none;">
                <?php for ($q = 1; $q <= 4; $q++): ?>
                    <option value="<?php echo $q; ?>" <?php echo ($quarter ?? 1) == $q ? 'selected' : ''; ?>>Quý <?php echo $q; ?></option>
                <?php endfor; ?>
            </select>
            <select name="year" style="padding: 8px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit;">
                <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                    <option value="<?php echo $y; ?>" <?php echo $year == $y ? 'selected' : ''; ?>><?php echo $y; ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" style="padding: 8px 18px; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 700; cursor: pointer; font-family: inherit;">
                <i class="fa-solid fa-magnifying-glass"></i> Xem Báo Cáo
            </button>
        </form>
    </div>

    <!-- THẺ TỔNG QUAN -->
    <div class="admin-stats">
        <div class="stat-card">
            <div>
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Tổng Doanh Thu</div>
                <div style="font-size: 1.4rem; font-weight: 800; color: #e11d48; margin-top: 4px;"><?php echo number_format($total_revenue, 0, ',', '.'); ?>đ</div>
            </div>
            <div class="stat-icon" style="background: #fff1f2; color: #e11d48;"><i class="fa-solid fa-money-bill-trend-up"></i></div>
        </div>
        <div class="stat-card">
            <div>
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Tổng Đơn Hàng</div>
                <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-top: 4px;"><?php echo $total_orders; ?></div>
            </div>
            <div class="stat-icon" style="background: #ecfdf5; color: #10b981;"><i class="fa-solid fa-receipt"></i></div>
        </div>
        <div class="stat-card">
            <div>
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Giá Trị TB / Đơn</div>
                <div style="font-size: 1.4rem; font-weight: 800; color: #2563eb; margin-top: 4px;"><?php echo number_format($avg_order_value, 0, ',', '.'); ?>đ</div>
            </div>
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;"><i class="fa-solid fa-chart-bar"></i></div>
        </div>
        <div class="stat-card">
            <div>
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Hoàn Thành / Hủy</div>
                <div style="font-size: 1.4rem; font-weight: 800; margin-top: 4px;">
                    <span style="color: #10b981;"><?php echo $completed_orders; ?></span>
                    <span style="color: #94a3b8; font-size: 1rem;"> / </span>
                    <span style="color: #ef4444;"><?php echo $cancelled_orders; ?></span>
                </div>
            </div>
            <div class="stat-icon" style="background: #f0fdf4; color: #10b981;"><i class="fa-solid fa-check-double"></i></div>
        </div>
    </div>

    <!-- BIỂU ĐỒ DOANH THU + PHƯƠNG THỨC THANH TOÁN -->
    <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 20px; margin-bottom: 24px;">
        <div style="background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 12px;">
                <i class="fa-solid fa-chart-area" style="color: var(--primary);"></i> Biểu Đồ Doanh Thu
            </h3>
            <div style="position: relative; height: 300px;"><canvas id="revenueDetailChart"></canvas></div>
        </div>
        <div style="background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 12px;">
                <i class="fa-solid fa-wallet" style="color: #2563eb;"></i> Phương Thức Thanh Toán
            </h3>
            <div style="position: relative; height: 200px;"><canvas id="paymentChart"></canvas></div>
            <div style="margin-top: 14px;">
                <?php foreach ($summary_payment as $sp): ?>
                    <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 0.85rem;">
                        <span style="color: #475569;"><?php echo htmlspecialchars($sp['payment_method']); ?> (<?php echo $sp['cnt']; ?> đơn)</span>
                        <strong style="color: #e11d48;"><?php echo number_format($sp['total'], 0, ',', '.'); ?>đ</strong>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- TOP SẢN PHẨM + PHƯƠNG TIỆN VẬN CHUYỂN -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        <div style="background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 14px;">
                <i class="fa-solid fa-ranking-star" style="color: #f59e0b;"></i> Top 10 Sản Phẩm Doanh Thu Cao Nhất
            </h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead><tr><th>#</th><th>Sản phẩm</th><th>SL bán</th><th>Doanh thu</th></tr></thead>
                    <tbody>
                        <?php if (empty($top_products)): ?>
                            <tr><td colspan="4" style="text-align:center; color:#94a3b8; padding:20px;">Không có dữ liệu</td></tr>
                        <?php else: ?>
                            <?php foreach ($top_products as $i => $tp): ?>
                                <tr>
                                    <td>
                                        <?php if ($i < 3): ?>
                                            <span style="display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; border-radius:50%; background:<?php echo ['#f59e0b','#94a3b8','#cd7f32'][$i]; ?>; color:#fff; font-size:0.72rem; font-weight:800;"><?php echo $i + 1; ?></span>
                                        <?php else: ?>
                                            <span style="color:#94a3b8; font-weight:600;"><?php echo $i + 1; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-weight:600; font-size:0.84rem;"><?php echo htmlspecialchars($tp['product_name']); ?></td>
                                    <td><?php echo number_format($tp['total_qty']); ?> <?php echo htmlspecialchars($tp['unit']); ?></td>
                                    <td><strong style="color:#e11d48;"><?php echo number_format($tp['total_amount'], 0, ',', '.'); ?>đ</strong></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 14px;">
                <i class="fa-solid fa-truck" style="color: #10b981;"></i> Thống Kê Phương Tiện Vận Chuyển
            </h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead><tr><th>Phương tiện</th><th>Số đơn</th><th>Tỷ lệ</th></tr></thead>
                    <tbody>
                        <?php if (empty($summary_vehicle)): ?>
                            <tr><td colspan="3" style="text-align:center; color:#94a3b8; padding:20px;">Không có dữ liệu</td></tr>
                        <?php else: ?>
                            <?php $totalV = array_sum(array_column($summary_vehicle, 'cnt')); ?>
                            <?php foreach ($summary_vehicle as $sv): ?>
                                <?php $pct = $totalV > 0 ? round($sv['cnt'] / $totalV * 100) : 0; ?>
                                <tr>
                                    <td style="font-weight:600;"><?php echo htmlspecialchars($sv['vehicle_requirement']); ?></td>
                                    <td><?php echo $sv['cnt']; ?></td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:8px;">
                                            <div style="flex:1; height:8px; background:#f1f5f9; border-radius:4px; overflow:hidden;">
                                                <div style="height:100%; width:<?php echo $pct; ?>%; background:var(--primary); border-radius:4px;"></div>
                                            </div>
                                            <span style="font-weight:700; font-size:0.82rem; min-width:36px;"><?php echo $pct; ?>%</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SỔ SÁCH CHI TIẾT ĐƠN HÀNG (BẤM MỞ RỘNG XEM SẢN PHẨM) -->
    <div style="background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0;">
                <i class="fa-solid fa-book-open" style="color: #8b5cf6;"></i> Sổ Sách Chi Tiết Đơn Hàng
                <span style="font-size: 0.8rem; font-weight: 500; color: #64748b; margin-left: 8px;">(<?php echo count($orders_list); ?> đơn)</span>
            </h3>
            <div style="display: flex; gap: 8px;">
                <button onclick="expandAll()" style="padding: 5px 12px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.78rem; font-weight: 600; cursor: pointer; font-family: inherit; color: #475569;">
                    <i class="fa-solid fa-angles-down"></i> Mở tất cả
                </button>
                <button onclick="collapseAll()" style="padding: 5px 12px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.78rem; font-weight: 600; cursor: pointer; font-family: inherit; color: #475569;">
                    <i class="fa-solid fa-angles-up"></i> Thu gọn
                </button>
            </div>
        </div>
        <p style="font-size: 0.78rem; color: #94a3b8; margin-bottom: 12px;"><i class="fa-solid fa-circle-info"></i> Bấm vào dòng đơn hàng để xem chi tiết sản phẩm trong đơn</p>
        <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
            <table class="admin-table" id="orderLedger">
                <thead style="position: sticky; top: 0; z-index: 2; background: #fff;">
                    <tr>
                        <th style="width: 30px;"></th>
                        <th>STT</th>
                        <th>Mã Đơn</th>
                        <th>Ngày Đặt</th>
                        <th>Khách Hàng</th>
                        <th>SĐT</th>
                        <th>Địa Chỉ Giao</th>
                        <th>Thanh Toán</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders_list)): ?>
                        <tr><td colspan="10" style="text-align:center; color:#94a3b8; padding:30px;">Không có đơn hàng trong khoảng thời gian này</td></tr>
                    <?php else: ?>
                        <?php foreach ($orders_list as $i => $o): ?>
                            <?php
                                $oid = $o['id'];
                                $items = $order_items[$oid] ?? [];
                                $os = $o['order_status'];
                                $ob = 'badge-warning';
                                if (mb_strpos($os, 'vận chuyển') !== false) $ob = 'badge-info';
                                if (mb_strpos($os, 'giao') !== false) $ob = 'badge-success';
                                if (mb_strpos($os, 'hủy') !== false) $ob = 'badge-danger';
                            ?>
                            <tr class="order-row" onclick="toggleDetail(<?php echo $oid; ?>)" style="cursor: pointer; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                                <td style="text-align: center; color: #94a3b8; font-size: 0.85rem;">
                                    <i class="fa-solid fa-chevron-right detail-arrow" id="arrow-<?php echo $oid; ?>" style="transition: transform 0.2s;"></i>
                                </td>
                                <td style="color:#94a3b8;"><?php echo $i + 1; ?></td>
                                <td><strong style="color:var(--primary);"><?php echo htmlspecialchars($o['order_code']); ?></strong></td>
                                <td style="font-size:0.82rem; white-space:nowrap;"><?php echo date('d/m/Y H:i', strtotime($o['created_at'])); ?></td>
                                <td><strong><?php echo htmlspecialchars($o['customer_name']); ?></strong></td>
                                <td style="white-space:nowrap;"><?php echo htmlspecialchars($o['customer_phone']); ?></td>
                                <td style="font-size:0.82rem; max-width:180px;"><?php echo htmlspecialchars($o['delivery_address']); ?></td>
                                <td style="font-size:0.82rem;"><?php echo htmlspecialchars($o['payment_method']); ?></td>
                                <td><strong style="color:#e11d48;"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?>đ</strong></td>
                                <td><span class="badge <?php echo $ob; ?>" style="white-space:nowrap;"><?php echo htmlspecialchars($os); ?></span></td>
                            </tr>
                            <!-- Chi tiết sản phẩm -->
                            <tr class="order-detail" id="detail-<?php echo $oid; ?>" style="display: none;">
                                <td colspan="10" style="padding: 0; background: #f8fafc; border-left: 4px solid var(--primary);">
                                    <div style="padding: 14px 20px 14px 40px;">
                                        <div style="font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 8px;">
                                            <i class="fa-solid fa-box-open" style="color: var(--primary);"></i> Chi tiết sản phẩm trong đơn #<?php echo htmlspecialchars($o['order_code']); ?>
                                        </div>
                                        <?php if (empty($items)): ?>
                                            <p style="color: #94a3b8; font-size: 0.82rem;">Không có chi tiết sản phẩm</p>
                                        <?php else: ?>
                                            <table style="width: 100%; border-collapse: collapse; font-size: 0.82rem;">
                                                <thead>
                                                    <tr style="background: #e2e8f0;">
                                                        <th style="padding: 8px 10px; text-align: left; font-weight: 700; color: #334155; border-radius: 6px 0 0 0;">#</th>
                                                        <th style="padding: 8px 10px; text-align: left; font-weight: 700; color: #334155;">Tên sản phẩm</th>
                                                        <th style="padding: 8px 10px; text-align: center; font-weight: 700; color: #334155;">Số lượng</th>
                                                        <th style="padding: 8px 10px; text-align: right; font-weight: 700; color: #334155;">Đơn giá</th>
                                                        <th style="padding: 8px 10px; text-align: right; font-weight: 700; color: #334155; border-radius: 0 6px 0 0;">Thành tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($items as $j => $item): ?>
                                                        <tr style="border-bottom: 1px solid #e2e8f0;">
                                                            <td style="padding: 8px 10px; color: #94a3b8;"><?php echo $j + 1; ?></td>
                                                            <td style="padding: 8px 10px; font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                            <td style="padding: 8px 10px; text-align: center;"><?php echo number_format($item['quantity']); ?> <?php echo htmlspecialchars($item['unit'] ?? ''); ?></td>
                                                            <td style="padding: 8px 10px; text-align: right;"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                                            <td style="padding: 8px 10px; text-align: right; font-weight: 700; color: #e11d48;"><?php echo number_format($item['subtotal'], 0, ',', '.'); ?>đ</td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr style="background: #f1f5f9;">
                                                        <td colspan="4" style="padding: 8px 10px; text-align: right; font-weight: 800; color: #0f172a;">Tổng đơn hàng:</td>
                                                        <td style="padding: 8px 10px; text-align: right; font-weight: 800; color: #e11d48; font-size: 0.9rem;"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?>đ</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        <?php endif; ?>
                                        <?php if (!empty($o['notes'])): ?>
                                            <div style="margin-top: 10px; padding: 8px 12px; background: #fef3c7; border-radius: 6px; font-size: 0.8rem; color: #92400e;">
                                                <i class="fa-solid fa-note-sticky"></i> <strong>Ghi chú:</strong> <?php echo htmlspecialchars($o['notes']); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($o['vehicle_requirement'])): ?>
                                            <div style="margin-top: 6px; font-size: 0.8rem; color: #64748b;">
                                                <i class="fa-solid fa-truck"></i> Yêu cầu xe: <strong><?php echo htmlspecialchars($o['vehicle_requirement']); ?></strong>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr style="background: #f8fafc; font-weight: 800;">
                            <td></td>
                            <td colspan="7" style="text-align: right; font-size: 0.9rem;">TỔNG CỘNG:</td>
                            <td style="color: #e11d48; font-size: 1rem;"><?php echo number_format($total_revenue, 0, ',', '.'); ?>đ</td>
                            <td></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
function toggleFilterFields() {
    var f = document.getElementById('filterType').value;
    document.getElementById('monthField').style.display = f === 'month' ? '' : 'none';
    document.getElementById('quarterField').style.display = f === 'quarter' ? '' : 'none';
}
toggleFilterFields();

function toggleDetail(orderId) {
    var row = document.getElementById('detail-' + orderId);
    var arrow = document.getElementById('arrow-' + orderId);
    if (row.style.display === 'none') {
        row.style.display = '';
        arrow.style.transform = 'rotate(90deg)';
    } else {
        row.style.display = 'none';
        arrow.style.transform = 'rotate(0deg)';
    }
}

function expandAll() {
    document.querySelectorAll('.order-detail').forEach(function(r) { r.style.display = ''; });
    document.querySelectorAll('.detail-arrow').forEach(function(a) { a.style.transform = 'rotate(90deg)'; });
}

function collapseAll() {
    document.querySelectorAll('.order-detail').forEach(function(r) { r.style.display = 'none'; });
    document.querySelectorAll('.detail-arrow').forEach(function(a) { a.style.transform = 'rotate(0deg)'; });
}

<?php
    $chartLabels = array_column($revenue_data, 'label');
    $chartRevenue = array_map('floatval', array_column($revenue_data, 'revenue'));
    $chartOrders = array_map('intval', array_column($revenue_data, 'total_orders'));
    if ($filter === 'month') {
        $chartLabels = array_map(fn($d) => 'Ngày ' . $d, $chartLabels);
    }
    $payLabels = array_column($summary_payment, 'payment_method');
    $payData = array_map('floatval', array_column($summary_payment, 'total'));
    $payColors = ['#f36f21', '#2563eb', '#10b981', '#f59e0b'];
?>

<?php if (!empty($chartLabels)): ?>
new Chart(document.getElementById('revenueDetailChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($chartLabels, JSON_UNESCAPED_UNICODE); ?>,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: <?php echo json_encode($chartRevenue); ?>,
            backgroundColor: 'rgba(243, 111, 33, 0.15)',
            borderColor: '#f36f21',
            borderWidth: 2, borderRadius: 5, yAxisID: 'y'
        }, {
            label: 'Số đơn',
            data: <?php echo json_encode($chartOrders); ?>,
            type: 'line', borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            fill: true, pointRadius: 4, pointBackgroundColor: '#10b981',
            borderWidth: 2, tension: 0.3, yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 14, font: { size: 11 } } } },
        scales: {
            y: { position: 'left', ticks: { callback: v => (v >= 1000000 ? (v/1000000).toFixed(1) + 'tr' : (v/1000).toFixed(0) + 'k') }, grid: { color: '#f1f5f9' } },
            y1: { position: 'right', grid: { drawOnChartArea: false }, ticks: { stepSize: 1 } },
            x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 45 } }
        }
    }
});
<?php else: ?>
document.getElementById('revenueDetailChart').parentElement.innerHTML = '<p style="text-align:center; color:#94a3b8; padding:80px 0;">Không có dữ liệu trong khoảng thời gian này</p>';
<?php endif; ?>

<?php if (!empty($payData)): ?>
new Chart(document.getElementById('paymentChart'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($payLabels, JSON_UNESCAPED_UNICODE); ?>,
        datasets: [{ data: <?php echo json_encode($payData); ?>, backgroundColor: <?php echo json_encode(array_slice($payColors, 0, count($payData))); ?>, borderWidth: 2, borderColor: '#fff' }]
    },
    options: {
        responsive: true, maintainAspectRatio: false, cutout: '60%',
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 10, font: { size: 11 } } } }
    }
});
<?php else: ?>
document.getElementById('paymentChart').parentElement.innerHTML = '<p style="text-align:center; color:#94a3b8; padding:60px 0;">Không có dữ liệu</p>';
<?php endif; ?>
</script>
