<?php
$useMini = isset($data['mini']) && $data['mini'] === true;
if (!empty($data['cover'])) : ?>
<a href="<?= "/articles/read/{$data['slug']}" ;?>">
    <div class="article__cover <?= $useMini ? 'article__cover--mini' : '' ;?>"
         style="background-image: url(<?= ASSETS_UPLOADS . "{$data['cover']}" ;?>)"
    ></div>
</a>
<?php endif; ?>
<div class="article__title <?= $useMini ? 'article__title--mini' : '' ;?>">
    <a href="<?="/articles/read/{$data['slug']}";?>"><?= $data['title']; ?></a>
</div>
<?php if (!empty($data['tags'])) : ?>
    <div class="tags">
        <?php foreach($data['tags'] as $tag) : ?>
            <a class="tag" href="/tags/<?= $tag; ?>">
                <span>#</span><?= $tag; ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if ($useMini) : ?>
    <div class="article__created-info">
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
<?php else : ?>
<div class="article__content">
    <?= $data['content']; ?>
</div>
<?php endif; ?>
