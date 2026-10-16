<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực Email - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .auth-card { background: #fff; border-radius: 16px; padding: 40px 36px; width: 100%; max-width: 440px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); text-align: center; }
        .auth-logo .icon { width: 68px; height: 68px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .auth-logo .icon i { font-size: 28px; color: #fff; }
        .auth-logo h1 { font-size: 1.25rem; color: #0f172a; font-weight: 800; }
        .auth-logo p { font-size: 0.85rem; color: #64748b; margin-top: 6px; line-height: 1.5; }
        .auth-logo .email-highlight { color: #f36f21; font-weight: 700; }
        .otp-inputs { display: flex; gap: 8px; justify-content: center; margin: 28px 0 20px; }
        .otp-inputs input { width: 50px; height: 56px; text-align: center; font-size: 1.4rem; font-weight: 800; border: 2px solid #e2e8f0; border-radius: 10px; outline: none; font-family: inherit; color: #0f172a; transition: border-color 0.2s; }
        .otp-inputs input:focus { border-color: #f36f21; background: #fff9f5; }
        .error-msg { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 10px 14px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; text-align: left; }
        .error-msg i { margin-right: 6px; }
        .success-msg { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 10px 14px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; text-align: left; }
        .success-msg i { margin-right: 6px; }
        .btn-submit { width: 100%; padding: 14px; background: linear-gradient(135deg, #10b981, #059669); color: #fff; border: none; border-radius: 10px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: opacity 0.2s; font-family: inherit; }
        .btn-submit:hover { opacity: 0.9; }
        .resend-row { margin-top: 20px; font-size: 0.85rem; color: #64748b; }
        .resend-row a { color: #f36f21; text-decoration: none; font-weight: 600; }
        .resend-row a:hover { text-decoration: underline; }
        .timer { font-weight: 700; color: #f36f21; }
        .back-link { margin-top: 16px; font-size: 0.85rem; }
        .back-link a { color: #94a3b8; text-decoration: none; font-weight: 500; }
        .back-link a:hover { color: #64748b; }
        input[name="otp"] { display: none; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <div class="icon"><i class="fa-solid fa-envelope-open-text"></i></div>
            <h1>XÁC THỰC EMAIL</h1>
            <p>Chúng tôi đã gửi mã xác thực 6 số đến<br><span class="email-highlight"><?php echo htmlspecialchars($email); ?></span></p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-msg">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success-msg">
                <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo url('verify'); ?>" method="POST" id="otpForm">
            <input type="hidden" name="otp" id="otpHidden">

            <div class="otp-inputs">
                <input type="text" maxlength="1" class="otp-box" data-index="0" inputmode="numeric" autofocus>
                <input type="text" maxlength="1" class="otp-box" data-index="1" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-box" data-index="2" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-box" data-index="3" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-box" data-index="4" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-box" data-index="5" inputmode="numeric">
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-circle-check"></i> Xác Nhận & Tạo Tài Khoản
            </button>
        </form>

        <div class="resend-row">
            <span>Không nhận được mã? </span>
            <span id="resendArea">
                <span id="timerText">Gửi lại sau <span class="timer" id="countdown">60</span>s</span>
                <a href="<?php echo url('resend-otp'); ?>" id="resendLink" style="display:none;">Gửi lại mã</a>
            </span>
        </div>

        <div class="back-link">
            <a href="<?php echo url('register'); ?>"><i class="fa-solid fa-arrow-left"></i> Quay lại đăng ký</a>
        </div>
    </div>

    <script>
        const boxes = document.querySelectorAll('.otp-box');
        const hidden = document.getElementById('otpHidden');
        const form = document.getElementById('otpForm');

        function updateHidden() {
            let code = '';
            boxes.forEach(b => code += b.value);
            hidden.value = code;
        }

        boxes.forEach((box, i) => {
            box.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
                if (this.value && i < 5) boxes[i + 1].focus();
                updateHidden();
                if (hidden.value.length === 6) form.submit();
            });
            box.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && i > 0) {
                    boxes[i - 1].focus();
                    boxes[i - 1].value = '';
                    updateHidden();
                }
            });
            box.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData.getData('text') || '').replace(/\D/g, '').slice(0, 6);
                for (let j = 0; j < paste.length && j < 6; j++) {
                    boxes[j].value = paste[j];
                }
                updateHidden();
                if (paste.length === 6) form.submit();
                else if (paste.length > 0) boxes[Math.min(paste.length, 5)].focus();
            });
        });

        let seconds = 60;
        const countdownEl = document.getElementById('countdown');
        const timerText = document.getElementById('timerText');
        const resendLink = document.getElementById('resendLink');

        const timer = setInterval(() => {
            seconds--;
            countdownEl.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(timer);
                timerText.style.display = 'none';
                resendLink.style.display = 'inline';
            }
        }, 1000);
    </script>
</body>
</html>
