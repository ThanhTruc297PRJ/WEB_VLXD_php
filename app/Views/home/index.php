<?php if (!$db_connected): ?>
<div style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 16px 20px; margin: 15px auto; max-width: 1240px; border-radius: 8px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid fa-triangle-exclamation" style="color: #f59e0b; font-size: 24px;"></i>
            <div>
                <strong style="color: #92400e; font-size: 0.95rem;">Hệ thống đang chạy chế độ dữ liệu mẫu (Demo Mode)</strong>
                <p style="color: #b45309; font-size: 0.85rem; margin-top: 2px;">
                    Để kích hoạt đầy đủ CSDL MySQL: Hãy mở <strong>Laragon -> Start All</strong>, vào phpMyAdmin tạo database <code>vlxd_db</code> và import file <code>database/schema.sql</code>.
                </p>
            </div>
        </div>
        <span style="background: #fef3c7; color: #92400e; font-size: 0.8rem; font-weight: 700; padding: 6px 12px; border-radius: 20px;">Laragon MySQL</span>
    </div>
</div>
<?php endif; ?>

<!-- 1. HERO BANNER -->
<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-content">
            <h2>TỔNG KHO PHÂN PHỐI <br><span>VẬT LIỆU XÂY DỰNG</span> UY TÍN</h2>
            <p>Cung cấp sắt thép Hòa Phát, Pomina, xi măng Hà Tiên, Insee, cát đá rửa sạch và gạch tuynel. Hệ thống xe ben 5T - xe cẩu 15T giao hàng xuyên suốt 24/7 đến tận chân công trình.</p>
            <div class="hero-buttons">
                <a href="<?php echo url('products'); ?>" class="btn-primary">
                    <i class="fa-solid fa-boxes-stacked"></i> Xem Bảng Giá Vật Tư
                </a>
                <a href="<?php echo url('estimate'); ?>" class="btn-secondary">
                    <i class="fa-solid fa-calculator"></i> Tính Dự Toán Xây Nhà
                </a>
            </div>
        </div>
        <div class="hero-card">
            <h3><i class="fa-solid fa-truck-ramp-box"></i> Năng Lực Cung Ứng Kho Bãi</h3>
            <p style="font-size: 0.88rem; color: #cbd5e1; line-height: 1.5;">Đáp ứng đồng thời hàng trăm tấn sắt thép và hàng ngàn khối cát đá mỗi ngày cho các dự án dân dụng & công nghiệp.</p>
            <div class="quick-stats">
                <div class="stat-item"><div class="stat-number">15+ Xe</div><div class="stat-desc">Xe ben, xe cẩu tự hành</div></div>
                <div class="stat-item"><div class="stat-number">5.000m²</div><div class="stat-desc">Tổng diện tích 2 kho bãi</div></div>
                <div class="stat-item"><div class="stat-number">100%</div><div class="stat-desc">Chuẩn mác & khối lượng</div></div>
                <div class="stat-item"><div class="stat-number">24/7</div><div class="stat-desc">Cấp hàng ban đêm & chủ nhật</div></div>
            </div>
        </div>
    </div>
</section>

<!-- 2. DANH MỤC -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-title"><h2>Danh Mục Vật Tư Xây Dựng</h2><p>Đầy đủ các nhóm chủng loại vật liệu phục vụ từ phần thô đến giai đoạn hoàn thiện</p></div>
            <a href="<?php echo url('products'); ?>" class="section-link">Xem tất cả danh mục <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="categories-grid">
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo url('products?cat=' . $cat['id']); ?>" class="category-card">
                    <div class="category-icon-wrapper"><i class="fa-solid <?php echo htmlspecialchars($cat['icon']); ?>"></i></div>
                    <h3><?php echo htmlspecialchars($cat['name']); ?></h3>
                    <p><?php echo htmlspecialchars($cat['description']); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 3. CÔNG CỤ DỰ TOÁN -->
