</div>

<?php $assetVersion = defined('ASSET_VERSION') ? (string)constant('ASSET_VERSION') : '1.0.0'; ?>
<script src="<?= e(adminUrl('assets/js/admin.js') . '?v=' . urlencode($assetVersion)) ?>"></script>
</body>

</html>