<?php
$pageDepth = 1;
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$q = trim($_GET['q'] ?? '');
$results = !empty($q) ? searchLinks($q) : [];
$totalResults = count($results);

$pageTitle = 'Search: ' . htmlspecialchars($q) . ' - LinksBase';
$breadcrumbs = [
    ['label' => 'Home', 'url' => '../index.php'],
    ['label' => 'Search', 'url' => '']
];

require_once __DIR__ . '/../includes/header.php';
?>

<div class="category-header-banner" style="background: linear-gradient(135deg, #4f46e5, #3730a3);">
    <div class="banner-content">
        <div class="banner-icon-wrap">
            <?= getIconSvg('search', 'icon-hero') ?>
        </div>
        <div class="banner-text">
            <div class="banner-tag-badge">Search Results</div>
            <h1 class="banner-title"><?= !empty($q) ? 'Results for "' . htmlspecialchars($q) . '"' : 'Search Bookmarks' ?></h1>
            <p class="banner-desc">Showing all matching titles, tags, and notes.</p>
        </div>
        <div class="banner-stats">
            <div class="banner-stat-box">
                <span class="banner-stat-number"><?= $totalResults ?></span>
                <span class="banner-stat-label">Matches</span>
            </div>
        </div>
    </div>
</div>

<section class="section-container">
    <?php if (empty($q)): ?>
        <div class="empty-state">
            <p>Please enter a keyword into the search bar above.</p>
        </div>
    <?php elseif (empty($results)): ?>
        <div class="empty-state">
            <p>No bookmarks found matching <strong>"<?= htmlspecialchars($q) ?>"</strong>.</p>
            <a href="../index.php" class="btn btn-secondary">Back to Categories</a>
        </div>
    <?php else: ?>
        <div class="cards-grid links-grid">
            <?php foreach ($results as $link): ?>
                <?php 
                    $favicon = getLinkFavicon($link['url'], $link['icon_url'] ?? '');
                    $host = getDisplayHost($link['url']);
                ?>
                <div class="card link-card interactive-link-card" data-url="<?= htmlspecialchars($link['url']) ?>" title="Click to open in new tab">
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
                            <a href="major.php?tag=<?= urlencode($link['major_tag']) ?>" class="tag-chip tag-chip-major" onclick="event.stopPropagation()"><?= htmlspecialchars($link['major_tag']) ?></a>
                            <a href="minor.php?major=<?= urlencode($link['major_tag']) ?>&minor=<?= urlencode($link['minor_tag']) ?>" class="tag-chip tag-chip-minor" onclick="event.stopPropagation()"><?= htmlspecialchars($link['minor_tag']) ?></a>
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
