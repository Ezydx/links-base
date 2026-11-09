<?php
$pageDepth = 1;
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$currentMajor = trim($_GET['tag'] ?? '');
if (empty($currentMajor)) {
    header('Location: ../index.php');
    exit;
}

$visuals = getMajorTagVisuals($currentMajor);
$minorTags = getMinorTags($currentMajor);
$allLinks = getLinks($currentMajor);
$totalLinks = count($allLinks);

$pageTitle = htmlspecialchars($currentMajor) . ' - Sub-categories & Tags';
$breadcrumbs = [
    ['label' => 'Home', 'url' => '../index.php'],
    ['label' => $currentMajor, 'url' => '']
];

require_once __DIR__ . '/../includes/header.php';
?>

<div class="category-header-banner" style="background: <?= $visuals['color'] ?>;">
    <div class="banner-content">
        <div class="banner-icon-wrap">
            <?= getIconSvg($visuals['icon'], 'icon-hero') ?>
        </div>
        <div class="banner-text">
            <div class="banner-tag-badge">Major Category</div>
            <h1 class="banner-title"><?= htmlspecialchars($currentMajor) ?></h1>
            <p class="banner-desc">
                Select a sub-category card below to view all bookmarked links and tools, or browse through the resources.
            </p>
        </div>
        <div class="banner-stats">
            <div class="banner-stat-box">
                <span class="banner-stat-number"><?= count($minorTags) ?></span>
                <span class="banner-stat-label">Sub-tags</span>
            </div>
            <div class="banner-stat-box">
                <span class="banner-stat-number"><?= $totalLinks ?></span>
                <span class="banner-stat-label">Links</span>
            </div>
        </div>
    </div>
</div>

<section class="section-container">
    <div class="section-header">
        <div>
            <h2 class="section-title">Sub-categories & Minor Tags</h2>
            <p class="section-subtitle">Click a minor tag card to view its dedicated links</p>
        </div>
        <div class="section-actions">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('all-links-preview').scrollIntoView({behavior: 'smooth'})">
                View All Links (<?= $totalLinks ?>) &darr;
            </button>
        </div>
    </div>

    <?php if (empty($minorTags)): ?>
        <div class="empty-state">
            <p>No sub-categories found in this category yet.</p>
            <button type="button" class="btn btn-primary" onclick="openAddModalWithTags('<?= htmlspecialchars(addslashes($currentMajor)) ?>', '')">
                Add the First Link
            </button>
        </div>
    <?php else: ?>
        <div class="cards-grid minor-grid">
            <?php foreach ($minorTags as $minor): ?>
                <?php 
                    $minorUrl = 'minor.php?major=' . urlencode($currentMajor) . '&minor=' . urlencode($minor['minor_tag']);
                    $sampleLinks = getLinks($currentMajor, $minor['minor_tag']);
                ?>
                <a href="<?= $minorUrl ?>" class="card minor-card">
                    <div class="minor-card-top">
                        <div class="minor-card-icon-box">
                            <?= getIconSvg('folder', 'icon-md') ?>
                        </div>
                        <span class="badge badge-accent"><?= $minor['total_links'] ?> <?= $minor['total_links'] === 1 ? 'link' : 'links' ?></span>
                    </div>

                    <div class="minor-card-body">
                        <h3 class="minor-card-title"><?= htmlspecialchars($minor['minor_tag']) ?></h3>
                        
                        <!-- Preview link titles -->
                        <ul class="minor-links-preview-list">
                            <?php foreach (array_slice($sampleLinks, 0, 3) as $sl): ?>
                                <li>
                                    <span class="bullet">&bull;</span>
                                    <span class="preview-title"><?= htmlspecialchars($sl['title']) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="minor-card-footer">
                        <span class="explore-link">
                            Explore Minor Card
                            <?= getIconSvg('arrow-right', 'icon-xs') ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Quick preview of all links in this major category -->
<section class="section-container" id="all-links-preview">
    <div class="section-header">
        <div>
            <h2 class="section-title">All Links in <?= htmlspecialchars($currentMajor) ?></h2>
            <p class="section-subtitle">Quick overview of every bookmark in this major category</p>
        </div>
    </div>

    <div class="cards-grid links-grid">
        <?php foreach ($allLinks as $link): ?>
            <?php 
                $favicon = getLinkFavicon($link['url'], $link['icon_url'] ?? '');
                $host = getDisplayHost($link['url']);
            ?>
            <div class="card link-card" data-url="<?= htmlspecialchars($link['url']) ?>">
                <div class="link-card-header">
                    <div class="link-brand">
                        <img src="<?= $favicon ?>" alt="" class="link-favicon" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236366f1\' stroke-width=\'2\'><circle cx=\'12\' cy=\'12\' r=\'10\'/></svg>'">
                        <div class="link-titles">
                            <h3 class="link-title" title="<?= htmlspecialchars($link['title']) ?>"><?= htmlspecialchars($link['title']) ?></h3>
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
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
