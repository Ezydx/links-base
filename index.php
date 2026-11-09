<?php
$pageDepth = 0;
$pageTitle = 'LinksBase - Major Categories';
require_once __DIR__ . '/includes/header.php';

$majorTags = getMajorTags();
$totalLinks = countTotalLinks();
$totalMajors = count($majorTags);
?>

<div class="hero-section">
    <div class="hero-content">
        <span class="hero-badge">Curated Bookmarks & Web Hub</span>
        <h1 class="hero-title">Browse by Major Category</h1>
        <p class="hero-desc">
            Organized hierarchical cards replace cluttered browser bookmarks. 
            Select any major genre to explore its specific sub-tags and resources.
        </p>

        <div class="hero-stats">
            <div class="stat-pill">
                <span class="stat-num"><?= $totalMajors ?></span>
                <span class="stat-label">Major Categories</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-pill">
                <span class="stat-num"><?= $totalLinks ?></span>
                <span class="stat-label">Total Saved Links</span>
            </div>
        </div>
    </div>
</div>

<section class="section-container">
    <div class="section-header">
        <div>
            <h2 class="section-title">Major Categories</h2>
            <p class="section-subtitle">Click a card to view its sub-categories and tags</p>
        </div>
    </div>

    <?php if (empty($majorTags)): ?>
        <div class="empty-state">
            <p>No links found yet.</p>
            <a href="seed.php" class="btn btn-primary">Seed Initial Bookmarks</a>
        </div>
    <?php else: ?>
        <div class="cards-grid major-grid">
            <?php foreach ($majorTags as $cat): ?>
                <?php 
                    $visuals = getMajorTagVisuals($cat['major_tag']);
                    $minors = getMinorTags($cat['major_tag']);
                    $tagUrl = 'page/major.php?tag=' . urlencode($cat['major_tag']);
                ?>
                <a href="<?= $tagUrl ?>" class="card major-card">
                    <div class="major-card-banner" style="background: <?= $visuals['color'] ?>;">
                        <span class="major-card-icon">
                            <?= getIconSvg($visuals['icon'], 'icon-xl') ?>
                        </span>
                        <span class="card-arrow-indicator">
                            <?= getIconSvg('arrow-right', 'icon-sm') ?>
                        </span>
                    </div>

                    <div class="major-card-content">
                        <div class="major-card-header">
                            <h3 class="major-card-title"><?= htmlspecialchars($cat['major_tag']) ?></h3>
                            <span class="badge badge-count"><?= $cat['total_links'] ?> <?= $cat['total_links'] === 1 ? 'link' : 'links' ?></span>
                        </div>

                        <p class="major-card-meta">
                            <?= $cat['total_minors'] ?> <?= $cat['total_minors'] === 1 ? 'sub-category' : 'sub-categories' ?>
                        </p>

                        <!-- Preview chips of minor tags -->
                        <div class="minor-chips-preview">
                            <?php foreach (array_slice($minors, 0, 4) as $m): ?>
                                <span class="chip"><?= htmlspecialchars($m['minor_tag']) ?> (<?= $m['total_links'] ?>)</span>
                            <?php endforeach; ?>
                            <?php if (count($minors) > 4): ?>
                                <span class="chip chip-more">+<?= count($minors) - 4 ?> more</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
