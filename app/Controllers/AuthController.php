<?php

require_once ROOT_PATH . '/app/Models/Customer.php';

class AuthController extends Controller
{
    public function login(): void
    {
        if ($this->isCustomerLoggedIn()) {
            $this->redirect('');
            return;
        }
        $this->view('auth/login', ['error' => '', 'old' => []], 'none');
    }

    public function handleLogin(): void
    {
        if ($this->isCustomerLoggedIn()) {
            $this->redirect('');
            return;
        }

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->view('auth/login', [
                'error' => 'Vui lòng nhập đầy đủ email và mật khẩu.',
                'old'   => ['email' => $email],
            ], 'none');
            return;
        }

        $customer = Customer::findByEmail($email);

        if ($customer && password_verify($password, $customer['password'])) {
            $_SESSION['customer_id']    = $customer['id'];
            $_SESSION['customer_name']  = $customer['fullname'];
            $_SESSION['customer_email'] = $customer['email'];
            $this->redirect('');
            return;
        }

        $this->view('auth/login', [
            'error' => 'Email hoặc mật khẩu không đúng.',
            'old'   => ['email' => $email],
        ], 'none');
    }

    public function register(): void
    {
        if ($this->isCustomerLoggedIn()) {
            $this->redirect('');
            return;
        }
        $this->view('auth/register', ['error' => '', 'old' => []], 'none');
    }

    public function handleRegister(): void
    {
        if ($this->isCustomerLoggedIn()) {
            $this->redirect('');
            return;
        }

        $fullname  = trim($_POST['fullname'] ?? '');
        $phone     = trim($_POST['phone'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';
        $password2 = $_POST['password_confirm'] ?? '';

        $old = compact('fullname', 'phone', 'email');

        if (empty($fullname) || empty($phone) || empty($email) || empty($password)) {
            $this->view('auth/register', [
                'error' => 'Vui lòng điền đầy đủ các trường bắt buộc.',
                'old' => $old,
            ], 'none');
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->view('auth/register', [
                'error' => 'Địa chỉ email không hợp lệ.',
                'old' => $old,
            ], 'none');
            return;
        }

        if (strlen($password) < 6) {
            $this->view('auth/register', [
                'error' => 'Mật khẩu phải có ít nhất 6 ký tự.',
                'old' => $old,
            ], 'none');
            return;
        }

        if ($password !== $password2) {
            $this->view('auth/register', [
                'error' => 'Xác nhận mật khẩu không khớp.',
                'old' => $old,
            ], 'none');
            return;
        }

        $existing = Customer::findByEmail($email);
        if ($existing) {
            $this->view('auth/register', [
                'error' => 'Email này đã được đăng ký. Vui lòng đăng nhập hoặc dùng email khác.',
                'old' => $old,
            ], 'none');
            return;
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $_SESSION['register_data'] = [
            'fullname' => $fullname,
            'phone'    => $phone,
            'email'    => $email,
            'password' => $password,
        ];
        $_SESSION['register_otp']     = $otp;
        $_SESSION['register_otp_exp'] = time() + 300;

        $this->sendOtpEmail($email, $fullname, $otp);

        $this->redirect('verify');
    }

    public function verify(): void
    {
        if ($this->isCustomerLoggedIn()) {
            $this->redirect('');
            return;
        }

        if (empty($_SESSION['register_data'])) {
            $this->redirect('register');
            return;
        }

        $this->view('auth/verify', [
            'error' => '',
            'email' => $_SESSION['register_data']['email'],
        ], 'none');
    }

    public function handleVerify(): void
    {
        if ($this->isCustomerLoggedIn()) {
            $this->redirect('');
            return;
        }

        if (empty($_SESSION['register_data']) || empty($_SESSION['register_otp'])) {
            $this->redirect('register');
            return;
        }

        $email = $_SESSION['register_data']['email'];
        $inputCode = trim($_POST['otp'] ?? '');

        if (empty($inputCode)) {
            $this->view('auth/verify', [
                'error' => 'Vui lòng nhập mã xác thực.',
                'email' => $email,
            ], 'none');
            return;
        }

        if (time() > ($_SESSION['register_otp_exp'] ?? 0)) {
            unset($_SESSION['register_data'], $_SESSION['register_otp'], $_SESSION['register_otp_exp']);
            $this->view('auth/verify', [
                'error' => 'Mã xác thực đã hết hạn. Vui lòng đăng ký lại.',
                'email' => $email,
            ], 'none');
            return;
        }

        if ($inputCode !== $_SESSION['register_otp']) {
            $this->view('auth/verify', [
                'error' => 'Mã xác thực không đúng. Vui lòng kiểm tra lại email.',
                'email' => $email,
            ], 'none');
            return;
        }

        $data = $_SESSION['register_data'];
        unset($_SESSION['register_data'], $_SESSION['register_otp'], $_SESSION['register_otp_exp']);

        try {
            $newId = Customer::create([
                'fullname' => $data['fullname'],
                'phone'    => $data['phone'],
                'email'    => $data['email'],
                'password' => $data['password'],
            ]);

            if ($newId > 0) {
                $_SESSION['customer_id']    = $newId;
                $_SESSION['customer_name']  = $data['fullname'];
                $_SESSION['customer_email'] = $data['email'];
                $this->redirect('');
                return;
            }

            $this->redirect('register');
        } catch (Exception $e) {
            $this->redirect('register');
        }
    }

    public function resendOtp(): void
    {
        if (empty($_SESSION['register_data'])) {
            $this->redirect('register');
            return;
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $_SESSION['register_otp']     = $otp;
        $_SESSION['register_otp_exp'] = time() + 300;

        $data = $_SESSION['register_data'];
        $this->sendOtpEmail($data['email'], $data['fullname'], $otp);

        $this->view('auth/verify', [
            'error' => '',
            'success' => 'Đã gửi lại mã xác thực. Vui lòng kiểm tra email.',
            'email' => $data['email'],
        ], 'none');
    }

    public function logout(): void
    {
        unset($_SESSION['customer_id'], $_SESSION['customer_name'], $_SESSION['customer_email']);
        $this->redirect('login');
    }

    private function isCustomerLoggedIn(): bool
    {
        return !empty($_SESSION['customer_id']);
    }

    private function sendOtpEmail(string $toEmail, string $toName, string $otp): bool
    {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USERNAME;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(SMTP_USERNAME, SMTP_FROM_NAME);
            $mail->addAddress($toEmail, $toName);

            $mail->isHTML(true);
            $mail->Subject = '[' . SITE_NAME . '] Mã xác thực đăng ký: ' . $otp;
            $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width: 480px; margin: 0 auto; padding: 30px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;'>
                <div style='text-align: center; margin-bottom: 24px;'>
                    <div style='width: 56px; height: 56px; background: linear-gradient(135deg, #f36f21, #e85d04); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center;'>
                        <span style='font-size: 24px; color: #fff;'>&#x1F3D7;</span>
                    </div>
                    <h2 style='color: #0f172a; margin: 12px 0 4px;'>Xác thực Email</h2>
                    <p style='color: #64748b; font-size: 14px;'>" . SITE_NAME . "</p>
                </div>
                <p style='color: #334155; font-size: 15px;'>Xin chào <strong>" . htmlspecialchars($toName) . "</strong>,</p>
                <p style='color: #334155; font-size: 15px;'>Mã xác thực của bạn là:</p>
                <div style='text-align: center; margin: 24px 0;'>
                    <span style='display: inline-block; background: #f8fafc; border: 2px solid #f36f21; border-radius: 10px; padding: 16px 32px; font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #f36f21;'>$otp</span>
                </div>
                <p style='color: #64748b; font-size: 13px; text-align: center;'>Mã này có hiệu lực trong <strong>5 phút</strong>. Vui lòng không chia sẻ mã này với bất kỳ ai.</p>
                <hr style='border: none; border-top: 1px solid #e2e8f0; margin: 24px 0;'>
                <p style='color: #94a3b8; font-size: 12px; text-align: center;'>Nếu bạn không yêu cầu đăng ký, vui lòng bỏ qua email này.</p>
            </div>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
