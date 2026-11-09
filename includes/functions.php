<?php
require_once __DIR__ . '/../config.php';

/**
 * Returns SVG markup for common tag categories and UI icons.
 */
function getIconSvg(string $name, string $class = "icon"): string {
    $icons = [
        'code' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>',
        'design' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path></svg>',
        'media' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>',
        'utilities' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>',
        'hosting' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>',
        'social' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>',
        'external-link' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>',
        'plus' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>',
        'search' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        'copy' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>',
        'trash' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',
        'folder' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>',
        'bookmark' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>',
        'arrow-right' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
        'home' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
        'tag' => '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>',
    ];

    $cleanName = strtolower(trim($name));
    return $icons[$cleanName] ?? $icons['bookmark'];
}

/**
 * Maps a major tag name to a corresponding SVG icon name and gradient color.
 */
function getMajorTagVisuals(string $tag): array {
    $lower = strtolower($tag);
    if (strpos($lower, 'dev') !== false || strpos($lower, 'code') !== false) {
        return ['icon' => 'code', 'color' => 'linear-gradient(135deg, #3b82f6, #1d4ed8)', 'badge' => '#3b82f6'];
    }
    if (strpos($lower, 'design') !== false || strpos($lower, 'graphic') !== false) {
        return ['icon' => 'design', 'color' => 'linear-gradient(135deg, #ec4899, #be185d)', 'badge' => '#ec4899'];
    }
    if (strpos($lower, 'media') !== false || strpos($lower, 'audio') !== false || strpos($lower, 'video') !== false) {
        return ['icon' => 'media', 'color' => 'linear-gradient(135deg, #8b5cf6, #6d28d9)', 'badge' => '#8b5cf6'];
    }
    if (strpos($lower, 'util') !== false || strpos($lower, 'tool') !== false) {
        return ['icon' => 'utilities', 'color' => 'linear-gradient(135deg, #10b981, #047857)', 'badge' => '#10b981'];
    }
    if (strpos($lower, 'host') !== false || strpos($lower, 'web') !== false || strpos($lower, 'cloud') !== false) {
        return ['icon' => 'hosting', 'color' => 'linear-gradient(135deg, #f59e0b, #b45309)', 'badge' => '#f59e0b'];
    }
    if (strpos($lower, 'social') !== false || strpos($lower, 'chat') !== false) {
        return ['icon' => 'social', 'color' => 'linear-gradient(135deg, #06b6d4, #0e7490)', 'badge' => '#06b6d4'];
    }
    return ['icon' => 'bookmark', 'color' => 'linear-gradient(135deg, #6366f1, #4338ca)', 'badge' => '#6366f1'];
}

/**
 * Extracts clean domain or display text from a URL.
 */
function getDisplayHost(string $url): string {
    if (strpos($url, 'file:///') === 0) {
        return 'Local File';
    }
    if (strpos($url, 'chrome://') === 0) {
        return 'Chrome Internal';
    }
    $host = parse_url($url, PHP_URL_HOST);
    if ($host) {
        return preg_replace('/^www\./i', '', $host);
    }
    return $url;
}

/**
 * Generates an appropriate favicon/image icon for a URL.
 */
function getLinkFavicon(string $url, string $customIcon = ''): string {
    if (!empty($customIcon)) {
        return htmlspecialchars($customIcon);
    }
    if (strpos($url, 'file:///') === 0) {
        return 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="%233b82f6" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>';
    }
    if (strpos($url, 'chrome://') === 0) {
        return 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="%23ef4444" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><line x1="21.17" y1="8" x2="12" y2="8"></line><line x1="3.95" y1="6.06" x2="8.54" y2="14"></line><line x1="10.88" y1="21.94" x2="15.46" y2="14"></line></svg>';
    }

    $host = parse_url($url, PHP_URL_HOST);
    if ($host) {
        return 'https://www.google.com/s2/favicons?domain=' . urlencode($host) . '&sz=128';
    }
    return 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="%236366f1" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';
}

/**
 * Retrieves all Major Tags with link counts and minor tag counts.
 */
function getMajorTags(): array {
    $db = getDB();
    $sql = "
        SELECT major_tag,
               COUNT(*) AS total_links,
               COUNT(DISTINCT minor_tag) AS total_minors
        FROM links
        GROUP BY major_tag
        ORDER BY total_links DESC, major_tag ASC
    ";
    return $db->query($sql)->fetchAll();
}

/**
 * Retrieves all Minor Tags for a specific Major Tag.
 */
function getMinorTags(string $majorTag): array {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT minor_tag,
               COUNT(*) AS total_links
        FROM links
        WHERE major_tag = :major
        GROUP BY minor_tag
        ORDER BY total_links DESC, minor_tag ASC
    ");
    $stmt->execute([':major' => $majorTag]);
    return $stmt->fetchAll();
}

/**
 * Retrieves links by Major Tag and optional Minor Tag.
 */
function getLinks(string $majorTag, string $minorTag = ''): array {
    $db = getDB();
    if ($minorTag !== '') {
        $stmt = $db->prepare("
            SELECT * FROM links
            WHERE major_tag = :major AND minor_tag = :minor
            ORDER BY id DESC
        ");
        $stmt->execute([':major' => $majorTag, ':minor' => $minorTag]);
    } else {
        $stmt = $db->prepare("
            SELECT * FROM links
            WHERE major_tag = :major
            ORDER BY minor_tag ASC, id DESC
        ");
        $stmt->execute([':major' => $majorTag]);
    }
    return $stmt->fetchAll();
}

/**
 * Search links across title, URL, description, major and minor tags.
 */
function searchLinks(string $query): array {
    $db = getDB();
    $param = '%' . trim($query) . '%';
    $stmt = $db->prepare("
        SELECT * FROM links
        WHERE title LIKE :q1
           OR url LIKE :q2
           OR description LIKE :q3
           OR major_tag LIKE :q4
           OR minor_tag LIKE :q5
        ORDER BY id DESC
    ");
    $stmt->execute([
        ':q1' => $param,
        ':q2' => $param,
        ':q3' => $param,
        ':q4' => $param,
        ':q5' => $param,
    ]);
    return $stmt->fetchAll();
}

/**
 * Adds a new link to the database.
 */
function addLink(string $title, string $url, string $majorTag, string $minorTag, string $description = '', string $iconUrl = ''): int {
    $db = getDB();
    $stmt = $db->prepare("
        INSERT INTO links (title, url, major_tag, minor_tag, description, icon_url)
        VALUES (:title, :url, :major_tag, :minor_tag, :description, :icon_url)
    ");
    $stmt->execute([
        ':title' => trim($title),
        ':url' => trim($url),
        ':major_tag' => trim($majorTag),
        ':minor_tag' => trim($minorTag) !== '' ? trim($minorTag) : 'General',
        ':description' => trim($description),
        ':icon_url' => trim($iconUrl)
    ]);
    return (int)$db->lastInsertId();
}

/**
 * Deletes a link by ID.
 */
function deleteLink(int $id): bool {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM links WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}

/**
 * Check if the links table has any entries.
 */
function countTotalLinks(): int {
    $db = getDB();
    return (int)$db->query("SELECT COUNT(*) FROM links")->fetchColumn();
}
