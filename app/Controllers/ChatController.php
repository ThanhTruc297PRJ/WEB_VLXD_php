<?php

require_once ROOT_PATH . '/app/Models/Contact.php';

class ChatController extends Controller
{
    public function send(): void
    {
        $name    = trim($_POST['name'] ?? '');
        $phone   = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? 'Chat từ website');
        $message = trim($_POST['message'] ?? '');

        if (empty($name) || empty($phone) || empty($message)) {
            $this->json(['ok' => false, 'error' => 'Thiếu thông tin']);
            return;
        }

        $saved = Contact::create([
            'name'    => $name,
            'phone'   => $phone,
            'subject' => $subject,
            'message' => $message,
        ]);

        $this->json(['ok' => $saved]);
    }
}
