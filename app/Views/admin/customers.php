<header class="admin-header">
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a;"><i class="fa-solid fa-users" style="color: var(--primary);"></i> Quản Lý Khách Hàng</h2>
        <p style="font-size: 0.82rem; color: #64748b;">Danh sách khách hàng đã đăng ký tài khoản</p>
    </div>
</header>

<div class="admin-body">
    <!-- THANH TÌM KIẾM -->
    <div style="background: #fff; border-radius: 12px; padding: 14px 18px; margin-bottom: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
        <form action="<?php echo url('admin/customers'); ?>" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <div style="flex: 1; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm theo tên, SĐT hoặc email..."
                    style="width: 100%; padding: 10px 10px 10px 36px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
            </div>
            <button type="submit" style="padding: 10px 20px; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; font-family: inherit;">
                Tìm Kiếm
            </button>
            <?php if ($search): ?>
                <a href="<?php echo url('admin/customers'); ?>" style="padding: 10px 16px; background: #f1f5f9; color: #64748b; border-radius: 8px; font-weight: 600; font-size: 0.85rem; text-decoration: none;">
                    Xóa lọc
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div style="font-size: 0.82rem; color: #64748b; margin-bottom: 12px;">
        Hiển thị <strong><?php echo count($customers); ?></strong> / <strong><?php echo $total_rows; ?></strong> khách hàng
        <?php if ($search): ?> — Tìm kiếm: "<strong><?php echo htmlspecialchars($search); ?></strong>"<?php endif; ?>
    </div>

    <!-- BẢNG KHÁCH HÀNG -->
    <div style="background: #fff; border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <?php if (empty($customers)): ?>
            <div style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                <i class="fa-solid fa-user-slash" style="font-size: 2.5rem; margin-bottom: 10px; display: block;"></i>
                <p style="font-size: 0.95rem; font-weight: 600;">Không có khách hàng nào</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Khách hàng</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Ngày đăng ký</th>
                            <th style="text-align: center;">Đơn hàng</th>
                            <th style="text-align: right;">Tổng chi tiêu</th>
                            <th style="text-align: center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $i => $c): ?>
                            <tr>
                                <td style="color: #94a3b8;"><?php echo ($page - 1) * 15 + $i + 1; ?></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #f36f21, #ff9a56); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.82rem;">
                                            <?php echo mb_strtoupper(mb_substr($c['fullname'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: #1e293b; font-size: 0.88rem;"><?php echo htmlspecialchars($c['fullname']); ?></div>
                                            <?php if (!empty($c['address'])): ?>
                                                <div style="font-size: 0.75rem; color: #94a3b8;"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($c['address']); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td style="white-space: nowrap;"><?php echo htmlspecialchars($c['phone']); ?></td>
                                <td style="font-size: 0.82rem;"><?php echo htmlspecialchars($c['email']); ?></td>
                                <td style="font-size: 0.82rem; white-space: nowrap;"><?php echo date('d/m/Y', strtotime($c['created_at'])); ?></td>
                                <td style="text-align: center;">
                                    <?php if ($c['total_orders'] > 0): ?>
                                        <span style="background: #ecfdf5; color: #10b981; padding: 3px 10px; border-radius: 10px; font-size: 0.8rem; font-weight: 700;"><?php echo $c['total_orders']; ?> đơn</span>
                                    <?php else: ?>
                                        <span style="color: #cbd5e1; font-size: 0.82rem;">0</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php if ($c['total_spent'] > 0): ?>
                                        <strong style="color: #e11d48;"><?php echo number_format($c['total_spent'], 0, ',', '.'); ?>đ</strong>
                                    <?php else: ?>
                                        <span style="color: #cbd5e1;">0đ</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?php echo url('admin/customers/detail?id=' . $c['id']); ?>" style="padding: 6px 14px; background: #eff6ff; color: #2563eb; border-radius: 6px; font-size: 0.8rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- PHÂN TRANG -->
    <?php if ($total_pages > 1): ?>
        <div style="display: flex; justify-content: center; gap: 6px; margin-top: 20px;">
            <?php if ($page > 1): ?>
                <a href="<?php echo url('admin/customers?' . http_build_query(array_filter(['search' => $search, 'page' => $page - 1]))); ?>"
                   style="padding: 8px 14px; border-radius: 8px; background: #fff; border: 2px solid #e2e8f0; color: #475569; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            <?php endif; ?>
            <?php for ($p = max(1, $page - 2); $p <= min($total_pages, $page + 2); $p++): ?>
                <a href="<?php echo url('admin/customers?' . http_build_query(array_filter(['search' => $search, 'page' => $p]))); ?>"
                   style="padding: 8px 14px; border-radius: 8px; border: 2px solid <?php echo $p === $page ? 'var(--primary)' : '#e2e8f0'; ?>; background: <?php echo $p === $page ? 'var(--primary)' : '#fff'; ?>; color: <?php echo $p === $page ? '#fff' : '#475569'; ?>; text-decoration: none; font-size: 0.85rem; font-weight: 700;">
                    <?php echo $p; ?>
                </a>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <a href="<?php echo url('admin/customers?' . http_build_query(array_filter(['search' => $search, 'page' => $page + 1]))); ?>"
                   style="padding: 8px 14px; border-radius: 8px; background: #fff; border: 2px solid #e2e8f0; color: #475569; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
