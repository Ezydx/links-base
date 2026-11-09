<?php
if (!defined('DB_DRIVER')) {
    require_once __DIR__ . '/../config.php';
}
require_once __DIR__ . '/functions.php';

// Determine relative path depth to root
$depth = isset($pageDepth) ? $pageDepth : 0;
$basePath = str_repeat('../', $depth);

$pageTitle = $pageTitle ?? 'Links Base - Web Tools Hub';
$breadcrumbs = $breadcrumbs ?? [
    ['label' => 'Home', 'url' => $basePath . 'index.php']
];

// Pre-fill tags for modal if available in current view
$modalMajor = $currentMajor ?? '';
$modalMinor = $currentMinor ?? '';

// Total links for topbar pill
$totalLinkCount = countTotalLinks();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="icon" type="image/png" href="<?= $basePath ?>resource/links-base.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $basePath ?>style/style.css">
</head>
<body data-basepath="<?= $basePath ?>">
    <!-- Top Navigation Bar -->
    <header class="topbar">
        <div class="topbar-container">
            <div class="topbar-left">
                <a href="<?= $basePath ?>index.php" class="brand-logo">
                    <?php if (file_exists(__DIR__ . '/../resource/links-base.png')): ?>
                        <img src="<?= $basePath ?>resource/links-base.png" alt="LinksBase Logo" class="brand-logo-img">
                    <?php else: ?>
                        <span class="logo-icon"><?= getIconSvg('bookmark', 'icon-brand') ?></span>
                    <?php endif; ?>
                    <span class="logo-text">Links<span class="logo-accent">Base</span></span>
                </a>

                <!-- Breadcrumbs -->
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <?php foreach ($breadcrumbs as $idx => $crumb): ?>
                        <?php if ($idx > 0): ?>
                            <span class="breadcrumb-separator">/</span>
                        <?php endif; ?>
                        <?php if (!empty($crumb['url']) && $idx < count($breadcrumbs) - 1): ?>
                            <a href="<?= htmlspecialchars($crumb['url']) ?>" class="breadcrumb-link"><?= htmlspecialchars($crumb['label']) ?></a>
                        <?php else: ?>
                            <span class="breadcrumb-current"><?= htmlspecialchars($crumb['label']) ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </nav>
            </div>

            <!-- Center: Live Clock (preserving user's original clock) -->
            <div class="topbar-center">
                <div class="clock-badge" id="date-time" title="Current Local Date & Time">
                    <span class="clock-icon">🕒</span>
                    <span class="clock-label">Date now:</span>
                    <span id="live-clock-time" class="clock-val">Loading...</span>
                </div>
            </div>

            <!-- Right Controls: Search & Add Link -->
            <div class="topbar-right">
                <form action="<?= $basePath ?>page/search.php" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <span class="search-icon"><?= getIconSvg('search', 'icon-sm') ?></span>
                        <input type="text" name="q" placeholder="Search links or tags..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" autocomplete="off" class="search-input">
                    </div>
                </form>

                <button type="button" class="btn btn-primary" id="open-add-modal-btn">
                    <?= getIconSvg('plus', 'icon-sm') ?>
                    <span>Add Link</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Add Link Modal -->
    <div class="modal-overlay" id="add-link-modal" aria-hidden="true">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <span class="modal-icon"><?= getIconSvg('bookmark', 'icon-md') ?></span>
                    <h3>Add New Bookmark</h3>
                </div>
                <button type="button" class="modal-close-btn" id="close-modal-btn" aria-label="Close modal">&times;</button>
            </div>

            <form action="<?= $basePath ?>api/save_link.php" method="POST" id="add-link-form">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? $basePath . 'index.php') ?>">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="link-url">URL / Destination <span class="required">*</span></label>
                        <input type="text" id="link-url" name="url" placeholder="https://example.com" required autocomplete="off">
                        <small class="form-hint">Tip: Web links (https://), local paths (file:///), or chrome:// URLs are supported</small>
                    </div>

                    <div class="form-group">
                        <label for="link-title">Title / Name</label>
                        <input type="text" id="link-title" name="title" placeholder="e.g. Android Developers" autocomplete="off">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-half">
                            <label for="link-major">Major Tag / Category <span class="required">*</span></label>
                            <input list="major-tags-list" id="link-major" name="major_tag" value="<?= htmlspecialchars($modalMajor) ?>" placeholder="Select or type..." required>
                            <datalist id="major-tags-list">
                                <option value="Development">
                                <option value="Design">
                                <option value="Media">
                                <option value="Utilities">
                                <option value="Web Hosting">
                                <option value="Social">
                            </datalist>
                        </div>

                        <div class="form-group col-half">
                            <label for="link-minor">Minor Tag / Sub-category</label>
                            <input type="text" id="link-minor" name="minor_tag" value="<?= htmlspecialchars($modalMinor) ?>" placeholder="e.g. Reference & Docs">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link-description">Description / Note</label>
                        <textarea id="link-description" name="description" rows="2" placeholder="Brief note or info about what this link is used for..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="link-icon">Custom Icon / Image URL (optional)</label>
                        <input type="text" id="link-icon" name="icon_url" placeholder="Leave blank to auto-detect favicon">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancel-modal-btn">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <?= getIconSvg('plus', 'icon-sm') ?>
                        <span>Save Link</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content Container -->
    <main class="main-wrapper">
