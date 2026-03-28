    </main><!-- /.admin-content -->
</div><!-- /.admin-main -->

<!-- Admin JS -->
<script src="<?= APP_URL ?>/admin/assets/js/admin.js"></script>
<?php if (isset($pageJS)): ?>
<script src="<?= e($pageJS) ?>"></script>
<?php endif; ?>

<?php if (isset($inlineJS)): ?>
<script><?= $inlineJS ?></script>
<?php endif; ?>

</body>
</html>
