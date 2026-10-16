<div class="container" style="padding: 30px 20px;">
    <!-- Breadcrumb -->
    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 25px;">
        <a href="<?php echo url('/'); ?>" style="color: var(--primary);"><i class="fa-solid fa-house"></i> Trang chu</a>
        <span style="margin: 0 8px;">/</span><span>Lien he & Kho bai</span>
    </div>

    <!-- Title Section -->
    <div style="background: linear-gradient(135deg, #1e293b, #0f172a); color: #ffffff; border-radius: var(--radius-lg); padding: 35px; margin-bottom: 30px; text-align: center;">
        <h1 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 10px;">
            <i class="fa-solid fa-map-location-dot" style="color: var(--primary);"></i> Lien He & He Thong Kho Bai
        </h1>
        <p style="color: #94a3b8; max-width: 650px; margin: 0 auto; font-size: 0.92rem; line-height: 1.7;">
            Lien he truc tiep hoac den tham kho bai de duoc tu van va nhan bao gia tot nhat tu <?php echo SITE_NAME; ?>.
        </p>
    </div>

    <?php if (!empty($sent)): ?>
    <div style="background: #dcfce7; border: 1px solid #bbf7d0; border-left: 4px solid #22c55e; border-radius: var(--radius-md); padding: 16px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-circle-check" style="color: #22c55e; font-size: 22px;"></i>
        <div>
            <strong style="color: #166534; font-size: 0.95rem;">Gui lien he thanh cong!</strong>
            <p style="color: #15803d; font-size: 0.85rem; margin-top: 2px;">Cam on quy khach da lien he. Chung toi se phan hoi trong thoi gian som nhat.</p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Two-column Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">

        <!-- Left Column: Warehouse Info -->
        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 30px; box-shadow: var(--shadow-sm);">
            <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 20px; border-bottom: 2px solid var(--primary-light); padding-bottom: 10px;">
                <i class="fa-solid fa-warehouse" style="color: var(--primary);"></i> Thong Tin Kho Bai & Van Phong
            </h2>

            <div style="margin-bottom: 20px;">
                <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid var(--border-color);">
                    <div style="width: 40px; height: 40px; background: var(--primary-light); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-location-dot" style="color: var(--primary); font-size: 18px;"></i>
                    </div>
                    <div>
                        <strong style="font-size: 0.88rem; color: var(--secondary-dark); display: block; margin-bottom: 4px;">Van Phong Giao Dich</strong>
                        <span style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6;"><?php echo SITE_ADDRESS; ?></span>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid var(--border-color);">
                    <div style="width: 40px; height: 40px; background: var(--primary-light); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-warehouse" style="color: var(--primary); font-size: 18px;"></i>
                    </div>
                    <div>
                        <strong style="font-size: 0.88rem; color: var(--secondary-dark); display: block; margin-bottom: 4px;">Kho Bai Vat Tu</strong>
                        <span style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6;"><?php echo SITE_WAREHOUSE; ?></span>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid var(--border-color);">
                    <div style="width: 40px; height: 40px; background: var(--primary-light); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-phone" style="color: var(--primary); font-size: 18px;"></i>
                    </div>
                    <div>
                        <strong style="font-size: 0.88rem; color: var(--secondary-dark); display: block; margin-bottom: 4px;">Hotline Dat Hang 24/7</strong>
                        <span style="font-size: 1.1rem; color: var(--primary); font-weight: 800;"><?php echo SITE_HOTLINE; ?></span>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: var(--primary-light); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-clock" style="color: var(--primary); font-size: 18px;"></i>
                    </div>
                    <div>
                        <strong style="font-size: 0.88rem; color: var(--secondary-dark); display: block; margin-bottom: 4px;">Gio Xuat Hang Kho Bai</strong>
                        <span style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6;">05:30 - 22:00 (Ca Thu Bay & Chu Nhat)</span>
                    </div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: var(--radius-md); padding: 20px; text-align: center; margin-top: 20px;">
                <i class="fa-solid fa-truck-fast" style="font-size: 28px; color: var(--primary); margin-bottom: 10px;"></i>
                <h4 style="color: #ffffff; font-size: 0.95rem; font-weight: 700; margin-bottom: 6px;">Giao Hang Tan Cong Trinh</h4>
                <p style="color: #94a3b8; font-size: 0.82rem; line-height: 1.6;">Doi xe ben 2.5T - 5T & xe cau tu hanh 15T. San sang cap hang 24/7 ke ca ngay le.</p>
            </div>
        </div>

        <!-- Right Column: Contact Form -->
        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 30px; box-shadow: var(--shadow-sm);">
            <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 20px; border-bottom: 2px solid var(--primary-light); padding-bottom: 10px;">
                <i class="fa-solid fa-envelope" style="color: var(--primary);"></i> Gui Lien He Cho Chung Toi
            </h2>

            <form action="<?php echo url('contact'); ?>" method="POST">
                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="name" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                        Ho va Ten <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nhap ho ten cua ban" required style="width: 100%;">
                </div>

                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="phone" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                        So Dien Thoai <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="VD: 0909 123 456" required style="width: 100%;">
                </div>

                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="subject" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                        Chu De <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" id="subject" name="subject" class="form-control" placeholder="VD: Hoi gia thep Hoa Phat" required style="width: 100%;">
                </div>

                <div class="form-group" style="margin-bottom: 22px;">
                    <label for="message" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                        Noi Dung <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea id="message" name="message" class="form-control" rows="5" required style="width: 100%; resize: vertical;" placeholder="Nhap noi dung lien he..."></textarea>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-size: 0.95rem; justify-content: center;">
                    <i class="fa-solid fa-paper-plane"></i> Gui Lien He
                </button>

                <p style="font-size: 0.8rem; color: var(--text-muted); text-align: center; margin-top: 12px;">
                    <i class="fa-solid fa-shield-halved" style="color: #22c55e;"></i>
                    Thong tin cua ban duoc bao mat. Chung toi se phan hoi qua dien thoai trong thoi gian som nhat.
                </p>
            </form>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .container > div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
