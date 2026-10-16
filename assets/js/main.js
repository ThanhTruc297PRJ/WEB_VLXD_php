/**
 * WEBSITE VẬT LIỆU XÂY DỰNG - JAVASCRIPT XỬ LÝ TƯƠNG TÁC
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. CÔNG CỤ DỰ TOÁN VẬT TƯ XÂY DỰNG NHANH
    const areaInput = document.getElementById('calc-area');
    const floorsInput = document.getElementById('calc-floors');
    const typeSelect = document.getElementById('calc-type');

    function calculateMaterials() {
        if (!areaInput || !floorsInput) return;

        const area = parseFloat(areaInput.value) || 0;
        const floors = parseInt(floorsInput.value) || 1;
        const totalFloorArea = area * floors;

        // Định mức xây dựng trung bình nhà dân dụng tại Việt Nam / m2 sàn:
        // - Xi măng: 7.5 bao (50kg) / m2
        // - Cát vàng + cát xây: 0.55 m3 / m2
        // - Đá 1x2: 0.42 m3 / m2
        // - Sắt thép: 32 kg (0.032 tấn) / m2
        // - Gạch tuynel 4 lỗ: 130 viên / m2

        const cementBags = Math.round(totalFloorArea * 7.5);
        const sandM3 = (totalFloorArea * 0.55).toFixed(1);
        const stoneM3 = (totalFloorArea * 0.42).toFixed(1);
        const steelTons = (totalFloorArea * 0.032).toFixed(2);
        const brickCount = Math.round(totalFloorArea * 130);

        // Cập nhật DOM
        const elTotalArea = document.getElementById('res-total-area');
        const elCement = document.getElementById('res-cement');
        const elSand = document.getElementById('res-sand');
        const elStone = document.getElementById('res-stone');
        const elSteel = document.getElementById('res-steel');
        const elBrick = document.getElementById('res-brick');

        if (elTotalArea) elTotalArea.innerText = totalFloorArea.toLocaleString('vi-VN') + ' m²';
        if (elCement) elCement.innerText = cementBags.toLocaleString('vi-VN') + ' Bao';
        if (elSand) elSand.innerText = sandM3 + ' m³';
        if (elStone) elStone.innerText = stoneM3 + ' m³';
        if (elSteel) elSteel.innerText = steelTons + ' Tấn';
        if (elBrick) elBrick.innerText = brickCount.toLocaleString('vi-VN') + ' Viên';
    }

    if (areaInput && floorsInput) {
        areaInput.addEventListener('input', calculateMaterials);
        floorsInput.addEventListener('input', calculateMaterials);
        if (typeSelect) typeSelect.addEventListener('change', calculateMaterials);
        // Khởi chạy tính toán ban đầu
        calculateMaterials();
    }

    // 2. NÚT TĂNG GIẢM SỐ LƯỢNG SẢN PHẨM
    const qtyMinusBtns = document.querySelectorAll('.qty-btn-minus');
    const qtyPlusBtns = document.querySelectorAll('.qty-btn-plus');

    qtyMinusBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const input = this.parentElement.querySelector('input');
            if (input) {
                let val = parseInt(input.value) || 1;
                if (val > 1) {
                    input.value = val - 1;
                    triggerChange(input);
                }
            }
        });
    });

    qtyPlusBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const input = this.parentElement.querySelector('input');
            if (input) {
                let val = parseInt(input.value) || 1;
                input.value = val + 1;
                triggerChange(input);
            }
        });
    });

    function triggerChange(element) {
        const event = new Event('change', { bubbles: true });
        element.dispatchEvent(event);
    }
});
