    </main>

    <!-- =================================================================
       FOOTER - Professional & Clean
       ================================================================= -->
    <footer class="main-footer">
        <!-- Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <!-- Brand Column -->
                    <div class="footer-brand">
                        <div class="footer-logo">
                            <?php if (!isset($site_logo_path)) $site_logo_path = 'assets/images/logo-ucao.png'; ?>
                            <?php if (file_exists(__DIR__ . '/../' . $site_logo_path)): ?>
                                <img src="<?= htmlspecialchars($site_logo_path) ?>" alt="<?= htmlspecialchars($site_name) ?>" class="footer-logo-img">
                            <?php else: ?>
                                <div class="footer-logo-text"><?= htmlspecialchars(explode(' ', $site_name)[0]) ?><span>.</span></div>
                            <?php endif; ?>
                        </div>
                        <ul class="footer-points" style="list-style: none; padding-left: 0; margin-bottom: 20px;">
                            <li><a href="orientation.php" style="color: inherit; text-decoration: none;">Orientation</a></li>
                            <li>UCAO-UUC</li>
                            <li>Foi, Science, Action</li>
                        </ul>
                        <div class="footer-social" aria-label="Réseaux sociaux">
                            <?php foreach ($social_links as $name => $link): ?>
                                <a href="<?= htmlspecialchars($link['url']) ?>" title="<?= htmlspecialchars($name) ?>" aria-label="<?= htmlspecialchars($name) ?>"><?= $link['icon'] ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <?php foreach ($footer_links as $title => $links): ?>
                    <?php if (!in_array($title, ['Navigation', 'Légal', 'Legal', 'Ressources'], true)): ?>
                    <?php $footer_col_class = $title === 'Menu' ? ' footer-col-menu' : ''; ?>
                    <div class="footer-col<?= $footer_col_class ?>">
                        <h4><?= htmlspecialchars($title) ?></h4>
                        <ul>
                            <?php foreach ($links as $link): ?>
                            <li><a href="<?= htmlspecialchars($link['url']) ?>"><?= htmlspecialchars($link['name']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>

                    <!-- Contact Column -->
                    <?php if (isset($contact_info)): ?>
                    <div class="footer-col footer-col-contact">
                        <h4>Contact</h4>
                        <ul class="footer-contact-list">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span><?= htmlspecialchars($contact_info['adresse']) ?></span>
                            </li>   
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <a href="tel:<?= htmlspecialchars(str_replace(' ', '', $contact_info['telephone'])) ?>"><?= htmlspecialchars($contact_info['telephone']) ?></a>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <a href="mailto:<?= htmlspecialchars($contact_info['email']) ?>"><?= htmlspecialchars($contact_info['email']) ?></a>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span><?= htmlspecialchars($contact_info['horaires']) ?></span>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content" style="display: flex; justify-content: center; align-items: center; text-align: center;">
                    <p class="footer-copyright">&copy; 2026 UCAO - Orientation. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Shared JavaScript -->
    <script src="assets/js/shared.js"></script>

    <?php if (isset($page_js)): ?>
    <script src="<?= htmlspecialchars($page_js) ?>"></script>
    <?php endif; ?>

</body>
</html>
