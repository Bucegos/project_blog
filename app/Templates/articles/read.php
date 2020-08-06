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
            class="button--like <?= $article['liked_by_current_user'] ? 'animated' : ''; ?>"
            type="button"
            data-article-id="<?= $article['id']; ?>"
        >
        </button>
        <button
            class="button button--bookmark button--bookmark--mini <?= $article['bookmarked_by_current_user'] ? 'bookmarked' : null; ?>"
            type="button"
            data-article-id="<?=$article['id'];?>"
            title="Bookmark this article"
        >
            <i class="<?= $article['bookmarked_by_current_user'] ? 'fas' : 'far' ;?> fa-bookmark"></i>
        </button>

    </aside>
    <?php Elements::add('article', $article); ?>
    <aside class="article-read__user sticky">
        <p>test</p>
        <p>test</p>
        <p>test</p>
    </aside>
</section>
