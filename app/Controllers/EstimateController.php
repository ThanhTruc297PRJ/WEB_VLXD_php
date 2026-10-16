<?php

class EstimateController extends Controller
{
    public function index(): void
    {
        $this->view('estimate/index', [
            'page_title' => 'Công Cụ Dự Toán Vật Tư Xây Nhà Tự Động',
        ]);
    }
}
