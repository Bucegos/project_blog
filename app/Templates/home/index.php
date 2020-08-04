<?php

use App\Helper\Elements;

?>
<section class="home container">
    <h1>Posts</h1>
    <?php foreach ($data['posts'] as $post) {
        $post['likedByCurrentUser'] = false;
        $post['onReadListForCurrentUser'] = false;
        if (isset($_SESSION['user'])) {
            if (!empty($post['readers'])) {
                foreach ($post['readers'] as $user) {
                    if ($user === (int)$_SESSION['user']['id']) {
                        $post['onReadListForCurrentUser'] = true;
                    }
                }
            }
            if (!empty($post['likedBy'])) {
                foreach ($post['likedBy'] as $user) {
                    if ($user === (int)$_SESSION['user']['id']) {
                        $post['likedByCurrentUser'] = true;
                    }
                }
            }
        }
        Elements::element('post', $post);
    } ?>
</section>
