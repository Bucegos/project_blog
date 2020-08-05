<?php
use App\Helper\Elements;
use App\Model\User;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?></title>
    <link type="text/css" rel="stylesheet" href="<?= ASSETS_CSS . 'main.min.css'; ?>" />
    <link type="text/css" rel="stylesheet" href="<?= ASSETS_CSS . 'login.min.css'; ?>" />
    <?php if (isset($customCss)) :
        foreach($customCss as $file) : ?>
        <link type="text/css" rel="stylesheet" href="<?= ASSETS_CSS . "$file"; ?>" />
    <?php endforeach;
    endif; ?>
    <link rel="icon" type="image/x-icon" href="<?= ASSETS_IMG . 'logo.svg'; ?>" />
</head>
<body>
<nav class="navigation">
    <a class="logo" href="/">
        <img class="logo__img" src="<?= ASSETS_IMG . 'logo.svg'; ?>" alt="Logo" />
        <p>Blog</p>
    </a>
<!--    ADD SEARCH!! -->
<!--    <form class="d-flex mb-0">-->
<!--        <input class="form-control mr-2" type="search" placeholder="Search" aria-label="Search">-->
<!--        <button class="btn btn-success" type="submit">Search</button>-->
<!--    </form>-->
    <ul class="navigation__menu">
        <li>
            <button class="button button--gradient" onclick="location.href='/articles/write'" type="button">
                Write an artile
            </button>
        </li>
        <li>
            <div class="dropdown">
                <?php if (isset($data['user'])) : ?>
                <div>
                    <button class="dropdown__toggler profile-image" role="button">
                        <img src="<?= ASSETS_UPLOADS . "{$data['user']['image']}"; ?>" alt="profile" />
                    </button>
                    <ul class="dropdown__content">
                        <li class="dropdown__item">
                            <a href="/account/reading-list">
                                Reading list[<?= isset($data['user']['reading_list_count']) ? $data['user']['reading_list_count'] : 0; ?>]
                            </a>
                        </li>
                        <li class="dropdown__item"><a href="/account/dashboard">Dashboard</a></li>
                        <li class="dropdown__item"><a href="/account/drafts">Drafs[0]</a></li>
                        <li class="dropdown__item"><a href="/account/settings">Account Settings</a></li>
                        <?php if ($data['user']['role'] === User::ADMIN) : ?>
                            <li class="dropdown__item navigation__user__admin"><a href="/admin">Admin</a></li>
                        <?php endif; ?>
                        <li>
                            <button class="button button--secondary" onclick="location.href='/auth/logout'" type="button">
                                Logout
                            </button>
                        </li>
                    </ul>
                </div>
                <?php else : ?>
                <div>
                    <button class="button dropdown__toggler" role="button">
                        Login
                    </button>
                    <div class="dropdown__content">
                        <?php Elements::add('login'); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </li>
    </ul>
</nav>
<main id="main-content">