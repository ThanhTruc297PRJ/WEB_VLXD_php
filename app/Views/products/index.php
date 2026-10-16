<div class="container" style="padding: 30px 20px;">
    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 25px;">
        <a href="<?php echo url('/'); ?>" style="color: var(--primary);"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <span style="margin: 0 8px;">/</span><span>Vật liệu xây dựng</span>
        <?php if ($cat_id): ?><span style="margin: 0 8px;">/</span><strong><?php echo htmlspecialchars($current_cat_name); ?></strong><?php endif; ?>
        <?php if ($search): ?><span style="margin: 0 8px;">/</span><span>Tìm kiếm: "<em><?php echo htmlspecialchars($search); ?></em>"</span><?php endif; ?>
    </div>

    <div style="display: grid; grid-template-columns: 260px 1fr; gap: 30px; align-items: start;">
        <aside style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; box-shadow: var(--shadow-sm);">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 15px; border-bottom: 2px solid var(--primary-light); padding-bottom: 8px;">
                <i class="fa-solid fa-filter" style="color: var(--primary);"></i> Phân Loại Vật Tư
            </h3>
            <ul style="list-style: none;">
                <li style="margin-bottom: 8px;">
                    <a href="<?php echo url('products'); ?>" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; border-radius: 6px; font-weight: 600; font-size: 0.88rem; <?php echo !$cat_id ? 'background: var(--primary-light); color: var(--primary); font-weight: 700;' : 'color: var(--text-main);'; ?>">
                        <span><i class="fa-solid fa-border-all" style="width: 20px;"></i> Tất cả vật liệu</span>
                    </a>
                </li>
                <?php foreach ($categories as $cat): ?>
                <li style="margin-bottom: 6px;">
                    <a href="<?php echo url('products?cat=' . $cat['id']); ?>" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; border-radius: 6px; font-size: 0.88rem; <?php echo ($cat_id == $cat['id']) ? 'background: var(--primary-light); color: var(--primary); font-weight: 700;' : 'color: var(--text-main);'; ?>">
                        <span><i class="fa-solid <?php echo htmlspecialchars($cat['icon']); ?>" style="width: 20px;"></i> <?php echo htmlspecialchars($cat['name']); ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <div style="background: linear-gradient(135deg, #1e293b, #0f172a); color: white; border-radius: 8px; padding: 18px; margin-top: 25px; text-align: center;">
                <i class="fa-solid fa-headset" style="font-size: 32px; color: var(--primary); margin-bottom: 10px;"></i>
                <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 6px;">Cần Báo Giá Dự Án?</h4>
                <p style="font-size: 0.78rem; color: #94a3b8; margin-bottom: 12px;">Gửi bảng vẽ hoặc khối lượng để nhận chiết khấu cao nhất theo tấn / m³.</p>
                <a href="<?php echo url('quote'); ?>" class="btn-primary" style="font-size: 0.8rem; padding: 8px 14px; width: 100%; justify-content: center;">Gửi yêu cầu báo giá</a>
            </div>
        </aside>

        <main>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; background: #fff; padding: 14px 20px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                <div>
                    <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--secondary-dark);"><?php echo htmlspecialchars($current_cat_name); ?></h2>
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Hiển thị <strong><?php echo count($products); ?></strong> sản phẩm vật liệu</span>
                </div>
            </div>

            <?php if (empty($products)): ?>
                <div style="background: #ffffff; border: 1px dashed var(--border-color); border-radius: var(--radius-md); padding: 50px 20px; text-align: center;">
                    <i class="fa-solid fa-box-open" style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                    <h3 style="font-size: 1.15rem; color: var(--secondary-dark); margin-bottom: 8px;">Không tìm thấy sản phẩm phù hợp</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">Vui lòng thử tìm với từ khóa khác hoặc liên hệ hotline để được báo giá trực tiếp.</p>
                    <a href="<?php echo url('products'); ?>" class="btn-primary">Xem tất cả sản phẩm</a>
                </div>
            <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($products as $prod): ?>
                        <div class="product-card">
                            <?php if (!empty($prod['is_featured'])): ?><span class="product-badge featured">Bán chạy</span><?php endif; ?>
                            <div class="product-thumb"><img src="<?php echo htmlspecialchars($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" loading="lazy" onerror="this.onerror=null;this.src='<?php echo asset('images/no-image.svg'); ?>'"></div>
                            <div class="product-body">
                                <div class="product-meta"><span class="product-brand"><?php echo htmlspecialchars($prod['brand'] ?? 'Chính Hãng'); ?></span><span>ĐVT: <strong><?php echo htmlspecialchars($prod['unit']); ?></strong></span></div>
                                <h3 class="product-title"><a href="<?php echo url('product/' . $prod['id']); ?>"><?php echo htmlspecialchars($prod['name']); ?></a></h3>
                                <div class="product-spec"><i class="fa-solid fa-tag"></i> <?php echo htmlspecialchars($prod['specification'] ?? 'Tiêu chuẩn chất lượng cao'); ?></div>
                                <div class="product-pricing">
                                    <span class="product-price"><?php echo formatCurrency($prod['price'], $prod['price_negotiable'] ?? 0); ?></span>
                                    <?php if ($prod['price'] > 0): ?><span class="product-unit">/ <?php echo htmlspecialchars($prod['unit']); ?></span><?php endif; ?>
                                </div>
                                <div class="product-actions">
                                    <form action="<?php echo url('cart'); ?>" method="POST" style="margin: 0;"><input type="hidden" name="action" value="add"><input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>"><input type="hidden" name="quantity" value="1"><button type="submit" class="btn-cart" style="width: 100%;"><i class="fa-solid fa-cart-plus"></i> Đặt mua</button></form>
                                    <a href="<?php echo url('product/' . $prod['id']); ?>" class="btn-detail" title="Xem chi tiết"><i class="fa-solid fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>
