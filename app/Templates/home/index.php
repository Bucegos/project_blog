<?php

use App\Helper\Elements;

?>
<section class="container">
    <h1>Articles</h1>
    <?php foreach ($data['articles'] as $article) {
        $article['liked_by_current_user'] = false;
        $article['bookmarked_by_current_user'] = false;
        if (isset($_SESSION['user'])) {
            if (!empty($article['bookmarked_by'])) {
                foreach ($article['bookmarked_by'] as $user) {
                    if ($user === (int)$_SESSION['user']['id']) {
                        $article['bookmarked_by_current_user'] = true;
                    }
                }
            }
            if (!empty($article['liked_by'])) {
                foreach ($article['liked_by'] as $user) {
                    if ($user === (int)$_SESSION['user']['id']) {
                        $article['liked_by_current_user'] = true;
                    }
                }
            }
        }
        $article['mini'] = true;
        Elements::add('article', $article);
    } ?>
</section>
