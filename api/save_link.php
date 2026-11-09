<?php
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_POST['action'] ?? $_GET['action'] ?? $_REQUEST['action'] ?? 'add';
$method = $_SERVER['REQUEST_METHOD'] ?? (empty($_POST) ? 'GET' : 'POST');

if ($action === 'add' && ($method === 'POST' || !empty($_POST))) {
    $url = trim($_POST['url'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $majorTag = trim($_POST['major_tag'] ?? '');
    $minorTag = trim($_POST['minor_tag'] ?? 'General');
    $description = trim($_POST['description'] ?? '');
    $iconUrl = trim($_POST['icon_url'] ?? '');

    if (empty($url)) {
        echo json_encode(['success' => false, 'error' => 'URL is required']);
        exit;
    }

    if (empty($title)) {
        // Derive fallback title from host or URL
        $host = parse_url($url, PHP_URL_HOST);
        $title = $host ? ucfirst(preg_replace('/^www\./i', '', $host)) : $url;
    }

    if (empty($majorTag)) {
        $majorTag = 'General';
    }

    try {
        $id = addLink($title, $url, $majorTag, $minorTag, $description, $iconUrl);
        
        // If request was standard form submit (non-AJAX)
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !isset($_GET['ajax'])) {
            $redirect = $_POST['redirect_to'] ?? '../index.php';
            header('Location: ' . $redirect);
            exit;
        }

        echo json_encode([
            'success' => true,
            'id' => $id,
            'message' => 'Link added successfully!'
        ]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid link ID']);
        exit;
    }

    try {
        deleteLink($id);
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !isset($_GET['ajax'])) {
            $redirect = $_SERVER['HTTP_REFERER'] ?? '../index.php';
            header('Location: ' . $redirect);
            exit;
        }
        echo json_encode(['success' => true, 'message' => 'Link deleted successfully']);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

if ($action === 'tags') {
    // Return existing major and minor tags for auto-completion in the modal
    $db = getDB();
    $rows = $db->query("SELECT DISTINCT major_tag, minor_tag FROM links ORDER BY major_tag, minor_tag")->fetchAll();
    $map = [];
    foreach ($rows as $r) {
        $map[$r['major_tag']][] = $r['minor_tag'];
    }
    echo json_encode(['success' => true, 'tags' => $map]);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid action']);
