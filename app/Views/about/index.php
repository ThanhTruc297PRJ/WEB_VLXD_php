<!-- HERO GIỚI THIỆU -->
<section style="background: linear-gradient(135deg, #0f172a, #1e293b); color: #fff; padding: 60px 0; position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; background: radial-gradient(circle at 80% 20%, rgba(243,111,33,0.15) 0%, transparent 60%); pointer-events: none;"></div>
    <div class="container" style="position: relative; text-align: center;">
        <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #f36f21, #e85d04); border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 16px; box-shadow: 0 8px 24px rgba(243,111,33,0.4);">
            <i class="fa-solid fa-trowel-bricks"></i>
        </div>
        <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 10px;">Về Chúng Tôi</h1>
        <p style="color: #94a3b8; font-size: 1.05rem; max-width: 600px; margin: 0 auto;">
            <?php echo SITE_SLOGAN; ?>
        </p>
    </div>
</section>

<!-- CÂU CHUYỆN -->
<section class="section">
    <div class="container">
        <div class="about-grid-2">
            <div>
                <h2 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin-bottom: 14px;">
                    <span style="color: var(--primary);">VLXD Hương Tiến</span> — Đối Tác Tin Cậy Cho Mọi Công Trình
                </h2>
                <p style="color: #475569; font-size: 0.95rem; line-height: 1.8; margin-bottom: 14px;">
                    Được thành lập với sứ mệnh cung cấp vật liệu xây dựng chất lượng cao với giá cả hợp lý nhất,
                    <strong>VLXD Hương Tiến</strong> đã và đang trở thành địa chỉ uy tín được nhiều nhà thầu,
                    kỹ sư và hộ gia đình tin tưởng lựa chọn.
                </p>
                <p style="color: #475569; font-size: 0.95rem; line-height: 1.8; margin-bottom: 14px;">
                    Chúng tôi chuyên cung cấp trọn gói vật liệu xây dựng từ phần thô đến hoàn thiện:
                    <strong>thép xây dựng Hòa Phát, Pomina</strong>, <strong>xi măng Hà Tiên, INSEE</strong>,
                    <strong>cát, đá, gạch tuynel</strong> và nhiều loại vật tư khác với giá xuất kho tốt nhất khu vực.
                </p>
                <p style="color: #475569; font-size: 0.95rem; line-height: 1.8;">
                    Với hệ thống kho bãi rộng rãi và đội xe vận chuyển chuyên nghiệp,
                    chúng tôi cam kết giao hàng nhanh chóng, đúng hẹn tận chân công trình.
                </p>
            </div>
            <div style="background: linear-gradient(135deg, #fff7ed, #ffedd5); border-radius: 16px; padding: 36px; border: 1px solid #fed7aa;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div style="text-align: center; padding: 20px; background: #fff; border-radius: 12px; box-shadow: var(--shadow-sm);">
                        <div style="font-size: 2rem; font-weight: 800; color: var(--primary);">500+</div>
                        <div style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Công Trình Cung Ứng</div>
                    </div>
                    <div style="text-align: center; padding: 20px; background: #fff; border-radius: 12px; box-shadow: var(--shadow-sm);">
                        <div style="font-size: 2rem; font-weight: 800; color: #2563eb;">50+</div>
                        <div style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Sản Phẩm Đa Dạng</div>
                    </div>
                    <div style="text-align: center; padding: 20px; background: #fff; border-radius: 12px; box-shadow: var(--shadow-sm);">
                        <div style="font-size: 2rem; font-weight: 800; color: #10b981;">100%</div>
                        <div style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Hàng Chính Hãng</div>
                    </div>
                    <div style="text-align: center; padding: 20px; background: #fff; border-radius: 12px; box-shadow: var(--shadow-sm);">
                        <div style="font-size: 2rem; font-weight: 800; color: #f59e0b;">24/7</div>
                        <div style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Hỗ Trợ Tư Vấn</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TẠI SAO CHỌN CHÚNG TÔI -->
