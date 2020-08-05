</main>
<div id="main-spinner" class="spinner hide" role="status"><div></div><div></div><div></div><div></div></div>
<div class="notification">
    <img class="notification__image"
        <?php if (isset($data['response']['icon'])) : ?>
        src="<?= ASSETS_IMG . "{$data['response']['icon']}"; ?>"
        <?php endif; ?>
        alt="img" />
    <p class="notification__message">
        <?= $data['response']['message'] ?? null; ?>
    </p>
</div>
<script type="module" src="<?= ASSETS_JS . 'app.js'; ?>"></script>
</body>
</html>
