<div class="container" style="padding: 30px 20px;">
    <!-- Breadcrumb -->
    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 25px;">
        <a href="<?php echo url('/'); ?>" style="color: var(--primary);"><i class="fa-solid fa-house"></i> Trang chu</a>
        <span style="margin: 0 8px;">/</span><span>Du toan vat tu xay dung</span>
    </div>

    <!-- Title Section -->
    <div style="background: linear-gradient(135deg, #1e293b, #0f172a); color: #ffffff; border-radius: var(--radius-lg); padding: 40px 35px; margin-bottom: 30px; text-align: center;">
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 12px;">
            <i class="fa-solid fa-calculator" style="color: var(--primary);"></i> Du Toan Khoi Luong Vat Tu Xay Dung
        </h1>
        <p style="color: #94a3b8; max-width: 750px; margin: 0 auto; font-size: 0.95rem; line-height: 1.7;">
            Cong cu uoc tinh khoi luong vat lieu xay dung theo tieu chuan dinh muc xay dung Viet Nam.
            He thong tinh toan dua tren he so tieu hao binh quan cho cac loai hinh cong trinh dan dung pho bien.
        </p>
    </div>

    <!-- Calculator Form -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 30px; box-shadow: var(--shadow-sm); margin-bottom: 30px;">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 20px; border-bottom: 2px solid var(--primary-light); padding-bottom: 10px;">
            <i class="fa-solid fa-sliders" style="color: var(--primary);"></i> Thong So Cong Trinh
        </h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label for="calc-area" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                    <i class="fa-solid fa-ruler-combined" style="color: var(--primary);"></i> Dien tich san 1 tang (m2):
                </label>
                <input type="number" id="calc-area" class="form-control" value="100" min="10" max="5000" style="width: 100%;">
            </div>
            <div class="form-group">
                <label for="calc-floors" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                    <i class="fa-solid fa-layer-group" style="color: var(--primary);"></i> So tang xay dung:
                </label>
                <input type="number" id="calc-floors" class="form-control" value="2" min="1" max="20" style="width: 100%;">
            </div>
            <div class="form-group">
                <label for="calc-type" style="display: block; font-weight: 600; font-size: 0.88rem; color: var(--secondary-dark); margin-bottom: 6px;">
                    <i class="fa-solid fa-building" style="color: var(--primary);"></i> Loai hinh cong trinh:
                </label>
                <select id="calc-type" class="form-control" style="width: 100%;">
                    <option value="nhapho">Nha pho ket cau be tong cot thep</option>
                    <option value="bietthu">Biet thu san vuon</option>
                    <option value="cap4">Nha cap 4 mai ngoi / ton</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div style="background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: var(--radius-lg); padding: 30px; margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #ffffff;">
                <i class="fa-solid fa-chart-bar" style="color: var(--primary);"></i>
                Uoc Tinh Khoi Luong Vat Tu
                <span style="font-weight: 400; font-size: 0.9rem; color: #94a3b8;">(Tong dien tich san: <span id="res-total-area" style="color: var(--primary); font-weight: 700;">200 m2</span>)</span>
            </h3>
            <a href="<?php echo url('quote'); ?>" style="font-size: 0.85rem; color: var(--primary); font-weight: 700; text-decoration: none;">
                Yeu cau gui bang bao gia <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 15px;">
            <div style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-md); padding: 18px; text-align: center;">
                <div id="res-cement" style="font-size: 1.4rem; font-weight: 800; color: var(--primary); margin-bottom: 4px;">1.500 Bao</div>
                <div style="font-size: 0.8rem; color: #94a3b8;">Xi mang (PCB40 50kg)</div>
            </div>
            <div style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-md); padding: 18px; text-align: center;">
                <div id="res-sand" style="font-size: 1.4rem; font-weight: 800; color: var(--primary); margin-bottom: 4px;">110.0 m3</div>
                <div style="font-size: 0.8rem; color: #94a3b8;">Cat be tong & xay to</div>
            </div>
            <div style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-md); padding: 18px; text-align: center;">
                <div id="res-stone" style="font-size: 1.4rem; font-weight: 800; color: var(--primary); margin-bottom: 4px;">84.0 m3</div>
                <div style="font-size: 0.8rem; color: #94a3b8;">Da xanh 1x2 be tong</div>
            </div>
            <div style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-md); padding: 18px; text-align: center;">
                <div id="res-steel" style="font-size: 1.4rem; font-weight: 800; color: var(--primary); margin-bottom: 4px;">6.40 Tan</div>
                <div style="font-size: 0.8rem; color: #94a3b8;">Sat thep xay dung</div>
            </div>
            <div style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-md); padding: 18px; text-align: center;">
                <div id="res-brick" style="font-size: 1.4rem; font-weight: 800; color: var(--primary); margin-bottom: 4px;">26.000 Vien</div>
                <div style="font-size: 0.8rem; color: #94a3b8;">Gach tuynel 4 lo</div>
            </div>
        </div>
    </div>

    <!-- Technical Explanation -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 30px; box-shadow: var(--shadow-sm);">
        <h2 style="font-size: 1.2rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 18px; border-bottom: 2px solid var(--primary-light); padding-bottom: 10px;">
            <i class="fa-solid fa-circle-info" style="color: var(--primary);"></i> Giai Thich He So Dinh Muc Xay Dung
        </h2>
        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.7; margin-bottom: 15px;">
            Khoi luong vat tu duoc uoc tinh dua tren dinh muc binh quan cho cong trinh dan dung theo tieu chuan Viet Nam.
            Cac he so tieu hao tren moi m2 san xay dung nhu sau:
        </p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px; margin-bottom: 20px;">
            <div style="background: var(--primary-light); border-radius: var(--radius-md); padding: 15px;">
                <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 8px;">
                    <i class="fa-solid fa-building" style="color: var(--primary);"></i> Nha pho (BTCT)
                </h4>
                <ul style="list-style: none; font-size: 0.82rem; color: var(--text-muted); line-height: 2;">
                    <li>Xi mang: 7.5 bao/m2 | Cat: 0.55 m3/m2</li>
                    <li>Da 1x2: 0.42 m3/m2 | Thep: 32 kg/m2</li>
                    <li>Gach: 130 vien/m2</li>
                </ul>
            </div>
            <div style="background: var(--primary-light); border-radius: var(--radius-md); padding: 15px;">
                <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 8px;">
                    <i class="fa-solid fa-landmark" style="color: var(--primary);"></i> Biet thu san vuon
                </h4>
                <ul style="list-style: none; font-size: 0.82rem; color: var(--text-muted); line-height: 2;">
                    <li>Xi mang: 8.5 bao/m2 | Cat: 0.65 m3/m2</li>
                    <li>Da 1x2: 0.50 m3/m2 | Thep: 38 kg/m2</li>
                    <li>Gach: 150 vien/m2</li>
                </ul>
            </div>
            <div style="background: var(--primary-light); border-radius: var(--radius-md); padding: 15px;">
                <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--secondary-dark); margin-bottom: 8px;">
                    <i class="fa-solid fa-house-chimney" style="color: var(--primary);"></i> Nha cap 4
                </h4>
                <ul style="list-style: none; font-size: 0.82rem; color: var(--text-muted); line-height: 2;">
                    <li>Xi mang: 5.5 bao/m2 | Cat: 0.45 m3/m2</li>
                    <li>Da 1x2: 0.28 m3/m2 | Thep: 18 kg/m2</li>
                    <li>Gach: 110 vien/m2</li>
                </ul>
            </div>
        </div>
        <p style="color: var(--text-muted); font-size: 0.82rem; font-style: italic; line-height: 1.6;">
            <i class="fa-solid fa-triangle-exclamation" style="color: #f59e0b;"></i>
            <strong>Luu y:</strong> Day la uoc tinh so bo mang tinh chat tham khao. Khoi luong thuc te se thay doi tuy theo thiet ke ket cau, dia chat nen mong va yeu cau ky thuat cu the cua tung cong trinh.
            Vui long lien he hotline <strong><?php echo SITE_HOTLINE; ?></strong> hoac <a href="<?php echo url('quote'); ?>" style="color: var(--primary); font-weight: 700;">gui yeu cau bao gia</a> de duoc tu van chinh xac.
        </p>
    </div>
