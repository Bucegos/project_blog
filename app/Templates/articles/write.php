<?php
use App\Helper\Elements;
?>
<section class="article-write container">
    <?php if (isset($data['user'])) : ?>
        <div class="article-write__actions">
            <button class="button button--outline button--outline--active" id="articleEditButton">Edit</button>
            <button class="button button--outline" id="articlePreviewButton">Preview</button>
        </div>
        <div class="article-write__edit">
            <div class="article-write__cover">
                <div class="article-write__cover--mini-preview hide"></div>
                <div class="article-write__cover__buttons">
                    <button class="button button--secondary" id="articleCoverButton" type="button">Add a cover image</button>
                    <button class="button hide" id="articleRemoveCoverButton" type="button">Remove</button>
                </div>
                <input id="articleCoverInput" type="file" name="image" accept="image/png, image/gif, image/jpeg, image/jpg" />
            </div>
            <form id="articleForm" action="/articles/write" method="POST" autocomplete="off">
                <input id="articleCoverFilename" type="hidden" name="cover" />
                <input class="article__input article__input--title" type="text" name="title" placeholder="New article title here..." aria-label="title" required>
                <div>
                    <p class="article__input--title">Tag your article:</p>
                    <?php foreach ($data['tags'] as $key => $tag) : ?>
                        <div class="article__input--tags">
                            <input
                                class="article__input--tag"
                                type="checkbox"
                                value="<?= $tag['id']; ?>"
                                name="tags[<?= $key ;?>]"
                                title="<?= $tag['description']; ?>"
                            />
                            <label class="article__label--tag"
                                   style="background-color: <?=$tag['color']; ?>"
                            >#<?= $tag['name']; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <textarea class="article__input article__input--content" rows="10" name="content" placeholder="Write your article here..." aria-label="content"></textarea>
                <p class="error"></p>
                <div class="article__submit">
                    <button class="button" type="submit">Publish</button>
                    <button class="button button--secondary" id="articleDraft" type="submit">Save draft</button>
                </div>
            </form>
        </div>
        <div class="article-write__preview hide">
            testing preview
        </div>
    <?php else : ?>
        <div class="article-write__login">
            <div class="article-write__login__message">
                <img src="<?= ASSETS_IMG . 'logo.svg'; ?>" alt="logo" />
                <div>
                    <h1>Welcome to "BLOG"</h1>
                    <p>Sign in below to compose your article and share it with the community.</p>
                </div>
            </div>
            <div class="article-write__login__form">
                <?php Elements::add('login'); ?>
            </div>
        </div>
    <?php endif; ?>
</section>
