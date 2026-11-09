<?php
require_once __DIR__ . '/includes/functions.php';

function seedDatabase(bool $force = false) {
    $db = getDB();
    $total = countTotalLinks();
    if ($total > 0 && !$force) {
        return "Database already has $total links. Skipping seed (use ?force=1 to reseed).";
    }

    if ($force) {
        $db->exec("DELETE FROM links");
        $db->exec("DELETE FROM tag_meta");
    }

    $initialLinks = [
        // Development
        [
            'title' => 'Fullstack Bootcamp Courses',
            'url' => 'file:///C:/Users/rash4/Documents/WareHouse/Ra$%20projectZ/sysout/index.html',
            'major_tag' => 'Development',
            'minor_tag' => 'Bootcamp & Fullstack',
            'description' => 'Local archive of my fullstack bootcamp courses and exercises'
        ],
        [
            'title' => 'Android Developers',
            'url' => 'https://developer.android.com/',
            'major_tag' => 'Development',
            'minor_tag' => 'Android & Mobile',
            'description' => 'Official Android developer guides, SDKs, and API documentation'
        ],
        [
            'title' => 'MDN Web Docs',
            'url' => 'https://developer.mozilla.org/en-US/',
            'major_tag' => 'Development',
            'minor_tag' => 'Reference & Docs',
            'description' => 'Resources, standards, and specifications for web developers'
        ],
        [
            'title' => 'HTML Tags Reference',
            'url' => 'https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input',
            'major_tag' => 'Development',
            'minor_tag' => 'Reference & Docs',
            'description' => 'HTML input elements, tag references, and syntax'
        ],
        [
            'title' => 'W3Schools',
            'url' => 'https://www.w3schools.com/',
            'major_tag' => 'Development',
            'minor_tag' => 'Reference & Docs',
            'description' => 'Web development tutorials, references, and interactive sandbox'
        ],
        [
            'title' => 'Apache NetBeans',
            'url' => 'https://netbeans.apache.org/front/main/download/',
            'major_tag' => 'Development',
            'minor_tag' => 'IDE & Platforms',
            'description' => 'Latest Apache NetBeans IDE downloads and releases'
        ],
        [
            'title' => 'Replit',
            'url' => 'https://replit.com/',
            'major_tag' => 'Development',
            'minor_tag' => 'IDE & Platforms',
            'description' => 'In-browser IDE, repl, and collaborative coding environment'
        ],
        [
            'title' => 'JavaRanch',
            'url' => 'https://javaranch.com/',
            'major_tag' => 'Development',
            'minor_tag' => 'IDE & Platforms',
            'description' => 'Friendly Java discussion board and programming community'
        ],
        [
            'title' => 'My GitHub',
            'url' => 'https://github.com/Rash-collection?tab=repositories',
            'major_tag' => 'Development',
            'minor_tag' => 'Repositories',
            'description' => 'My personal GitHub profile and code repositories'
        ],

        // Design & Graphics
        [
            'title' => 'Figma',
            'url' => 'https://www.figma.com/',
            'major_tag' => 'Design',
            'minor_tag' => 'UI & Wireframing',
            'description' => 'Collaborative interface design, prototyping, and vector graphics tool'
        ],
        [
            'title' => 'Photopea',
            'url' => 'https://www.photopea.com/',
            'major_tag' => 'Design',
            'minor_tag' => 'Photo & Editors',
            'description' => 'Online image editor, raster and vector graphics, PSD Photoshop alternative'
        ],
        [
            'title' => 'Remove.bg',
            'url' => 'https://www.remove.bg/upload',
            'major_tag' => 'Design',
            'minor_tag' => 'Photo & Editors',
            'description' => 'Instant AI background removal for photos and images'
        ],
        [
            'title' => 'Ionicons',
            'url' => 'https://ionic.io/ionicons',
            'major_tag' => 'Design',
            'minor_tag' => 'Icons & Emojis',
            'description' => 'Premium open-source icon library designed for web and mobile apps'
        ],
        [
            'title' => 'React Emojis',
            'url' => 'https://dreamyguy.github.io/react-emojis/',
            'major_tag' => 'Design',
            'minor_tag' => 'Icons & Emojis',
            'description' => 'Fast emoji search, copy, and React emoji component helper'
        ],
        [
            'title' => 'Symbl (ASCII & Symbols)',
            'url' => 'https://symbl.cc/',
            'major_tag' => 'Design',
            'minor_tag' => 'Icons & Emojis',
            'description' => 'Complete character tables, Unicode symbols, and ASCII codes'
        ],
        [
            'title' => 'Unsplash',
            'url' => 'https://unsplash.com/',
            'major_tag' => 'Design',
            'minor_tag' => 'Stock & Illustrations',
            'description' => 'High-resolution free stock photography from creators worldwide'
        ],
        [
            'title' => 'unDraw',
            'url' => 'https://undraw.co/',
            'major_tag' => 'Design',
            'minor_tag' => 'Stock & Illustrations',
            'description' => 'Open-source SVG illustrations with customizable brand colors'
        ],

        // Media & Converters
        [
            'title' => 'YouTube',
            'url' => 'https://www.youtube.com/',
            'major_tag' => 'Media',
            'minor_tag' => 'Video & Audio',
            'description' => 'Video streaming, channels, and tutorials'
        ],
        [
            'title' => 'Clideo',
            'url' => 'https://clideo.com/',
            'major_tag' => 'Media',
            'minor_tag' => 'Video & Audio',
            'description' => 'All-in-one online video tools: merge, resize, compress, and edit'
        ],
        [
            'title' => 'YT-Converter',
            'url' => 'https://ytmp3.cc/k2q9/',
            'major_tag' => 'Media',
            'minor_tag' => 'Video & Audio',
            'description' => 'Convert online videos directly to MP3 audio files'
        ],
        [
            'title' => 'FreeConvert WAV Converter',
            'url' => 'https://www.freeconvert.com/wav-converter',
            'major_tag' => 'Media',
            'minor_tag' => 'Sound & Music',
            'description' => 'High-quality audio converter to WAV format'
        ],
        [
            'title' => 'MP3Cut',
            'url' => 'https://mp3cut.net/',
            'major_tag' => 'Media',
            'minor_tag' => 'Sound & Music',
            'description' => 'Trim and cut MP3 soundtracks online with ease'
        ],
        [
            'title' => 'BeepBox',
            'url' => 'https://www.beepbox.co/',
            'major_tag' => 'Media',
            'minor_tag' => 'Sound & Music',
            'description' => 'Sketching and composing 8-bit melodies and retro sound effects'
        ],
        [
            'title' => 'Online Convert (ICO)',
            'url' => 'https://image.online-convert.com/convert-to-ico',
            'major_tag' => 'Media',
            'minor_tag' => 'Converters',
            'description' => 'Convert images to Windows ICO and favicon format'
        ],

        // Utilities & Cloud
        [
            'title' => 'ChatGPT',
            'url' => 'https://chatgpt.com/',
            'major_tag' => 'Utilities',
            'minor_tag' => 'AI & Translation',
            'description' => 'OpenAI conversational assistant for code, writing, and research'
        ],
        [
            'title' => 'Google Translate',
            'url' => 'https://translate.google.com/?sl=en&tl=ar&op=translate',
            'major_tag' => 'Utilities',
            'minor_tag' => 'AI & Translation',
            'description' => 'Instant translation between English, Arabic, and 100+ languages'
        ],
        [
            'title' => 'Clock::Zone',
            'url' => 'https://clock.zone/',
            'major_tag' => 'Utilities',
            'minor_tag' => 'Time & System',
            'description' => 'Super accurate world clock, time zones, and stopwatch'
        ],
        [
            'title' => 'Chrome Settings',
            'url' => 'chrome://settings/',
            'major_tag' => 'Utilities',
            'minor_tag' => 'Time & System',
            'description' => 'Google Chrome browser settings and internal configuration'
        ],
        [
            'title' => 'Catbox',
            'url' => 'https://catbox.moe/',
            'major_tag' => 'Utilities',
            'minor_tag' => 'File & Image Uploads',
            'description' => 'Quick and permanent file, image, and video hosting'
        ],
        [
            'title' => 'PostImages',
            'url' => 'https://postimages.org/',
            'major_tag' => 'Utilities',
            'minor_tag' => 'File & Image Uploads',
            'description' => 'Free and easy image hosting and forum link generator'
        ],

        // Web Hosting
        [
            'title' => 'WordPress',
            'url' => 'https://wordpress.com/me',
            'major_tag' => 'Web Hosting',
            'minor_tag' => 'CMS & Identity',
            'description' => 'WordPress user profile and website management panel'
        ],
        [
            'title' => 'Gravatar',
            'url' => 'https://gravatar.com/profile',
            'major_tag' => 'Web Hosting',
            'minor_tag' => 'CMS & Identity',
            'description' => 'Globally Recognized Avatar profile manager'
        ],
        [
            'title' => 'AwardSpace',
            'url' => 'https://cp1.awardspace.net/',
            'major_tag' => 'Web Hosting',
            'minor_tag' => 'Hosting Control',
            'description' => 'AwardSpace web hosting control panel and domain manager'
        ],
        [
            'title' => 'Rash Personal Page',
            'url' => 'http://rashnoash.atwebpages.com/home.html',
            'major_tag' => 'Web Hosting',
            'minor_tag' => 'Hosting Control',
            'description' => 'Personal website and project showcase (under construction)'
        ],

        // Social
        [
            'title' => 'Discord',
            'url' => 'https://discord.com/channels/@me',
            'major_tag' => 'Social',
            'minor_tag' => 'Chat & Community',
            'description' => 'Direct messaging, developer servers, and community channels'
        ],
    ];

    $inserted = 0;
    foreach ($initialLinks as $link) {
        addLink(
            $link['title'],
            $link['url'],
            $link['major_tag'],
            $link['minor_tag'],
            $link['description'] ?? '',
            $link['icon_url'] ?? ''
        );
        $inserted++;
    }

    return "Successfully seeded $inserted links into database!";
}

if (php_sapi_name() === 'cli' || isset($_GET['run'])) {
    $force = isset($_GET['force']) || in_array('--force', $argv ?? []);
    echo seedDatabase($force) . PHP_EOL;
}