<section style="background: #f1f5f9; padding: 60px 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 36px;">
            <h2 style="font-size: 1.6rem; font-weight: 800; color: #0f172a;">Tại Sao Chọn VLXD Hương Tiến?</h2>
            <p style="color: #64748b; font-size: 0.95rem; margin-top: 6px;">6 lý do khách hàng luôn quay lại với chúng tôi</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
            <?php
            $reasons = [
                ['icon' => 'fa-certificate', 'color' => '#f36f21', 'title' => 'Hàng Chính Hãng 100%', 'desc' => 'Tất cả sản phẩm đều có tem mác, CO/CQ đầy đủ. Cam kết đúng chủng loại, đúng khối lượng.'],
                ['icon' => 'fa-tags', 'color' => '#e11d48', 'title' => 'Giá Xuất Kho Tốt Nhất', 'desc' => 'Lấy hàng trực tiếp từ nhà máy, không qua trung gian. Giá cạnh tranh nhất khu vực, chiết khấu hấp dẫn cho đơn lớn.'],
                ['icon' => 'fa-truck-fast', 'color' => '#2563eb', 'title' => 'Giao Hàng Tận Công Trình', 'desc' => 'Đội xe ben 2.5T, 5T và xe cẩu 15T. Giao hàng nhanh trong ngày, đúng hẹn, đúng địa điểm.'],
                ['icon' => 'fa-calculator', 'color' => '#10b981', 'title' => 'Hỗ Trợ Dự Toán Miễn Phí', 'desc' => 'Đội ngũ tư vấn giúp bạn tính toán vật tư chính xác theo bản vẽ, tiết kiệm chi phí tối đa.'],
                ['icon' => 'fa-file-invoice', 'color' => '#7c3aed', 'title' => 'Xuất Hóa Đơn VAT', 'desc' => 'Cung cấp đầy đủ hóa đơn giá trị gia tăng, chứng từ hợp lệ cho mọi đơn hàng.'],
                ['icon' => 'fa-handshake', 'color' => '#0891b2', 'title' => 'Hợp Đồng Dài Hạn', 'desc' => 'Ưu đãi đặc biệt cho nhà thầu và đối tác lâu dài. Chính sách công nợ linh hoạt, thanh toán thuận tiện.'],
            ];
            foreach ($reasons as $r):
            ?>
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; display: flex; gap: 16px; align-items: flex-start; box-shadow: var(--shadow-sm); transition: all 0.25s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.transform='';this.style.boxShadow='var(--shadow-sm)'">
                <div style="width: 48px; height: 48px; background: <?php echo $r['color']; ?>15; color: <?php echo $r['color']; ?>; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                    <i class="fa-solid <?php echo $r['icon']; ?>"></i>
                </div>
                <div>
                    <h4 style="font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 6px;"><?php echo $r['title']; ?></h4>
                    <p style="font-size: 0.85rem; color: #64748b; line-height: 1.6;"><?php echo $r['desc']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- THÔNG TIN LIÊN HỆ -->
<section class="section">
    <div class="container">
        <div class="about-contact-grid" style="background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 16px; padding: 40px; color: #fff;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 16px;">Liên Hệ Hợp Tác</h2>
                <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.7; margin-bottom: 20px;">
                    Quý khách cần báo giá vật tư công trình, tư vấn dự toán hoặc hợp tác cung ứng dài hạn?
                    Hãy liên hệ ngay với chúng tôi để nhận báo giá tốt nhất!
                </p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="<?php echo url('contact'); ?>" class="btn-primary" style="padding: 12px 24px;">
                        <i class="fa-solid fa-paper-plane"></i> Gửi Liên Hệ
                    </a>
                    <a href="<?php echo url('quote'); ?>" class="btn-secondary" style="padding: 12px 24px;">
                        <i class="fa-solid fa-file-invoice-dollar"></i> Báo Giá Công Trình
                    </a>
                </div>
            </div>
            <div style="display: grid; gap: 14px;">
                <div style="display: flex; align-items: center; gap: 14px; background: rgba(255,255,255,0.05); border-radius: 10px; padding: 14px 18px;">
                    <i class="fa-solid fa-location-dot" style="color: var(--primary); font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="color: #cbd5e1; font-size: 0.9rem;"><?php echo SITE_ADDRESS; ?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; background: rgba(255,255,255,0.05); border-radius: 10px; padding: 14px 18px;">
                    <i class="fa-solid fa-phone" style="color: var(--primary); font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="color: #cbd5e1; font-size: 0.9rem;">Hotline: <strong style="color: #fff;"><?php echo SITE_HOTLINE; ?></strong></span>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; background: rgba(255,255,255,0.05); border-radius: 10px; padding: 14px 18px;">
                    <i class="fa-solid fa-envelope" style="color: var(--primary); font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="color: #cbd5e1; font-size: 0.9rem;"><?php echo SITE_EMAIL; ?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; background: rgba(255,255,255,0.05); border-radius: 10px; padding: 14px 18px;">
                    <i class="fa-solid fa-clock" style="color: var(--primary); font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="color: #cbd5e1; font-size: 0.9rem;">Giờ xuất hàng: <strong style="color: #fff;">05:30 - 22:00</strong> (Cả T7 & CN)</span>
                </div>
            </div>
        </div>
    </div>
</section>
