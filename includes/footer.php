<?php
$depth = isset($pageDepth) ? $pageDepth : 0;
$basePath = str_repeat('../', $depth);
?>
    </main> <!-- /main-wrapper -->

    <footer class="app-footer">
        <div class="footer-container">
            <div class="footer-info">
                <span>LinksBase &bull; Custom Tag & Section System</span>
                <span class="db-pill">Storage: <strong><?= htmlspecialchars(strtoupper(DB_DRIVER)) ?></strong></span>
            </div>
            <div class="footer-links">
                <a href="<?= $basePath ?>index.old.html" target="_blank" class="footer-link">Original HTML Archive</a>
                <span class="footer-sep">&bull;</span>
                <a href="<?= $basePath ?>seed.php?force=1" onclick="return confirm('Reset all links back to default seed?')" class="footer-link text-muted">Reset / Reseed</a>
            </div>
        </div>
    </footer>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="toast-container"></div>

    <script src="<?= $basePath ?>script/app.js"></script>
</body>
</html>
