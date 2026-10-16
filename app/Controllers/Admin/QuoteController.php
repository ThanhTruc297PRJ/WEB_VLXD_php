<?php

require_once ROOT_PATH . '/app/Models/Quote.php';

class QuoteController extends Controller
{
    public function index(): void
    {
        if (!$this->requireAdmin()) return;

        $this->view('admin/quotes', [
            'page_title' => 'Quản Lý Báo Giá Vật Tư Công Trình',
            'quotes'     => Quote::all(),
            'message'    => '',
        ], 'admin');
    }

    public function updateStatus(): void
    {
        if (!$this->requireAdmin()) return;

        $quote_id   = (int)$_POST['quote_id'];
        $new_status = cleanInput($_POST['status']);

        Quote::updateStatus($quote_id, $new_status);

        $db = Database::getInstance();
        $message = $db->isConnected()
            ? 'Đã cập nhật trạng thái báo giá thành công!'
            : "Chế độ demo: Đã mô phỏng cập nhật trạng thái sang '$new_status'.";

        $this->view('admin/quotes', [
            'page_title' => 'Quản Lý Báo Giá Vật Tư Công Trình',
            'quotes'     => Quote::all(),
            'message'    => $message,
        ], 'admin');
    }
}
