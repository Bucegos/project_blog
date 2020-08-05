<?php

use App\Helper\Elements;

?>
<section class="post container">
    <?php if (!$data['user']) : ?>
    <div class="post__login">
        <div class="post__login__message">
            <img src="<?= ASSETS_IMG . 'logo.svg'; ?>" alt="logo" />
            <div>
                <h1>Welcome to "BLOG"</h1>
                <p>Sign in below to compose your post and share it with the community.</p>
            </div>
        </div>
        <div class="post__login__form">
            <?php Elements::add('login'); ?>
        </div>
    </div>
    <?php else : ?>
    <div class="post__actions">
        <button class="button button--outline button--outline--active" id="postEditButton">Edit</button>
        <button class="button button--outline" id="postPreviewButton">Preview</button>
    </div>
    <div class="post__edit">
        <div class="post__cover">
            <div class="post__cover--mini-preview hide"></div>
            <div class="post__cover__buttons">
                <button class="button button--secondary" id="postCoverButton" type="button">Add a cover image</button>
                <button class="button hide" id="postRemoveCoverButton" type="button">Remove</button>
            </div>
            <input id="imageInput" type="file" name="image" accept="image/png, image/gif, image/jpeg, image/jpg" />
        </div>
        <form id="post" action="/posts/write" method="POST" autocomplete="off">
            <input id="postCoverInput" type="hidden" name="cover" />
            <input class="post__input post__input--title" type="text" name="title" placeholder="New post title here..." aria-label="title" required>
            <div class="post__tags">
                <h5>Select up to 4 tags(hold CTRL + click)</h5>
                <select class="post__input--tags" name="tags[]" multiple>
                    <?php foreach ($data['tags'] as $tag) : ?>
                    <option
                        class="post__input--tag"
                        value="<?= $tag['id']; ?>"
                        title="<?= $tag['description']; ?>"
                        style="background-color: <?=$tag['color']; ?>"
                    >
                        <?= $tag['name']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <textarea class="post__input post__input--content" rows="10" name="content" placeholder="Write your post here..." aria-label="content"></textarea>
            <p class="error"></p>
            <div class="post__submit">
                <button class="button" type="submit">Publish</button>
                <button class="button button--secondary" id="postDraft" type="submit">Save draft</button>
            </div>
        </form>
    </div>
    <div class="post__preview hide">
        testing preview
    </div>
    <?php endif; ?>
</section>