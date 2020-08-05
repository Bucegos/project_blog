<?php $useMini = isset($data['mini']) && $data['mini'] === true; ?>
<div class="article">
    <?php if (!empty($data['cover'])) : ?>
        <a href="<?= "/articles/read/{$data['slug']}" ;?>">
            <div class="article__cover <?= $useMini ? 'article__cover--mini' : '' ;?>"
                 style="background-image: url(<?= ASSETS_UPLOADS . "{$data['cover']}" ;?>)"
            ></div>
        </a>
    <?php endif; ?>
    <div class="article__container">
        <?php if ($useMini) : ?>
            <div class="article__info">
                <div class="profile-image">
                    <a href="/users/<?= $data['username']; ?>">
                        <img src="<?= ASSETS_UPLOADS . "{$data['image']}"; ?>" alt="profile" />
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
                    class="button--like <?= $data['likedByCurrentUser'] ? 'animated' : ''; ?>"
                    type="button"
                    data-post-id="<?=$data['id'];?>"
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
                    class="button button--reading-list <?= $data['onReadListForCurrentUser'] ? 'saved' : null; ?>"
                    type="button"
                    data-post-id="<?=$data['id'];?>"
                >
                    <?= $data['onReadListForCurrentUser'] ? 'SAVED' : 'SAVE'; ?>
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
            </div>
        <?php endif; ?>
    </div>
</div>
