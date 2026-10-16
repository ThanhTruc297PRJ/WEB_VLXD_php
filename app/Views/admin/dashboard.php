<header class="admin-header">
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a;">Bảng Điều Khiển Tổng Quan</h2>
        <p style="font-size: 0.82rem; color: #64748b;">Theo dõi doanh thu, đơn hàng, vật tư & khách hàng</p>
    </div>
    <div style="display: flex; align-items: center; gap: 15px;">
        <span style="font-size: 0.85rem; color: #64748b;"><?php echo date('d/m/Y H:i'); ?></span>
        <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
            <?php echo mb_substr($_SESSION['admin_name'] ?? 'A', 0, 1); ?>
        </div>
    </div>
</header>

<div class="admin-body">
    <!-- CARDS THỐNG KÊ -->
    <div class="admin-stats">
        <div class="stat-card">
            <div>
                <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Tổng Doanh Thu</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #e11d48; margin-top: 4px;">
                    <?php echo number_format($total_revenue, 0, ',', '.'); ?>đ
                </div>
            </div>
            <div class="stat-icon" style="background: #fff1f2; color: #e11d48;">
                <i class="fa-solid fa-money-bill-trend-up"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Đơn Đặt Hàng</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-top: 4px;"><?php echo $total_orders; ?></div>
            </div>
            <div class="stat-icon" style="background: #ecfdf5; color: #10b981;">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Sản Phẩm Vật Tư</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-top: 4px;"><?php echo $total_products; ?></div>
            </div>
            <div class="stat-icon" style="background: #fff3ec; color: var(--primary);">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Khách Hàng</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-top: 4px;"><?php echo $total_customers; ?></div>
            </div>
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Yêu Cầu Báo Giá</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-top: 4px;"><?php echo $total_quotes; ?></div>
            </div>
            <div class="stat-icon" style="background: #fefce8; color: #f59e0b;">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>
        </div>
    </div>

    <!-- BIỂU ĐỒ -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px;">
        <div style="background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 12px;">
                <i class="fa-solid fa-chart-line" style="color: var(--primary);"></i> Doanh Thu 6 Tháng Gần Nhất
            </h3>
            <div style="position: relative; height: 280px;"><canvas id="revenueChart"></canvas></div>
        </div>

        <div style="background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 12px;">
                <i class="fa-solid fa-chart-pie" style="color: #10b981;"></i> Trạng Thái Đơn Hàng
            </h3>
            <div style="position: relative; height: 280px;"><canvas id="orderStatusChart"></canvas></div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        <div style="background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 12px;">
                <i class="fa-solid fa-layer-group" style="color: #2563eb;"></i> Sản Phẩm Theo Danh Mục
            </h3>
            <div style="position: relative; height: 250px;"><canvas id="categoryChart"></canvas></div>
        </div>

        <div style="background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 12px;">
                <i class="fa-solid fa-ranking-star" style="color: #f59e0b;"></i> Top 5 Sản Phẩm Bán Chạy
            </h3>
            <div style="position: relative; height: 250px;"><canvas id="topProductsChart"></canvas></div>
        </div>
    </div>

    <!-- BẢNG KHÁCH HÀNG MỚI -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 30px;">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                    <i class="fa-solid fa-user-plus" style="color: #2563eb;"></i> Khách Hàng Mới Đăng Ký
                </h3>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Ngày đăng ký</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recent_customers)): ?>
                            <tr><td colspan="4" style="text-align:center; color:#94a3b8; padding:20px;">Chưa có khách hàng nào</td></tr>
                        <?php else: ?>
                            <?php foreach ($recent_customers as $c): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($c['fullname']); ?></strong></td>
                                    <td style="font-size:0.82rem;"><?php echo htmlspecialchars($c['email']); ?></td>
                                    <td><?php echo htmlspecialchars($c['phone']); ?></td>
                                    <td style="font-size:0.82rem; color:#64748b;"><?php echo date('d/m/Y', strtotime($c['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Báo giá theo trạng thái -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                    <i class="fa-solid fa-file-signature" style="color: #f59e0b;"></i> Báo Giá Theo Trạng Thái
                </h3>
                <a href="<?php echo url('admin/quotes'); ?>" style="font-size:0.85rem; color:var(--primary); font-weight:700; text-decoration:none;">Xem tất cả</a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Trạng thái</th>
                            <th>Số lượng</th>
                            <th>Tỷ lệ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($quotes_by_status)): ?>
                            <tr><td colspan="3" style="text-align:center; color:#94a3b8; padding:20px;">Chưa có dữ liệu</td></tr>
                        <?php else: ?>
                            <?php
                                $totalQ = array_sum(array_column($quotes_by_status, 'cnt'));
                                $statusColors = [
                                    'Mới tiếp nhận' => '#f59e0b',
                                    'Đang báo giá' => '#2563eb',
                                    'Đã chốt hợp đồng' => '#10b981',
                                    'Đã hủy' => '#ef4444',
                                ];
                            ?>
                            <?php foreach ($quotes_by_status as $qs): ?>
                                <tr>
                                    <td>
                                        <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:<?php echo $statusColors[$qs['status']] ?? '#94a3b8'; ?>; margin-right:6px;"></span>
                                        <?php echo htmlspecialchars($qs['status']); ?>
                                    </td>
                                    <td><strong><?php echo $qs['cnt']; ?></strong></td>
                                    <td><?php echo $totalQ > 0 ? round($qs['cnt'] / $totalQ * 100) : 0; ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- BẢNG ĐƠN HÀNG GẦN ĐÂY -->
    <div style="margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                <i class="fa-solid fa-truck-ramp-box" style="color: #10b981;"></i> Đơn Hàng Gần Đây
            </h3>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Người Đặt</th>
                        <th>SĐT</th>
                        <th>Địa Chỉ Giao</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Đặt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_orders)): ?>
                        <tr><td colspan="7" style="text-align:center; color:#94a3b8; padding:25px;">Chưa có đơn hàng nào</td></tr>
                    <?php else: ?>
                        <?php foreach ($recent_orders as $ord): ?>
                            <tr>
                                <td><strong style="color:var(--primary);"><?php echo htmlspecialchars($ord['order_code']); ?></strong></td>
                                <td><?php echo htmlspecialchars($ord['customer_name']); ?></td>
                                <td><a href="tel:<?php echo $ord['customer_phone']; ?>" style="color:var(--primary); font-weight:600;"><?php echo htmlspecialchars($ord['customer_phone']); ?></a></td>
                                <td style="max-width:200px; font-size:0.82rem;"><?php echo htmlspecialchars($ord['delivery_address']); ?></td>
                                <td><strong style="color:#e11d48;"><?php echo number_format($ord['total_amount'], 0, ',', '.'); ?>đ</strong></td>
                                <td>
                                    <?php
                                        $os = $ord['order_status'] ?? 'Chờ xác nhận';
                                        $ob = 'badge-warning';
                                        if (str_contains($os, 'vận chuyển')) $ob = 'badge-info';
                                        if (str_contains($os, 'giao')) $ob = 'badge-success';
                                        if (str_contains($os, 'hủy')) $ob = 'badge-danger';
                                    ?>
                                    <span class="badge <?php echo $ob; ?>"><?php echo htmlspecialchars($os); ?></span>
                                </td>
                                <td style="font-size:0.82rem; color:#64748b;"><?php echo date('d/m/Y', strtotime($ord['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- BẢNG BÁO GIÁ MỚI NHẤT -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                <i class="fa-solid fa-file-invoice-dollar" style="color: var(--primary);"></i> Yêu Cầu Báo Giá Mới Nhất
            </h3>
            <a href="<?php echo url('admin/quotes'); ?>" style="font-size:0.85rem; color:var(--primary); font-weight:700; text-decoration:none;">Xem tất cả</a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Khách Hàng</th>
                        <th>SĐT</th>
                        <th>Công Trình</th>
                        <th>Vật Tư Cần Cấp</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_quotes)): ?>
                        <tr><td colspan="5" style="text-align:center; color:#94a3b8; padding:25px;">Chưa có yêu cầu báo giá nào</td></tr>
                    <?php else: ?>
                        <?php foreach ($recent_quotes as $q): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($q['fullname']); ?></strong></td>
                                <td><a href="tel:<?php echo $q['phone']; ?>" style="color:var(--primary); font-weight:600;"><?php echo htmlspecialchars($q['phone']); ?></a></td>
                                <td style="font-size:0.82rem;"><?php echo htmlspecialchars($q['project_address']); ?></td>
                                <td style="max-width:280px; font-size:0.82rem; color:#475569;"><?php echo htmlspecialchars($q['material_notes']); ?></td>
                                <td>
                                    <?php
                                        $qs = $q['status'] ?? 'Mới tiếp nhận';
                                        $qb = 'badge-warning';
                                        if ($qs === 'Đang báo giá') $qb = 'badge-info';
                                        if ($qs === 'Đã chốt hợp đồng') $qb = 'badge-success';
                                        if ($qs === 'Đã hủy') $qb = 'badge-danger';
                                    ?>
                                    <span class="badge <?php echo $qb; ?>"><?php echo htmlspecialchars($qs); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
<?php
    $monthLabels = [];
    $revenueData = [];
    $orderCountData = [];
    if (!empty($revenue_by_month)) {
        foreach ($revenue_by_month as $rm) {
            $monthLabels[] = date('m/Y', strtotime($rm['month'] . '-01'));
            $revenueData[] = (float)$rm['revenue'];
            $orderCountData[] = (int)$rm['total_orders'];
        }
    }
    if (empty($monthLabels)) {
        for ($i = 5; $i >= 0; $i--) {
            $monthLabels[] = date('m/Y', strtotime("-$i months"));
            $revenueData[] = 0;
            $orderCountData[] = 0;
        }
    }

    $osLabels = [];
    $osData = [];
    $osColors = [];
    $colorMap = [
        'Chờ xác nhận' => '#f59e0b',
        'Đang bốc xếp & vận chuyển' => '#2563eb',
        'Đã giao tới công trình' => '#10b981',
        'Đã hủy' => '#ef4444',
    ];
    if (!empty($orders_by_status)) {
        foreach ($orders_by_status as $os) {
            $osLabels[] = $os['order_status'];
            $osData[] = (int)$os['cnt'];
            $osColors[] = $colorMap[$os['order_status']] ?? '#94a3b8';
        }
    }

    $catLabels = [];
    $catData = [];
    if (!empty($products_by_cat)) {
        foreach ($products_by_cat as $pc) {
            $catLabels[] = $pc['name'];
            $catData[] = (int)$pc['cnt'];
        }
    }

    $tpLabels = [];
    $tpData = [];
    if (!empty($top_products)) {
        foreach ($top_products as $tp) {
            $name = mb_strlen($tp['name']) > 25 ? mb_substr($tp['name'], 0, 25) . '...' : $tp['name'];
            $tpLabels[] = $name;
            $tpData[] = (int)$tp['sold'];
        }
    }
?>

// Biểu đồ doanh thu
new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($monthLabels); ?>,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: <?php echo json_encode($revenueData); ?>,
            backgroundColor: 'rgba(243, 111, 33, 0.2)',
            borderColor: '#f36f21',
            borderWidth: 2,
            borderRadius: 6,
            yAxisID: 'y'
        }, {
            label: 'Số đơn hàng',
            data: <?php echo json_encode($orderCountData); ?>,
            type: 'line',
            borderColor: '#10b981',
            backgroundColor: '#10b981',
            pointRadius: 5,
            pointBackgroundColor: '#10b981',
            borderWidth: 2,
            tension: 0.3,
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16, font: { size: 12 } } } },
        scales: {
            y: { type: 'linear', position: 'left', ticks: { callback: v => (v/1000000).toFixed(1) + 'tr' }, grid: { color: '#f1f5f9' } },
            y1: { type: 'linear', position: 'right', grid: { drawOnChartArea: false }, ticks: { stepSize: 1 } },
            x: { grid: { display: false } }
        }
    }
});

