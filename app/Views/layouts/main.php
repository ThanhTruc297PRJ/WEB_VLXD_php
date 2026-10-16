<?php
$current_url = $_GET['url'] ?? '';
$cart_count = getCartCount();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME . ' | Vật Liệu Xây Dựng Uy Tín Giá Tốt'; ?></title>
    <meta name="description" content="Chuyên cung cấp vật liệu xây dựng thô và hoàn thiện: Thép Hòa Phát, Pomina, Xi măng Hà Tiên, Insee, Cát bê tông, Đá 1x2, Gạch tuynel. Vận chuyển tận công trình.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
</head>
<body>

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="container topbar-content">
            <div class="topbar-info">
                <span><i class="fa-solid fa-truck-fast"></i> Giao hàng tận công trình bằng xe ben & xe cẩu</span>
                <span><i class="fa-solid fa-phone"></i> Hotline 24/7: <strong><?php echo SITE_HOTLINE; ?></strong></span>
            </div>
            <div class="topbar-links">
                <a href="<?php echo url('quote'); ?>"><i class="fa-solid fa-file-invoice-dollar"></i> Yêu cầu báo giá công trình</a>
                <?php if (!empty($_SESSION['admin_id'])): ?>
                    <a href="<?php echo url('admin'); ?>"><i class="fa-solid fa-user-shield"></i> Quản trị</a>
                    <a href="<?php echo url('admin/logout'); ?>"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
                <?php elseif (!empty($_SESSION['customer_id'])): ?>
                    <a href="<?php echo url('account/profile'); ?>" style="color: #fbbf24;"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($_SESSION['customer_name']); ?></a>
                    <a href="<?php echo url('account/orders'); ?>"><i class="fa-solid fa-clipboard-list"></i> Đơn hàng</a>
                    <a href="<?php echo url('logout'); ?>"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
                <?php else: ?>
                    <a href="<?php echo url('login'); ?>"><i class="fa-solid fa-right-to-bracket"></i> Đăng nhập</a>
                    <a href="<?php echo url('register'); ?>"><i class="fa-solid fa-user-plus"></i> Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <header class="header-main">
        <div class="container header-wrapper">
            <a href="<?php echo url('/'); ?>" class="logo-brand">
                <div class="logo-icon"><i class="fa-solid fa-trowel-bricks"></i></div>
                <div class="logo-text">
                    <h1>VLXD HƯƠNG TIẾN</h1>
                    <p>VẬT TƯ CÔNG TRÌNH & DÂN DỤNG</p>
                </div>
            </a>

            <div class="header-search">
                <form action="<?php echo url('products'); ?>" method="GET" class="search-form">
                    <input type="text" name="search" class="search-input" placeholder="Tìm kiếm thép, xi măng, cát, đá, gạch..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
                </form>
            </div>

            <div class="header-actions">
                <a href="<?php echo url('cart'); ?>" class="action-item">
                    <div class="action-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="badge-count" id="cart-counter"><?php echo $cart_count; ?></span>
                    </div>
                    <div class="action-text">
                        <span>Giỏ hàng</span>
                        <strong>Vật tư đặt mua</strong>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container nav-wrapper">
            <ul class="nav-links">
                <li class="nav-item <?php echo ($current_url === '') ? 'active' : ''; ?>">
                    <a href="<?php echo url('/'); ?>"><i class="fa-solid fa-house"></i> Trang Chủ</a>
                </li>
                <li class="nav-item <?php echo (str_starts_with($current_url, 'product')) ? 'active' : ''; ?>">
                    <a href="<?php echo url('products'); ?>"><i class="fa-solid fa-boxes-stacked"></i> Danh Mục Vật Liệu</a>
                </li>
                <li class="nav-item <?php echo ($current_url === 'estimate') ? 'active' : ''; ?>">
                    <a href="<?php echo url('estimate'); ?>"><i class="fa-solid fa-calculator"></i> Dự Toán Vật Tư Xây Nhà</a>
                </li>
                <li class="nav-item <?php echo ($current_url === 'quote') ? 'active' : ''; ?>">
                    <a href="<?php echo url('quote'); ?>"><i class="fa-solid fa-file-signature"></i> Báo Giá Công Trình</a>
                </li>
                <li class="nav-item <?php echo ($current_url === 'about') ? 'active' : ''; ?>">
                    <a href="<?php echo url('about'); ?>"><i class="fa-solid fa-building"></i> Giới Thiệu</a>
                </li>
                <li class="nav-item <?php echo ($current_url === 'contact') ? 'active' : ''; ?>">
                    <a href="<?php echo url('contact'); ?>"><i class="fa-solid fa-map-location-dot"></i> Liên Hệ & Kho Bãi</a>
                </li>
            </ul>
            <div>
                <a href="<?php echo url('quote'); ?>" class="nav-special-btn">
                    <i class="fa-solid fa-bolt"></i> Báo Giá Nhanh Số Lượng Lớn
                </a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <?php echo $content; ?>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-col">
                <h3>VLXD HƯƠNG TIẾN</h3>
                <p><?php echo SITE_SLOGAN; ?>. Chuyên cung cấp trọn gói từ phần thô đến phần hoàn thiện với giá xuất xưởng tốt nhất khu vực.</p>
                <p><i class="fa-solid fa-clock"></i> <strong>Giờ xuất hàng kho bãi:</strong> 05:30 - 22:00 (Cả Thứ Bảy & Chủ Nhật)</p>
            </div>
            <div class="footer-col">
                <h3>Vật Tư Trọng Điểm</h3>
                <ul class="footer-links">
                    <li><a href="<?php echo url('products?cat=3'); ?>"><i class="fa-solid fa-angle-right"></i> Thép Xây Dựng Hòa Phát, Pomina</a></li>
                    <li><a href="<?php echo url('products?cat=1'); ?>"><i class="fa-solid fa-angle-right"></i> Xi Măng Hà Tiên, INSEE PCB40</a></li>
                    <li><a href="<?php echo url('products?cat=2'); ?>"><i class="fa-solid fa-angle-right"></i> Cát Vàng Bê Tông & Cát Xây Tô</a></li>
                    <li><a href="<?php echo url('products?cat=2'); ?>"><i class="fa-solid fa-angle-right"></i> Đá Xanh 1x2, Đá 4x6 Hóa An</a></li>
                    <li><a href="<?php echo url('products?cat=4'); ?>"><i class="fa-solid fa-angle-right"></i> Gạch Tuynel 4 Lỗ Bình Dương</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Dịch Vụ & Vận Chuyển</h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="fa-solid fa-shield-halved"></i> Cam kết đúng tem mác, đủ khối lượng</a></li>
                    <li><a href="#"><i class="fa-solid fa-truck-moving"></i> Đội xe ben 2.5T, 5T & xe cẩu 15T</a></li>
                    <li><a href="#"><i class="fa-solid fa-file-invoice"></i> Cung cấp đầy đủ CO/CQ & Hóa đơn VAT</a></li>
                    <li><a href="<?php echo url('estimate'); ?>"><i class="fa-solid fa-calculator"></i> Hỗ trợ dự toán vật tư miễn phí</a></li>
                    <li><a href="<?php echo url('quote'); ?>"><i class="fa-solid fa-headset"></i> Hợp đồng cung ứng công trình dài hạn</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Kho Bãi & Liên Hệ</h3>
                <p><i class="fa-solid fa-location-dot" style="color: var(--primary);"></i> <?php echo SITE_ADDRESS; ?></p>
                <p><i class="fa-solid fa-warehouse" style="color: var(--primary);"></i> <?php echo SITE_WAREHOUSE; ?></p>
                <p><i class="fa-solid fa-phone" style="color: var(--primary);"></i> Hotline: <strong><?php echo SITE_HOTLINE; ?></strong></p>
                <p><i class="fa-solid fa-envelope" style="color: var(--primary);"></i> Email: <?php echo SITE_EMAIL; ?></p>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Thiết kế theo mô hình MVC trên Laragon.</p>
            </div>
        </div>
    </footer>

    <!-- CHATBOX WIDGET -->
    <div id="chatbox-toggle" onclick="toggleChatbox()" style="position: fixed; bottom: 24px; right: 24px; width: 56px; height: 56px; background: linear-gradient(135deg, #f36f21, #e85d04); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 20px rgba(243,111,33,0.45); z-index: 9999; transition: all 0.3s;">
        <i class="fa-solid fa-comments" id="chatbox-icon" style="color: #fff; font-size: 24px; transition: all 0.3s;"></i>
        <span id="chatbox-badge" style="display: none; position: absolute; top: -2px; right: -2px; background: #ef4444; color: #fff; font-size: 0.65rem; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: none; align-items: center; justify-content: center;">1</span>
    </div>

    <div id="chatbox-panel" style="display: none; position: fixed; bottom: 92px; right: 24px; width: 360px; max-width: calc(100vw - 32px); background: #fff; border-radius: 16px; box-shadow: 0 12px 40px rgba(0,0,0,0.18); z-index: 9999; overflow: hidden; animation: chatSlideUp 0.3s ease;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #f36f21, #e85d04); padding: 16px 20px; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-headset" style="color: #fff; font-size: 18px;"></i>
            </div>
            <div style="flex: 1;">
                <div style="color: #fff; font-weight: 700; font-size: 0.95rem;">Hỗ Trợ Tư Vấn</div>
                <div style="color: rgba(255,255,255,0.8); font-size: 0.75rem; display: flex; align-items: center; gap: 4px;">
                    <span style="width: 6px; height: 6px; background: #4ade80; border-radius: 50; display: inline-block;"></span> Online — Phản hồi trong 5 phút
                </div>
            </div>
            <div onclick="toggleChatbox()" style="cursor: pointer; color: rgba(255,255,255,0.8); font-size: 18px; padding: 4px;">
                <i class="fa-solid fa-xmark"></i>
            </div>
        </div>

        <!-- Messages -->
        <div id="chatbox-messages" style="height: 280px; overflow-y: auto; padding: 16px; background: #f8fafc;">
            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                <div style="width: 30px; height: 30px; background: linear-gradient(135deg, #f36f21, #e85d04); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fa-solid fa-trowel-bricks" style="color: #fff; font-size: 12px;"></i>
                </div>
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 0 12px 12px 12px; padding: 10px 14px; max-width: 80%; font-size: 0.85rem; color: #334155; line-height: 1.5;">
                    Xin chào! 👋 Chào mừng bạn đến với <strong>VLXD Hương Tiến</strong>.<br>
                    Bạn cần tư vấn về vật liệu xây dựng, báo giá hay vận chuyển? Hãy để lại tin nhắn, chúng tôi sẽ phản hồi sớm nhất!
                </div>
            </div>
        </div>

        <!-- Quick buttons -->
        <div id="chatbox-quick" style="padding: 8px 16px; border-top: 1px solid #e2e8f0; display: flex; gap: 6px; flex-wrap: wrap;">
            <button onclick="quickChat('Tôi cần báo giá vật liệu')" style="background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; border-radius: 16px; padding: 5px 12px; font-size: 0.78rem; font-weight: 600; cursor: pointer; font-family: inherit;">Báo giá vật liệu</button>
            <button onclick="quickChat('Tôi cần tư vấn vận chuyển')" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 16px; padding: 5px 12px; font-size: 0.78rem; font-weight: 600; cursor: pointer; font-family: inherit;">Tư vấn vận chuyển</button>
            <button onclick="quickChat('Tôi muốn hỏi về sản phẩm')" style="background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; border-radius: 16px; padding: 5px 12px; font-size: 0.78rem; font-weight: 600; cursor: pointer; font-family: inherit;">Hỏi về sản phẩm</button>
        </div>

        <!-- Input form -->
        <div style="padding: 12px 16px; border-top: 1px solid #e2e8f0; background: #fff;">
            <div id="chatbox-info" style="display: flex; gap: 8px; margin-bottom: 8px;">
                <input type="text" id="chat-name" placeholder="Họ tên *" style="flex: 1; padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.82rem; font-family: inherit; outline: none;" value="<?php echo !empty($_SESSION['customer_name']) ? htmlspecialchars($_SESSION['customer_name']) : ''; ?>">
                <input type="text" id="chat-phone" placeholder="SĐT *" style="width: 120px; padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.82rem; font-family: inherit; outline: none;">
            </div>
            <div style="display: flex; gap: 8px;">
                <input type="text" id="chat-message" placeholder="Nhập tin nhắn..." style="flex: 1; padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 24px; font-size: 0.88rem; font-family: inherit; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor='#f36f21'" onblur="this.style.borderColor='#e2e8f0'" onkeypress="if(event.key==='Enter')sendChat()">
                <button onclick="sendChat()" style="width: 42px; height: 42px; background: linear-gradient(135deg, #f36f21, #e85d04); border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.2s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform=''">
                    <i class="fa-solid fa-paper-plane" style="color: #fff; font-size: 16px;"></i>
                </button>
            </div>
        </div>
    </div>

    <style>
    @keyframes chatSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    #chatbox-messages::-webkit-scrollbar { width: 4px; }
    #chatbox-messages::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    @media (max-width: 480px) {
        #chatbox-panel { width: calc(100vw - 16px) !important; right: 8px !important; bottom: 80px !important; }
        #chatbox-toggle { bottom: 16px !important; right: 16px !important; width: 50px !important; height: 50px !important; }
    }
    </style>

    <script>
    var chatboxOpen = false;
    function toggleChatbox() {
        var panel = document.getElementById('chatbox-panel');
        var icon = document.getElementById('chatbox-icon');
        chatboxOpen = !chatboxOpen;
        panel.style.display = chatboxOpen ? 'block' : 'none';
        icon.className = chatboxOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-comments';
        if (chatboxOpen) {
            var msgs = document.getElementById('chatbox-messages');
            msgs.scrollTop = msgs.scrollHeight;
        }
    }

    function quickChat(text) {
        document.getElementById('chat-message').value = text;
        document.getElementById('chat-message').focus();
        document.getElementById('chatbox-quick').style.display = 'none';
    }

    function addMessage(text, isUser) {
        var msgs = document.getElementById('chatbox-messages');
        var div = document.createElement('div');
        div.style.cssText = 'display:flex;gap:8px;margin-bottom:12px;' + (isUser ? 'flex-direction:row-reverse;' : '');

        if (isUser) {
            div.innerHTML = '<div style="background:#f36f21;color:#fff;border-radius:12px 0 12px 12px;padding:10px 14px;max-width:80%;font-size:0.85rem;line-height:1.5;">' + escHtml(text) + '</div>';
        } else {
            div.innerHTML = '<div style="width:30px;height:30px;background:linear-gradient(135deg,#f36f21,#e85d04);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fa-solid fa-trowel-bricks" style="color:#fff;font-size:12px;"></i></div>'
                + '<div style="background:#fff;border:1px solid #e2e8f0;border-radius:0 12px 12px 12px;padding:10px 14px;max-width:80%;font-size:0.85rem;color:#334155;line-height:1.5;">' + text + '</div>';
        }
        msgs.appendChild(div);
        msgs.scrollTop = msgs.scrollHeight;
    }

    function escHtml(t) {
        var d = document.createElement('div');
        d.textContent = t;
        return d.innerHTML;
    }

    function sendChat() {
        var name = document.getElementById('chat-name').value.trim();
        var phone = document.getElementById('chat-phone').value.trim();
        var msg = document.getElementById('chat-message').value.trim();

        if (!name || !phone) {
            document.getElementById('chat-name').style.borderColor = name ? '#e2e8f0' : '#ef4444';
            document.getElementById('chat-phone').style.borderColor = phone ? '#e2e8f0' : '#ef4444';
            return;
        }
        if (!msg) return;

        addMessage(msg, true);
        document.getElementById('chat-message').value = '';
        document.getElementById('chatbox-quick').style.display = 'none';

        var info = document.getElementById('chatbox-info');
        if (info) info.style.display = 'none';

        var fd = new FormData();
        fd.append('name', name);
        fd.append('phone', phone);
        fd.append('subject', 'Chat từ website');
        fd.append('message', msg);

        fetch('<?php echo url("chat/send"); ?>', {
            method: 'POST',
            body: fd
        }).then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.ok) {
                addMessage('Cảm ơn bạn! Chúng tôi đã nhận được tin nhắn và sẽ phản hồi sớm nhất. Bạn cũng có thể gọi trực tiếp <strong><?php echo SITE_HOTLINE; ?></strong> để được tư vấn ngay.', false);
            } else {
                addMessage('Xin lỗi, có lỗi xảy ra. Vui lòng thử lại hoặc gọi <strong><?php echo SITE_HOTLINE; ?></strong>.', false);
            }
        }).catch(function() {
            addMessage('Không thể gửi tin nhắn. Vui lòng gọi <strong><?php echo SITE_HOTLINE; ?></strong> để được hỗ trợ.', false);
        });
    }
    </script>

    <script src="<?php echo asset('js/main.js'); ?>"></script>
</body>
</html>
