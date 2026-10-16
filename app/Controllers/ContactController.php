<?php

require_once ROOT_PATH . '/app/Models/Contact.php';

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
        $name    = trim($_POST['name'] ?? '');
        $phone   = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        $saved = false;
        if ($name && $phone && $subject && $message) {
            $saved = Contact::create([
                'name' => $name, 'phone' => $phone,
                'subject' => $subject, 'message' => $message,
            ]);
        }

        $this->view('contact/index', [
            'page_title' => 'Liên Hệ & Hệ Thống Kho Bãi Vật Liệu',
            'sent'       => $saved,
        ]);
    }
}
