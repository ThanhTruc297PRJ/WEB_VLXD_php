<div class="container" style="padding: 30px 20px;">
    <!-- Breadcrumb -->
    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 25px;">
        <a href="<?php echo url('/'); ?>" style="color: var(--primary);"><i class="fa-solid fa-house"></i> Trang chu</a>
        <span style="margin: 0 8px;">/</span><span>Yeu cau bao gia cong trinh</span>
    </div>

    <?php if ($quote_submitted): ?>
    <!-- Success Message -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 50px 30px; text-align: center; box-shadow: var(--shadow-sm);">
        <div style="width: 80px; height: 80px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fa-solid fa-circle-check" style="font-size: 40px; color: #22c55e;"></i>
        </div>
        <h1 style="font-size: 1.8rem; font-weight: 800; color: var(--secondary-dark); margin-bottom: 10px;">
            Da Tiep Nhan Yeu Cau Bao Gia!
        </h1>
        <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 550px; margin: 0 auto 12px; line-height: 1.7;">
            Cam on quy khach da gui yeu cau. Doi ngu kinh doanh cua <?php echo SITE_NAME; ?> se lien he lai trong vong <strong>30 phut</strong> (gio hanh chinh) de tu van va bao gia chi tiet.
        </p>
        <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 25px;">
            Neu can gap, vui long goi truc tiep hotline: <strong style="color: var(--primary);"><?php echo SITE_HOTLINE; ?></strong>
        </p>
        <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
            <a href="<?php echo url('/'); ?>" class="btn-primary" style="padding: 12px 24px;">
                <i class="fa-solid fa-house"></i> Ve Trang Chu
            </a>
            <a href="<?php echo url('products'); ?>" class="btn-secondary" style="padding: 12px 24px;">
                <i class="fa-solid fa-boxes-stacked"></i> Xem San Pham Vat Tu
            </a>
        </div>
    </div>

    <?php else: ?>
    <!-- Quote Form -->
    <div style="background: linear-gradient(135deg, #1e293b, #0f172a); color: #ffffff; border-radius: var(--radius-lg); padding: 35px; margin-bottom: 30px; text-align: center;">
        <h1 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 10px;">
            <i class="fa-solid fa-file-invoice-dollar" style="color: var(--primary);"></i> Yeu Cau Bao Gia Cong Trinh
        </h1>
        <p style="color: #94a3b8; max-width: 650px; margin: 0 auto; font-size: 0.92rem; line-height: 1.7;">
            Gui thong tin du an de nhan bao gia chiet khau tot nhat cho don hang so luong lon.
            Doi ngu kinh doanh se phan hoi trong vong 30 phut (gio hanh chinh).
        </p>
    </div>

    <?php if (!empty($error)): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; border-left: 4px solid #ef4444; border-radius: var(--radius-md); padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-exclamation" style="color: #ef4444; font-size: 18px;"></i>
        <span style="color: #991b1b; font-size: 0.9rem; font-weight: 600;"><?php echo htmlspecialchars($error); ?></span>
    </div>
    <?php endif; ?>

    <form action="<?php echo url('quote'); ?>" method="POST" style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 30px; box-shadow: var(--shadow-sm);">
        <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 20px; border-bottom: 2px solid var(--primary-light); padding-bottom: 10px;">
            <i class="fa-solid fa-user-pen" style="color: var(--primary);"></i> Thong Tin Lien He & Du An
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label for="fullname" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                    Ho va Ten <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" id="fullname" name="fullname" class="form-control" placeholder="VD: Nguyen Van A" required style="width: 100%;">
            </div>
            <div class="form-group">
                <label for="phone" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                    So Dien Thoai <span style="color: #ef4444;">*</span>
                </label>
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="VD: 0909 123 456" required style="width: 100%;">
            </div>
            <div class="form-group">
                <label for="email" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                    Email (khong bat buoc)
                </label>
                <input type="email" id="email" name="email" class="form-control" placeholder="VD: ten@email.com" style="width: 100%;">
            </div>
            <div class="form-group">
                <label for="project_type" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                    Loai Cong Trinh <span style="color: #ef4444;">*</span>
                </label>
                <select id="project_type" name="project_type" class="form-control" required style="width: 100%;">
                    <option value="">-- Chon loai cong trinh --</option>
                    <option value="nha_pho">Nha pho dan dung</option>
                    <option value="biet_thu">Biet thu, nha vuon</option>
                    <option value="nha_cap4">Nha cap 4</option>
                    <option value="chung_cu">Chung cu, cao oc</option>
                    <option value="nha_xuong">Nha xuong, kho bai</option>
                    <option value="cong_trinh_cong">Cong trinh cong cong</option>
                    <option value="khac">Khac</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="project_address" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                Dia chi cong trinh <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" id="project_address" name="project_address" class="form-control" placeholder="So nha, duong, phuong/xa, quan/huyen" required style="width: 100%;">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="delivery_date" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                Thoi gian can giao hang
            </label>
            <input type="date" id="delivery_date" name="delivery_date" class="form-control" style="width: 100%;">
        </div>

        <div class="form-group" style="margin-bottom: 25px;">
            <label for="material_notes" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                Chi tiet vat tu can bao gia <span style="color: #ef4444;">*</span>
            </label>
            <textarea id="material_notes" name="material_notes" class="form-control" rows="5" required style="width: 100%; resize: vertical;" placeholder="VD: 10 tan thep Hoa Phat D10-D20, 200 bao xi mang Ha Tien PCB40, 50m3 cat vang, 30m3 da 1x2..."></textarea>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">
                <i class="fa-solid fa-shield-halved" style="color: #22c55e;"></i>
                Thong tin cua quy khach duoc bao mat tuyet doi.
            </p>
            <button type="submit" class="btn-primary" style="padding: 12px 30px; font-size: 0.95rem;">
                <i class="fa-solid fa-paper-plane"></i> Gui Yeu Cau Bao Gia
            </button>
        </div>
    </form>
    <?php endif; ?>
</div>
