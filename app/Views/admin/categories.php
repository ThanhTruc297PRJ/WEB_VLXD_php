<?php $iconOptions = ['fa-cubes','fa-mountain','fa-layer-group','fa-th-large','fa-paint-roller','fa-warehouse','fa-hammer','fa-wrench','fa-screwdriver','fa-toilet','fa-faucet-drip','fa-plug','fa-lightbulb','fa-door-open','fa-window-maximize']; ?>

<header class="admin-header">
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a;"><i class="fa-solid fa-layer-group" style="color: var(--primary);"></i> Quản Lý Danh Mục</h2>
        <p style="font-size: 0.82rem; color: #64748b;">Thêm, sửa, xóa danh mục sản phẩm</p>
    </div>
</header>

<div class="admin-body">
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 22px;">
        <!-- FORM THÊM/SỬA -->
        <div style="background: #fff; border-radius: 14px; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); align-self: start;">
            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 16px;">
                <i class="fa-solid <?php echo $edit_cat ? 'fa-pen' : 'fa-plus'; ?>" style="color: var(--primary);"></i>
                <?php echo $edit_cat ? 'Sửa Danh Mục' : 'Thêm Danh Mục Mới'; ?>
            </h3>
            <form action="<?php echo url('admin/categories'); ?>" method="POST">
                <?php if ($edit_cat): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_cat['id']; ?>">
                <?php endif; ?>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Tên danh mục <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($edit_cat['name'] ?? ''); ?>" required
                        style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Icon (Font Awesome)</label>
                    <select name="icon" style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit;">
                        <?php foreach ($iconOptions as $ic): ?>
                            <option value="<?php echo $ic; ?>" <?php echo ($edit_cat['icon'] ?? 'fa-cubes') === $ic ? 'selected' : ''; ?>>
                                <?php echo $ic; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Mô tả</label>
                    <textarea name="description" rows="3" style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; resize: vertical; box-sizing: border-box;"><?php echo htmlspecialchars($edit_cat['description'] ?? ''); ?></textarea>
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 5px;">Trạng thái</label>
                    <select name="status" style="width: 100%; padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit;">
                        <option value="1" <?php echo ($edit_cat['status'] ?? 1) == 1 ? 'selected' : ''; ?>>Hiển thị</option>
                        <option value="0" <?php echo ($edit_cat['status'] ?? 1) == 0 ? 'selected' : ''; ?>>Ẩn</option>
                    </select>
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="submit" style="flex: 1; padding: 10px; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; font-family: inherit;">
                        <i class="fa-solid <?php echo $edit_cat ? 'fa-save' : 'fa-plus'; ?>"></i> <?php echo $edit_cat ? 'Cập Nhật' : 'Thêm Mới'; ?>
                    </button>
                    <?php if ($edit_cat): ?>
                        <a href="<?php echo url('admin/categories'); ?>" style="padding: 10px 16px; background: #f1f5f9; color: #64748b; border-radius: 8px; font-weight: 600; font-size: 0.85rem; text-decoration: none; display: flex; align-items: center;">Hủy</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- DANH SÁCH -->
        <div style="background: #fff; border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
            <div style="padding: 18px 20px; border-bottom: 1px solid #f1f5f9;">
                <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0;">
                    <i class="fa-solid fa-list" style="color: var(--primary);"></i> Danh Sách Danh Mục
                    <span style="font-size: 0.8rem; font-weight: 500; color: #64748b;">(<?php echo count($categories); ?>)</span>
                </h3>
            </div>
            <?php if (empty($categories)): ?>
                <div style="text-align: center; padding: 50px; color: #94a3b8;">
                    <i class="fa-solid fa-folder-open" style="font-size: 2rem; margin-bottom: 8px; display: block;"></i>
                    <p>Chưa có danh mục nào</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr><th>ID</th><th>Icon</th><th>Tên danh mục</th><th>Slug</th><th>Sản phẩm</th><th>Trạng thái</th><th style="text-align: center;">Thao tác</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td style="color: #94a3b8;"><?php echo $cat['id']; ?></td>
                                    <td><i class="fa-solid <?php echo htmlspecialchars($cat['icon']); ?>" style="color: var(--primary); font-size: 1.1rem;"></i></td>
                                    <td><strong style="color: #1e293b;"><?php echo htmlspecialchars($cat['name']); ?></strong></td>
                                    <td style="font-size: 0.8rem; color: #94a3b8;"><?php echo htmlspecialchars($cat['slug']); ?></td>
                                    <td>
                                        <?php $pc = $product_counts[$cat['id']] ?? 0; ?>
                                        <span style="background: <?php echo $pc > 0 ? '#ecfdf5' : '#f1f5f9'; ?>; color: <?php echo $pc > 0 ? '#10b981' : '#94a3b8'; ?>; padding: 3px 10px; border-radius: 10px; font-size: 0.8rem; font-weight: 700;">
                                            <?php echo $pc; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($cat['status']): ?>
                                            <span style="color: #10b981; font-weight: 700; font-size: 0.82rem;"><i class="fa-solid fa-eye"></i> Hiển thị</span>
                                        <?php else: ?>
                                            <span style="color: #94a3b8; font-weight: 700; font-size: 0.82rem;"><i class="fa-solid fa-eye-slash"></i> Ẩn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; gap: 6px; justify-content: center;">
                                            <a href="<?php echo url('admin/categories/edit?id=' . $cat['id']); ?>" style="padding: 5px 12px; background: #eff6ff; color: #2563eb; border-radius: 6px; font-size: 0.78rem; font-weight: 700; text-decoration: none;">
                                                <i class="fa-solid fa-pen"></i> Sửa
                                            </a>
                                            <?php if (($product_counts[$cat['id']] ?? 0) === 0): ?>
                                                <a href="<?php echo url('admin/categories/delete?id=' . $cat['id']); ?>" onclick="return confirm('Xóa danh mục này?')" style="padding: 5px 12px; background: #fee2e2; color: #ef4444; border-radius: 6px; font-size: 0.78rem; font-weight: 700; text-decoration: none;">
                                                    <i class="fa-solid fa-trash"></i> Xóa
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
