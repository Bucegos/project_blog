<div class="post__container">
    <?php if (!empty($data['cover'])) : ?>
    <a href="<?="/posts/read/{$data['slug']}";?>">
        <div class="post__image"
             style="background-image: url(<?= HOST . "assets/uploads/{$data['cover']}" ;?>)"
        ></div>
        <?php endif; ?>
    </a>
    <div class="post__content">
        <div class="post__header">
            <div class="profile-image">
                <a href="/users/<?= $data['username']; ?>">
                    <img src="<?= HOST . "assets/uploads/{$data['image']}"; ?>" alt="profile" />
                </a>
            </div>
            <div>
                <a href="/users/<?= $data['username']; ?>">
                    <?= $data['username']; ?>
                </a>
                <p class="muted">
                    <?= date("h:i - M, jS 'y", strtotime($data['created_at'])); ?>
                </p>
            </div>
            <button class="button--like <?= $data['likedByCurrentUser'] ? 'animated' : null; ?>"
                type="button"
                data-post-id="<?=$data['id'];?>"
            >
            </button>
        </div>
        <div class="post__title">
            <a href="<?="/posts/read/{$data['slug']}";?>"><?= $data['title']; ?></a>
        </div>
        <div class="post__footer">
            <div class="post__tags">
                <?php foreach($data['tags'] as $tag) : ?>
                    <a class="tag" href="/tags/<?= $tag; ?>">
                        <span>#</span><?= $tag; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <button class="button button--reading-list <?= $data['onReadListForCurrentUser'] ? 'saved' : null; ?>"
                 type="button"
                 data-post-id="<?=$data['id'];?>"
            >
                 <?= $data['onReadListForCurrentUser'] ? 'SAVED' : 'SAVE'; ?>
            </button>
        </div>
    </div>
</div>