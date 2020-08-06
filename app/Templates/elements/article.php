<?php $useMini = isset($data['mini']) && $data['mini'] === true; ?>
<article class="article">
    <?php if (!empty($data['cover'])) : ?>
        <a href="<?= "/articles/read/{$data['slug']}" ;?>">
            <div class="article__cover <?= $useMini ? 'article__cover--mini' : null ;?>"
                 style="background-image: url(<?= ASSETS_UPLOADS . "{$data['cover']}" ;?>)"
            ></div>
        </a>
    <?php endif; ?>
    <div class="article__container">
        <?php if ($useMini) : ?>
            <div class="article__info">
                <div class="profile-image">
                    <a href="/users/<?= $data['username']; ?>">
                        <img src="<?= ASSETS_IMG . "{$data['user_image']}"; ?>" alt="profile" />
                    </a>
                </div>
                <div>
                    <a href="/users/<?= $data['username']; ?>">
                        <?= $data['username']; ?>
                    </a>
                    <p class="muted">
                        <?= date("M jS, Y", strtotime($data['created_at'])); ?>
                    </p>
                </div>
                <button
                    class="button--like <?= $data['liked_by_current_user'] ? 'liked' : null; ?>"
                    type="button"
                    data-article-id="<?=$data['id'];?>"
                    title="<?= $data['liked_by_current_user'] ? 'Unlike article' : 'Like article'; ?>"
                >
                </button>
            </div>
        <?php endif; ?>
        <div class="article__title <?= $useMini ? 'article__title--mini' : '' ;?>">
            <?php if ($useMini) : ?>
                <a href="<?="/articles/read/{$data['slug']}";?>"><?= $data['title']; ?></a>
            <?php else : ?>
                <h1><?= $data['title']; ?></h1>
            <?php endif; ?>
        </div>
        <div class="article__misc">
            <?php if (!empty($data['tags'])) : ?>
                <div class="article__tags">
                    <?php foreach($data['tags'] as $tag) : ?>
                        <a class="tag" href="/tags/<?= $tag; ?>">
                            <span>#</span><?= $tag; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ($useMini) : ?>
                <button
                    class="button button--bookmark <?= $data['bookmarked_by_current_user'] ? 'bookmarked' : null; ?>"
                    type="button"
                    data-article-id="<?=$data['id'];?>"
                    title="<?= $data['liked_by_current_user'] ? 'Remove bookmark' : 'Bookmark article'; ?>"
                >
                    <?= $data['bookmarked_by_current_user'] ? 'SAVED' : 'SAVE'; ?>
                </button>
            <?php endif; ?>
        </div>
        <?php if ($useMini) :
            if (!empty($data['description'])) : ?>
                <div class="article__description">
                    <?= $data['description']; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="article__content">
                <?= $data['content']; ?>
                <p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p><p>test</p>
                <p>test</p>
                <p>test</p>
            </div>
        <?php endif; ?>
    </div>
</article>
