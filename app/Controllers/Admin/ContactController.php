<?php

require_once ROOT_PATH . '/app/Models/Contact.php';

class ContactController extends Controller
{
    public function index(): void
    {
        if (!$this->requireAdmin()) return;

        $db = Database::getInstance();
        $pdo = $db->isConnected() ? $db->getConnection() : null;

        $filter = $_GET['filter'] ?? '';
        $search = trim($_GET['search'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;

        $contacts = [];
        $totalRows = 0;
        $totalPages = 1;
        $unreadCount = 0;

        if ($pdo) {
            try {
                $unreadCount = (int)$pdo->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();

                $where = "1=1";
                $params = [];
                if ($filter === 'unread') {
                    $where .= " AND is_read = 0";
                } elseif ($filter === 'read') {
                    $where .= " AND is_read = 1";
                }
                if ($search !== '') {
                    $where .= " AND (name LIKE ? OR phone LIKE ? OR subject LIKE ?)";
                    $like = "%$search%";
                    $params = array_merge($params, [$like, $like, $like]);
                }

                $stmt = $pdo->prepare("SELECT COUNT(*) FROM contacts WHERE $where");
                $stmt->execute($params);
                $totalRows = (int)$stmt->fetchColumn();
                $totalPages = max(1, ceil($totalRows / $perPage));
                $page = min($page, $totalPages);
                $offset = ($page - 1) * $perPage;

                $stmt = $pdo->prepare("SELECT * FROM contacts WHERE $where ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
                $stmt->execute($params);
                $contacts = $stmt->fetchAll();
            } catch (Exception $e) {}
        }

        $this->view('admin/contacts', [
            'page_title'   => 'Quản Lý Liên Hệ',
            'contacts'     => $contacts,
            'filter'       => $filter,
            'search'       => $search,
            'page'         => $page,
            'total_pages'  => $totalPages,
            'total_rows'   => $totalRows,
            'unread_count' => $unreadCount,
        ], 'admin');
    }

    public function markRead(): void
    {
        if (!$this->requireAdmin()) return;

        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            Contact::markRead($id);
        }

        $query = $_GET['redirect'] ?? '';
        header('Location: ' . url('admin/contacts' . ($query ? '?' . $query : '')));
        exit;
    }

    public function delete(): void
    {
        if (!$this->requireAdmin()) return;

        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            Contact::delete($id);
        }

        $query = $_GET['redirect'] ?? '';
        header('Location: ' . url('admin/contacts' . ($query ? '?' . $query : '')));
        exit;
    }
}
