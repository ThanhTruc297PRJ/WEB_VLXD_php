<?php

class ContactController extends Controller
{
    public function index(): void
    {
        $this->view('contact/index', [
            'page_title' => 'Liên Hệ & Hệ Thống Kho Bãi Vật Liệu',
            'sent'       => false,
        ]);
    }

    public function send(): void
    {
        $this->view('contact/index', [
            'page_title' => 'Liên Hệ & Hệ Thống Kho Bãi Vật Liệu',
            'sent'       => true,
        ]);
    }
}