</div>

<script>
(function() {
    var coefficients = {
        nhapho:  { cement: 7.5,  sand: 0.55, stone: 0.42, steel: 32, brick: 130 },
        bietthu: { cement: 8.5,  sand: 0.65, stone: 0.50, steel: 38, brick: 150 },
        cap4:    { cement: 5.5,  sand: 0.45, stone: 0.28, steel: 18, brick: 110 }
    };

    function formatNum(n) {
        if (n >= 1000) {
            return n.toLocaleString('vi-VN');
        }
        return n % 1 === 0 ? n.toLocaleString('vi-VN') : n.toFixed(1).replace('.', ',');
    }

    function calculate() {
        var area   = parseFloat(document.getElementById('calc-area').value) || 0;
        var floors = parseInt(document.getElementById('calc-floors').value) || 1;
        var type   = document.getElementById('calc-type').value;
        var coeff  = coefficients[type] || coefficients.nhapho;
        var total  = area * floors;

        document.getElementById('res-total-area').textContent = formatNum(total) + ' m²';
        document.getElementById('res-cement').textContent = formatNum(Math.round(coeff.cement * total)) + ' Bao';
        document.getElementById('res-sand').textContent   = formatNum(parseFloat((coeff.sand * total).toFixed(1))) + ' m³';
        document.getElementById('res-stone').textContent  = formatNum(parseFloat((coeff.stone * total).toFixed(1))) + ' m³';
        document.getElementById('res-steel').textContent  = formatNum(parseFloat((coeff.steel * total / 1000).toFixed(2))) + ' Tấn';
        document.getElementById('res-brick').textContent  = formatNum(Math.round(coeff.brick * total)) + ' Viên';
    }

    document.getElementById('calc-area').addEventListener('input', calculate);
    document.getElementById('calc-floors').addEventListener('input', calculate);
    document.getElementById('calc-type').addEventListener('change', calculate);

    calculate();
})();
</script>
