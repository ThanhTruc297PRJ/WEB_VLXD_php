<!-- Admin Products - Main Content (wrapped by admin layout) -->
<header class="admin-header">
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a;">Quản Lý Sản Phẩm Vật Liệu Xây Dựng</h2>
        <p style="font-size: 0.82rem; color: #64748b;">Xem danh mục, cập nhật đơn giá xuất xưởng và thêm mới vật tư vào kho</p>
    </div>
    <button onclick="document.getElementById('add-modal').style.display='block'" style="padding: 10px 18px; font-size: 0.85rem; cursor: pointer; border: none; background: var(--primary); color: white; border-radius: 6px; font-weight: 700;">
        <i class="fa-solid fa-plus"></i> Thêm Vật Liệu Mới
    </button>
</header>

<div class="admin-body">
    <?php if (!empty($message)): ?>
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- BẢNG DANH SÁCH SẢN PHẨM -->
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Hình ảnh</th>
                    <th>Tên Vật Liệu</th>
                    <th>Mã SKU</th>
                    <th>Đơn Vị Tính</th>
                    <th>Giá Xuất Kho</th>
                    <th>Thương Hiệu</th>
                    <th>Quy Cách</th>
                    <th style="text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; color: #94a3b8; padding: 25px;">Chưa có sản phẩm nào trong kho</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td>
                                <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" style="width: 48px; height: 48px; object-fit: cover; border-radius: 6px;" onerror="this.onerror=null;this.src='<?php echo asset('images/no-image.svg'); ?>'">
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($p['name']); ?></strong>
                                <?php if (!empty($p['is_featured'])): ?>
                                    <span class="badge badge-warning" style="margin-left: 6px;">Bán chạy</span>
                                <?php endif; ?>
                            </td>
                            <td><code><?php echo htmlspecialchars($p['sku'] ?? 'N/A'); ?></code></td>
                            <td><span class="badge badge-info"><?php echo htmlspecialchars($p['unit']); ?></span></td>
                            <td><strong style="color: #e11d48;"><?php echo formatCurrency($p['price'], $p['price_negotiable'] ?? 0); ?></strong></td>
                            <td><?php echo htmlspecialchars($p['brand'] ?? 'Chính hãng'); ?></td>
                            <td style="font-size: 0.8rem; color: #64748b;"><?php echo htmlspecialchars($p['specification'] ?? ''); ?></td>
                            <td style="text-align: center; white-space: nowrap;">
                                <button type="button" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($p, JSON_HEX_APOS | JSON_HEX_QUOT)); ?>)" style="background: none; border: none; color: #f59e0b; cursor: pointer; font-size: 1rem; padding: 4px 6px;" title="Sửa">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <a href="<?php echo url('product/' . $p['id']); ?>" target="_blank" style="color: #2563eb; padding: 4px 6px;" title="Xem">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="<?php echo url('admin/products/delete/' . $p['id']); ?>" onclick="return confirm('Bạn có chắc muốn xóa vật liệu này khỏi danh mục?');" style="color: #ef4444; padding: 4px 6px;" title="Xóa">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- MODAL / FORM THÊM SẢN PHẨM MỚI -->
    <div id="add-modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; overflow-y: auto; padding: 40px 20px;">
        <div style="background: #fff; max-width: 650px; margin: 0 auto; border-radius: 12px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a;">Thêm Mới Vật Liệu Vào Kho</h3>
                <button onclick="document.getElementById('add-modal').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
            </div>

            <form action="<?php echo url('admin/products'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_product">

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Tên vật liệu xây dựng: *</label>
                    <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;" placeholder="Ví dụ: Thép cây D12 Việt Nhật CB300">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Danh mục nhóm:</label>
                        <select name="category_id" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            <?php foreach ($categories as $c): ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Đơn vị tính (ĐVT): *</label>
                        <select name="unit" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            <option value="Bao">Bao (50kg)</option>
                            <option value="Tấn">Tấn</option>
                            <option value="m3">m3 (Khối cát/đá)</option>
                            <option value="Cây">Cây (Thép 11.7m)</option>
                            <option value="Viên">Viên (Gạch)</option>
                            <option value="Thùng">Thùng / Lon</option>
                            <option value="m2">m2 (Tôn, gạch lát)</option>
                            <option value="Kg">Kg</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Đơn giá (VNĐ):</label>
                        <input type="number" name="price" value="0" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Thương hiệu / Xuất xứ:</label>
                        <input type="text" name="brand" placeholder="Hòa Phát, Hà Tiên, Insee..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Quy cách kỹ thuật:</label>
                    <input type="text" name="specification" placeholder="Ví dụ: Đường kính 12mm, chuẩn TCVN 1651-2:2018" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Ảnh đại diện sản phẩm:</label>
                    <input type="file" name="image_file" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc;">
                    <p style="font-size: 0.78rem; color: #94a3b8; margin-top: 4px;">Ảnh chính hiển thị ở danh sách. Để trống sẽ dùng ảnh mặc định.</p>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Thư viện ảnh sản phẩm (nhiều ảnh):</label>
                    <input type="file" name="gallery_files[]" accept="image/*" multiple style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc;">
                    <p style="font-size: 0.78rem; color: #94a3b8; margin-top: 4px;">Chọn nhiều ảnh cùng lúc (Ctrl+Click). JPG, PNG, WEBP. Tối đa 5MB/ảnh.</p>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Mô tả sản phẩm & ứng dụng công trình:</label>
                    <textarea name="description" rows="3" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;" placeholder="Mô tả cường độ chịu lực, ứng dụng thi công..."></textarea>
                </div>

                <div style="display: flex; gap: 20px; margin-bottom: 25px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; cursor: pointer;">
                        <input type="checkbox" name="is_featured" value="1">
                        <span>Đặt làm sản phẩm bán chạy / nổi bật</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; cursor: pointer;">
                        <input type="checkbox" name="price_negotiable" value="1">
                        <span>Giá liên hệ theo khối lượng</span>
                    </label>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="document.getElementById('add-modal').style.display='none'" style="padding: 10px 20px; border: 1px solid #cbd5e1; background: #fff; border-radius: 6px; cursor: pointer;">Hủy bỏ</button>
                    <button type="submit" style="padding: 10px 24px; background: var(--primary); color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">Lưu Vào Kho</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CHỈNH SỬA SẢN PHẨM -->
    <div id="edit-modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; overflow-y: auto; padding: 40px 20px;">
        <div style="background: #fff; max-width: 650px; margin: 0 auto; border-radius: 12px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a;">Chỉnh Sửa Sản Phẩm</h3>
                <button onclick="document.getElementById('edit-modal').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
            </div>

            <form action="<?php echo url('admin/products'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_product">
                <input type="hidden" name="product_id" id="edit-id">

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Tên vật liệu: *</label>
                    <input type="text" name="name" id="edit-name" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Danh mục:</label>
                        <select name="category_id" id="edit-category" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            <?php foreach ($categories as $c): ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Đơn vị tính: *</label>
                        <select name="unit" id="edit-unit" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            <option value="Bao">Bao (50kg)</option>
                            <option value="Tấn">Tấn</option>
                            <option value="m3">m3 (Khối cát/đá)</option>
                            <option value="Cây">Cây (Thép 11.7m)</option>
                            <option value="Viên">Viên (Gạch)</option>
                            <option value="Thùng">Thùng / Lon</option>
                            <option value="m2">m2 (Tôn, gạch lát)</option>
                            <option value="Kg">Kg</option>
                            <option value="Can">Can</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Đơn giá (VNĐ):</label>
                        <input type="number" name="price" id="edit-price" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Thương hiệu:</label>
                        <input type="text" name="brand" id="edit-brand" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Quy cách kỹ thuật:</label>
                    <input type="text" name="specification" id="edit-spec" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Ảnh đại diện:</label>
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 8px;">
                        <img id="edit-preview" src="" alt="Preview" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #cbd5e1;">
                        <span style="font-size: 0.82rem; color: #64748b;">Ảnh chính hiện tại</span>
                    </div>
                    <input type="file" name="image_file" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc;">
                    <p style="font-size: 0.78rem; color: #94a3b8; margin-top: 4px;">Chọn ảnh mới để thay ảnh đại diện. Để trống giữ ảnh cũ.</p>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Thư viện ảnh đã có:</label>
                    <div id="edit-gallery" style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 8px;"></div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Thêm ảnh vào thư viện:</label>
                    <input type="file" name="gallery_files[]" accept="image/*" multiple style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc;">
                    <p style="font-size: 0.78rem; color: #94a3b8; margin-top: 4px;">Chọn nhiều ảnh (Ctrl+Click). Ảnh cũ được giữ nguyên, ảnh mới thêm vào.</p>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 5px;">Mô tả sản phẩm:</label>
                    <textarea name="description" id="edit-desc" rows="3" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;"></textarea>
                </div>

                <div style="display: flex; gap: 20px; margin-bottom: 25px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; cursor: pointer;">
                        <input type="checkbox" name="is_featured" value="1" id="edit-featured">
                        <span>Sản phẩm bán chạy / nổi bật</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; cursor: pointer;">
                        <input type="checkbox" name="price_negotiable" value="1" id="edit-negotiable">
                        <span>Giá liên hệ theo khối lượng</span>
                    </label>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="document.getElementById('edit-modal').style.display='none'" style="padding: 10px 20px; border: 1px solid #cbd5e1; background: #fff; border-radius: 6px; cursor: pointer;">Hủy bỏ</button>
                    <button type="submit" style="padding: 10px 24px; background: #2563eb; color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;"><i class="fa-solid fa-floppy-disk"></i> Lưu Thay Đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var productGallery = <?php
    $galleryMap = [];
    if (!empty($products)) {
        require_once ROOT_PATH . '/app/Models/ProductImage.php';
        foreach ($products as $p) {
            $galleryMap[$p['id']] = ProductImage::getByProductId($p['id']);
        }
    }
    echo json_encode($galleryMap, JSON_HEX_APOS | JSON_HEX_QUOT);
