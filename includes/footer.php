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
                        <p>L'excellence académique au service de l'avenir de l'Afrique de l'Ouest. Rejoignez une communauté d'apprenants passionnés.</p>
                        <div class="footer-social-mobile" aria-label="Réseaux sociaux">
                            <?php foreach ($social_links as $name => $link): ?>
                                <a href="<?= htmlspecialchars($link['url']) ?>" title="<?= htmlspecialchars($name) ?>" aria-label="<?= htmlspecialchars($name) ?>"><?= $link['icon'] ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <?php foreach ($footer_links as $title => $links): ?>
                    <?php if (!in_array($title, ['Navigation', 'Légal', 'Legal', 'Ressources'], true)): ?>
                    <?php $footer_col_class = $title === 'Menu' ? ' footer-col-menu' : ($title === 'Contact' ? ' footer-col-contact' : ''); ?>
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
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <p class="footer-copyright">&copy; <?= date('Y') ?> <?= htmlspecialchars($site_name) ?>. Tous droits réservés.</p>
                    <div class="social-links hide-mobile">
                        <?php foreach ($social_links as $name => $link): ?>
                            <a href="<?= htmlspecialchars($link['url']) ?>" title="<?= htmlspecialchars($name) ?>" aria-label="<?= htmlspecialchars($name) ?>"><?= $link['icon'] ?></a>
                        <?php endforeach; ?>
                    </div>
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
