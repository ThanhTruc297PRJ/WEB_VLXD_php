<?php

require_once ROOT_PATH . '/app/Models/Quote.php';

class QuoteController extends Controller
{
    public function index(): void
    {
        $this->view('quote/index', [
            'page_title'      => 'Yêu Cầu Báo Giá Vật Liệu Xây Dựng Số Lượng Lớn',
            'quote_submitted' => false,
            'error'           => '',
        ]);
    }

    public function submit(): void
    {
        $fullname        = cleanInput($_POST['fullname'] ?? '');
        $phone           = cleanInput($_POST['phone'] ?? '');
        $email           = cleanInput($_POST['email'] ?? '');
        $project_address = cleanInput($_POST['project_address'] ?? '');
        $project_type    = cleanInput($_POST['project_type'] ?? 'Nhà ở dân dụng');
        $delivery_date   = cleanInput($_POST['delivery_date'] ?? date('Y-m-d'));
        $material_notes  = cleanInput($_POST['material_notes'] ?? '');

        if (empty($fullname) || empty($phone) || empty($project_address) || empty($material_notes)) {
            $this->view('quote/index', [
                'page_title'      => 'Yêu Cầu Báo Giá Vật Liệu Xây Dựng Số Lượng Lớn',
                'quote_submitted' => false,
                'error'           => 'Vui lòng điền đầy đủ các thông tin bắt buộc (*).',
            ]);
            return;
        }

        Quote::store([
            'fullname'        => $fullname,
            'phone'           => $phone,
            'email'           => $email,
            'project_address' => $project_address,
            'project_type'    => $project_type,
            'delivery_date'   => $delivery_date,
            'material_notes'  => $material_notes,
        ]);

        $this->view('quote/index', [
            'page_title'      => 'Yêu Cầu Báo Giá Vật Liệu Xây Dựng Số Lượng Lớn',
            'quote_submitted' => true,
            'error'           => '',
        ]);
    }
}