<section class="container">
    <div class="estimate-banner">
        <h2 style="font-size: 1.85rem; font-weight: 800; margin-bottom: 8px;">
            <i class="fa-solid fa-calculator" style="color: var(--primary);"></i> CÔNG CỤ DỰ TOÁN VẬT TƯ XÂY NHÀ NHANH
        </h2>
        <p style="color: #cbd5e1; max-width: 750px;">Nhập diện tích xây dựng để hệ thống tự động ước tính khối lượng xi măng, cát, đá, sắt thép và gạch ống cần chuẩn bị.</p>
        <div class="calc-box">
            <div class="calc-inputs">
                <div class="form-group"><label><i class="fa-solid fa-ruler-combined"></i> Diện tích sàn 1 tầng (m²):</label><input type="number" id="calc-area" class="form-control" value="80" min="10" max="2000"></div>
                <div class="form-group"><label><i class="fa-solid fa-layer-group"></i> Số tầng xây dựng:</label><input type="number" id="calc-floors" class="form-control" value="2" min="1" max="20"></div>
                <div class="form-group"><label><i class="fa-solid fa-building"></i> Loại hình công trình:</label><select id="calc-type" class="form-control"><option value="nhapho">Nhà phố kết cấu bê tông cốt thép</option><option value="bietthu">Biệt thự sân vườn</option><option value="cap4">Nhà cấp 4 mái ngói / tôn</option></select></div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 10px;">
                <span style="font-size: 0.88rem; font-weight: 700; color: var(--secondary-dark);">Ước tính khối lượng vật tư (Tổng diện tích sàn: <span id="res-total-area" style="color: var(--primary);">160 m²</span>):</span>
                <a href="<?php echo url('quote'); ?>" style="font-size: 0.85rem; color: var(--primary); font-weight: 700;">Yêu cầu gửi bảng báo giá <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="calc-results">
                <div class="res-item"><div class="res-val" id="res-cement">1.200 Bao</div><div class="res-label">Xi măng (PCB40 50kg)</div></div>
                <div class="res-item"><div class="res-val" id="res-sand">88.0 m³</div><div class="res-label">Cát bê tông & xây tô</div></div>
                <div class="res-item"><div class="res-val" id="res-stone">67.2 m³</div><div class="res-label">Đá xanh 1x2 bê tông</div></div>
                <div class="res-item"><div class="res-val" id="res-steel">5.12 Tấn</div><div class="res-label">Sắt thép xây dựng</div></div>
                <div class="res-item"><div class="res-val" id="res-brick">20.800 Viên</div><div class="res-label">Gạch tuynel 4 lỗ</div></div>
            </div>
        </div>
    </div>
</section>

<!-- 4. SẢN PHẨM TIÊU BIỂU -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-title"><h2>Vật Liệu Xây Dựng Bán Chạy</h2><p>Hàng chính hãng có sẵn tại kho, giao ngay trong ngày bằng xe ben & xe cẩu</p></div>
            <a href="<?php echo url('products'); ?>" class="section-link">Xem toàn bộ sản phẩm <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="products-grid">
            <?php foreach ($featured_products as $prod): ?>
                <div class="product-card">
                    <?php if ($prod['is_featured']): ?><span class="product-badge featured">Bán chạy</span><?php endif; ?>
                    <div class="product-thumb"><img src="<?php echo htmlspecialchars($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" loading="lazy" onerror="this.onerror=null;this.src='<?php echo asset('images/no-image.svg'); ?>'"></div>
                    <div class="product-body">
                        <div class="product-meta"><span class="product-brand"><?php echo htmlspecialchars($prod['brand']); ?></span><span>ĐVT: <strong><?php echo htmlspecialchars($prod['unit']); ?></strong></span></div>
                        <h3 class="product-title"><a href="<?php echo url('product/' . $prod['id']); ?>"><?php echo htmlspecialchars($prod['name']); ?></a></h3>
                        <div class="product-spec"><i class="fa-solid fa-tag"></i> <?php echo htmlspecialchars($prod['specification']); ?></div>
                        <div class="product-pricing">
                            <span class="product-price"><?php echo formatCurrency($prod['price'], $prod['price_negotiable']); ?></span>
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
    </div>
</section>

<!-- 5. CAM KẾT -->
<section class="section" style="background: #ffffff; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <div class="section-title" style="text-align: center; margin-bottom: 35px;"><h2>Tại Sao Các Nhà Thầu Lựa Chọn VLXD Toàn Thắng?</h2><p>Uy tín tạo nên thương hiệu - Đồng hành cùng hàng ngàn công trình dân dụng & dự án lớn</p></div>
        <div class="features-grid">
            <div class="feature-box"><div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div><div class="feature-info"><h4>Vận Chuyển Đa Phương Tiện</h4><p>Sở hữu đội xe ben 2.5T luồn lách hẻm nhỏ và xe tải cẩu 15T hạ hàng nặng an toàn tại công trình.</p></div></div>
            <div class="feature-box"><div class="feature-icon"><i class="fa-solid fa-weight-scale"></i></div><div class="feature-info"><h4>Chuẩn Khối Lượng & Mác Thép</h4><p>Cát đá đong thùng m³ chính xác, sắt thép nguyên tem mác nhà máy, cân tải trọng rõ ràng minh bạch.</p></div></div>
            <div class="feature-box"><div class="feature-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div><div class="feature-info"><h4>Giá Tận Gốc - Chiết Khấu Cao</h4><p>Nhà phân phối cấp 1 trực tiếp từ nhà máy sản xuất, giá luôn cạnh tranh và bình ổn nhất thị trường.</p></div></div>
            <div class="feature-box"><div class="feature-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div><div class="feature-info"><h4>Đầy Đủ Hóa Đơn & Chứng Từ</h4><p>Cung cấp phiếu xuất kho, chứng nhận hợp chuẩn CO/CQ và hóa đơn VAT nhanh chóng cho dự án.</p></div></div>
        </div>
    </div>
</section>
