<?php

use App\Helper\Elements;

?>
<section class="container">
    <h1>Articles</h1>
    <?php foreach ($data['articles'] as $article) {
        $article['likedByCurrentUser'] = false;
        $article['onReadListForCurrentUser'] = false;
        if (isset($_SESSION['user'])) {
            if (!empty($article['bookmarkedBy'])) {
                foreach ($article['bookmarkedBy'] as $user) {
                    if ($user === (int)$_SESSION['user']['id']) {
                        $article['onReadListForCurrentUser'] = true;
                    }
                }
            }
            if (!empty($article['likedBy'])) {
                foreach ($article['likedBy'] as $user) {
                    if ($user === (int)$_SESSION['user']['id']) {
                        $article['likedByCurrentUser'] = true;
                    }
                }
            }
        }
        Elements::add('article', $article);
    } ?>
</section>
