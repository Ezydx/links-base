<?php
$pageDepth = 1;
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$currentMajor = trim($_GET['major'] ?? '');
$currentMinor = trim($_GET['minor'] ?? '');

if (empty($currentMajor)) {
    header('Location: ../index.php');
    exit;
}

$visuals = getMajorTagVisuals($currentMajor);
$links = getLinks($currentMajor, $currentMinor);
$totalLinks = count($links);

$pageTitle = htmlspecialchars($currentMinor ?: $currentMajor) . ' - Links & Bookmarks';
$breadcrumbs = [
    ['label' => 'Home', 'url' => '../index.php'],
    ['label' => $currentMajor, 'url' => 'major.php?tag=' . urlencode($currentMajor)],
    ['label' => $currentMinor ?: 'General', 'url' => '']
];

require_once __DIR__ . '/../includes/header.php';
?>

<div class="category-header-banner" style="background: <?= $visuals['color'] ?>;">
    <div class="banner-content">
        <div class="banner-icon-wrap">
            <?= getIconSvg('folder', 'icon-hero') ?>
        </div>
        <div class="banner-text">
            <div class="banner-tag-badge"><?= htmlspecialchars($currentMajor) ?> &rsaquo; Minor Tag</div>
            <h1 class="banner-title"><?= htmlspecialchars($currentMinor ?: 'All Links') ?></h1>
            <p class="banner-desc">
                Clicking any card opens the destination in a new tab.
            </p>
        </div>
        <div class="banner-stats">
            <div class="banner-stat-box">
                <span class="banner-stat-number"><?= $totalLinks ?></span>
                <span class="banner-stat-label"><?= $totalLinks === 1 ? 'Link' : 'Links' ?></span>
            </div>
        </div>
    </div>
</div>

<section class="section-container">
    <div class="section-header">
        <div>
            <h2 class="section-title">Saved Resources</h2>
            <p class="section-subtitle">Cards in <strong><?= htmlspecialchars($currentMinor) ?></strong></p>
        </div>
        <div class="section-actions">
            <button type="button" class="btn btn-primary" onclick="openAddModalWithTags('<?= htmlspecialchars(addslashes($currentMajor)) ?>', '<?= htmlspecialchars(addslashes($currentMinor)) ?>')">
                <?= getIconSvg('plus', 'icon-sm') ?>
                <span>Add Link Here</span>
            </button>
        </div>
    </div>

    <?php if (empty($links)): ?>
        <div class="empty-state">
            <p>No links found in this sub-category yet.</p>
            <button type="button" class="btn btn-primary" onclick="openAddModalWithTags('<?= htmlspecialchars(addslashes($currentMajor)) ?>', '<?= htmlspecialchars(addslashes($currentMinor)) ?>')">
                Add a Link
            </button>
        </div>
    <?php else: ?>
        <div class="cards-grid links-grid">
            <?php foreach ($links as $link): ?>
                <?php 
                    $favicon = getLinkFavicon($link['url'], $link['icon_url'] ?? '');
                    $host = getDisplayHost($link['url']);
                ?>
                <div class="card link-card interactive-link-card" data-url="<?= htmlspecialchars($link['url']) ?>" title="Click to open <?= htmlspecialchars($link['title']) ?> in new tab">
                    <div class="link-card-header">
                        <div class="link-brand">
                            <img src="<?= $favicon ?>" alt="" class="link-favicon" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236366f1\' stroke-width=\'2\'><circle cx=\'12\' cy=\'12\' r=\'10\'/></svg>'">
                            <div class="link-titles">
                                <h3 class="link-title"><?= htmlspecialchars($link['title']) ?></h3>
                                <span class="link-host"><?= htmlspecialchars($host) ?></span>
                            </div>
                        </div>
                        <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener noreferrer" class="link-open-btn" title="Open in new tab" onclick="event.stopPropagation()">
                            <?= getIconSvg('external-link', 'icon-sm') ?>
                        </a>
                    </div>

                    <?php if (!empty($link['description'])): ?>
                        <p class="link-desc"><?= htmlspecialchars($link['description']) ?></p>
                    <?php endif; ?>

                    <div class="link-card-footer">
                        <div class="link-tags">
                            <span class="tag-chip tag-chip-major"><?= htmlspecialchars($link['major_tag']) ?></span>
                            <span class="tag-chip tag-chip-minor"><?= htmlspecialchars($link['minor_tag']) ?></span>
                        </div>

                        <div class="link-actions" onclick="event.stopPropagation()">
                            <button type="button" class="btn-action copy-link-btn" data-url="<?= htmlspecialchars($link['url']) ?>" title="Copy URL">
                                <?= getIconSvg('copy', 'icon-xs') ?>
                            </button>
                            <form action="../api/save_link.php" method="POST" class="inline-delete-form" onsubmit="return confirm('Delete bookmark: <?= htmlspecialchars(addslashes($link['title'])) ?>?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $link['id'] ?>">
                                <button type="submit" class="btn-action btn-danger" title="Delete bookmark">
                                    <?= getIconSvg('trash', 'icon-xs') ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