// Biểu đồ trạng thái đơn hàng
<?php if (!empty($osData)): ?>
new Chart(document.getElementById('orderStatusChart'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($osLabels); ?>,
        datasets: [{ data: <?php echo json_encode($osData); ?>, backgroundColor: <?php echo json_encode($osColors); ?>, borderWidth: 2, borderColor: '#fff' }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '55%',
        plugins: {
            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, font: { size: 11 } } }
        }
    }
});
<?php else: ?>
document.getElementById('orderStatusChart').parentElement.insertAdjacentHTML('beforeend',
    '<p style="text-align:center; color:#94a3b8; padding:40px 0;">Chưa có đơn hàng nào</p>');
<?php endif; ?>

// Biểu đồ sản phẩm theo danh mục
<?php if (!empty($catData)): ?>
new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($catLabels); ?>,
        datasets: [{ data: <?php echo json_encode($catData); ?>, backgroundColor: ['#f36f21','#2563eb','#10b981','#f59e0b','#8b5cf6','#ec4899'], borderWidth: 2, borderColor: '#fff' }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '50%',
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 10, font: { size: 11 } } } }
    }
});
<?php else: ?>
document.getElementById('categoryChart').parentElement.insertAdjacentHTML('beforeend',
    '<p style="text-align:center; color:#94a3b8; padding:40px 0;">Chưa có dữ liệu</p>');
<?php endif; ?>

// Biểu đồ top sản phẩm bán chạy
<?php if (!empty($tpData) && array_sum($tpData) > 0): ?>
new Chart(document.getElementById('topProductsChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($tpLabels, JSON_UNESCAPED_UNICODE); ?>,
        datasets: [{
            label: 'Số lượng bán',
            data: <?php echo json_encode($tpData); ?>,
            backgroundColor: ['#f36f21','#2563eb','#10b981','#f59e0b','#8b5cf6'],
            borderRadius: 6,
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } },
            y: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});
<?php else: ?>
document.getElementById('topProductsChart').parentElement.insertAdjacentHTML('beforeend',
    '<p style="text-align:center; color:#94a3b8; padding:40px 0;">Chưa có đơn hàng nào</p>');
<?php endif; ?>
</script>
