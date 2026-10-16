<!-- Admin Quotes - Main Content (wrapped by admin layout) -->
<header class="admin-header">
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a;">Quản Lý Báo Giá Vật Tư Công Trình</h2>
        <p style="font-size: 0.82rem; color: #64748b;">Xem danh sách nhà thầu & chủ nhà gửi khối lượng sắt thép, cát đá, xi măng</p>
    </div>
</header>

<div class="admin-body">
    <?php if (!empty($message)): ?>
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Khách Hàng / Nhà Thầu</th>
                    <th>Liên Hệ</th>
                    <th>Địa Chỉ & Loại Công Trình</th>
                    <th>Chi Tiết Khối Lượng Cần Cấp</th>
                    <th>Ngày Cần Hàng</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($quotes)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; color: #94a3b8; padding: 30px;">Chưa có yêu cầu báo giá nào</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($quotes as $q): ?>
                        <tr>
                            <td><strong>#<?php echo $q['id']; ?></strong></td>
                            <td>
                                <strong><?php echo htmlspecialchars($q['fullname']); ?></strong>
                                <div style="font-size: 0.78rem; color: #64748b;"><?php echo htmlspecialchars($q['email'] ?? ''); ?></div>
                            </td>
                            <td>
                                <a href="tel:<?php echo htmlspecialchars($q['phone']); ?>" style="color: var(--primary); font-weight: 700;">
                                    <i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($q['phone']); ?>
                                </a>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #0f172a;"><?php echo htmlspecialchars($q['project_address']); ?></div>
                                <span class="badge badge-info" style="margin-top: 4px;"><?php echo htmlspecialchars($q['project_type'] ?? 'Dân dụng'); ?></span>
                            </td>
                            <td style="max-width: 320px; font-size: 0.85rem; line-height: 1.5; color: #334155;">
                                <?php echo nl2br(htmlspecialchars($q['material_notes'])); ?>
                            </td>
                            <td style="font-size: 0.82rem; color: #64748b;">
                                <?php echo htmlspecialchars($q['delivery_date'] ?? 'Càng sớm càng tốt'); ?>
                            </td>
                            <td>
                                <?php
                                    $status = $q['status'] ?? 'Mới tiếp nhận';
                                    $badge_class = 'badge-warning';
                                    if ($status === 'Đã chốt hợp đồng') $badge_class = 'badge-success';
                                    if ($status === 'Đang báo giá') $badge_class = 'badge-info';
                                ?>
                                <span class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($status); ?></span>
                            </td>
                            <td>
                                <form action="<?php echo url('admin/quotes'); ?>" method="POST" style="margin: 0; display: flex; gap: 6px;">
                                    <input type="hidden" name="quote_id" value="<?php echo $q['id']; ?>">
                                    <select name="status" style="padding: 6px; border-radius: 4px; border: 1px solid #cbd5e1; font-size: 0.8rem;">
                                        <option value="Mới tiếp nhận" <?php echo ($status === 'Mới tiếp nhận') ? 'selected' : ''; ?>>Mới tiếp nhận</option>
                                        <option value="Đang báo giá" <?php echo ($status === 'Đang báo giá') ? 'selected' : ''; ?>>Đang báo giá</option>
                                        <option value="Đã chốt hợp đồng" <?php echo ($status === 'Đã chốt hợp đồng') ? 'selected' : ''; ?>>Đã chốt HĐ</option>
                                        <option value="Đã hủy" <?php echo ($status === 'Đã hủy') ? 'selected' : ''; ?>>Hủy bỏ</option>
                                    </select>
                                    <button type="submit" name="update_status" style="background: var(--primary); color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer;" title="Cập nhật">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
