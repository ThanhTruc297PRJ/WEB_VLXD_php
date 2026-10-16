<?php $currentQuery = http_build_query(array_filter(['filter' => $filter, 'search' => $search])); ?>

<header class="admin-header">
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a;"><i class="fa-solid fa-envelope" style="color: var(--primary);"></i> Quản Lý Liên Hệ</h2>
        <p style="font-size: 0.82rem; color: #64748b;">Tin nhắn từ khách hàng qua form liên hệ</p>
    </div>
    <?php if ($unread_count > 0): ?>
        <div style="background: #fee2e2; color: #ef4444; padding: 8px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">
            <i class="fa-solid fa-bell"></i> <?php echo $unread_count; ?> tin chưa đọc
        </div>
    <?php endif; ?>
</header>

<div class="admin-body">
    <!-- TABS -->
    <div style="display: flex; gap: 8px; margin-bottom: 18px; flex-wrap: wrap;">
        <a href="<?php echo url('admin/contacts'); ?>" style="padding: 8px 16px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; border: 2px solid <?php echo $filter === '' ? 'var(--primary)' : '#e2e8f0'; ?>; background: <?php echo $filter === '' ? 'rgba(243,111,33,0.08)' : '#fff'; ?>; color: <?php echo $filter === '' ? 'var(--primary)' : '#64748b'; ?>;">
            <i class="fa-solid fa-inbox"></i> Tất cả <span style="background: #f1f5f9; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; margin-left: 4px;"><?php echo $total_rows; ?></span>
        </a>
        <a href="<?php echo url('admin/contacts?filter=unread'); ?>" style="padding: 8px 16px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; border: 2px solid <?php echo $filter === 'unread' ? '#ef4444' : '#e2e8f0'; ?>; background: <?php echo $filter === 'unread' ? '#fee2e2' : '#fff'; ?>; color: <?php echo $filter === 'unread' ? '#ef4444' : '#64748b'; ?>;">
            <i class="fa-solid fa-envelope"></i> Chưa đọc <span style="background: #fee2e2; color: #ef4444; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; margin-left: 4px;"><?php echo $unread_count; ?></span>
        </a>
        <a href="<?php echo url('admin/contacts?filter=read'); ?>" style="padding: 8px 16px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; border: 2px solid <?php echo $filter === 'read' ? '#10b981' : '#e2e8f0'; ?>; background: <?php echo $filter === 'read' ? '#d1fae5' : '#fff'; ?>; color: <?php echo $filter === 'read' ? '#10b981' : '#64748b'; ?>;">
            <i class="fa-solid fa-envelope-open"></i> Đã đọc
        </a>
    </div>

    <!-- TÌM KIẾM -->
    <div style="background: #fff; border-radius: 12px; padding: 14px 18px; margin-bottom: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
        <form action="<?php echo url('admin/contacts'); ?>" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <?php if ($filter): ?><input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>"><?php endif; ?>
            <div style="flex: 1; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm theo tên, SĐT hoặc chủ đề..."
                    style="width: 100%; padding: 10px 10px 10px 36px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; font-family: inherit; box-sizing: border-box;">
            </div>
            <button type="submit" style="padding: 10px 20px; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; font-family: inherit;">Tìm</button>
        </form>
    </div>

    <!-- DANH SÁCH -->
    <div style="background: #fff; border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <?php if (empty($contacts)): ?>
            <div style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                <i class="fa-solid fa-envelope-open" style="font-size: 2.5rem; margin-bottom: 10px; display: block;"></i>
                <p style="font-size: 0.95rem; font-weight: 600;">Không có tin nhắn nào</p>
            </div>
        <?php else: ?>
            <?php foreach ($contacts as $c): ?>
                <div style="border-bottom: 1px solid #f1f5f9; <?php echo !$c['is_read'] ? 'background: #fffbeb;' : ''; ?>">
                    <div onclick="toggleMsg(<?php echo $c['id']; ?>)" style="padding: 16px 20px; cursor: pointer; display: flex; align-items: center; gap: 14px; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='<?php echo !$c['is_read'] ? '#fffbeb' : ''; ?>'">
                        <?php if (!$c['is_read']): ?>
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444; flex-shrink: 0;"></span>
                        <?php else: ?>
                            <span style="width: 10px; height: 10px; flex-shrink: 0;"></span>
                        <?php endif; ?>
                        <i class="fa-solid fa-chevron-right" id="arrow-<?php echo $c['id']; ?>" style="color: #cbd5e1; font-size: 0.8rem; transition: transform 0.2s;"></i>
                        <div style="flex: 1; display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                            <div style="min-width: 140px;">
                                <div style="font-weight: 700; color: #1e293b; font-size: 0.88rem;"><?php echo htmlspecialchars($c['name']); ?></div>
                                <div style="font-size: 0.78rem; color: #64748b;"><i class="fa-solid fa-phone" style="font-size: 0.7rem;"></i> <?php echo htmlspecialchars($c['phone']); ?></div>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #334155; font-size: 0.85rem;"><?php echo htmlspecialchars($c['subject']); ?></div>
                                <div style="font-size: 0.78rem; color: #94a3b8; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 400px;"><?php echo htmlspecialchars(mb_substr($c['message'], 0, 80)); ?>...</div>
                            </div>
                            <div style="font-size: 0.78rem; color: #94a3b8; white-space: nowrap;"><?php echo date('d/m/Y H:i', strtotime($c['created_at'])); ?></div>
                        </div>
                    </div>

                    <div id="msg-<?php echo $c['id']; ?>" style="display: none; background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 18px 20px 18px 56px;">
                        <div style="background: #fff; border-radius: 10px; padding: 16px; border: 1px solid #e2e8f0; margin-bottom: 14px;">
                            <div style="font-weight: 700; color: #334155; font-size: 0.88rem; margin-bottom: 8px;">
                                <i class="fa-solid fa-message" style="color: var(--primary);"></i> <?php echo htmlspecialchars($c['subject']); ?>
                            </div>
                            <p style="font-size: 0.85rem; color: #475569; line-height: 1.7; white-space: pre-wrap; margin: 0;"><?php echo htmlspecialchars($c['message']); ?></p>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <?php if (!$c['is_read']): ?>
                                <a href="<?php echo url('admin/contacts/mark-read?id=' . $c['id'] . '&redirect=' . urlencode($currentQuery)); ?>" style="padding: 6px 14px; background: #d1fae5; color: #10b981; border-radius: 6px; font-size: 0.8rem; font-weight: 700; text-decoration: none;">
                                    <i class="fa-solid fa-check"></i> Đánh dấu đã đọc
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo url('admin/contacts/delete?id=' . $c['id'] . '&redirect=' . urlencode($currentQuery)); ?>" onclick="return confirm('Xóa tin nhắn này?')" style="padding: 6px 14px; background: #fee2e2; color: #ef4444; border-radius: 6px; font-size: 0.8rem; font-weight: 700; text-decoration: none;">
                                <i class="fa-solid fa-trash"></i> Xóa
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- PHÂN TRANG -->
    <?php if ($total_pages > 1): ?>
        <div style="display: flex; justify-content: center; gap: 6px; margin-top: 20px;">
            <?php for ($p = max(1, $page - 2); $p <= min($total_pages, $page + 2); $p++): ?>
                <a href="<?php echo url('admin/contacts?' . http_build_query(array_filter(['filter' => $filter, 'search' => $search, 'page' => $p]))); ?>"
                   style="padding: 8px 14px; border-radius: 8px; border: 2px solid <?php echo $p === $page ? 'var(--primary)' : '#e2e8f0'; ?>; background: <?php echo $p === $page ? 'var(--primary)' : '#fff'; ?>; color: <?php echo $p === $page ? '#fff' : '#475569'; ?>; text-decoration: none; font-size: 0.85rem; font-weight: 700;">
                    <?php echo $p; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function toggleMsg(id) {
    var d = document.getElementById('msg-' + id);
    var a = document.getElementById('arrow-' + id);
    if (d.style.display === 'none') { d.style.display = ''; a.style.transform = 'rotate(90deg)'; }
    else { d.style.display = 'none'; a.style.transform = 'rotate(0deg)'; }
}
</script>
