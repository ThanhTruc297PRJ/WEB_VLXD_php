<div class="container" style="padding: 30px 20px;">

    <!-- BREADCRUMB -->
    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 25px;">
        <a href="<?php echo url('/'); ?>" style="color: var(--primary);"><i class="fa-solid fa-house"></i> Trang chủ</a>
        <span style="margin: 0 8px;">/</span>
        <a href="<?php echo url('products?cat=' . $product['category_id']); ?>" style="color: var(--primary);"><?php echo htmlspecialchars($product['category_name']); ?></a>
        <span style="margin: 0 8px;">/</span>
        <strong><?php echo htmlspecialchars($product['name']); ?></strong>
    </div>

    <!-- PRODUCT DETAIL CARD -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 30px; box-shadow: var(--shadow-md); margin-bottom: 40px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 35px; align-items: start;">

            <!-- LEFT: PRODUCT IMAGE -->
            <div>
                <div id="main-image-wrap" style="border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8fafc; margin-bottom: 12px;">
                    <img id="main-product-image" src="<?php echo htmlspecialchars($product['image']); ?>"
                         alt="<?php echo htmlspecialchars($product['name']); ?>"
                         style="width: 100%; height: 380px; object-fit: contain; padding: 15px;"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='<?php echo asset('images/no-image.svg'); ?>'">
                </div>
                <?php if (!empty($gallery_images)): ?>
                <div style="display: flex; gap: 8px; overflow-x: auto; padding: 4px 0;">
                    <div style="flex-shrink: 0; cursor: pointer; border: 2px solid var(--primary); border-radius: 8px; overflow: hidden;" onclick="document.getElementById('main-product-image').src='<?php echo htmlspecialchars($product['image']); ?>'">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Ảnh chính" style="width: 70px; height: 70px; object-fit: cover;" onerror="this.onerror=null;this.src='<?php echo asset('images/no-image.svg'); ?>'">
                    </div>
                    <?php foreach ($gallery_images as $gi): ?>
                    <div style="flex-shrink: 0; cursor: pointer; border: 2px solid var(--border-color); border-radius: 8px; overflow: hidden;" onclick="document.getElementById('main-product-image').src='<?php echo htmlspecialchars($gi['image_path']); ?>'; this.parentNode.querySelectorAll('div').forEach(function(d){d.style.borderColor='var(--border-color)'}); this.style.borderColor='var(--primary)'">
                        <img src="<?php echo htmlspecialchars($gi['image_path']); ?>" alt="Ảnh sản phẩm" style="width: 70px; height: 70px; object-fit: cover;" onerror="this.onerror=null;this.src='<?php echo asset('images/no-image.svg'); ?>'">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- RIGHT: PRODUCT INFO -->
            <div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <span style="background: var(--primary-light); color: var(--primary); font-size: 0.78rem; font-weight: 700; padding: 4px 12px; border-radius: 20px;">
                        <i class="fa-solid fa-award"></i> <?php echo htmlspecialchars($product['brand'] ?? 'Chính Hãng'); ?>
                    </span>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">
                        SKU: <strong><?php echo htmlspecialchars($product['sku'] ?? 'N/A'); ?></strong>
                    </span>
                </div>

                <h1 style="font-size: 1.55rem; font-weight: 800; color: var(--secondary-dark); margin-bottom: 15px; line-height: 1.35;">
                    <?php echo htmlspecialchars($product['name']); ?>
                </h1>

                <!-- PRICE BLOCK -->
                <div style="background: linear-gradient(135deg, #fff7ed, #fff3ec); border: 1px solid #fed7aa; border-radius: var(--radius-md); padding: 18px 20px; margin-bottom: 20px;">
                    <span style="font-size: 0.82rem; color: var(--text-muted); display: block; margin-bottom: 6px;">
                        <i class="fa-solid fa-warehouse"></i> Giá xuất xưởng tại kho:
                    </span>
                    <div style="display: flex; align-items: baseline; gap: 8px;">
                        <span style="font-size: 1.75rem; font-weight: 800; color: var(--primary);">
                            <?php echo formatCurrency($product['price'], $product['price_negotiable'] ?? 0); ?>
                        </span>
                        <?php if ($product['price'] > 0): ?>
                            <span style="font-size: 0.95rem; color: var(--text-muted); font-weight: 600;">
                                / <?php echo htmlspecialchars($product['unit']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- STOCK STATUS -->
                <?php if (isset($product['stock']) && $product['stock'] > 0): ?>
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 18px; font-size: 0.85rem; color: #16a34a; font-weight: 600;">
                        <i class="fa-solid fa-circle-check"></i> Còn hàng tại kho (<?php echo number_format($product['stock']); ?> <?php echo htmlspecialchars($product['unit']); ?>)
                    </div>
                <?php else: ?>
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 18px; font-size: 0.85rem; color: #dc2626; font-weight: 600;">
                        <i class="fa-solid fa-circle-xmark"></i> Liên hệ để kiểm tra tồn kho
                    </div>
                <?php endif; ?>

                <!-- ADD TO CART FORM -->
                <form action="<?php echo url('cart'); ?>" method="POST" style="margin-bottom: 18px;">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                        <label style="font-size: 0.88rem; font-weight: 600; color: var(--secondary-dark); white-space: nowrap;">
                            Số lượng:
                        </label>
                        <input type="number" name="quantity" value="1" min="1" max="10000"
                               style="width: 110px; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.95rem; font-weight: 600; text-align: center; color: var(--secondary-dark);">
                        <span style="font-size: 0.85rem; color: var(--text-muted);">
                            <?php echo htmlspecialchars($product['unit']); ?>
                        </span>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 14px 24px; font-size: 1rem;">
                        <i class="fa-solid fa-cart-plus"></i> Thêm Vào Giỏ Hàng
                    </button>
                </form>

                <!-- BULK QUOTE LINK -->
                <a href="<?php echo url('quote'); ?>" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 20px; border: 2px dashed var(--primary); border-radius: 8px; color: var(--primary); font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: background 0.2s;">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Báo Giá Khối Lượng Lớn
                </a>
            </div>
        </div>

        <!-- DESCRIPTION & SPECIFICATION TABLE -->
        <div style="margin-top: 35px; border-top: 1px solid var(--border-color); padding-top: 30px;">

            <?php if (!empty($product['description'])): ?>
                <div style="margin-bottom: 30px;">
                    <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-circle-info" style="color: var(--primary);"></i> Mô Tả Sản Phẩm
                    </h2>
                    <div style="font-size: 0.92rem; color: var(--text-main); line-height: 1.75;">
                        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                    </div>
                </div>
            <?php endif; ?>

            <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-list-check" style="color: var(--primary);"></i> Thông Số Kỹ Thuật
            </h2>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 12px 15px; font-weight: 600; color: var(--text-muted); background: #f8fafc; width: 200px; border-right: 1px solid var(--border-color);">
                        <i class="fa-solid fa-cube" style="width: 18px; color: var(--primary);"></i> Đơn vị tính
                    </td>
                    <td style="padding: 12px 15px; color: var(--text-main);">
                        <?php echo htmlspecialchars($product['unit']); ?>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 12px 15px; font-weight: 600; color: var(--text-muted); background: #f8fafc; width: 200px; border-right: 1px solid var(--border-color);">
                        <i class="fa-solid fa-tag" style="width: 18px; color: var(--primary);"></i> Quy cách
                    </td>
                    <td style="padding: 12px 15px; color: var(--text-main);">
                        <?php echo htmlspecialchars($product['specification'] ?? 'Tiêu chuẩn chất lượng cao'); ?>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 12px 15px; font-weight: 600; color: var(--text-muted); background: #f8fafc; width: 200px; border-right: 1px solid var(--border-color);">
                        <i class="fa-solid fa-award" style="width: 18px; color: var(--primary);"></i> Thương hiệu
                    </td>
                    <td style="padding: 12px 15px; color: var(--text-main); font-weight: 600;">
                        <?php echo htmlspecialchars($product['brand'] ?? 'Chính Hãng'); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 12px 15px; font-weight: 600; color: var(--text-muted); background: #f8fafc; width: 200px; border-right: 1px solid var(--border-color);">
                        <i class="fa-solid fa-truck" style="width: 18px; color: var(--primary);"></i> Vận chuyển
                    </td>
                    <td style="padding: 12px 15px; color: var(--text-main);">
                        Giao tận công trình bằng xe ben &amp; xe cẩu
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- RELATED PRODUCTS -->
    <?php if (!empty($related_products)): ?>
    <div style="margin-bottom: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--secondary-dark); display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-boxes-stacked" style="color: var(--primary);"></i> Vật Liệu Cùng Chủng Loại
            </h2>
            <a href="<?php echo url('products?cat=' . $product['category_id']); ?>" style="font-size: 0.88rem; color: var(--primary); font-weight: 700; text-decoration: none;">
                Xem tất cả <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="products-grid">
            <?php foreach ($related_products as $rel): ?>
                <div class="product-card">
                    <div class="product-thumb">
                        <img src="<?php echo htmlspecialchars($rel['image']); ?>"
                             alt="<?php echo htmlspecialchars($rel['name']); ?>"
                             loading="lazy"
                             onerror="this.onerror=null;this.src='<?php echo asset('images/no-image.svg'); ?>'">
                    </div>
                    <div class="product-body">
                        <div class="product-meta">
                            <span class="product-brand"><?php echo htmlspecialchars($rel['brand'] ?? 'Chính Hãng'); ?></span>
                            <span>ĐVT: <strong><?php echo htmlspecialchars($rel['unit']); ?></strong></span>
                        </div>
                        <h3 class="product-title">
                            <a href="<?php echo url('product/' . $rel['id']); ?>">
                                <?php echo htmlspecialchars($rel['name']); ?>
                            </a>
                        </h3>
                        <div class="product-spec">
                            <i class="fa-solid fa-tag"></i> <?php echo htmlspecialchars($rel['specification'] ?? 'Tiêu chuẩn chất lượng cao'); ?>
                        </div>
                        <div class="product-pricing">
                            <span class="product-price"><?php echo formatCurrency($rel['price'], $rel['price_negotiable'] ?? 0); ?></span>
                            <?php if ($rel['price'] > 0): ?>
                                <span class="product-unit">/ <?php echo htmlspecialchars($rel['unit']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="product-actions">
                            <form action="<?php echo url('cart'); ?>" method="POST" style="margin: 0;">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="product_id" value="<?php echo $rel['id']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-cart" style="width: 100%;">
                                    <i class="fa-solid fa-cart-plus"></i> Đặt mua
                                </button>
                            </form>
                            <a href="<?php echo url('product/' . $rel['id']); ?>" class="btn-detail" title="Xem chi tiết">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</div>
