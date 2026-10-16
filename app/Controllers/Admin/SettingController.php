<?php

class SettingController extends Controller
{
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

        $appFile = ROOT_PATH . '/config/app.php';
        $content = file_get_contents($appFile);

        $fields = [
            'SITE_NAME'      => $_POST['site_name'] ?? '',
            'SITE_SLOGAN'    => $_POST['site_slogan'] ?? '',
            'SITE_HOTLINE'   => $_POST['site_hotline'] ?? '',
            'SITE_EMAIL'     => $_POST['site_email'] ?? '',
            'SITE_ADDRESS'   => $_POST['site_address'] ?? '',
            'SITE_WAREHOUSE' => $_POST['site_warehouse'] ?? '',
        ];

        foreach ($fields as $key => $value) {
            $value = str_replace("'", "\\'", $value);
            $content = preg_replace(
                "/define\(\s*'" . $key . "'\s*,\s*'[^']*'\s*\)/",
                "define('" . $key . "', '" . $value . "')",
                $content
            );
        }

        file_put_contents($appFile, $content);
        header('Location: ' . url('admin/settings?success=store'));
        exit;
    }

    public function updateBank(): void
    {
        if (!$this->requireAdmin()) return;

        $appFile = ROOT_PATH . '/config/app.php';
        $content = file_get_contents($appFile);

        $fields = [
            'BANK_ID'           => $_POST['bank_id'] ?? '',
            'BANK_ACCOUNT_NO'   => $_POST['bank_account_no'] ?? '',
            'BANK_ACCOUNT_NAME' => $_POST['bank_account_name'] ?? '',
        ];

        foreach ($fields as $key => $value) {
            $value = str_replace("'", "\\'", $value);
            $content = preg_replace(
                "/define\(\s*'" . $key . "'\s*,\s*'[^']*'\s*\)/",
                "define('" . $key . "', '" . $value . "')",
                $content
            );
        }

        file_put_contents($appFile, $content);
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
            $v = str_replace("'", "\\'", $vehicles[$i]);
            $b = (int)$bases[$i];
            $f = (int)$freeKms[$i];
            $p = (int)$perKms[$i];
            $ratesCode .= "    '$v' => ['base' => $b, 'free_km' => $f, 'per_km' => $p],\n";
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
}