?>;

function openEditModal(product) {
    document.getElementById('edit-id').value = product.id;
    document.getElementById('edit-name').value = product.name || '';
    document.getElementById('edit-category').value = product.category_id || 1;
    document.getElementById('edit-unit').value = product.unit || 'Bao';
    document.getElementById('edit-price').value = product.price || 0;
    document.getElementById('edit-brand').value = product.brand || '';
    document.getElementById('edit-spec').value = product.specification || '';
    document.getElementById('edit-desc').value = product.description || '';
    document.getElementById('edit-featured').checked = product.is_featured == 1;
    document.getElementById('edit-negotiable').checked = product.price_negotiable == 1;

    var preview = document.getElementById('edit-preview');
    var noImg = '<?php echo asset("images/no-image.svg"); ?>';
    preview.src = product.image || noImg;
    preview.onerror = function() { this.src = noImg; };

    var galleryDiv = document.getElementById('edit-gallery');
    galleryDiv.innerHTML = '';
    var images = productGallery[product.id] || [];
    if (images.length === 0) {
        galleryDiv.innerHTML = '<span style="font-size:0.82rem;color:#94a3b8;">Chưa có ảnh trong thư viện</span>';
    } else {
        images.forEach(function(img) {
            var wrap = document.createElement('div');
            wrap.style.cssText = 'position:relative;display:inline-block;';
            wrap.innerHTML = '<img src="' + img.image_path + '" style="width:70px;height:70px;object-fit:cover;border-radius:6px;border:1px solid #cbd5e1;" onerror="this.src=\'' + noImg + '\'">'
                + '<a href="<?php echo url("admin/products/delete-image/"); ?>' + img.id + '" onclick="return confirm(\'Xóa ảnh này?\')" style="position:absolute;top:-6px;right:-6px;background:#ef4444;color:#fff;border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;font-size:11px;text-decoration:none;font-weight:700;">&times;</a>';
            galleryDiv.appendChild(wrap);
        });
    }

    document.getElementById('edit-modal').style.display = 'block';
}
</script>
