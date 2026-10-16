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
        $name    = trim($_POST['name'] ?? '');
        $phone   = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        $saved = false;
        if ($name && $phone && $subject && $message) {
            $db = Database::getInstance();
            if ($db->isConnected()) {
                try {
                    $stmt = $db->getConnection()->prepare(
                        "INSERT INTO contacts (name, phone, subject, message) VALUES (?, ?, ?, ?)"
                    );
                    $stmt->execute([$name, $phone, $subject, $message]);
                    $saved = true;
                } catch (Exception $e) {}
            }
        }

        $this->view('contact/index', [
            'page_title' => 'Liên Hệ & Hệ Thống Kho Bãi Vật Liệu',
            'sent'       => $saved,
        ]);
    }
}
