<?php

class SettingController extends Controller
{
    private array $allowedStoreFields = [
        'SITE_NAME', 'SITE_SLOGAN', 'SITE_HOTLINE', 'SITE_EMAIL', 'SITE_ADDRESS', 'SITE_WAREHOUSE',
    ];

    private array $allowedBankFields = [
        'BANK_ID', 'BANK_ACCOUNT_NO', 'BANK_ACCOUNT_NAME',
    ];

    public function index(): void
    {
        if (!$this->requireAdmin()) return;

        $this->view('admin/settings', [
            'page_title' => 'Cài Đặt Hệ Thống',
            'success'    => $_GET['success'] ?? '',
        ], 'admin');
    }

    public function updateStore(): void
    {
        if (!$this->requireAdmin()) return;

        $fields = [
            'SITE_NAME'      => $_POST['site_name'] ?? '',
            'SITE_SLOGAN'    => $_POST['site_slogan'] ?? '',
            'SITE_HOTLINE'   => $_POST['site_hotline'] ?? '',
            'SITE_EMAIL'     => $_POST['site_email'] ?? '',
            'SITE_ADDRESS'   => $_POST['site_address'] ?? '',
            'SITE_WAREHOUSE' => $_POST['site_warehouse'] ?? '',
        ];

        $this->updateDefines($fields, $this->allowedStoreFields);
        header('Location: ' . url('admin/settings?success=store'));
        exit;
    }

    public function updateBank(): void
    {
        if (!$this->requireAdmin()) return;

        $fields = [
            'BANK_ID'           => $_POST['bank_id'] ?? '',
            'BANK_ACCOUNT_NO'   => $_POST['bank_account_no'] ?? '',
            'BANK_ACCOUNT_NAME' => $_POST['bank_account_name'] ?? '',
        ];

        $this->updateDefines($fields, $this->allowedBankFields);
        header('Location: ' . url('admin/settings?success=bank'));
        exit;
    }

    public function updateShipping(): void
    {
        if (!$this->requireAdmin()) return;

        $appFile = ROOT_PATH . '/config/app.php';
        $content = file_get_contents($appFile);

        $vehicles = $_POST['vehicle'] ?? [];
        $bases    = $_POST['base'] ?? [];
        $freeKms  = $_POST['free_km'] ?? [];
        $perKms   = $_POST['per_km'] ?? [];

        $ratesCode = "const SHIPPING_RATES = [\n";
        for ($i = 0; $i < count($vehicles); $i++) {
            $v = preg_replace('/[^a-zA-ZÀ-ỹ0-9\s.,]/', '', $vehicles[$i]);
            $b = abs((int)($bases[$i] ?? 0));
            $f = abs((int)($freeKms[$i] ?? 0));
            $p = abs((int)($perKms[$i] ?? 0));
            if (empty($v)) continue;
            $ratesCode .= "    '" . addslashes($v) . "' => ['base' => $b, 'free_km' => $f, 'per_km' => $p],\n";
        }
        $ratesCode .= "];";

        $content = preg_replace(
            '/const SHIPPING_RATES = \[.*?\];/s',
            $ratesCode,
            $content
        );

        file_put_contents($appFile, $content);
        header('Location: ' . url('admin/settings?success=shipping'));
        exit;
    }

    private function updateDefines(array $fields, array $allowedKeys): void
    {
        $appFile = ROOT_PATH . '/config/app.php';
        $content = file_get_contents($appFile);

        foreach ($fields as $key => $value) {
            if (!in_array($key, $allowedKeys, true)) continue;

            $value = strip_tags($value);
            $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $value);
            $value = addslashes($value);

            $content = preg_replace(
                "/define\(\s*'" . preg_quote($key, '/') . "'\s*,\s*'[^']*'\s*\)/",
                "define('" . $key . "', '" . $value . "')",
                $content
            );
        }

        file_put_contents($appFile, $content);
    }
}
