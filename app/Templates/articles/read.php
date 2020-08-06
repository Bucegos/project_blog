<?php
use App\Helper\Elements;
$article = $data['article'];
if (isset($_SESSION['user'])) {
    $article['bookmarked_by_current_user'] = $article['bookmarked_by'][0] === (int)$_SESSION['user']['id'];
    $article['liked_by_current_user'] = $article['liked_by'][0] === (int)$_SESSION['user']['id'];
}
?>
<section class="article-read container">
    <aside class="article-read__actions sticky">
        <button
            class="button--like <?= $article['liked_by_current_user'] ? 'liked' : null; ?>"
            type="button"
            data-article-id="<?= $article['id']; ?>"
            title="<?= $article['liked_by_current_user'] ? 'Unlike article' : 'Like article'; ?>"
        >
        </button>
        <button
            class="button button--bookmark button--bookmark--mini <?= $article['bookmarked_by_current_user'] ? 'bookmarked' : null; ?>"
            type="button"
            data-article-id="<?=$article['id'];?>"
            title="<?= $article['bookmarked_by_current_user'] ? 'Remove bookmark' : 'Bookmark article'; ?>"
        >
            <i class="<?= $article['bookmarked_by_current_user'] ? 'fas' : 'far' ;?> fa-bookmark"></i>
        </button>

    </aside>
    <?php Elements::add('article', $article); ?>
    <aside class="article-read__user sticky">
        <div class="article-read__user__info">
            <div class="profile-image">
                <a href="/users/<?= $article['username']; ?>">
                    <img src="<?= ASSETS_IMG . "{$article['user_image']}"; ?>" alt="profile" />
                    <p><?= $article['username']; ?></p>
                </a>
            </div>
            <p><?= $article['user_summary'] ;?></p>
            <p>Joined</p>
            <p><?= date("M jS, Y", strtotime($article['user_joined'])); ?></p>
        </div>
        <div class="article-read__user__articles">
            <h3>More from <?= $article['username'] ;?></h3>
            <?php foreach ($article['short_articles'] as $shortArticle) : ?>
                <a href="<?= $shortArticle['slug'] ;?>"><?= $shortArticle['title'] ;?></a>
                <?php foreach ($shortArticle['tags'] as $tag) : ?>
                    <a href="/tags/<?= $tag ;?>"><?= $tag ;?></a>
                <?php endforeach;
            endforeach; ?>
        </div>
    </aside>
</section>
